<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Document Approval System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Hero Section -->
    <div class="container flex-grow-1 d-flex flex-column justify-content-center align-items-center text-center py-5">
        <h1 class="display-4 fw-bold text-dark mb-3">
            Document Approval System
        </h1>
        <p class="lead text-muted mb-5">
            A secure and efficient platform to upload, approve, and track documents.<br>
            Simplify workflows for both users and administrators.
        </p>

        <div class="d-flex gap-3 mb-5">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg shadow-sm px-4">Login</a>
            <a href="{{ route('register') }}" class="btn btn-success btn-lg shadow-sm px-4">Register</a>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold mb-2">📂 Easy Upload</h5>
                        <p class="card-text text-muted">
                            Upload documents quickly with secure storage and user-friendly forms.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold mb-2">✅ Fast Approval</h5>
                        <p class="card-text text-muted">
                            Admins can approve or reject documents instantly with just one click.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold mb-2">📊 Track Status</h5>
                        <p class="card-text text-muted">
                            Users can track pending, approved, and rejected documents anytime.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-3 text-muted border-top">
        &copy; {{ date('Y') }} Document Approval System. All rights reserved.
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
