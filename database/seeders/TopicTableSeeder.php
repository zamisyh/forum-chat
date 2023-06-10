<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['title' => 'Business', 'slug' => 'business'],
            ['title' => 'Programming', 'slug' => 'programming'],
            ['title' => 'Data Science', 'slug' => 'data-science'],
            ['title' => 'Math', 'slug' => 'math'],
            ['title' => 'Structure Data', 'slug' => 'structure-data'],
            ['title' => 'Statistics', 'slug' => 'statistics'],
            ['title' => 'Computer Science', 'slug' => 'computer-science'],
            ['title' => 'Other', 'slug' => 'other'],
        ];

        Topic::insert($data);
    }
}
