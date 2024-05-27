<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $directory = public_path('uploads');
        $files = File::allFiles($directory);

        $paths = [];
        foreach ($files as $file) {
            $paths[] = $file->getPathname();
        }

        return [
            'link_url' => $this->faker->randomElement($paths),
        ];
    }
}
