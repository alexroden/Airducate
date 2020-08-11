<?php

use App\Models\Category;
use App\Models\Document;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Document::truncate();

        $documents = [
            [
                'token'     => '9da64f50-f39c-4b63-8673-9617c13d9ed6',
                'path'      => 'documents/dummy.pdf',
                'type'      => 'pdf',
                'mime_type' => 'application/pdf',
                'name'      => 'dummy.pdf',
            ],
        ];

        foreach ($documents as $document) {
            Document::create($document);
        }
    }
}
