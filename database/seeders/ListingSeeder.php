<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ListingSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            $this->command->error('Please create a user first.');
            return;
        }

        $category = Category::first();

        if (!$category) {
            $this->command->error('Please seed categories first.');
            return;
        }

        $listings = [
            [
                'type' => 'product',
                'name' => 'Samsung Galaxy Smartphone',
                'title' => 'Samsung Galaxy Smartphone',
                'detail' => 'Good condition smartphone with charger.',
                'description' => 'Good condition smartphone with charger.',
                'price' => 12000,
                'country' => 'India',
                'state' => 'Tamil Nadu',
                'city' => 'Chennai',
                'area' => 'Anna Nagar',
                'status' => 'published',
            ],
            [
                'type' => 'product',
                'name' => 'Second Hand Laptop',
                'title' => 'Second Hand Laptop',
                'detail' => 'Laptop suitable for office and student use.',
                'description' => 'Laptop suitable for office and student use.',
                'price' => 25000,
                'country' => 'India',
                'state' => 'Tamil Nadu',
                'city' => 'Madurai',
                'area' => 'KK Nagar',
                'status' => 'published',
            ],
            [
                'type' => 'service',
                'name' => 'Web Development Service',
                'title' => 'Web Development Service',
                'detail' => 'Website development and Laravel application services.',
                'description' => 'Website development and Laravel application services.',
                'price' => 5000,
                'country' => 'India',
                'state' => 'Tamil Nadu',
                'city' => 'Thoothukudi',
                'area' => 'Alangulam Road',
                'status' => 'published',
            ],
        ];

        foreach ($listings as $data) {
            Listing::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                array_merge($data, [
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                ])
            );
        }

        $this->command->info('Sample listings seeded successfully.');
    }
}
