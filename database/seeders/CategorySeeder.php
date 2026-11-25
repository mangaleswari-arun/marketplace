<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'Mobiles' => ['Mobile Phones', 'Accessories'],
            'Electronics' => ['Computers', 'TV & Audio'],
            'Vehicles' => ['Cars', 'Motorcycles'],
            'Home & Living' => ['Furniture', 'Appliances'],
            'Property' => ['For Sale', 'For Rent'],
            'Jobs' => ['Full-time Jobs', 'Part-time Jobs'],
            'Services' => ['Home Services', 'Education', 'Repair Services'],
            'Fashion' => ['Men', 'Women', 'Kids'],
        ];

        foreach ($items as $parentName => $children) {
            $parent = Category::firstOrCreate(
                ['slug' => Str::slug($parentName)],
                ['name' => $parentName, 'parent_id' => null, 'is_active' => true]
            );

            foreach ($children as $childName) {
                Category::firstOrCreate(
                    ['slug' => Str::slug($parentName . '-' . $childName)],
                    ['name' => $childName, 'parent_id' => $parent->id, 'is_active' => true]
                );
            }
        }
    }
}
