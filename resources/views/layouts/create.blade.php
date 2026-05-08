@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="fas fa-user-plus"></i> Add New Resident
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('residents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <!-- Personal Information -->
                    <div class="col-md-12 mb-3">
                        <h5 class="border-bottom pb-2">Personal Information</h5>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" 
                                   value="{{ old('first_name') }}" required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Middle Name</label>
                            <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name') }}">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" 
                                   value="{{ old('last_name') }}" required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Suffix</label>
                            <select name="suffix" class="form-control">
                                <option value="">None</option>
                                <option value="Jr.">Jr.</option>
                                <option value="Sr.">Sr.</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Birth Date <span class="text-danger">*</span></label>
                            <input type="date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror" 
                                   value="{{ old('birth_date') }}" required>
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Gender <span class="text-danger">*</span></label>
                            <select name="gender" class="form-control @error('gender') is-invalid @enderror" required>
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Civil Status <span class="text-danger">*</span></label>
                            <select name="civil_status" class="form-control @error('civil_status') is-invalid @enderror" required>
                                <option value="">Select Status</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                            @error('civil_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Address Information -->
                    <div class="col-md-12 mt-3 mb-3">
                        <h5 class="border-bottom pb-2">Address Information</h5>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Sitio <span class="text-danger">*</span></label>
                            <input type="text" name="sitio" class="form-control @error('sitio') is-invalid @enderror" 
                                   value="{{ old('sitio') }}" required>
                            @error('sitio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Street Address <span class="text-danger">*</span></label>
                            <input type="text" name="street_address" class="form-control @error('street_address') is-invalid @enderror" 
                                   value="{{ old('street_address') }}" required>
                            @error('street_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Household Number <span class="text-danger">*</span></label>
                            <input type="text" name="household_number" class="form-control @error('household_number') is-invalid @enderror" 
                                   value="{{ old('household_number') }}" required>
                            @error('household_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Contact Information -->
                    <div class="col-md-12 mt-3 mb-3">
                        <h5 class="border-bottom pb-2">Contact & Other Information</h5>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number') }}">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Occupation</label>
                            <input type="text" name="occupation" class="form-control" value="{{ old('occupation') }}">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Religion</label>
                            <input type="text" name="religion" class="form-control" value="{{ old('religion') }}">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Citizenship</label>
                            <input type="text" name="citizenship" class="form-control" value="{{ old('citizenship', 'Filipino') }}">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Photo</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                            <small class="text-muted">Max 2MB (JPG, PNG)</small>
                        </div>
                    </div>
                    
                    <!-- Family Information -->
                    <div class="col-md-12 mt-3 mb-3">
                        <h5 class="border-bottom pb-2">Family Information</h5>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Head of Family?</label>
                            <select name="is_head_of_family" class="form-control" id="is_head_of_family">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6" id="family_head_div">
                        <div class="mb-3">
                            <label class="form-label">Family Head</label>
                            <select name="family_head_id" class="form-control">
                                <option value="">Select Family Head</option>
                                @foreach($familyHeads as $head)
                                    <option value="{{ $head->id }}">{{ $head->full_name }} ({{ $head->household_number }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Save Resident
                    </button>
                    <a href="{{ route('residents.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('is_head_of_family').addEventListener('change', function() {
        var familyHeadDiv = document.getElementById('family_head_div');
        if(this.value == '1') {
            familyHeadDiv.style.display = 'none';
        } else {
            familyHeadDiv.style.display = 'block';
        }
    });
</script>
@endpush
@endsection