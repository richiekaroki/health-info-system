# Health Information System API + Blade UI

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

A robust Laravel-based API for managing client health programs with secure authentication.

## ✨ Features

-   **Dual Authentication**
    -   Web UI (Session-based)
    -   API (Sanctum tokens)
-   **Health Program Management**
    -   Programs available (TB, Malaria, and other )
    -   Client enrollment tracking
-   **Search & Reporting**
    -   Client search by name
    -   Enrollment status reports

## 🛠 Technology Stack

| Component         | Technology          |
| ----------------- | ------------------- |
| Backend Framework | Laravel 12(PHP 8.2) |
| Authentication    | Laravel Sanctum     |
| Database          | MySQL 8.0+          |
| API Documentation | Swagger/OpenAPI     |
| Frontend          | Blade Templates     |

## ⚙️ System Requirements

-   PHP 8.2+
-   MySQL 8.0+
-   Composer 2.5+
-   Node.js 18+ (for frontend assets) (Optional for those using frameworks)

## 🚀 Installation

### 1. Clone Repository

```bash
git clone https://github.com/richiekaroki/health-info-system.git
cd health-info-system

2. Install Dependencies
bash
composer install
npm install && npm run build

3. Configure Environment
bash
cp .env.example .env
php artisan key:generate

Edit .env:
ini
DB_DATABASE=health_db
DB_USERNAME=root
DB_PASSWORD=your_password

4. Database Setup
bash
php artisan migrate --seed

5. Start Development Server
bash
php artisan serve
Access: http://127.0.0.1:8000

🔐 API Authentication Flow
Sample Request: Login
bash
curl -X POST http://127.0.0.1:8000/api/v1/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password"}'

Sample Response
json
{
  "token": "1|AbCdE...",
  "user": {
    "id": 1,
    "name": "Admin User",
    "email": "admin@example.com"
  }
}

Using the Token
bash
curl -H "Authorization: Bearer 1|AbCdE..." \
  http://127.0.0.1:8000/api/v1/clients

📚 API Documentation
Interactive Swagger docs available at:
http://localhost:8000/api/documentation

🚨 Troubleshooting
Common Issues
Migration Errors

bash
# Reset and re-run
php artisan migrate:fresh --seed
Token Authentication Fails

Verify SANCTUM_STATEFUL_DOMAINS in .env

Check token expiration (default: 7 days)

Swagger Docs Not Loading

bash
php artisan l5-swagger:generate
Production Checklist
ini
# .env.production
APP_ENV=production
APP_DEBUG=false
SESSION_SECURE_COOKIE=true
SANCTUM_TOKEN_EXPIRATION=1440  # 1 day
🤝 Contributing
Fork the repository

Create a feature branch (git checkout -b feature/amazing-feature)

Commit changes (git commit -m 'Add amazing feature')

Push to branch (git push origin feature/amazing-feature)

Open a Pull Request



```
