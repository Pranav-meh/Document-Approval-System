@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark mb-0">
            <i class="bi bi-folder2-open me-2 text-primary"></i> My Documents
        </h2>
        <a href="{{ route('documents.create') }}" class="btn btn-success fw-semibold">
            <i class="bi bi-upload me-1"></i> Upload Document
        </a>
    </div>

    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Uploaded</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $doc)
                        <tr>
                            <td class="fw-semibold text-dark">
                                <i class="bi bi-file-earmark-text me-2 text-secondary"></i>
                                {{ $doc->original_name }}
                            </td>
                            <td>
                                @if($doc->status === 'approved')
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Approved</span>
                                @elseif($doc->status === 'rejected')
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill">Rejected</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill">Pending</span>
                                @endif
                            </td>
                            <td class="text-muted">
                                <i class="bi bi-calendar-event me-1"></i>
                                {{ $doc->uploaded_at }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('documents.download', $doc->id) }}" 
                                    class="btn btn-sm btn-primary me-1">
                                    <i class="bi bi-download"></i> Download
                                </a>

                                <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this document?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash me-1"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox me-1"></i> No documents uploaded yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
