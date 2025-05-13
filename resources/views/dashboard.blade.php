<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Health Info System</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f9fafb; margin: 0; padding: 2rem; }
        .container { background: white; padding: 2rem; border-radius: 12px; max-width: 800px; margin: 2rem auto; box-shadow: 0px 10px 20px rgba(0,0,0,0.1); text-align: center; }
        h1 { color: #2b6cb0; margin-bottom: 1rem; }
        p { color: #4a5568; font-size: 1.1rem; }
        a.button, button.logout-btn {
            display: inline-block; margin-top: 2rem; padding: 0.8rem 1.5rem;
            background-color: #4299e1; color: white; border-radius: 8px;
            font-weight: bold; text-decoration: none; border: none; cursor: pointer;
            transition: background-color 0.3s ease;
        }
        a.button:hover, button.logout-btn:hover { background-color: #2b6cb0; }
        ul { text-align: left; margin-top: 1rem; line-height: 1.8; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to your Dashboard, {{ Auth::user()->name }}!</h1>
        <p>You have successfully logged in.</p>
        <p>This system allows you to:</p>
        <ul>
            <li>Manage Clients (Create, View, Enroll)</li>
            <li>Manage Programs (Create and View)</li>
            <li>Enroll/Unenroll Clients into Programs</li>
            <li>Authenticate using Sanctum for API security</li>
            <li>Test APIs via Postman or CLI</li>
        </ul>
        <!-- Updated Button Link -->
        <a href="{{ url('/api/documentation') }}" class="button" target="_blank">View API Documentation</a>
        <form method="POST" action="{{ route('logout') }}" style="margin-top: 1.5rem;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</body>
</html>
