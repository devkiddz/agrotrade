<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlanCategory;

class PlanCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Starter Plans',
                'description' => 'Great for beginners with smaller investment amounts',
                'active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Standard Plans',
                'description' => 'Our most popular plans for average investors',
                'active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Premium Plans',
                'description' => 'Exclusive plans for high-value investors',
                'active' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Special Offers',
                'description' => 'Limited time investment opportunities',
                'active' => true,
                'sort_order' => 4
            ],
        ];

        foreach ($categories as $category) {
            PlanCategory::create($category);
        }
    }
}
