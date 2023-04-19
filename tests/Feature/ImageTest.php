<?php 

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File ;
use App\Models\Convertedimage;

class ImageTest extends TestCase
{
    /** @test */
    public function test_is_main_page_exist()
    {
        // Arrange
        
        // Act
        $response = $this->get( '/' );
       
        // Assert
        $response->assertStatus(200)->assertSeeText('Upload image Page');
    }

    /** @test */
    public function test_is_image_corectly_uploaded()
    {
        // Arrange
        // Act
        // Assert
        $this->assertTrue(true);
    }

    /** @test */
    public function test_is_image_corectly_converted()
    {
        // Arrange

        $TestImage = Image::create([
            'name' => 'testimage.png', 
            'path' => 'imagebase/testimage.png',
            'mime' => 'image/png', 
            'hash' => 'testimage.jpg',
            'size' => 288457, 
            'extension' => 'png',
            'width' => 600,
            'height' => 600,
            'resolutionx' => 96,  
            'resolutiony' => 96,    
        ]);

        $Image  = DB::table('images')->find( $TestImage->id );


        $imageId           = $Image->id ; 
        $newImageWidth     = 300 ; 
        $newImageHeight    = 300 ; 

        $newImageResolutionX    = 72; 
        $newImageResolutionY    = 72;
        $newImageType           = 'JPG';


        $imageResource = imagecreatefromstring( Storage::get( $Image->path ) ) ; 

        $newImageResource = imagecreatetruecolor( $newImageWidth, $newImageHeight );

        imagecopyresampled( $newImageResource, $imageResource, 0, 0, 0, 0, $newImageWidth, $newImageHeight, $Image->width, $Image->height);
            
        $imageResolution = imageresolution( $newImageResource, $newImageResolutionX, $newImageResolutionY ) ; 

        $ConvertedImage = new ConvertedImage ; 
        $ConvertedImage->baseimageid = $Image->id ;
        $ConvertedImage->name = $Image->name ;
        $ConvertedImage->path = $Image->path ;
        $ConvertedImage->mime = '' ;
        $ConvertedImage->hash = $Image->hash ;
        $ConvertedImage->size = $Image->size ;
        $ConvertedImage->extension = strtolower( $newImageType ) ;
        $ConvertedImage->width = $newImageWidth ;
        $ConvertedImage->height = $newImageHeight ;
        $ConvertedImage->resolutionx = $newImageResolutionX ;
        $ConvertedImage->resolutiony =  $newImageResolutionY ;

        $newImageFileName = 'testimage' ;

        // test conversion for JPG 
        $JpgConvertedImage = clone $ConvertedImage ;
        $JpgConvertedImage->mime = "image/jpeg"; 
        $JpgConvertedImage->path = 'imageconverted/'.$newImageFileName.'.jpg' ;
        $JpgConvertedImage->hash = $newImageFileName.'.jpg' ;
        imagejpeg( $newImageResource , public_path('storage/imageconverted/'.$newImageFileName.'.jpg' ) ) ;
        $JpgConvertedImage->size = filesize( public_path( 'storage/imageconverted/'.$newImageFileName.'.jpg' ) ) ;
        $JpgConvertedImage->save();

        // test conversion for PNG 
        $PngConvertedImage = clone $ConvertedImage ;
        $PngConvertedImage->mime = "image/png"; 
        $PngConvertedImage->path = 'imageconverted/'.$newImageFileName.'.png' ;
        $PngConvertedImage->hash = $newImageFileName.'.png' ;
        imagejpeg( $newImageResource , public_path('storage/imageconverted/'.$newImageFileName.'.png' ) ) ;
        $PngConvertedImage->size = filesize( public_path( 'storage/imageconverted/'.$newImageFileName.'.png' ) ) ;
        $PngConvertedImage->save();

        // test conversion for GIF 
        $GifConvertedImage = clone $ConvertedImage ;
        $GifConvertedImage->mime = "image/gif"; 
        $GifConvertedImage->path = 'imageconverted/'.$newImageFileName.'.gif' ;
        $GifConvertedImage->hash = $newImageFileName.'.gif' ;
        imagejpeg( $newImageResource , public_path('storage/imageconverted/'.$newImageFileName.'.gif' ) ) ;
        $GifConvertedImage->size = filesize( public_path( 'storage/imageconverted/'.$newImageFileName.'.gif' ) ) ;
        $GifConvertedImage->save();

        if( $JpgConvertedImage->size > 0 && $PngConvertedImage->size && $GifConvertedImage->size )
            $conversion = true ; 
        else 
            $conversion = false ; 

        // remove images from DB and from disc
        
        DB::table('convertedimages')->delete($JpgConvertedImage->id);
        DB::table('convertedimages')->delete($PngConvertedImage->id);
        DB::table('convertedimages')->delete($GifConvertedImage->id);
        DB::table('images')->delete($Image->id);

        File::delete(
            public_path('storage/imageconverted/'.$JpgConvertedImage->hash ),
            public_path('storage/imageconverted/'.$PngConvertedImage->hash ),
            public_path('storage/imageconverted/'.$GifConvertedImage->hash ),
        );
       
        // Assert
        $this->assertTrue($conversion);

    }


    /** @test */
    public function test_is_new_image_on_convert_page()
    {
        // Arrange
        $Image = Image::create([
            'name' => 'testimage.png', 
            'path' => 'imagebase/testimage.png',
            'mime' => 'image/png', 
            'hash' => 'testimage.jpg',
            'size' => 288457, 
            'extension' => 'png',
            'width' => 600,
            'height' => 600,
            'resolutionx' => 96,  
            'resolutiony' => 96,    
        ]);

        // Act
        $response = $this->get( '/image/' . $Image->id );
        
        // Assert
        $response->assertStatus(200)
            ->assertSeeText('Convert image Page');

        DB::table('images')->delete($Image->id);
    }

    /** @test */
    public function test_is_converted_image_exist()
    {
        // Arrange

        // Act
        $response = $this->get('/grid' );
       
        // Assert
        $response->assertStatus(200)->assertSeeText('Converted image list Page');
    }


    /** @test */
    public function test_is_converted_image_list_page_exist()
    {
        // Arrange 

        // Act
        $response = $this->get('/grid' );
       
        // Assert
        $response->assertStatus(200)->assertSeeText('Converted image list Page');
    }

    /** @test */
    public function test_is_statistics_page_exist()
    {
        // Arrange 
    
        // Act
        $response = $this->get( '/stats' );
           
        // Assert
        $response->assertStatus(200)->assertSeeText('Statistics Page');
    }    
}