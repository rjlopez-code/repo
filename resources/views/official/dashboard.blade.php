<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Barangay Management System | Admin Portal</title>

    <!-- Bootstrap 5 CSS + Icons + Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        body {
            background: #f0f2f8;
            margin: 0;
            padding: 0;
        }

        /* modern sidebar */
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(145deg, #0b2b44 0%, #123b5e 100%);
            color: white;
            transition: all 0.2s;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.06);
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.85);
            padding: 12px 18px;
            margin: 6px 12px;
            border-radius: 14px;
            font-weight: 500;
            transition: 0.2s;
        }

        .sidebar .nav-link i {
            width: 28px;
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.15);
            color: white;
            transform: translateX(4px);
        }

        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.22);
            color: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .user-profile-side {
            border-bottom: 1px solid rgba(255,255,255,0.2);
            margin-bottom: 16px;
        }

        /* card design */
        .card-modern {
            border: none;
            border-radius: 24px;
            box-shadow: 0 10px 25px -8px rgba(0,0,0,0.06);
            background: white;
            transition: all 0.2s;
            margin-bottom: 28px;
            overflow: hidden;
        }

        .card-header-custom {
            background: white;
            padding: 1rem 1.5rem;
            border-bottom: 2px solid #eef2f9;
            font-weight: 700;
            font-size: 1.2rem;
            color: #1e2f4e;
        }

        .stat-card {
            background: white;
            border-radius: 28px;
            padding: 1.2rem 1rem;
            transition: 0.2s;
            height: 100%;
            border-left: 6px solid;
            box-shadow: 0 6px 14px rgba(0,0,0,0.02);
        }

        /* add resident form - elegant card (inspired by screenshot) */
        .form-section-title {
            font-weight: 700;
            color: #1f3b62;
            border-left: 5px solid #2a73ff;
            padding-left: 14px;
            margin-bottom: 24px;
            font-size: 1.3rem;
        }

        .input-label {
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #556b88;
            margin-bottom: 6px;
        }

        .photo-upload-area {
            border: 2px dashed #cfdfed;
            border-radius: 24px;
            background: #fafcff;
            padding: 20px 10px;
            text-align: center;
            cursor: pointer;
            transition: 0.2s;
        }

        .photo-upload-area:hover {
            background: #f0f5fe;
            border-color: #2a73ff;
        }

        /* resident search & table modern */
        .search-bar-modern {
            border-radius: 60px;
            padding: 12px 20px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        }

        .resident-table th {
            background: #f8fafd;
            font-weight: 600;
            color: #1f3a5f;
            border-bottom: 2px solid #e4ecf5;
            padding: 14px 12px;
        }

        .resident-table td {
            vertical-align: middle;
            padding: 14px 12px;
            border-color: #edf2f9;
        }

        .avatar-placeholder {
            width: 44px;
            height: 44px;
            background: #eef2ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2c6e9e;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .btn-outline-family {
            border-radius: 40px;
            border: 1px solid #cbdde9;
            background: white;
            padding: 5px 14px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .btn-outline-family:hover {
            background: #eef3fc;
        }

        .badge-purok {
            background: #eef2ff;
            color: #2c4e7a;
            border-radius: 30px;
            padding: 4px 10px;
            font-size: 0.7rem;
            font-weight: 500;
        }

        .action-btns .btn-sm {
            border-radius: 30px;
            margin: 0 2px;
            padding: 5px 12px;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }
        }

        /* modal custom */
        .family-modal-header {
            background: #f0f6fe;
            border-bottom: 1px solid #dde5f0;
        }
    </style>

