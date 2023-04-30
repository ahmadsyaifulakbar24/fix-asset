<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [ 
                'id' => 1,
                'department' => 'HRGA & Purchasing' 
            ],
            [ 
                'id' => 2,
                'department' => 'Internal Audit' 
            ],
            [ 
                'id' => 3,
                'department' => 'Service & Sparepart' 
            ],
            [ 
                'id' => 4,
                'department' => 'Finance' 
            ],
            [ 
                'id' => 5,
                'department' => 'Logistik & Import' 
            ],
            [ 
                'id' => 6,
                'department' => 'Product Planning' 
            ],
            [ 
                'id' => 7,
                'department' => 'Sales' 
            ],
            [ 
                'id' => 8,
                'department' => 'Sellout' 
            ],
            [ 
                'id' => 9,
                'department' => 'Markom' 
            ],
            [ 
                'id' => 10,
                'department' => 'IT' 
            ],
            [ 
                'id' => 11,
                'department' => 'Startegy & Ops' 
            ],
            [ 
                'id' => 12,
                'department' => 'Corporate' 
            ],
        ];

        foreach($data as $res) {
            Department::create([
                'id' => $res['id'],
                'department' => $res['department'] 
            ]);
        }
    }
}
