@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-warning">
            <h4 class="mb-0">
                <i class="fas fa-edit"></i> Edit Resident
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('residents.update', $resident->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <h5 class="border-bottom pb-2">Personal Information</h5>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">First Name *</label>
                            <input type="text" name="first_name" class="form-control" 
                                   value="{{ old('first_name', $resident->first_name) }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Middle Name</label>
                            <input type="text" name="middle_name" class="form-control" 
                                   value="{{ old('middle_name', $resident->middle_name) }}">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Last Name *</label>
                            <input type="text" name="last_name" class="form-control" 
                                   value="{{ old('last_name', $resident->last_name) }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Suffix</label>
                            <select name="suffix" class="form-control">
                                <option value="">None</option>
                                <option value="Jr." {{ $resident->suffix == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                                <option value="Sr." {{ $resident->suffix == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                                <option value="III" {{ $resident->suffix == 'III' ? 'selected' : '' }}>III</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Birth Date *</label>
                            <input type="date" name="birth_date" class="form-control" 
                                   value="{{ old('birth_date', $resident->birth_date->format('Y-m-d')) }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-control">
                                <option value="Male" {{ $resident->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $resident->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Civil Status</label>
                            <select name="civil_status" class="form-control">
                                <option {{ $resident->civil_status == 'Single' ? 'selected' : '' }}>Single</option>
                                <option {{ $resident->civil_status == 'Married' ? 'selected' : '' }}>Married</option>
                                <option {{ $resident->civil_status == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                <option {{ $resident->civil_status == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-12 mt-3 mb-3">
                        <h5 class="border-bottom pb-2">Address Information</h5>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Sitio</label>
                            <input type="text" name="sitio" class="form-control" 
                                   value="{{ old('sitio', $resident->sitio) }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Street Address</label>
                            <input type="text" name="street_address" class="form-control" 
                                   value="{{ old('street_address', $resident->street_address) }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Household Number</label>
                            <input type="text" name="household_number" class="form-control" 
                                   value="{{ old('household_number', $resident->household_number) }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" class="form-control" 
                                   value="{{ old('contact_number', $resident->contact_number) }}">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Occupation</label>
                            <input type="text" name="occupation" class="form-control" 
                                   value="{{ old('occupation', $resident->occupation) }}">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Religion</label>
                            <input type="text" name="religion" class="form-control" 
                                   value="{{ old('religion', $resident->religion) }}">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Current Photo</label>
                            @if($resident->photo)
                                <div>
                                    <img src="{{ Storage::url($resident->photo) }}" width="100" class="img-thumbnail">
                                </div>
                            @endif
                            <input type="file" name="photo" class="form-control mt-2" accept="image/*">
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Resident
                    </button>
                    <a href="{{ route('residents.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection