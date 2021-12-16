<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Section::create([
            'section_name' => 'البنك الاهلي',
            'description' => 'خدمات',
            'created_by' => 'admin admin'
        ]);
    }
}
