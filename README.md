Health Information System API

A simple Laravel-based API to manage client registrations, health program enrollments, and secure authentication using Sanctum.

Features
User Registration and Login
Manage Clients
Manage Health Programs (TB, Malaria, etc.)
Enroll and Unenroll Clients into Programs
Search Clients by Name
View Client Profiles and Enrollments
Secure API Authentication (Laravel Sanctum)
API Documentation Provided

Technology Stack
Backend Laravel 12 (PHP 8.2)
Authentication Sanctum
Database MySQL
Testing Postman, PowerShell Scripts
Frontend Blade Templates (Login/Register/Dashboard)

Installation & Setup
Clone the repository:

bash
git clone https://github.com/richiekaroki/health-info-system.git
cd health-info-system

Install PHP dependencies:

bash
composer install
Copy .env file and generate app key:

bash
cp .env.example .env
php artisan key:generate
Setup Database:

Update .env database variables (DB_DATABASE, DB_USERNAME, DB_PASSWORD).
Use MySQL.
Run Migrations:

bash
php artisan migrate

Serve the Application:
bash
php artisan serve
Access your app at: http://127.0.0.1:8000

🛣️ Project Structure (High Level)
plaintext
app/
├── Http/
│ ├── Controllers/
│ │ ├── API/V1/AuthController.php (API login/register)
│ │ ├── API/V1/ClientController.php
│ │ ├── API/V1/ProgramController.php
│ │ ├── API/V1/EnrollmentController.php
│ │ └── Auth/LoginController.php (Web login)
│ │ └── Auth/RegisterController.php (Web register)
│ └── Requests/
├── Models/
│ ├── Client.php
│ ├── Program.php
│ └── User.php
database/
├── migrations/
├── seeders/
routes/
├── api.php
├── web.php
resources/
├── views/
│ ├── auth/login-register.blade.php
│ ├── dashboard.blade.php

Set environment variable:
bash
base_url = http://127.0.0.1:8000/api/v1

Test:
Register
Login
CRUD Clients/Programs
Enrollment/Unenrollment
Client Search
View Profile

PowerShell API Test Script
File: HealthSystem_API_Test.ps1

Automatically tests:
Register
Login
Protected Client Fetch
Logout

Run it:
bash
.\HealthSystem_API_Test.ps1
✅ Quick verification without opening Postman.

Running Tests
Type Tool How to Run
CLI API Testing PowerShell Run .ps1 script

Expected API Responses:
201 Created → Successful Registration, Client, Program creation
200 OK → Login, Fetch, Enrollments
401 Unauthorized → Invalid login or expired token
422 Validation Error → Bad form submission

Default Credentials (Seeder Data)
Admin Email: admin@example.com

Password: password

Key Demo Highlights
Clean separation of Web Auth (Sessions) and API Auth (Tokens)
RESTful API architecture
Mobile-responsive Login and Register pages
Dashboard landing page with Logout
API security (Laravel Sanctum)
Automated CLI Testing
API Documentation

Available at:
http://127.0.0.1:8000/api/documentation
(You can add Swagger later if required.)
