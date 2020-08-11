<?php

use App\Models\Assignment;
use App\Models\AssignmentCategory;
use App\Models\AssignmentType;
use App\Models\ModuleAssignment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Assignment::truncate();
        ModuleAssignment::truncate();
        AssignmentCategory::truncate();
        AssignmentType::truncate();

        $assignments = [
            [
                'type'       => Assignment::TYPE_VIDEO,
                'name'       => 'Terminal Hazard Awareness',
                'source'     => 'https://cdn.theguardian.tv/webM/2015/07/20/150716YesMen_synd_768k_vp8.webm',
                'length'     => 10.53,
                'modules'    => [1],
                'categories' => [1, 3],
                'types'      => [],
            ], [
                'type'       => Assignment::TYPE_VIDEO,
                'name'       => 'Detecting and Reporting Hazards',
                'source'     => 'https://cdn.theguardian.tv/webM/2015/07/20/150716YesMen_synd_768k_vp8.webm',
                'length'     => 10.53,
                'modules'    => [1, 2],
                'categories' => [1, 3],
                'types'      => [],
            ], [
                'type'        => Assignment::TYPE_DOCUMENT,
                'name'        => 'Onboard safety policies',
                'source'      => 'http://airducate.test/documents/9da64f50-f39c-4b63-8673-9617c13d9ed6',
                'cover_image' => 'https://www.britsafe.org/media/1056/level-2-award-in-health-and-safety-in-the-workplace-1400-x-788-min.png',
                'modules'     => [1, 2],
                'categories'  => [1, 2],
                'types'       => [],
            ], [
                'type'        => Assignment::TYPE_VIDEO,
                'name'        => 'Dealing with disgruntle customers',
                'source'      => 'https://cdn.theguardian.tv/webM/2015/07/20/150716YesMen_synd_768k_vp8.webm',
                'length'      => 10.53,
                'modules'     => [3],
                'categories'  => [],
                'types'       => [2],
            ],
        ];

        foreach ($assignments as $assignment) {
            $a = Assignment::create(Arr::except($assignment, ['modules', 'categories', 'types']));
            foreach ($assignment['modules'] as $module) {
                ModuleAssignment::create([
                    'module_id'     => $module,
                    'assignment_id' => $a->id,
                ]);
            }
            foreach ($assignment['categories'] as $category) {
                AssignmentCategory::create([
                    'assignment_id' => $a->id,
                    'category_id'   => $category
                ]);
            }
            foreach ($assignment['types'] as $types) {
                AssignmentType::create([
                    'assignment_id' => $a->id,
                    'type_id'       => $types
                ]);
            }
        }
    }
}
