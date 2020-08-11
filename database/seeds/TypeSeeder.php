<?php

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::truncate();

        $types = [
            [
                'name' => 'General',
            ], [
                'name' => 'Customer Facing',
            ],
        ];

        foreach ($types as $type) {
            Type::create($type);
        }
    }
}
