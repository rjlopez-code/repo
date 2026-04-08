from flask import Flask, render_template, request, redirect, session, url_for, flash, send_file
from models import db, User, Resident
from werkzeug.security import generate_password_hash, check_password_hash
from werkzeug.utils import secure_filename
import os
from datetime import datetime
from functools import wraps
from reportlab.platypus import SimpleDocTemplate, Paragraph, Spacer
from reportlab.lib.styles import ParagraphStyle
from reportlab.lib import colors
from reportlab.lib.units import inch
from reportlab.lib.pagesizes import letter
from reportlab.platypus import Table
from reportlab.platypus import TableStyle

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///barangay.db'
app.config['SECRET_KEY'] = 'secretkey'
app.config['UPLOAD_FOLDER'] = 'static/uploads'
db.init_app(app)

os.makedirs(app.config['UPLOAD_FOLDER'], exist_ok=True)

with app.app_context():
    db.create_all()

    # Create default admin if not exists
    if not User.query.filter_by(role='admin').first():
        admin = User(
            username="admin",
            password=generate_password_hash("admin123"),
            role="admin",
            full_name="System Administrator",
            position="System Admin"
        )
        db.session.add(admin)

    # Create default official users if not exists
    if not User.query.filter_by(role='official').first():
        officials = [
            User(
                username="captain",
                password=generate_password_hash("captain123"),
                role="official",
                full_name="Maria Santos",
                position="Barangay Captain",
                contact_number="09123456789",
                email="captain@barangay.gov"
            ),
            User(
                username="secretary",
                password=generate_password_hash("secretary123"),
                role="official",
                full_name="Juan Dela Cruz",
                position="Barangay Secretary",
                contact_number="09234567890",
                email="secretary@barangay.gov"
            ),
            User(
                username="treasurer",
                password=generate_password_hash("treasurer123"),
                role="official",
                full_name="Ana Reyes",
                position="Barangay Treasurer",
                contact_number="09345678901",
                email="treasurer@barangay.gov"
            )
        ]
        for official in officials:
            db.session.add(official)

    db.session.commit()

# Login decorators
def login_required(f):
    @wraps(f)
    def decorated_function(*args, **kwargs):
        if 'user_id' not in session:
            flash('Please login first', 'warning')
            return redirect(url_for('login'))
        return f(*args, **kwargs)
    return decorated_function

def admin_required(f):
    @wraps(f)
    def decorated_function(*args, **kwargs):
        if 'user_id' not in session:
            flash('Please login first', 'warning')
            return redirect(url_for('login'))
        if session.get('role') != 'admin':
            flash('Admin access required', 'danger')
            return redirect(url_for('dashboard'))
        return f(*args, **kwargs)
    return decorated_function

def official_required(f):
    @wraps(f)
    def decorated_function(*args, **kwargs):
        if 'user_id' not in session:
            flash('Please login first', 'warning')
            return redirect(url_for('login'))
        if session.get('role') not in ['admin', 'official']:
            flash('Official access required', 'danger')
            return redirect(url_for('dashboard'))
        return f(*args, **kwargs)
    return decorated_function

# LOGIN
@app.route("/", methods=["GET", "POST"])
def login():
    if request.method == "POST":
        user = User.query.filter_by(username=request.form["username"]).first()
        if user and user.check_password(request.form["password"]):
            if not user.is_active:
                flash('Your account is deactivated. Please contact admin.', 'danger')
                return redirect(url_for('login'))

            session["user_id"] = user.id
            session["username"] = user.username
            session["role"] = user.role
            session["full_name"] = user.full_name
            session["position"] = user.position

            # Update last login
            user.last_login = datetime.now()
            db.session.commit()

            # Custom welcome message based on role
            if user.role == 'admin':
                flash(f'Welcome back Admin {user.full_name}!', 'success')
            else:
                flash(f'Welcome Barangay Official {user.full_name} ({user.position})!', 'success')

            return redirect("/dashboard")
        flash("Invalid username or password", "danger")
    return render_template("login.html")

# LOGOUT
@app.route("/logout")
def logout():
    session.clear()
    flash('You have been logged out', 'info')
    return redirect("/")

# DASHBOARD
@app.route("/dashboard")
@login_required
def dashboard():
    total_residents = Resident.query.count()
    total_families = db.session.query(Resident.family_id).distinct().count()
    total_male = Resident.query.filter_by(gender="Male").count()
    total_female = Resident.query.filter_by(gender="Female").count()
    total_other = Resident.query.filter_by(gender="Other").count()

    # Get recent activities (last 5 residents added)
    recent_residents = Resident.query.order_by(Resident.id.desc()).limit(5).all()

    # Get user info for dashboard
    user_info = {
        'name': session.get('full_name', session.get('username')),
        'role': session.get('role'),
        'position': session.get('position')
    }

    return render_template("dashboard.html",
                           total_residents=total_residents,
                           total_families=total_families,
                           total_male=total_male,
                           total_female=total_female,
                           total_other=total_other,
                           recent_residents=recent_residents,
                           user=user_info)

