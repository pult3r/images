<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = \App\Models\Image::class;

    public function definition()
    {

        return [
            'name' => md5($this->faker->name()).'.'.$this->faker->fileExtension(),
            'path' => $this->faker->name(),
            'mime' => $this->$faker->mimeType(),
            'hash' => md5($this->faker->name()).'.'.$this->faker->fileExtension(),
            'size' => rand(1024,2048),
            
            'resolutionx' => 96,
            'resolutiony' => 96,
        ];
    }
}
