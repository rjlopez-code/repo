<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Officials Dashboard - Barangay System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            background: #f3f5f9;
            font-family: Arial;
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
        }

        .sidebar .nav-link {
            color: white;
            padding: 12px;
            margin: 5px;
            border-radius: 10px;
        }

        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.2);
        }

        .card-box {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .btn-edit { background: #ffc107; }
        .btn-delete { background: #dc3545; color: white; }
        .btn-family { background: #198754; color: white; }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-2 px-0">
            <div class="sidebar d-flex flex-column">

                <div class="text-center py-4">
                    <i class="fas fa-user-shield fa-3x"></i>
                    <h5 class="mt-2">Officials Panel</h5>

                    <small>
                        {{ Auth::user()->name }}
                        <br>
                        <span class="badge bg-light text-dark mt-1">
                            {{ Auth::user()->role }}
                        </span>
                    </small>
                </div>

                <nav class="nav flex-column mt-3">

                    <a class="nav-link active" href="#">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>

                    <a class="nav-link" href="#addResident">
                        <i class="fas fa-user-plus"></i> Add Resident
                    </a>

                    <a class="nav-link text-danger" href="{{ url('/logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>

                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </nav>

            </div>
        </div>

        <!-- MAIN -->
        <div class="col-md-10 p-4">

            <!-- WELCOME -->
            <div class="alert alert-info">
                Welcome <strong>{{ Auth::user()->name }}</strong> to Officials Dashboard
            </div>

            <!-- STATS -->
            <div class="row mb-4">

                <div class="col-md-4">
                    <div class="card card-box p-3 bg-primary text-white">
                        <h5>Total Residents</h5>
                        <h2 id="totalResidents">0</h2>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-box p-3 bg-success text-white">
                        <h5>Total Males</h5>
                        <h2 id="totalMales">0</h2>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-box p-3 bg-danger text-white">
                        <h5>Total Females</h5>
                        <h2 id="totalFemales">0</h2>
                    </div>
                </div>

            </div>

            <!-- ADD RESIDENT -->
            <div class="card card-box mb-4" id="addResident">

                <div class="card-header bg-primary text-white">
                    Add Resident
                </div>

                <div class="card-body">

                    <form id="residentForm">

                        <div class="row">

                            <div class="col-md-3 mb-2">
                                <input type="text" id="firstName" class="form-control" placeholder="First Name" required>
                            </div>

                            <div class="col-md-3 mb-2">
                                <input type="text" id="lastName" class="form-control" placeholder="Last Name" required>
                            </div>

                            <div class="col-md-2 mb-2">
                                <input type="number" id="age" class="form-control" placeholder="Age" required>
                            </div>

                            <div class="col-md-2 mb-2">
                                <select id="gender" class="form-control">
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>

                            <div class="col-md-2 mb-2">
                                <button class="btn btn-success w-100">Add</button>
                            </div>

                        </div>

                    </form>

                </div>
            </div>

            <!-- TABLE -->
            <div class="card card-box">

                <div class="card-header">
                    Resident List
                </div>

                <div class="card-body">

                    <table class="table table-hover">

                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody id="residentTable"></tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>
</div>

<script>
    let residents = [
        {id:1, first_name:"Juan", last_name:"Dela Cruz", age:45, gender:"Male"},
        {id:2, first_name:"Maria", last_name:"Santos", age:30, gender:"Female"}
    ];

    function render(){

        let table = document.getElementById('residentTable');
        table.innerHTML = "";

        residents.forEach(r => {

            table.innerHTML += `
                <tr>
                    <td>${r.first_name} ${r.last_name}</td>
                    <td>${r.age}</td>
                    <td>${r.gender}</td>
                    <td>

                        <button class="btn btn-sm btn-edit"
                            onclick="edit(${r.id})">
                            Edit
                        </button>

                        <button class="btn btn-sm btn-delete"
                            onclick="del(${r.id})">
                            Delete
                        </button>

                        <button class="btn btn-sm btn-family"
                            onclick="viewFamily(${r.id})">
                            Family
                        </button>

                    </td>
                </tr>
            `;
        });

        document.getElementById('totalResidents').innerText = residents.length;

        let males = residents.filter(r => r.gender=="Male").length;
        let females = residents.filter(r => r.gender=="Female").length;

        document.getElementById('totalMales').innerText = males;
        document.getElementById('totalFemales').innerText = females;
    }

    document.getElementById('residentForm')
    .addEventListener('submit', function(e){

        e.preventDefault();

        residents.push({
            id: residents.length+1,
            first_name: document.getElementById('firstName').value,
            last_name: document.getElementById('lastName').value,
            age: document.getElementById('age').value,
            gender: document.getElementById('gender').value
        });

        render();
        this.reset();
    });

    function edit(id){

        let r = residents.find(x => x.id==id);

        let name = prompt("Edit Name", r.first_name);

        if(name){
            r.first_name = name;
            render();
        }
    }

    function del(id){

        residents = residents.filter(r => r.id!=id);
        render();
    }

    function viewFamily(id){
        alert("Family feature (demo only)");
    }

    render();
</script>

</body>
</html>