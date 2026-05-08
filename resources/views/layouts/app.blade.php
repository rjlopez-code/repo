<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Barangay Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.9);
            padding: 12px 20px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.1);
        }
        .sidebar .nav-link i {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar">
                    <div class="text-center py-4">
                        <i class="fas fa-city fa-3x text-white"></i>
                        <h4 class="text-white mt-2">Barangay MS</h4>
                        @auth
                        <small class="text-white-50">
                            {{ Auth::user()->name }}
                            <br>
                            <span class="badge bg-light text-dark mt-1">
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                        </small>
                        @endauth
                    </div>
                    <nav class="nav flex-column">
                        @auth
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                        <a class="nav-link" href="{{ route('residents.index') }}">
                            <i class="fas fa-users"></i> Residents
                        </a>
                        <a class="nav-link" href="{{ route('residents.households') }}">
                            <i class="fas fa-home"></i> Households
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                            @csrf
                            <button type="submit" class="nav-link text-danger btn" 
                                    style="background: none; border: none; width: 100%; text-align: left;">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                        @else
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                        @endauth
                    </nav>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>