# CHANGE PASSWORD
@app.route("/change_password", methods=["GET", "POST"])
@login_required
def change_password():
    if request.method == "POST":
        old_password = request.form.get("old_password")
        new_password = request.form.get("new_password")
        confirm_password = request.form.get("confirm_password")

        user = User.query.get(session["user_id"])

        if not user.check_password(old_password):
            flash("❌ Old password is incorrect", "danger")
        elif new_password != confirm_password:
            flash("❌ New password and confirmation do not match", "danger")
        else:
            user.password = generate_password_hash(new_password)
            db.session.commit()
            flash("✅ Password successfully updated!", "success")
            return redirect("/dashboard")

    return render_template("change_password.html")

# USER MANAGEMENT (Admin only)
@app.route("/users")
@admin_required
def list_users():
    users = User.query.all()
    return render_template("users.html", users=users)

@app.route("/users/add", methods=["GET", "POST"])
@admin_required
def add_user():
    if request.method == "POST":
        # Check if username exists
        if User.query.filter_by(username=request.form["username"]).first():
            flash("Username already exists", "danger")
            return redirect(url_for("add_user"))

        user = User(
            username=request.form["username"],
            password=generate_password_hash(request.form["password"]),
            role=request.form["role"],
            full_name=request.form["full_name"],
            position=request.form.get("position", ""),
            contact_number=request.form.get("contact_number", ""),
            email=request.form.get("email", "")
        )
        db.session.add(user)
        db.session.commit()
        flash(f"User {user.username} created successfully!", "success")
        return redirect(url_for("list_users"))

    return render_template("add_user.html")

@app.route("/users/edit/<int:id>", methods=["GET", "POST"])
@admin_required
def edit_user(id):
    user = User.query.get_or_404(id)

    if request.method == "POST":
        user.full_name = request.form["full_name"]
        user.role = request.form["role"]
        user.position = request.form.get("position", "")
        user.contact_number = request.form.get("contact_number", "")
        user.email = request.form.get("email", "")
        user.is_active = 'is_active' in request.form

        # Update password if provided
        if request.form.get("new_password"):
            user.password = generate_password_hash(request.form["new_password"])

        db.session.commit()
        flash(f"User {user.username} updated successfully!", "success")
        return redirect(url_for("list_users"))

    return render_template("edit_user.html", user=user)

@app.route("/users/delete/<int:id>")
@admin_required
def delete_user(id):
    user = User.query.get_or_404(id)

    # Don't allow deleting yourself
    if user.id == session["user_id"]:
        flash("You cannot delete your own account", "danger")
        return redirect(url_for("list_users"))

    db.session.delete(user)
    db.session.commit()
    flash(f"User {user.username} deleted successfully!", "success")
    return redirect(url_for("list_users"))

# OFFICIALS MANAGEMENT (Admin only)
@app.route("/officials")
@admin_required
def list_officials():
    officials = User.query.filter_by(role='official').all()
    return render_template("officials.html", officials=officials)

# ADD RESIDENT (Accessible to both admin and officials)
@app.route("/add", methods=["GET", "POST"])
@official_required
def add():
    if request.method == "POST":
        file = request.files["photo"]
        filename = ""
        if file:
            filename = secure_filename(file.filename)
            file.save(os.path.join(app.config['UPLOAD_FOLDER'], filename))

        resident = Resident(
            first_name=request.form["first"],
            middle_name=request.form["middle"],
            last_name=request.form["last"],
            family_id=request.form["family"],
            purok=request.form["purok"],
            age=request.form["age"],
            birthdate=request.form["birthdate"],
            relationship=request.form["relationship"],
            gender=request.form["gender"],
            photo=filename,
            created_by=session["user_id"],
            created_by_role=session["role"]
        )
        db.session.add(resident)
        db.session.commit()
        flash("Resident added successfully!", "success")
        return redirect("/search")

    return render_template("add_resident.html")

# EDIT RESIDENT (Accessible to both admin and officials)
@app.route("/edit/<int:id>", methods=["GET", "POST"])
@official_required
def edit(id):
    resident = Resident.query.get_or_404(id)

    if request.method == "POST":
        resident.first_name = request.form["first"]
        resident.middle_name = request.form["middle"]
        resident.last_name = request.form["last"]
        resident.family_id = request.form["family"]
        resident.purok = request.form["purok"]
        resident.age = request.form["age"]
        resident.birthdate = request.form["birthdate"]
        resident.relationship = request.form["relationship"]
        resident.gender = request.form["gender"]
        resident.updated_by = session["user_id"]

        file = request.files.get("photo")
        if file and file.filename != "":
            filename = secure_filename(file.filename)
            file.save(os.path.join(app.config['UPLOAD_FOLDER'], filename))
            resident.photo = filename

        db.session.commit()
        flash("Resident Updated Successfully!", "success")
        return redirect("/search")

    return render_template("edit_resident.html", r=resident)

