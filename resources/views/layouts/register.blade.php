<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Barangay MS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 50px 0;
        }
        .register-card {
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px;
        }
        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: bold;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card register-card">
                    <div class="card-header text-white text-center">
                        <i class="fas fa-user-plus fa-2x mb-2"></i>
                        <h3 class="mb-0">Create New Account</h3>
                        <p class="mb-0 mt-2">Register as Barangay Personnel</p>
                    </div>
                    <div class="card-body p-4">
                        @if(session('success'))
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            </div>
                        @endif
                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i> Please fix the following errors:
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            
                            <!-- Role Selection - SIMPLE DROPDOWN -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Select Role <span class="text-danger">*</span></label>
                                <select name="role" class="form-control" required>
                                    <option value="">-- Select Account Type --</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>👑 Administrator (Full Access)</option>
                                    <option value="official" {{ old('role') == 'official' ? 'selected' : '' }}>👔 Barangay Official (Limited Access)</option>
                                </select>
                            </div>
                            
                            <!-- Personal Information -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Enter your full name" value="{{ old('name') }}" required>
                                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required>
                                @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Position/Title <span class="text-danger">*</span></label>
                                <select name="position" class="form-control" required>
                                    <option value="">Select Position</option>
                                    <option value="Barangay Captain" {{ old('position') == 'Barangay Captain' ? 'selected' : '' }}>Barangay Captain</option>
                                    <option value="Barangay Secretary" {{ old('position') == 'Barangay Secretary' ? 'selected' : '' }}>Barangay Secretary</option>
                                    <option value="Barangay Treasurer" {{ old('position') == 'Barangay Treasurer' ? 'selected' : '' }}>Barangay Treasurer</option>
                                    <option value="Kagawad" {{ old('position') == 'Kagawad' ? 'selected' : '' }}>Kagawad</option>
                                    <option value="SK Chairman" {{ old('position') == 'SK Chairman' ? 'selected' : '' }}>SK Chairman</option>
                                    <option value="Barangay Administrator" {{ old('position') == 'Barangay Administrator' ? 'selected' : '' }}>Barangay Administrator</option>
                                    <option value="Barangay Staff" {{ old('position') == 'Barangay Staff' ? 'selected' : '' }}>Barangay Staff</option>
                                </select>
                                @error('position') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" placeholder="Minimum 8 characters" required>
                                <small class="text-muted">Password must be at least 8 characters</small>
                                @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm your password" required>
                            </div>
                            
                            <button type="submit" class="btn btn-register text-white w-100">
                                <i class="fas fa-user-plus me-2"></i> Register Account
                            </button>
                        </form>
                        
                        <div class="text-center mt-4">
                            <p class="mb-0">Already have an account?</p>
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                <i class="fas fa-sign-in-alt me-1"></i> Login Here
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>