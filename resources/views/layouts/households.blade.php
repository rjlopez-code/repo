@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">
        <i class="fas fa-home text-info"></i> 
        Household Grouping
    </h2>
    
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Households</h5>
                    <h2 class="mb-0">{{ $households->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Residents</h5>
                    <h2 class="mb-0">{{ $households->sum(function($h) { return $h->familyMembers->count() + 1; }) }}</h2>
                </div>
            </div>
        </div>
    </div>
    
    @forelse($households as $household)
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">
                <i class="fas fa-home"></i> 
                Household #{{ $household->household_number }} - Head: {{ $household->full_name }}
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Member Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Civil Status</th>
                            <th>Occupation</th>
                            <th>Contact</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="table-primary">
                            <td>
                                <strong>{{ $household->full_name }}</strong>
                                <br><small class="text-muted">(Head of Family)</small>
                            </td>
                            <td>{{ $household->age }}</td>
                            <td>{{ $household->gender }}</td>
                            <td>{{ $household->civil_status }}</td>
                            <td>{{ $household->occupation ?? 'N/A' }}</td>
                            <td>{{ $household->contact_number ?? 'N/A' }}</td>
                        </tr>
                        @foreach($household->familyMembers as $member)
                        <tr>
                            <td>{{ $member->full_name }} </td>
                            <td>{{ $member->age }}</td>
                            <td>{{ $member->gender }}</td>
                            <td>{{ $member->civil_status }}</td>
                            <td>{{ $member->occupation ?? 'N/A' }}</td>
                            <td>{{ $member->contact_number ?? 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                <strong>Address:</strong> {{ $household->sitio }}, {{ $household->street_address }}
            </div>
        </div>
    </div>
    @empty
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> No households found. Add residents and mark them as head of family.
    </div>
    @endforelse
</div>
@endsection