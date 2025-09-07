@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold text-dark">📑 My Document Logs</h2>

    <div class="card shadow-lg border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Document</th>
                            <th>Action</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td>
                                {{ $log->document->original_name ?? '🗑️ Deleted Document' }}
                            </td>
                            <td class="text-capitalize">
                                @if($log->action === 'upload')
                                    <span class="badge bg-primary">
                                        <i class="bi bi-upload"></i> {{ $log->action }}
                                    </span>
                                @elseif($log->action === 'delete')
                                    <span class="badge bg-danger">
                                        <i class="bi bi-trash"></i> {{ $log->action }}
                                    </span>
                                @elseif($log->action === 'approve')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> {{ $log->action }}
                                    </span>
                                @elseif($log->action === 'reject')
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-x-circle"></i> {{ $log->action }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">{{ $log->action }}</span>
                                @endif
                            </td>
                            <td>
                                {{ $log->created_at->format('d M Y, h:i A') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                No activity found.
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
