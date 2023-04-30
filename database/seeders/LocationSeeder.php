<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'id' => 1,
                'code' => '65D1',
                'location' => 'HO Jakarta',
                'parent_id' => null,
            ],
            [
                'id' => 2,
                'code' => '65D1A',
                'location' => 'WH Cikarang',
                'parent_id' => 1,
            ],
            [
                'id' => 3,
                'code' => '65D1C',
                'location' => 'DSC Bogor',
                'parent_id' => 1,
            ],
            [
                'id' => 4,
                'code' => '65D1D',
                'location' => 'DSC Tanggerang',
                'parent_id' => 1,
            ],
            [
                'id' => 5,
                'code' => '65D2',
                'location' => 'Surabaya',
                'parent_id' => null,
            ],
            [
                'id' => 6,
                'code' => '65D2A',
                'location' => 'Kediri',
                'parent_id' => 5,
            ],
            [
                'id' => 7,
                'code' => '65D3',
                'location' => 'Semarang',
                'parent_id' => null,
            ],
            [
                'id' => 8,
                'code' => '65D4',
                'location' => 'Bandung',
                'parent_id' => null,
            ],
            [
                'id' => 9,
                'code' => '65D4A',
                'location' => 'Tasikmalaya',
                'parent_id' => 8,
            ],
            [
                'id' => 10,
                'code' => '65D5',
                'location' => 'Palembang',
                'parent_id' => null,
            ],
            [
                'id' => 11,
                'code' => '65D5A',
                'location' => 'Pangkal Pinang',
                'parent_id' => 10,
            ],
            [
                'id' => 12,
                'code' => '65D5B',
                'location' => 'Jambi',
                'parent_id' => 10,
            ],
            [
                'id' => 13,
                'code' => '65D7',
                'location' => 'Pontianak',
                'parent_id' => null,
            ],
            [
                'id' => 14,
                'code' => '65DA',
                'location' => 'Bali',
                'parent_id' => null,
            ],
            [
                'id' => 15,
                'code' => '65DAA',
                'location' => 'Lombok',
                'parent_id' => 14,
            ],
            [
                'id' => 16,
                'code' => '65DC',
                'location' => 'Yogyakarta',
                'parent_id' => null,
            ],
            [
                'id' => 17,
                'code' => '65DCC',
                'location' => 'DSC Solo',
                'parent_id' => 16,
            ],
            [
                'id' => 18,
                'code' => '65DD',
                'location' => 'Cirebon',
                'parent_id' => null,
            ],
            [
                'id' => 19,
                'code' => '65DG',
                'location' => 'Jember',
                'parent_id' => null,
            ],
            [
                'id' => 20,
                'code' => '65DH',
                'location' => 'Pekanbaru',
                'parent_id' => null,
            ],
            [
                'id' => 21,
                'code' => '65DHH',
                'location' => 'Batam',
                'parent_id' => 20,
            ],
            [
                'id' => 22,
                'code' => '65DI',
                'location' => 'Medan',
                'parent_id' => null,
            ],
            [
                'id' => 23,
                'code' => '65DJ',
                'location' => 'Makasar',
                'parent_id' => null,
            ],
            [
                'id' => 24,
                'code' => '65Dk',
                'location' => 'Manado',
                'parent_id' => null,
            ],
            [
                'id' => 25,
                'code' => '65DL',
                'location' => 'Samarinda',
                'parent_id' => null,
            ],
            [
                'id' => 26,
                'code' => '65DM',
                'location' => 'Banjarmasin',
                'parent_id' => null,
            ],
            [
                'id' => 27,
                'code' => '65D4B',
                'location' => 'Sukabumi',
                'parent_id' => 8,
            ],
            [
                'id' => 28,
                'code' => '65DCA',
                'location' => 'Purwokerto',
                'parent_id' => 16,
            ],
            [
                'id' => 29,
                'code' => '65DHA',
                'location' => 'Padang',
                'parent_id' => 20,
            ],
            [
                'id' => 30,
                'code' => '65DIA',
                'location' => 'Aceh',
                'parent_id' => 22,
            ],
        ];

        foreach($locations as $location) {
            Location::create([
                'id' => $location['id'],
                'code' => $location['code'],
                'location' => $location['location'],
                'parent_id' => $location['parent_id'],
            ]);
        }
    }
}
