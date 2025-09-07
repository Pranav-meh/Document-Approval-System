@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center py-5" style="min-height: 80vh; background: #f8f9fa;">
    <div class="col-lg-6 col-md-8">
        <div class="card shadow-lg border-0 rounded-3">
            
            <!-- Header -->
            <div class="card-header bg-primary text-white text-center py-3">
                <h3 class="fw-bold mb-0">📄 Upload Document</h3>
            </div>

            <!-- Body -->
            <div class="card-body p-4">
                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <h6 class="fw-bold mb-2">⚠️ Please fix the following:</h6>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- File Upload -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Select File</label>
                        <input type="file" name="document" class="form-control" accept=".pdf,.doc,.docx" required>
                        <div class="form-text">Supported formats: PDF, DOCX | Max size: 10MB</div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">
                        🚀 Upload Document
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="card-footer text-muted text-center small py-2">
                Your files are securely stored 🔒
            </div>
        </div>
    </div>
</div>
@endsection
