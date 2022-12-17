<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class company extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('companies');
        $rows = [
            ['company_name' => 'Hardware'],
            ['company_name' => 'Software'],
        ];
        $table->insert($rows);
    }
}
