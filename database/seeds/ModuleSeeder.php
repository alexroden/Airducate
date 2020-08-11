<?php

use App\Models\Group;
use App\Models\GroupModule;
use App\Models\Module;
use App\Models\ModuleCategory;
use App\Models\ModuleType;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::truncate();
        GroupModule::truncate();
        ModuleCategory::truncate();
        ModuleType::truncate();

        $modules = [
            [
                'name'       => 'Terminal Health & Safety',
                'groups'     => Group::GROUPS,
                'categories' => [1, 3],
                'types'      => [],
            ], [
                'name'       => 'Onboard Health & Safety',
                'groups'     => [
                    Group::GROUPS[Group::GROUP_PILOTS],
                    Group::GROUPS[Group::GROUP_STEWARDS],
                ],
                'categories' => [1, 2],
                'types'      => [],
            ], [
                'name'       => 'Customer Service',
                'groups'     => [
                    Group::GROUPS[Group::GROUP_STEWARDS],
                    Group::GROUPS[Group::GROUP_ADMIN],
                ],
                'categories' => [],
                'types'      => [2],
            ],
        ];

        foreach ($modules as $module) {
            $m = Module::create(['name' => $module['name']]);
            foreach($module['groups'] as $group) {
                GroupModule::create([
                    'group_id'  => $group,
                    'module_id' => $m->id,
                ]);
            }
            foreach ($module['categories'] as $category) {
                ModuleCategory::create([
                    'module_id'   => $m->id,
                    'category_id' => $category
                ]);
            }
            foreach ($module['types'] as $types) {
                ModuleType::create([
                    'module_id' => $m->id,
                    'type_id'   => $types
                ]);
            }
        }
    }
}
