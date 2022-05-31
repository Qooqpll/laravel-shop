<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Мобильные телефоны', 'code' => 'mobiles', 'description' => 'Описание мобильных телефон'],
            ['name' => 'Портативная техника', 'code' => 'portable', 'description' => 'Описание портативной техники'],
            ['name' => 'Бытовая техника', 'code' => 'technics', 'description' => 'Описание бытовой техники'],
        ]);
    }
}
