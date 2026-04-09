<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoLeadsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['New', 'In Queue', 'Waiting for Payments', 'Job Date Scheduled', 'Sold'];
        $addresses = [
            ['100 George St', 'Sydney', '2000'],
            ['45 Collins St', 'Melbourne', '3000'],
            ['12 Queen St', 'Brisbane', '4000'],
            ['88 St Georges Tce', 'Perth', '6000'],
            ['50 Flinders St', 'Adelaide', '5000'],
            ['10 Macquarie St', 'Hobart', '7000'],
            ['200 Northbourne Ave', 'Canberra', '2600'],
            ['1 Smith St', 'Darwin', '0800'],
            ['25 Beach Rd', 'Bondi', '2026'],
            ['99 High St', 'Fremantle', '6160']
        ];

        for ($i = 0; $i < 10; $i++) {
            \App\Models\Lead::create([
                'user_id' => 1,
                'first_name' => 'Demo'.($i+1),
                'last_name' => 'Client',
                'email' => 'demo'.($i+1).'@example.com',
                'phone' => '4'.rand(10000000, 99999999),
                'address' => $addresses[$i][0],
                'suburb' => $addresses[$i][1],
                'post_code' => $addresses[$i][2],
                'status' => $statuses[array_rand($statuses)],
                'lead_source' => 'Google',
                'system_size_kw' => rand(5, 15) + (rand(0, 9)/10),
                'panel_model' => 'Jinko Solar',
                'inverter_model' => 'Fronius',
            ]);
        }
    }
}
