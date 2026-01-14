# Hospital Appointment System (CA226)
##GROUP NAME: k

iD NAME CLASS C1220985 Bakar Isse Mohamed C226 C1221273 Abdifitah Muse Gurhan C226 C1221165 Isse Abdi Siyad C226##

**Stack:** PHP (PDO), MySQL, HTML, CSS  
**Features:** Registration, login (sessions + remember-me cookie), role-based dashboard, appointment CRUD, session expiry (5 minutes), form validation, file uploads.

## Setup
1. Create a MySQL database and import `db/schema.sql`.
2. Update credentials in `config.php`.
3. Ensure `uploads/profiles/` is writable.
4. Default users (replace bcrypt hashes in schema with real ones):
   - Admin: `admin` / `Admin@123`
   - Doctor: `drjane` / `Doctor@123`

## Pages
- `index.php` — public home
- `register.php` — user registration
- `login.php` — login with remember-me
- `logout.php` — proper logout
- `dashboard.php` — stats + recent items
- `users.php` — admin-only user management
- `appointments.php` — list, delete
- `appointment_form.php` — create/update
- `profile.php` — view profile

## Notes
- Sessions expire after 5 minutes of inactivity.
- All DB operations use prepared statements.
- Server-side validation included; add client-side as needed.
