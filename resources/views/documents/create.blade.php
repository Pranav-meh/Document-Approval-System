@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center py-5" style="min-height: 80vh; background: #f8f9fa;">
    <div class="col-lg-6 col-md-8">
        <div class="card shadow-lg border-0 rounded-3">
            
            <div class="card-header bg-primary text-white text-center py-3">
                <h3 class="fw-bold mb-0">📄 Upload Document</h3>
            </div>

            <div class="card-body p-4">
                <form id="uploadForm" enctype="multipart/form-data">
                    @csrf

                    <div id="successMessage" class="alert alert-success mb-3 d-none" role="alert">
                        📄 Document uploaded successfully!
                    </div>

                    <div id="errorMessages" class="alert alert-danger mb-4 d-none">
                        <h6 class="fw-bold mb-2">⚠️ Please fix the following:</h6>
                        <ul class="mb-0 ps-3"></ul>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Select File</label>
                        <input type="file" name="document" id="documentInput" class="form-control" accept=".pdf,.doc,.docx" required>
                        <div class="form-text">Supported formats: PDF, DOCX | Max size: 10MB</div>
                    </div>

                    <div class="mb-3">
                        <div class="progress" style="height: 20px;">
                            <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;">0%</div>
                        </div>
                    </div>

                    <button type="submit" id="uploadBtn" class="btn btn-success w-100 py-2 fw-semibold">
                        🚀 Upload Document
                    </button>
                </form>
            </div>

            <div class="card-footer text-muted text-center small py-2">
                Your files are securely stored 🔒
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('uploadForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const fileInput = document.getElementById('documentInput');
    const file = fileInput.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('document', file);
    formData.append('_token', '{{ csrf_token() }}');

    const progressBar = document.getElementById('progressBar');
    const errorMessages = document.getElementById('errorMessages');
    const successMessage = document.getElementById('successMessage');

    errorMessages.classList.add('d-none');
    errorMessages.querySelector('ul').innerHTML = '';
    successMessage.classList.add('d-none');

    try {
        const xhr = new XMLHttpRequest();

        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                const percent = Math.round((e.loaded / e.total) * 100);
                progressBar.style.width = percent + '%';
                progressBar.innerText = percent + '%';
            }
        });

        xhr.open('POST', "{{ route('documents.store') }}", true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                progressBar.style.width = '100%';
                progressBar.innerText = 'Upload complete!';
                successMessage.classList.remove('d-none');

                setTimeout(() => {
                    fileInput.value = '';
                    progressBar.style.width = '0%';
                    progressBar.innerText = '0%';
                    successMessage.classList.add('d-none');
                }, 3000);
            } else {
                let response;
                try {
                    response = JSON.parse(xhr.responseText);
                } catch (err) {
                    response = { errors: { document: ['Upload failed.'] } };
                }

                const errors = response.errors || { document: ['Upload failed.'] };
                errorMessages.classList.remove('d-none');
                const ul = errorMessages.querySelector('ul');
                ul.innerHTML = '';
                for (const key in errors) {
                    errors[key].forEach(msg => {
                        const li = document.createElement('li');
                        li.innerText = msg;
                        ul.appendChild(li);
                    });
                }
            }
        };

        xhr.send(formData);
    } catch (err) {
        console.error('Upload error:', err);
    }
});
</script>
@endsection
