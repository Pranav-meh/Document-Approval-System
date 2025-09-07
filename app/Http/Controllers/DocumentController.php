<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Auth::user()->documents;
        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        return view('documents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'document' => 'required|mimes:pdf,docx|max:2048'
        ]);

        $path = $request->file('document')->store('documents');

        $document = Document::create([
            'user_id' => Auth::id(),
            'filename' => $path,
            'original_name' => $request->file('document')->getClientOriginalName(),
            'status' => 'pending',
            'uploaded_at' => now(),
        ]);

        DocumentLog::create([
            'document_id' => $document->id,
            'action' => 'upload',
            'performed_by' => Auth::id(),
        ]);

        return redirect()->route('documents.index')->with('success', 'Document uploaded successfully!');
    }
    public function logs(){
        $logs = \App\Models\DocumentLog::with('document')
        ->where('performed_by', auth()->id())
        ->latest()
        ->get();

    return view('documents.logs', compact('logs'));
    }


    public function destroy($id)
    {
        $document = Document::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        DocumentLog::create([
        'document_id' => $document->id,
        'action' => 'delete',
        'performed_by' => Auth::id(),
        ]);

    Storage::delete($document->filename);
    $document->delete();

    return redirect()->route('documents.index')->with('success', 'Document deleted successfully!');
    }
    public function download($id)
    {
        $doc = Document::find($id);

        if (!$doc) {
        return redirect()->back()->with('error', 'Document not found.');
        }

        if (empty($doc->filename)) {
        return redirect()->back()->with('error', 'File path not set for this document.');
        }

        if (!Storage::exists($doc->filename)) {
        return redirect()->back()->with('error', 'File not found on server.');
    }

    return Storage::download($doc->filename, $doc->original_name ?? 'document.pdf');
    }
}
