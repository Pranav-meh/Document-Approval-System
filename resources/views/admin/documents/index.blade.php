@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold text-dark">📂 Admin Dashboard - Documents</h2>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-lg border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>User</th>
                            <th>Document</th>
                            <th>Status</th>
                            <th>Uploaded</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $doc)
                        <tr id="doc-row-{{ $doc->id }}">
                            <td>{{ $doc->user->name }}</td>
                            <td>{{ $doc->original_name }}</td>
                            <td id="status-{{ $doc->id }}">
                                @if($doc->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($doc->status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>{{ $doc->uploaded_at }}</td>
                            <td class="text-center" id="actions-{{ $doc->id }}">
                                <a href="{{ route('documents.download', $doc->id) }}" 
                                    class="btn btn-sm btn-primary me-1">
                                    <i class="bi bi-download"></i> Download
                                </a>

                                @if($doc->status === 'pending')
                                    <button class="btn btn-sm btn-success me-1"
                                            onclick="approveDocument({{ $doc->id }})">
                                        <i class="bi bi-check-circle"></i> Approve
                                    </button>

                                    <button class="btn btn-sm btn-danger"
                                            onclick="rejectDocument({{ $doc->id }})">
                                        <i class="bi bi-x-circle"></i> Reject
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No documents found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    async function approveDocument(id) {
        try {
            const response = await fetch(`/admin/documents/${id}/approve`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                }
            });

            if (!response.ok) throw new Error("Request failed");

            document.getElementById(`status-${id}`).innerHTML =
                '<span class="badge bg-success">Approved</span>';

            document.getElementById(`actions-${id}`).innerHTML =
                `<a href="/documents/${id}/download" class="btn btn-sm btn-primary me-1 download-btn">
                    <i class="bi bi-download"></i> Download
                </a>`;
        } catch (error) {
            console.error("Error approving document:", error);
            alert("Failed to approve document.");
        }
    }

    async function rejectDocument(id) {
        try {
            const response = await fetch(`/admin/documents/${id}/reject`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                }
            });

            if (!response.ok) throw new Error("Request failed");

            document.getElementById(`status-${id}`).innerHTML =
                '<span class="badge bg-danger">Rejected</span>';

            document.getElementById(`actions-${id}`).innerHTML =
                `<a href="/documents/${id}/download" class="btn btn-sm btn-primary me-1 download-btn">
                    <i class="bi bi-download"></i> Download
                </a>`;
        } catch (error) {
            console.error("Error rejecting document:", error);
            alert("Failed to reject document.");
        }
    }
</script>
@endsection
