<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $uom = 'database/seeds/uom.sql';
        DB::unprepared(file_get_contents($uom));
        $this->command->info('UOM table seeded!');

        $cat = 'database/seeds/categories.sql';
        DB::unprepared(file_get_contents($cat));
        $this->command->info('Categories table seeded!');

        $items = 'database/seeds/items.sql';
        DB::unprepared(file_get_contents($items));
        $this->command->info('Items table seeded!');

        $ledger = 'database/seeds/ledger.sql';
        DB::unprepared(file_get_contents($ledger));
        $this->command->info('Ledger table seeded!');
    }
}