# DELETE RESIDENT (Admin only)
@app.route("/delete/<int:id>")
@admin_required
def delete(id):
    resident = Resident.query.get_or_404(id)
    db.session.delete(resident)
    db.session.commit()
    flash("Resident deleted successfully!", "success")
    return redirect("/search")

# SEARCH RESIDENTS (Accessible to both)
@app.route("/search", methods=["GET", "POST"])
@official_required
def search():
    residents = []
    if request.method == "POST":
        name = request.form["search"]
        residents = Resident.query.filter(
            Resident.last_name.like(f"%{name}%")
        ).all()
    else:
        # GET request - show all residents
        residents = Resident.query.order_by(Resident.last_name, Resident.first_name).all()

    return render_template("search.html", residents=residents, role=session.get('role'))

# FAMILY VIEW (Accessible to both)
@app.route("/family/<family_id>")
@official_required
def family(family_id):
    members = Resident.query.filter_by(family_id=family_id).all()
    return render_template("family.html", members=members, fid=family_id)

# PRINT PDF (Admin only now - officials cannot print)
@app.route("/print/<family_id>")
@login_required
def print_family(family_id):
    # Check if user is admin - only admin can print
    if session.get('role') != 'admin':
        flash("⚠️ Printing is only allowed for Admin users", "warning")
        return redirect(url_for('family', family_id=family_id))

    members = Resident.query.filter_by(family_id=family_id).all()
    filename = f"family_{family_id}.pdf"
    filepath = os.path.join("static", filename)

    doc = SimpleDocTemplate(filepath, pagesize=letter)
    elements = []

    data = [["Name", "Relationship", "Age", "Gender"]]
    for m in members:
        data.append([f"{m.first_name} {m.last_name}", m.relationship, m.age, m.gender])

    table = Table(data)
    table.setStyle(TableStyle([
        ('BACKGROUND', (0, 0), (-1, 0), colors.grey),
        ('GRID', (0, 0), (-1, -1), 1, colors.black)
    ]))

    elements.append(table)
    doc.build(elements)

    return send_file(filepath, as_attachment=True)

# PROFILE PAGE (For both admin and officials)
@app.route("/profile")
@login_required
def profile():
    user = User.query.get(session["user_id"])
    return render_template("profile.html", user=user)

# REGISTRATION PAGE FOR OFFICIALS
@app.route("/register", methods=["GET", "POST"])
def register():
    if request.method == "POST":
        # Check if username already exists
        existing_user = User.query.filter_by(username=request.form["username"]).first()
        if existing_user:
            flash("❌ Username already exists. Please choose another.", "danger")
            return redirect(url_for("register"))

        # Check if passwords match
        if request.form["password"] != request.form["confirm_password"]:
            flash("❌ Passwords do not match.", "danger")
            return redirect(url_for("register"))

        # Create new official user
        new_official = User(
            username=request.form["username"],
            password=generate_password_hash(request.form["password"]),
            role="official",  # Force role to be official
            full_name=request.form["full_name"],
            position=request.form["position"],
            contact_number=request.form["contact_number"],
            email=request.form["email"],
            is_active=True  # New accounts are active by default
        )

        db.session.add(new_official)
        db.session.commit()

        flash(f"✅ Registration successful! You can now login as {request.form['username']}", "success")
        return redirect(url_for("login"))

    return render_template("register.html")

# APPROVE OFFICIALS (Admin only)
@app.route("/approve_officials")
@admin_required
def approve_officials():
    # Get pending officials (you can add a 'is_approved' field if needed)
    pending_officials = User.query.filter_by(role='official', is_active=True).all()
    return render_template("approve_officials.html", officials=pending_officials)

# TOGGLE OFFICIAL STATUS (Admin only)
@app.route("/toggle_official/<int:id>")
@admin_required
def toggle_official(id):
    official = User.query.get_or_404(id)

    # Don't allow toggling yourself
    if official.id == session["user_id"]:
        flash("You cannot modify your own account", "danger")
        return redirect(url_for("approve_officials"))

    # Toggle active status
    official.is_active = not official.is_active
    status = "activated" if official.is_active else "deactivated"
    db.session.commit()

    flash(f"Official {official.full_name} has been {status}", "success")
    return redirect(url_for("approve_officials"))

# VIEW ALL RESIDENTS ROUTE (Fixed indentation)
@app.route('/residents')
@official_required
def view_all_residents():
    try:
        # Kunin ang lahat ng residents mula sa database
        residents = Resident.query.order_by(Resident.last_name, Resident.first_name).all()

        # I-render ang template kasama ang lahat ng residents
        return render_template('search.html', residents=residents, role=session.get('role'))
    except Exception as e:
        print(f"Error: {e}")
        flash("Error loading residents", "danger")
        return render_template('search.html', residents=[], role=session.get('role'))

if __name__ == "__main__":
    app.run(debug=True)