</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">

        <!-- ================= SIDEBAR (modern) ================= -->
        <div class="col-md-2 col-lg-2 px-0 sidebar">
            <div class="d-flex flex-column h-100">
                <div class="text-center py-4 user-profile-side">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex p-2 mb-2" style="background: rgba(255,255,255,0.15);">
                        <i class="fas fa-user-shield fa-3x" style="color: white;"></i>
                    </div>
                    <h5 class="mt-2 fw-bold">Barangay Portal</h5>
                    <small class="d-block text-light">Administrator</small>
                    <span class="badge bg-light text-dark mt-2 px-3 py-1 rounded-pill">Admin Role</span>
                </div>

                <nav class="nav flex-column mt-2">
                    <a class="nav-link active" href="#" id="navDashboardLink">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a class="nav-link" href="#" id="navAddResidentLink">
                        <i class="fas fa-user-plus"></i> Add Resident
                    </a>
                    <a class="nav-link" href="#" id="navResidentsLink">
                        <i class="fas fa-users"></i> Residents List
                    </a>
                    <hr class="bg-light opacity-25 my-3 mx-3">
                    <a class="nav-link text-danger" href="#" id="logoutBtn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </nav>
                <div class="mt-auto p-3 text-center small text-white-50">
                    <i class="far fa-building"></i> eBarangay v2.0
                </div>
            </div>
        </div>

        <!-- ================= MAIN CONTENT AREA ================= -->
        <div class="col-md-10 col-lg-10 p-3 p-md-4" style="background: #f0f2f8;">
            <div id="dynamicContent">
                <!-- content loaded dynamically via js -->
            </div>
        </div>
    </div>
</div>

