<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('modules')->insert([
            [

                'name' => 'URL Shortener',
                'description' => 'Raccourcir et gérer des liens',
                'active'=>true

            ],
            [

                'name' => 'Wallet',
                'description' => 'Gestion du solde et des transferts',
                'active'=>true


            ],
            [

                'name' => 'Marketplace + Stock Manager',
                'description' => 'Gestion de produits et commandes',
                'active'=>true


            ],
            [

                'name' => 'Time Tracker',
                'description' => 'Suivi des sessions et durées',
                'active'=>true


            ],
            [

                'name' => 'Investment Tracker',
                'description' => 'Gestion du portefeuille d’investissement',
                'active'=>true


            ],
        ]);
    }
}