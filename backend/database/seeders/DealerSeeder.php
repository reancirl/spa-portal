<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Dealer;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DealerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create();
        Dealer::insert(
            [
                [
                    'name' => 'HCZM',
                    'code' => 'D606',
                ],
                [
                    'name' => 'HCZM',
                    'code' => 'B307',
                ],
                [
                    'name' => 'HCSP',
                    'code' => 'D506',
                ],
                [
                    'name' => 'test 121333',
                    'code' => 'HCBG',
                ],
                [
                    'name' => 'test 121',
                    'code' => 'HCAC',
                ]
            ]
        );



        // Color::insert([
        //     [
        //         'name' => 'Color-1',
        //         'code' => 'NH-797M',
        //         'status' => true
        //     ],
        //     [
        //         'name' => 'Color-2',
        //         'code' => 'NH-830M',
        //         'status' => true
        //     ],
        //     [
        //         'name' => 'Color-3',
        //         'code' => 'NH-791M',
        //         'status' => true
        //     ]
        // ]);

        Variant::insert([
            [
                'name' => 'BRIO 1.2RS CVT',
                'alias' => 'BRIO 1.2RS CVT 2020 DD189LL',
                'code' => 'DD189LL',
                'status' => true
            ],
            [
                'name' => 'HR-V 1.8E CVT',
                'alias' => 'HR-V 1.8E CVT 2021 RU583ML',
                'code' => 'RU583ML',
                'status' => true,
            ],
            [
                'name' => 'BR-V 1.5V CVT',
                'alias' => 'BR-V 1.5V CVT 2021 DG184ML',
                'code' => 'DG184ML',
                'status' => true
            ]
        ]);
    }
}
