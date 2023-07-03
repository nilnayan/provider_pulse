<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DocumentTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $document_types = DocumentType::findAll();
        return Inertia::render('DocumentTypes/Index', [
            'document_types' => $document_types,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3'],
            'description' => ['min:3'],
            'allowed_formats' => ['min:3'],
        ]);

        DocumentType::create($data);

        return redirect(route('document-types.index'))->with('msg', 'Created department.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DocumentType $document_type)
    {
        return $document_type;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DocumentType $documentType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DocumentType $document_type)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3'],
            'description' => ['min:3'],
            'allowed_formats' => ['min:3'],
        ]);

        $document_type->update($data);

        return redirect(route('document-types.index'))->with('msg', 'Updated department.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentType $document_type)
    {
        $document_type->delete();
        return redirect(route('document-types.index'))->with('msg', 'Deleted document type.');
    }
}
