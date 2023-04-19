<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Convertedimage;
use Session;
use Illuminate\Support\Facades\Storage;


class ImageController extends Controller
{
    //
    public function index()
    {
        $images = DB::table('images')->paginate(10);
        return view("image")->with("images", $images);

    }


    public function stats()
    {
        $imageStats = DB::table('images')   
            ->select(DB::raw('SUM(size) as sizesum, COUNT(*) as count , width, height'))
            ->groupBy('width','height')
            ->get();
        
        $convertedImageStats = DB::table('convertedimages')   
            ->select(DB::raw('SUM(size) as sizesum, COUNT(*) as count , width, height'))
            ->groupBy('width','height')
            ->get();

        $extImageStats = DB::table('images')   
            ->select(DB::raw('COUNT(*) as count , extension'))
            ->groupBy('extension')
            ->get();

        $extConvertedImageStats = DB::table('convertedimages')   
            ->select(DB::raw('COUNT(*) as count , extension'))
            ->groupBy('extension')
            ->get();


        
        return view("statistic")
            ->with("imageStats", $imageStats)
            ->with("convertedImageStats", $convertedImageStats)
            ->with("extImageStats", $extImageStats)
            ->with("extConvertedImageStats", $extConvertedImageStats);
    }
    
    
    public function showimage( $imageId )
    {
        //storage_path
        $Image  = DB::table('images')->find( $imageId );

        if( empty( $Image ) )
            return view("errorpage")->with("error", "Image not found");

        $filename = asset('storage/'. $Image->path ) ;

        $imageResource = imagecreatefromstring( Storage::get( $Image->path ) ) ; 

        $imageResolution = (imageresolution( $imageResource ) ) ; 

        if( Storage::exists($Image->path) )
        {
            return view("showimage")->with("image", $Image);
        }
        else 
        {
            return view("errorpage")->with("error", "Image not found");
        }

        
    }

    public function change( Request $request )
    {
        $imageId           = intval( $request->input('id') ); 
        $newImageWidth     = intval( $request->input('imagewidth') ); 
        $newImageHeight    = intval( $request->input('imageheight') ); 

        $newImageResolutionX    = intval( $request->input('resolutionx') ); 
        $newImageResolutionY    = intval( $request->input('resolutiony') );



        if( ! is_int( $imageId ) || $imageId <= 0 )
        {
            return view("errorpage")->with("error", "Image not exist !");
        }

        if( ( ! is_int( $newImageWidth ) || $newImageWidth <=0 ) || ( ! is_int( $newImageHeight ) || $newImageHeight <=0 ) )
        {
            return view("errorpage")->with("error", "Wrong image size !");
        }

        if( ( ! is_int( $newImageResolutionX ) || $newImageResolutionX <=0 ) || ( ! is_int( $newImageResolutionY ) || $newImageResolutionY <=0 ) )
        {
            return view("errorpage")->with("error", "Wrong image resolution !");
        }

        $Image = DB::table('images')->find( $imageId );

        $filename = asset('storage/'. $Image->path ) ;
      
        if( Storage::exists( $Image->path ) ) 
        {  
            $imageResource = imagecreatefromstring( Storage::get( $Image->path ) ) ; 

            $newImageResource = imagecreatetruecolor( $newImageWidth, $newImageHeight );

            imagecopyresampled( $newImageResource, $imageResource, 0, 0, 0, 0, $newImageWidth, $newImageHeight, $Image->width, $Image->height);
            
            $imageResolution = imageresolution( $newImageResource, $newImageResolutionX, $newImageResolutionY ) ; 

            $ConvertedImage = new ConvertedImage ; 
            $ConvertedImage->baseimageid = $Image->id ;
            $ConvertedImage->name = $Image->name ;
            $ConvertedImage->path = $Image->path ;
            $ConvertedImage->mime = $Image->mime ;
            $ConvertedImage->hash = $Image->hash ;
            $ConvertedImage->size = $Image->size ;
            $ConvertedImage->extension = strtolower( $request->input('imagetype') ) ;
            $ConvertedImage->width = $newImageWidth ;
            $ConvertedImage->height = $newImageHeight ;
            $ConvertedImage->resolutionx = $newImageResolutionX ;
            $ConvertedImage->resolutiony =  $newImageResolutionY ;
            
            $ConvertedImage->save();

            $newImageFileName = md5('converted-'.$ConvertedImage->id) ; 

            switch( $request->input('imagetype') )
            {
                case "JPG":
                    $mimtType = "image/jpeg";
                    imagejpeg( $newImageResource , public_path('storage/imageconverted/'.$newImageFileName.'.jpg' ) ) ;
                    break ;
                case "PNG":
                    $mimtType = "image/png";
                    imagepng( $newImageResource , public_path('storage/imageconverted/'.$newImageFileName.'.png' ) ) ;
                    break ;
                case "GIF":    
                    $mimtType = "image/gif";
                    imagegif( $newImageResource , public_path('storage/imageconverted/'.$newImageFileName.'.gif' ) ) ;        
                    break ;

            }

            $ConvertedImage->path = 'imageconverted/'.md5('converted-'.$ConvertedImage->id).'.'.$ConvertedImage->extension ;
            $ConvertedImage->hash = md5('converted-'.$ConvertedImage->id).'.'.$ConvertedImage->extension ;
            $ConvertedImage->mime = $mimtType ;
            $ConvertedImage->size = filesize( public_path( 'storage/imageconverted/'.$newImageFileName.'.'.$ConvertedImage->extension ) ) ;
            $ConvertedImage->save();
        }

       
        return redirect()->route('image.index');
    }

    public function store( Request $request )
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif|max:4096',
        ]);

        $imagePath = $request->file('image')->store('imagebase', 'public');

        $filename = asset('storage/'. $imagePath ) ;
      
        if( Storage::exists( $imagePath )) 
        {  
            $imageResource = imagecreatefromstring( Storage::get( $imagePath ) ) ; 
            $imageResolution = ( imageresolution( $imageResource ) ) ; 
            
            list( $imageWidth, $imageHeight ) = getimagesize( public_path('storage/'.$imagePath ) );

            $data = Image::create([
                'name' => $request->file('image')->getClientOriginalName(), 
                'path' => $imagePath,
                'mime' => $request->file('image')->getMimeType(), 
                'hash' => $request->file('image')->hashName(),
                'size' => $request->file('image')->getSize(), 
                'extension' => $request->image->extension(),
                'width' => $imageWidth,
                'height' => $imageHeight,
                'resolutionx' => $imageResolution[0],  
                'resolutiony' => $imageResolution[1],    
            ]);

            session()->flash('success', 'Image Upload successfully');
            return redirect()->route('image.index');

        } 
        else 
        {
            return view("errorpage")->with("error", "Image not uploaded");
        }
        
        return redirect()->route('image.index');
        
    }
}


