<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'id' => 1,
                'code' => 'ID01',
                'category' => 'Land',
            ],
            [
                'id' => 2,
                'code' => 'ID02',
                'category' => 'Building',
            ],
            [
                'id' => 3,
                'code' => 'ID03',
                'category' => 'Equipment',
            ],
            [
                'id' => 4,
                'code' => 'ID05',
                'category' => 'Vehicle (4 Wheels)',
            ],
            [
                'id' => 5,
                'code' => 'ID07',
                'category' => 'Vehicle (2 Wheels)',
            ],
            [
                'id' => 6,
                'code' => 'ID08',
                'category' => 'Computers',
            ],
            [
                'id' => 7,
                'code' => 'ID09',
                'category' => 'Furniture & Fixture',
            ],
            [
                'id' => 8,
                'code' => 'ID11',
                'category' => 'Tools',
            ],
            [
                'id' => 9,
                'code' => 'ID21',
                'category' => 'Intagible Asset',
            ],
            [
                'id' => 10,
                'code' => 'ID51',
                'category' => 'Costruction',
            ],
        ];

        foreach($categories as $category) {
            Category::create([
                'id' => $category['id'],
                'code' => $category['code'],
                'category' => $category['category'],
            ]);
        }
    }
}
