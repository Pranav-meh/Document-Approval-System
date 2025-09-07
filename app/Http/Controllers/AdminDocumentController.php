<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentLog;
use Illuminate\Support\Facades\Auth;

class AdminDocumentController extends Controller
{
    public function index()
    {
        $documents = Document::all();
        return view('admin.documents.index', compact('documents'));
    }

    public function approve($id)
    {
        $document = Document::findOrFail($id);
        $document->status = 'approved';
        $document->save();

        DocumentLog::create([
            'document_id' => $document->id,
            'action' => 'approve',
            'performed_by' => Auth::id(),
        ]);

        if (request()->ajax()) {
            return response()->json(['status' => 'success', 'message' => 'Document approved!']);

        }

        return back()->with('success', 'Document approved!');
    }

    public function reject($id)
    {
        $document = Document::findOrFail($id);
        $document->status = 'rejected';
        $document->save();

        DocumentLog::create([
            'document_id' => $document->id,
            'action' => 'reject',
            'performed_by' => Auth::id(),
        ]);
        if (request()->ajax()) {
            return response()->json(['status' => 'success', 'message' => 'Document rejected!']);

        }

        return back()->with('success', 'Document rejected!');
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
