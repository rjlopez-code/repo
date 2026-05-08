<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password - Barangay Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .reset-card {
            border-radius: 25px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            animation: fadeInUp 0.6s ease;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px;
        }
    </style>
</head>
<body>
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-md-5">
                <div class="card reset-card">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-key fa-3x text-primary mb-3"></i>
                            <h2 class="fw-bold">Forgot Password?</h2>
                            <p class="text-muted">Enter your email to reset your password</p>
                        </div>
                        
                        @if(session('success'))
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            </div>
                        @endif
                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i> {{ $errors->first() }}
                            </div>
                        @endif
                        
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-envelope me-1"></i> Email Address
                                </label>
                                <input type="email" name="email" class="form-control" 
                                       value="{{ old('email') }}" placeholder="Enter your registered email" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-paper-plane me-2"></i> Send Reset Link
                            </button>
                        </form>
                        
                        <div class="text-center mt-4">
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i> Back to Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>