<!-- FAMILY MODAL (view household) -->
<div class="modal fade" id="familyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-4">

            <div class="modal-header family-modal-header border-0 rounded-top-4">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-users me-2"></i> Family Household
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4" id="familyModalBody">
                <!-- dynamic family members table -->
            </div>

            <div class="modal-footer bg-light border-0 rounded-bottom-4">
                <button type="button" class="btn btn-outline-primary" onclick="printFamily()">
                    <i class="fas fa-print me-1"></i> Print
                </button>

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function printFamily() {
    const content = document.getElementById("familyModalBody").innerHTML;

    const printWindow = window.open("", "", "width=900,height=650");
    printWindow.document.write(`
        <html>
        <head>
            <title>Family Household Print</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body { font-family: Arial; padding: 20px; }
                table { width: 100%; border-collapse: collapse; }
                table, th, td { border: 1px solid #ddd; }
                th, td { padding: 8px; text-align: left; }
                h3 { margin-bottom: 15px; }
            </style>
        </head>
        <body>
            <h3>Family Household Record</h3>
            ${content}
        </body>
        </html>
    `);

    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}
    // ---------- RESIDENTS DATA MODEL (enriched with family ID, purok, middle name, relationship, photo) ----------
    let residents = [
        { id: 1, first_name: "Jeanica", middle_name: "D.", last_name: "Peñaflorida", age: 21, birthdate: "2004-01-06", gender: "Female", relationship: "Child", purok: "Beri", family_id: "FAM-001", photo: null },
        { id: 2, first_name: "Wella Revi Mae", middle_name: "S.", last_name: "Peñaflorida", age: 19, birthdate: "2006-02-19", gender: "Female", relationship: "Child", purok: "Beri", family_id: "FAM-001", photo: null },
        { id: 3, first_name: "Jan Lenard", middle_name: "M.", last_name: "Peñaflorida", age: 18, birthdate: "2008-03-25", gender: "Male", relationship: "Child", purok: "Beri", family_id: "FAM-001", photo: null },
        { id: 4, first_name: "Crisjan", middle_name: "P.", last_name: "Peñaflorida", age: 15, birthdate: "2011-02-19", gender: "Male", relationship: "Child", purok: "Beri", family_id: "FAM-001", photo: null },
        { id: 5, first_name: "Ricardo", middle_name: "R.", last_name: "Peñaflorida", age: 14, birthdate: "2012-02-19", gender: "Male", relationship: "Child", purok: "Beri", family_id: "FAM-001", photo: null },
        { id: 6, first_name: "Mary Jean", middle_name: "C.", last_name: "Peñaflorida", age: 50, birthdate: "1975-07-17", gender: "Female", relationship: "Mother", purok: "Beri", family_id: "FAM-001", photo: null },
        { id: 7, first_name: "Roberto", middle_name: "M.", last_name: "Dela Cruz", age: 42, birthdate: "1982-05-12", gender: "Male", relationship: "Head", purok: "Purok 3", family_id: "FAM-002", photo: null },
        { id: 8, first_name: "Luzviminda", middle_name: "G.", last_name: "Dela Cruz", age: 39, birthdate: "1986-09-23", gender: "Female", relationship: "Spouse", purok: "Purok 3", family_id: "FAM-002", photo: null }
    ];

    // helper: generate age from birthdate (if birthdate present)
    function computeAge(birthdateStr) {
        if (!birthdateStr) return null;
        const today = new Date();
        const birth = new Date(birthdateStr);
        let age = today.getFullYear() - birth.getFullYear();
        const m = today.getMonth() - birth.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) age--;
        return age;
    }

    // sync ages for all residents based on birthdate
    function syncAges() {
        residents.forEach(r => {
            if (r.birthdate && r.birthdate.trim() !== "") {
                r.age = computeAge(r.birthdate);
            }
        });
    }
    syncAges();

    // stats counters
    function updateStats() {
        const total = residents.length;
        const males = residents.filter(r => r.gender === "Male").length;
        const females = residents.filter(r => r.gender === "Female").length;
        document.getElementById("statTotal").innerText = total;
        document.getElementById("statMales").innerText = males;
        document.getElementById("statFemales").innerText = females;
    }

    // ---------- RENDER DASHBOARD (stat cards + searchable residents table, same style as screenshot 3 & 4) ----------
    let currentSearchTerm = "";

    function renderResidentsTableView() {
        let filtered = residents.filter(r => 
            r.last_name.toLowerCase().includes(currentSearchTerm.toLowerCase()) ||
            r.first_name.toLowerCase().includes(currentSearchTerm.toLowerCase())
        );

        const tbody = document.getElementById("residentsTableBody");
        if (!tbody) return;
        tbody.innerHTML = "";
        filtered.forEach(res => {
            const fullName = ${res.first_name} ${res.middle_name ? res.middle_name + ' ' : ''}${res.last_name};
            const photoHtml = <div class="avatar-placeholder"><i class="fas fa-user-circle fa-2x"></i></div>;
            const purokBadge = <span class="badge-purok"><i class="fas fa-map-marker-alt me-1"></i>${res.purok || "N/A"}</span>;
            const actions = `
                <div class="action-btns">
                    <button class="btn btn-sm btn-outline-primary rounded-pill edit-resident" data-id="${res.id}"><i class="fas fa-edit"></i> Edit</button>
                    <button class="btn btn-sm btn-outline-danger rounded-pill delete-resident" data-id="${res.id}"><i class="fas fa-trash"></i> Del</button>
                    <button class="btn btn-sm btn-outline-info rounded-pill view-family" data-id="${res.id}"><i class="fas fa-users"></i> Family</button>
                </div>
            `;
            tbody.innerHTML += `
                <tr>
                    <td class="align-middle">${photoHtml}</td>
                    <td class="align-middle fw-semibold">${escapeHtml(fullName)}</td>
                    <td class="align-middle">${purokBadge}</td>
                    <td class="align-middle">${actions}</td>
                </tr>
            `;
        });

        document.getElementById("searchResultCount").innerText = filtered.length;
        updateStats();
        attachTableEvents();
    }

    // helpers
    function escapeHtml(str) { if(!str) return ''; return str.replace(/[&<>]/g, function(m){if(m==='&') return '&amp;'; if(m==='<') return '&lt;'; if(m==='>') return '&gt;'; return m;}); }

    function attachTableEvents() {
        document.querySelectorAll('.edit-resident').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const id = parseInt(btn.getAttribute('data-id'));
                editResidentById(id);
            });
        });
        document.querySelectorAll('.delete-resident').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const id = parseInt(btn.getAttribute('data-id'));
                if(confirm("Delete resident permanently?")) {
                    residents = residents.filter(r => r.id !== id);
                    if(currentView === 'residents') renderResidentsTableView();
                    if(currentView === 'dashboard') renderDashboardHome();
                    updateStats();
                }
            });
        });
        document.querySelectorAll('.view-family').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const id = parseInt(btn.getAttribute('data-id'));
                showFamilyModal(id);
            });
        });
    }

    function editResidentById(id) {
        const resident = residents.find(r => r.id === id);
        if(!resident) return;
        const newFirst = prompt("Edit First Name:", resident.first_name);
        if(newFirst && newFirst.trim()) resident.first_name = newFirst.trim();
        const newLast = prompt("Edit Last Name:", resident.last_name);
        if(newLast && newLast.trim()) resident.last_name = newLast.trim();
        const newPurok = prompt("Edit Purok:", resident.purok || "");
        if(newPurok !== null) resident.purok = newPurok.trim() || "N/A";
        const newRelationship = prompt("Edit Relationship to Head:", resident.relationship || "");
        if(newRelationship !== null) resident.relationship = newRelationship.trim() || "Member";
        if(currentView === 'residents') renderResidentsTableView();
        if(currentView === 'dashboard') renderDashboardHome();
        updateStats();
    }

    function showFamilyModal(residentId) {
        const resident = residents.find(r => r.id === residentId);
        if(!resident) return;
        const familyMembers = residents.filter(m => m.family_id === resident.family_id);
        let html = <div class="table-responsive"><table class="table table-sm table-bordered align-middle"><thead class="table-light"><tr><th>PHOTO</th><th>FULL NAME</th><th>RELATIONSHIP</th><th>AGE</th><th>BIRTHDATE</th><th>GENDER</th></tr></thead><tbody>;
        familyMembers.forEach(m => {
            const full = ${m.first_name} ${m.middle_name ? m.middle_name+' ' : ''}${m.last_name};
            const photoIcon = <div class="avatar-placeholder" style="width:32px;height:32px;font-size:14px;"><i class="fas fa-user"></i></div>;
            html += `<tr>
                        <td>${photoIcon}</td>
                        <td><strong>${escapeHtml(full)}</strong></td>
                        <td>${escapeHtml(m.relationship || 'Member')}</td>
                        <td>${m.age || '?'}</td>
                        <td>${m.birthdate || 'N/A'}</td>
                        <td>${m.gender}</td>
                     </tr>`;
        });
        html += </tbody></table></div><div class="mt-2 text-muted small"><i class="fas fa-home"></i> Family ID: ${resident.family_id} | Purok: ${resident.purok}</div>;
        document.getElementById("familyModalBody").innerHTML = html;
        const modal = new bootstrap.Modal(document.getElementById('familyModal'));
        modal.show();
    }

    // ---------- ADD RESIDENT FORM (exactly matching 1st and 2nd screenshot style) ----------
    function renderAddResidentForm() {
        return `
            <div class="card-modern">
                <div class="card-header-custom"><i class="fas fa-user-plus me-2 text-primary"></i> Add New Resident</div>
                <div class="card-body p-4">
                    <div class="form-section-title">Personal Information</div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="input-label">First Name <span class="text-danger">*</span></div>
                            <input type="text" class="form-control rounded-3" id="addFirstName" placeholder="e.g., Maria">
                        </div>
                        <div class="col-md-4">
                            <div class="input-label">Middle Name</div>
                            <input type="text" class="form-control rounded-3" id="addMiddleName" placeholder="e.g., Santos">
                        </div>
                        <div class="col-md-4">
                            <div class="input-label">Last Name <span class="text-danger">*</span></div>
                            <input type="text" class="form-control rounded-3" id="addLastName" placeholder="e.g., Dela Cruz">
                        </div>
                    </div>

                    <div class="form-section-title mt-2">Residence Information</div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-5">
                            <div class="input-label">Family ID</div>
                            <input type="text" class="form-control rounded-3" id="addFamilyId" placeholder="e.g., FAM-2024-001">
                        </div>
                        <div class="col-md-5">
                            <div class="input-label">Purok / Zone</div>
                            <input type="text" class="form-control rounded-3" id="addPurok" placeholder="e.g., Purok 3">
                        </div>
                    </div>

                    <div class="form-section-title">Demographics</div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <div class="input-label">Birthdate</div>
                            <input type="date" class="form-control rounded-3" id="addBirthdate">
                        </div>
                        <div class="col-md-2">
                            <div class="input-label">Age (auto)</div>
                            <input type="text" class="form-control bg-light" id="addAgeDisplay" readonly placeholder="Auto">
                        </div>
                        <div class="col-md-3">
                            <div class="input-label">Relationship to Head</div>
                            <input type="text" class="form-control rounded-3" id="addRelationship" placeholder="e.g., Daughter, Son">
                        </div>
                        <div class="col-md-2">
                            <div class="input-label">Gender</div>
                            <select class="form-select rounded-3" id="addGender">
                                <option>Select Gender</option><option>Male</option><option>Female</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <div class="input-label">Resident Photo</div>
                            <div class="photo-upload-area" id="photoUploadTrigger">
                                <i class="fas fa-camera fa-2x text-secondary"></i>
                                <div class="small mt-1">Click to upload</div>
                                <input type="file" id="photoFileInput" accept="image/*" style="display:none">
                                <div id="photoNameDisplay" class="small text-muted">No file chosen</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-4 pt-2">
                        <button type="button" class="btn btn-secondary px-4 rounded-pill" id="clearFormBtn"><i class="fas fa-eraser"></i> Clear Form</button>
                        <button type="button" class="btn btn-primary px-5 rounded-pill" id="saveResidentBtn"><i class="fas fa-save"></i> Save Resident</button>
                    </div>
                </div>
            </div>
        `;
    }

    let currentPhotoBase64 = null;
    let currentView = "dashboard";

    function bindAddResidentEvents() {
        const birthdateInput = document.getElementById('addBirthdate');
        const ageDisplay = document.getElementById('addAgeDisplay');
        if(birthdateInput) {
            birthdateInput.addEventListener('change', function() {
                if(this.value) {
                    const age = computeAge(this.value);
                    ageDisplay.value = age ? age : '';
                } else ageDisplay.value = '';
            });
        }
        const photoTrigger = document.getElementById('photoUploadTrigger');
        const fileInput = document.getElementById('photoFileInput');
        const photoNameSpan = document.getElementById('photoNameDisplay');
        if(photoTrigger && fileInput) {
            photoTrigger.addEventListener('click', () => fileInput.click());
            fileInput.addEventListener('change', function(e) {
                if(this.files && this.files[0]) {
                    photoNameSpan.innerText = this.files[0].name;
                    const reader = new FileReader();
                    reader.onload = function(ev) { currentPhotoBase64 = ev.target.result; };
                    reader.readAsDataURL(this.files[0]);
                } else { photoNameSpan.innerText = "No file chosen"; currentPhotoBase64 = null; }
            });
        }
        document.getElementById('clearFormBtn')?.addEventListener('click', () => {
            document.getElementById('addFirstName').value = '';
            document.getElementById('addMiddleName').value = '';
            document.getElementById('addLastName').value = '';
            document.getElementById('addFamilyId').value = '';
            document.getElementById('addPurok').value = '';
            document.getElementById('addBirthdate').value = '';
            document.getElementById('addAgeDisplay').value = '';
            document.getElementById('addRelationship').value = '';
            document.getElementById('addGender').value = 'Select Gender';
            if(fileInput) fileInput.value = '';
            if(photoNameSpan) photoNameSpan.innerText = "No file chosen";
            currentPhotoBase64 = null;
        });
        document.getElementById('saveResidentBtn')?.addEventListener('click', () => {
            const fname = document.getElementById('addFirstName')?.value.trim();
            const lname = document.getElementById('addLastName')?.value.trim();
            if(!fname || !lname) { alert("First Name and Last Name are required"); return; }
            const mname = document.getElementById('addMiddleName')?.value.trim() || "";
            const familyId = document.getElementById('addFamilyId')?.value.trim() || "FAM-"+Math.floor(Math.random()*900+100);
            const purok = document.getElementById('addPurok')?.value.trim() || "Not specified";
            const birthdate = document.getElementById('addBirthdate')?.value;
            let ageVal = null;
            if(birthdate) ageVal = computeAge(birthdate);
            const relationship = document.getElementById('addRelationship')?.value.trim() || "Member";
            const gender = document.getElementById('addGender')?.value;
            if(!gender || gender === "Select Gender") { alert("Select gender"); return; }
            const newId = residents.length ? Math.max(...residents.map(r=>r.id)) + 1 : 100;
            residents.push({
                id: newId, first_name: fname, middle_name: mname, last_name: lname,
                age: ageVal || 0, birthdate: birthdate || "", gender: gender,
                relationship: relationship, purok: purok, family_id: familyId, photo: currentPhotoBase64
            });
            syncAges();
            alert("Resident saved successfully!");
            if(currentView === 'dashboard') renderDashboardHome();
            else if(currentView === 'residents') renderResidentsTableView();
            updateStats();
            document.getElementById('clearFormBtn')?.click();
        });
    }

    // Dashboard main view: stat cards + residents list search (like screenshot 3&4)
    function renderDashboardHome() {
        const mainDiv = document.getElementById('dynamicContent');
        mainDiv.innerHTML = `
            <div class="row mb-4">
                <div class="col-md-4"><div class="stat-card border-left-primary" style="border-left-color: #2a73ff;"><h6 class="text-secondary">Total Residents</h6><h2 class="fw-bold" id="statTotal">0</h2></div></div>
                <div class="col-md-4"><div class="stat-card border-left-success" style="border-left-color: #28a745;"><h6 class="text-secondary">Males</h6><h2 class="fw-bold" id="statMales">0</h2></div></div>
                <div class="col-md-4"><div class="stat-card border-left-danger" style="border-left-color: #dc3545;"><h6 class="text-secondary">Females</h6><h2 class="fw-bold" id="statFemales">0</h2></div></div>
            </div>
            <div class="card-modern">
                <div class="card-header-custom d-flex justify-content-between align-items-center flex-wrap">
                    <span><i class="fas fa-list-ul me-2"></i> Resident Directory</span>
                    <div class="position-relative mt-2 mt-sm-0">
                        <input type="text" id="globalSearchInput" class="form-control search-bar-modern" placeholder="Enter last name to search... 🔍" style="width: 260px;">
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="p-3 bg-light border-bottom small">Found <span id="searchResultCount">0</span> resident(s) in the barangay</div>
                    <div class="table-responsive">
                        <table class="table resident-table mb-0">
                            <thead><tr><th>PHOTO</th><th>NAME</th><th>PUROK</th><th>ACTION</th></tr></thead>
                            <tbody id="residentsTableBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        `;
        updateStats();
        renderResidentsTableView();
        const searchInput = document.getElementById('globalSearchInput');
        if(searchInput) {
            searchInput.addEventListener('input', (e) => { currentSearchTerm = e.target.value; renderResidentsTableView(); });
        }
        attachTableEvents();
    }

    // navigation handler
    function setActiveView(view) {
        currentView = view;
        const mainDiv = document.getElementById('dynamicContent');
        if(view === 'add') {
            mainDiv.innerHTML = renderAddResidentForm();
            bindAddResidentEvents();
        } else if(view === 'residents') {
            mainDiv.innerHTML = `
                <div class="card-modern">
                    <div class="card-header-custom d-flex justify-content-between"><span><i class="fas fa-users"></i> All Residents</span><input type="text" id="residentSearchInput" class="form-control form-control-sm w-50" placeholder="Search by last name... 🔍"></div>
                    <div class="card-body p-0"><div class="table-responsive"><table class="table resident-table mb-0"><thead><tr><th>PHOTO</th><th>FULL NAME</th><th>PUROK</th><th>ACTIONS</th></tr></thead><tbody id="residentsTableBody"></tbody></table></div><div class="p-2 text-muted small ps-3">Found <span id="searchResultCount">0</span> residents</div></div>
                </div>
            `;
            const search = document.getElementById('residentSearchInput');
            if(search) search.addEventListener('input', (e) => { currentSearchTerm = e.target.value; renderResidentsTableView(); });
            renderResidentsTableView();
        } else {
            renderDashboardHome();
        }
        document.querySelectorAll('.sidebar .nav-link').forEach(link => link.classList.remove('active'));
        if(view === 'add') document.getElementById('navAddResidentLink')?.classList.add('active');
        else if(view === 'residents') document.getElementById('navResidentsLink')?.classList.add('active');
        else document.getElementById('navDashboardLink')?.classList.add('active');
    }

    // event listeners for sidebar
    document.getElementById('navDashboardLink')?.addEventListener('click', (e) => { e.preventDefault(); setActiveView('dashboard'); });
    document.getElementById('navAddResidentLink')?.addEventListener('click', (e) => { e.preventDefault(); setActiveView('add'); });
    document.getElementById('navResidentsLink')?.addEventListener('click', (e) => { e.preventDefault(); setActiveView('residents'); });
    document.getElementById('logoutBtn')?.addEventListener('click', (e) => { e.preventDefault(); alert("Logout simulation — session cleared"); });

    // initial load
    setActiveView('dashboard');
</script>
</body>
</html>
cdn.jsdelivr.net
Compose
Write to RenaJean Lopez
