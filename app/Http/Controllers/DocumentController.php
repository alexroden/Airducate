<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \App\Models\Document $document
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Document $document)
    {
        $path = Storage::path($document->path);

        return Response::make(file_get_contents($path), 200, [
            'Content-Type'        => $document->mime_type,
            'Content-Disposition' => 'inline; filename="'.$document->name.'"',
        ]);
    }
}
