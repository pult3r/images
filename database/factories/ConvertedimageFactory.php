<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ConvertedimageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = \App\Models\Convertedimage::class;

    public function definition()
    {
        return [
            'baseimageid' => $this->faker->name(),
            'name' => $this->faker->name(),
            'name' => $this->faker->name(),
            'path' => $this->faker->name(),
            'mime' => $this->faker->name(),
            'hash' => $this->faker->name(),
            'size' => $this->faker->name(),
            'extension' => $this->faker->name(),
            'width' => $this->faker->name(),
            'height' => $this->faker->name(),
            
            'resolutionx' => $this->faker->name(),
            'resolutiony' => $this->faker->name(),
        ];
    }
}
