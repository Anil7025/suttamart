<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => 'content comming soon',
                'description' => 'Description is coming soon.',
                'image' => 'image.jpg',
                'is_publish' => 1,
                'og_title' => 'About Us',
                'og_description' => 'About Us Content',
                'og_keywords' => 'about us',
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms-conditions',
                'content' => 'content comming soon',
                'description' => 'Description is coming soon.',
                'image' => 'image.jpg',
                'is_publish' => 1,
                'og_title' => 'Terms & Conditions',
                'og_description' => 'Terms & Conditions Content',
                'og_keywords' => 'terms conditions',
            ],
        ];

        foreach ($pages as $pageData) {
            $page = new Page($pageData);
            $page->save();
        }
    }
}
