# HealthSystem_API_Test.ps1

# Set base URL
$baseUrl = "http://localhost:8000/api/v1"

# 1. GET all clients
$response = Invoke-WebRequest -Uri "$baseUrl/clients" -Method Get
"GET /clients:"
$response.Content | ConvertFrom-Json
"`n"

# 2. Create new client
$clientBody = @{
    full_name = "Jane Smith"
    email = "jane@example.com"
    phone_number = "+1234567890"
    birth_date = "1990-01-01"
} | ConvertTo-Json

$response = Invoke-WebRequest -Uri "$baseUrl/clients" -Method Post -Body $clientBody -ContentType "application/json"
"POST /clients:"
$response.Content | ConvertFrom-Json
"`n"

# 3. Create new program
$programBody = @{
    title = "Fitness Program"
    summary = "Wellness and exercise sessions"
} | ConvertTo-Json

$response = Invoke-WebRequest -Uri "$baseUrl/programs" -Method Post -Body $programBody -ContentType "application/json"
"POST /programs:"
$response.Content | ConvertFrom-Json
"`n"

# 4. Enroll client
$enrollBody = @{
    program_ids = @(1)
} | ConvertTo-Json

$response = Invoke-WebRequest -Uri "$baseUrl/clients/1/enroll" -Method Post -Body $enrollBody -ContentType "application/json"
"POST /clients/1/enroll:"
$response.Content | ConvertFrom-Json
"`n"

# 5. Fetch enrolled client profile
$response = Invoke-WebRequest -Uri "$baseUrl/clients/1" -Method Get
"GET /clients/1:"
$response.Content | ConvertFrom-Json
"`n"

# 6. Unenroll client
$unenrollBody = @{
    program_ids = @(1)
} | ConvertTo-Json

$response = Invoke-WebRequest -Uri "$baseUrl/clients/1/unenroll" -Method Delete -Body $unenrollBody -ContentType "application/json"
"DELETE /clients/1/unenroll:"
$response.Content | ConvertFrom-Json
"`n"
