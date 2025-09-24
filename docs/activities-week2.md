# Week 2 Activities – Health Information System

## Objectives

-   Extend backend with enrollment functionality.
-   Add resources for clean API responses.
-   Introduce policies for role-based access.

## Completed Tasks

1. Added **EnrollmentController** with:
    - Enroll client into a program
    - Unenroll client
    - List client/program enrollments
2. Created **EnrollmentResource** for structured JSON output.
3. Updated **ClientResource** & **ProgramResource**:
    - Return enrollment details without pivot clutter
4. Implemented **EnrollmentPolicy**:
    - Only authorized users can manage enrollments
5. Updated `routes/api.php` with enrollment endpoints:
    - `POST /clients/{client}/programs/{program}/enroll`
    - `DELETE /clients/{client}/programs/{program}/unenroll`
    - `GET /clients/{client}/programs`
6. Fixed Eloquent relationships:
    - Client ↔ Program ↔ Enrollment
7. Updated **DatabaseSeeder**:
    - Added example enrollments for testing

## Deliverables

-   Enrollments working with pivot data (status, dates, notes, etc.)
-   Resources ensure clean JSON responses
-   Seeder includes sample clients, programs, and enrollments
