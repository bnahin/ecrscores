<?php

use Illuminate\Database\Seeder;

class ScoreRangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // year => [ 0: [min,max] ]
        $elaRanges = [
            8  => [
                [2288, 2486],
                [2487, 2566],
                [2567, 2667],
                [2668, 2769]
            ],
            11 => [
                [2299, 2492],
                [2493, 2582],
                [2583, 2681],
                [2682, 2795]
            ]
        ];
        $mathRanges = [
            8 => [
                [2265, 2503],
                [2504, 2585],
                [2586, 2652],
                [2653, 2802]
            ],
            9 => [
                [2280, 2542],
                [2543, 2627],
                [2628, 2717],
                [2718, 2862]
            ]
        ];
        foreach ($elaRanges as $year => $data) {
            foreach ($data as $level => $minmax) {
                \App\ScoreRange::create([
                    'year'  => $year,
                    'type'  => 'ela',
                    'level' => $level,
                    'min'   => $minmax[0],
                    'max'   => $minmax[1]
                ]);
            }
        }

        foreach ($mathRanges as $year => $data) {
            foreach ($data as $level => $minmax) {
                \App\ScoreRange::create([
                    'year'  => $year,
                    'type'  => 'math',
                    'level' => $level,
                    'min'   => $minmax[0],
                    'max'   => $minmax[1]
                ]);
            }
        }
    }
}
