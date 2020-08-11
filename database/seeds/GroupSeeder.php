<?php

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::truncate();

        foreach (array_keys(Group::GROUPS) as $group) {
            Group::create(['name' => $group]);
        }
    }
}
