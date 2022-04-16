<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            [
                'name' => 'Head Office',
                'slug' => 'head_office',
            ],

            [
                'name' => 'Dealer',
                'slug' => 'dealer',
            ],

            [
                'name' => 'Sales Consultant',
                'slug' => 'sales_consultant',
            ],

        ]);
    }
}
