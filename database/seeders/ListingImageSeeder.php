<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ListingImageSeeder extends Seeder
{
    public function run(): void
    {
        // Get existing listings
        $listings = DB::table('listings')->get();

        if ($listings->isEmpty()) {
            $this->command->warn(
                'No listings found. Please seed listings first.'
            );
            return;
        }

        $images = [
            'https://placehold.co/800x600?text=Product+Image+1',
            'https://placehold.co/800x600?text=Product+Image+2',
            'https://placehold.co/800x600?text=Product+Image+3',
        ];

        foreach ($listings as $listing) {
            foreach ($images as $index => $imagePath) {
                DB::table('listing_images')->updateOrInsert(
                    [
                        'listing_id' => $listing->id,
                        'path' => $imagePath,
                    ],
                    [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }

        $this->command->info(
            'Listing images seeded successfully.'
        );
    }
}
