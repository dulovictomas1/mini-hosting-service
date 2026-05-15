<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::updateOrcreate(
            ['slug' => 'mini'],
            [
                'name' => 'Mini',
                'database_limit' => 1,
            ]
        );

        Plan::updateOrcreate(
            ['slug' => 'standard'],
            [
                'name' => 'Standard',
                'database_limit' => 3,
            ]
        );

        Plan::updateOrcreate(
            ['slug' => 'top'],
            [
                'name' => 'Top',
                'database_limit' => 10,
            ]
        );
    }
}
