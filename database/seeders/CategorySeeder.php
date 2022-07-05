<?php

namespace Database\Seeders;

use App\Models\Category;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function __construct(Category $category)
    {
        $this->category = $category;
        $this->faker = Factory::create();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate();

        for ($i = 1; $i <= 20; $i++) {
            $this->category->create([
                'name' => $this->faker->sentence(3),
                'description' => $this->faker->paragraph(2),
                'slug' => $this->faker->slug(3, false),
                'image' => $this->faker->imageUrl(640, 640, 'products', true),
                'keywords' => $this->faker->words(5, true),
                'parent_id' => null,
            ]);
        }
    }
}
