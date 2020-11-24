<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IntervalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('intervals')->delete();

        DB::table('intervals')->insert([
            [
                'name' => 'm2',
                'distance' => 1
            ],
            [
                'name' => 'M2',
                'distance' => 2
            ],
            [
                'name' => 'm3',
                'distance' => 3
            ],
            [
                'name' => 'M3',
                'distance' => 4
            ],
            [
                'name' => 'p4',
                'distance' => 5
            ],
            [
                'name' => 'tritone',
                'distance' => 6
            ],
            [
                'name' => 'p5',
                'distance' => 7
            ],
            [
                'name' => 'm6',
                'distance' => 8
            ],
            [
                'name' => 'M6',
                'distance' => 9
            ],
            [
                'name' => 'm7',
                'distance' => 10
            ],
            [
                'name' => 'M7',
                'distance' => 11
            ],
            [
                'name' => 'p8',
                'distance' => 12
            ],
            [
                'name' => 'm9',
                'distance' => 13
            ],
            [
                'name' => 'M9',
                'distance' => 14
            ],
            [
                'name' => 'm10',
                'distance' => 15
            ],
            [
                'name' => 'M10',
                'distance' => 16
            ],
            [
                'name' => 'm11',
                'distance' => 17
            ],
            [
                'name' => 'M11',
                'distance' => 18
            ],
            [
                'name' => 'm12',
                'distance' => 19
            ],
            [
                'name' => 'M12',
                'distance' => 20
            ],
            [
                'name' => 'm13',
                'distance' => 21
            ],
            [
                'name' => 'M13',
                'distance' => 22
            ],
        ]);
    }
}
