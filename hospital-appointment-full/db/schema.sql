-- db/schema.sql
CREATE DATABASE IF NOT EXISTS hospital_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE hospital_app;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  sex ENUM('Male','Female','Other') NOT NULL,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  phone VARCHAR(30),
  email VARCHAR(150) UNIQUE,
  profile_picture VARCHAR(255),
  user_type ENUM('admin','doctor','patient') DEFAULT 'patient',
  status ENUM('active','not_active') DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS appointments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  patient_id INT NOT NULL,
  doctor_id INT NOT NULL,
  title VARCHAR(150) NOT NULL,
  description TEXT,
  appointment_date DATETIME NOT NULL,
  status ENUM('scheduled','completed','cancelled') DEFAULT 'scheduled',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (patient_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (doctor_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Seed users (replace hashes with real ones generated via PHP password_hash)
INSERT INTO users (first_name, last_name, sex, username, password_hash, phone, email, user_type, status)
VALUES
('System', 'Admin', 'Other', 'admin', '$2y$10$REPLACE_WITH_BCRYPT_FOR_Admin@123', '000000000', 'admin@example.com', 'admin', 'active'),
('Jane', 'Doe', 'Female', 'drjane', '$2y$10$REPLACE_WITH_BCRYPT_FOR_Doctor@123', '111111111', 'drjane@example.com', 'doctor', 'active');

 To generate hashes:
 PHP: echo password_hash('Admin@123', PASSWORD_BCRYPT);
PHP: echo password_hash('Doctor@123', PASSWORD_BCRYPT);
