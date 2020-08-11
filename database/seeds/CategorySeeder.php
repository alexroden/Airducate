<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();

        $categories = [
            [
                'name' => 'Health & Safety',
            ], [
                'name' => 'Onboard',
            ], [
                'name' => 'Terminal',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
