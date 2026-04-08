from flask_sqlalchemy import SQLAlchemy
from werkzeug.security import generate_password_hash, check_password_hash

db = SQLAlchemy()

class User(db.Model):
    __tablename__ = 'users'

    id = db.Column(db.Integer, primary_key=True)
    username = db.Column(db.String(100), unique=True, nullable=False)
    password = db.Column(db.String(200), nullable=False)
    role = db.Column(db.String(20), nullable=False)  # 'admin' or 'official'
    full_name = db.Column(db.String(200))
    position = db.Column(db.String(100))  # For officials: Captain, Councilor, Secretary, etc.
    contact_number = db.Column(db.String(20))
    email = db.Column(db.String(100))
    is_active = db.Column(db.Boolean, default=True)
    last_login = db.Column(db.DateTime)
    created_at = db.Column(db.DateTime, server_default=db.func.now())

    def check_password(self, password):
        return check_password_hash(self.password, password)

    def is_admin(self):
        return self.role == 'admin'

    def is_official(self):
        return self.role == 'official'

class Resident(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    first_name = db.Column(db.String(100))
    middle_name = db.Column(db.String(100))
    last_name = db.Column(db.String(100))
    family_id = db.Column(db.String(100))
    purok = db.Column(db.String(100))
    age = db.Column(db.Integer)
    birthdate = db.Column(db.String(20))
    relationship = db.Column(db.String(100))
    gender = db.Column(db.String(20))
    photo = db.Column(db.String(200))

    # Audit fields
    created_by = db.Column(db.Integer, db.ForeignKey('users.id'))
    created_by_role = db.Column(db.String(20))
    created_at = db.Column(db.DateTime, server_default=db.func.now())
    updated_by = db.Column(db.Integer, db.ForeignKey('users.id'))
    updated_at = db.Column(db.DateTime, onupdate=db.func.now())
