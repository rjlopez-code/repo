<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Residents</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3>Residents List</h3>
            </div>
            <div class="card-body">
                <a href="/dashboard" class="btn btn-secondary mb-3">Back to Dashboard</a>
                <a href="{{ route('residents.create') }}" class="btn btn-primary mb-3">Add Resident</a>
                
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Sitio</th>
                            <th>Household #</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($residents as $resident)
                        <tr>
                            <td>{{ $resident->id }}</td>
                            <td>{{ $resident->first_name }} {{ $resident->last_name }}</td>
                            <td>{{ $resident->age }}</td>
                            <td>{{ $resident->gender }}</td>
                            <td>{{ $resident->sitio }}</td>
                            <td>{{ $resident->household_number }}</td>
                            <td>
                                <a href="{{ route('residents.edit', $resident->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('residents.destroy', $resident->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $residents->links() }}
            </div>
        </div>
    </div>
</body>
</html>