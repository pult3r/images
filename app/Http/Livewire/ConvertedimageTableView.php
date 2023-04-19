<?php

namespace App\Http\Livewire;

use LaravelViews\Views\TableView;
use Illuminate\Database\Eloquent\Builder;
use LaravelViews\Facades\UI;
use App\Models\Convertedimage;
use LaravelViews\Facades\Header;

class ConvertedimageTableView extends TableView
{
    /**
     * Sets a model class to get the initial data
     */
    protected $model = Convertedimage::class;
    protected $paginate = 20 ;

    protected function repository()
    {
        return Convertedimage::query();
    }


    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */
    public function headers(): array
    {
        return [
            'image', 
            Header::title('name')->sortBy('name'),
            'resolution',
            Header::title('size')->sortBy('size'),

            Header::title('Created')->sortBy('created_at'),
            Header::title('modificated')->sortBy('updated_at'),
            'download'
        ];
    }

    /**
     * Sets the data to every cell of a single row
     *
     * @param $model Current model for each row
     */
    public function row($model): array
    {
        return [
            UI::avatar( asset('storage/'.$model->path ) ) ,
            $model->name,
            $model->width.' x '. $model->height ,
            round( $model->size / 1024,2) . ' KB'	,
            $model->created_at->diffforHumans(), 
            $model->updated_at->diffforHumans(),
            UI::link('Show', asset('storage/'.$model->path ) ),

        ];
    }
}
