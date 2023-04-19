<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convertedimage extends Model
{
    use HasFactory;
    protected $table = 'convertedimages';
    protected $fillable = [
        'baseimageid',
        'path',
        'name', 
        'mime',
        'hash',
        'size',
        'extension',
        'width',
        'height',
        'resolutionx', 
        'resolutiony'
    ];
}
