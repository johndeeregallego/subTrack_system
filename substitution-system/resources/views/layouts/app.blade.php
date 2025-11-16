<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SubTrack Teacher Substitution System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-pV...your_integrity_hash..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    {{-- Custom CSS --}}
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .navbar {
            background: linear-gradient(90deg, #2563eb, #1e40af);
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
        }
        .card {
            border: none;
            border-radius: 12px;
        }
        .btn-rounded {
            border-radius: 25px;
            padding: 0.6rem 1.2rem;
        }
        footer {
            margin-top: 40px;
            padding: 15px 0;
            background-color: #1e293b;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">SubTrack Teacher Substitution System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a></li>
                    <li class="nav-item"><a href="{{ route('teachers.index') }}" class="nav-link">Teachers</a></li>
                    <li class="nav-item"><a href="{{ route('classes.index') }}" class="nav-link">Classes</a></li>
                    <li class="nav-item"><a href="{{ route('absences.index') }}" class="nav-link">Absences</a></li>
                    <li class="nav-item"><a href="{{ route('substitutions.index') }}" class="nav-link">Substitutions</a></li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Page Content --}}
    <main class="container my-5">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer>
        <div class="container">
            <small>© {{ date('Y') }} School Substitution System. All Rights Reserved.</small>
        </div>
    </footer>
<style>
/* 🔹 Tab hover effect */
#dayTabs .nav-link:hover {
    color: #0d6efd !important; /* Bootstrap primary blue */
    background-color: #e9f2ff !important; /* soft blue background */
}

/* Keep active tab consistent */
#dayTabs .nav-link.active:hover {
    color: #fff !important;
    background-color: #0d6efd !important;
}
</style>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
