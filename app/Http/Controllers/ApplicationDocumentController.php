<?php

namespace App\Http\Controllers;

use App\Application;
use App\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApplicationDocumentController extends Controller
{
    public function __construct(Application $application, Document $document)
    {
        $this->application = $application;
    	$this->document = $document;
    }

    public function store(Request $request, Application $application)
    {
        if ($path = $request->file('image')->store('/application/documents')) {
            if ($document = $this->createDocument($request, $path)) {
                if ($application->documents()->attach($document->id)) {
                    activity()
                    ->performedOn($document)
                    ->causedBy($request->user())
                    ->withProperties([
                        'application_id' => $application->id, 
                        'document_id' => $document->id, 
                        'file_path' => $path,
                    ])
                    ->log('uploaded a new document to application');
                }
            }

            return $document;
        }

        return response()->json([
            'message' => 'unable to upload or save'
        ], 400);
    }

    protected function createDocument($request, $path)
    {
        return $this->document->create([
            'file_path' => $path,
            'name' => $request->name,
        ]);
    }

    public function index(Application $application)
    {
        return $application->documents;
    }

    public function viewDocument(Application $application, $documentId)
    {
        $document = $application->documents()->findOrFail($documentId);

        $filePath = storage_path('/app//'. $document->file_path);
        return $this->getImage($filePath);
    }

    public function destroy(Request $request, Application $application, $documentId)
    {
        if ($application->documents()->detach($documentId)) {
            activity()
            ->performedOn($application)
            ->causedBy($request->user())
            ->withProperties(['application_id' => $application->id, 'document_id' => $documentId])
            ->log('detached document from application');
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}