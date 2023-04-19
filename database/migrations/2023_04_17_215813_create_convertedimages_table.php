<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConvertedimagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convertedimages', function (Blueprint $table) {
            $table->id();
            
            $table->integer('baseimageid');
            $table->string('name', 255);
            $table->string('path', 255);
            $table->string('mime', 255);
            $table->string('hash', 255);
            $table->integer('size');
            $table->string('extension',10);
            $table->integer('width');
            $table->integer('height');
            $table->integer('resolutionx');
            $table->integer('resolutiony');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('convertedimages');
    }
}
