# Hospital-Appointment-Management-System
A web-based hospital appointment system that allows patients to book appointments online, doctors to manage schedules, and administrators to control users, roles, and departments.
GROUP NAME: k

iD NAME CLASS C1220985 Bakar Isse Mohamed C226 C1221273 Abdifitah Muse Gurhan C226 C1221147 Isse Abdi Siyad C226

A robust, modern Hospital Appointment Management System designed to streamline healthcare operations. This project features a high-performance PHP backend and a dynamic, premium React frontend.

🚀 Key Features
📅 Appointment Management
Smart Booking: Check doctor availability and detect scheduling conflicts in real-time.
Intuitive UI: Easy-to-use patient and doctor interfaces for managing appointments.
Status Tracking: Track appointments through various stages (Scheduled, Completed, Canceled).
🩺 Doctor & Availability
Departmental Organization: Categorize doctors by medical departments.
Availability Management: Define complex schedules and availability slots for healthcare providers.
👤 User & Role Management
Granular Permissions: Secure RBAC (Role-Based Access Control) for Admins, Doctors, and Patients.
Secure Authentication: Robust user authentication and session management.
Profile Management: Detailed patient and doctor profiles.
🛠️ Technology Stack
Backend
Core: PHP (Custom MVC architecture)
Database: MySQL (optimized for relational integrity)
Architecture: Repository-Service pattern for clean code separation.
Frontend
Framework: React.js with Vite
Styling: Tailwind CSS for a responsive, modern glassmorphism design.
Icons: Lucide-React for crisp, scalable visuals.
📁 Project Structure
hospital_appointment_ms/
├── app/                # Backend Source
│   ├── controllers/    # API Request Handling
│   ├── models/         # Data representation
│   ├── services/       # Business Logic
│   └── repositories/   # Database Abstraction
├── frontend/           # React Application
│   └── src/            # Components, Pages, and Hooks
├── public/             # Entry point (index.php)
└── database/           # Migrations and Seeds
⚙️ Setup & Installation
Clone the repository:
git clone <repository-url>
Backend Configuration:
Ensure XAMPP/WAMP is running with PHP 8.0+.
Configure .env with your database credentials.
Run composer install.
Frontend Configuration:
Navigate to frontend/.
Run npm install.
Start dev server: npm run dev.
