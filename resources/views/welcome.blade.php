<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Register - Health Info System</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0px 10px 20px rgba(0,0,0,0.1);
            width: 360px;
            max-width: 90%;
            text-align: center;
        }
        h1 {
            margin-bottom: 1rem;
            color: #2d3748;
        }
        form {
            display: flex;
            flex-direction: column;
            margin-top: 1rem;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            padding: 0.8rem;
            margin-bottom: 1rem;
            border: 1px solid #cbd5e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        input:focus {
            border-color: #4299e1;
            box-shadow: 0 0 5px rgba(66, 153, 225, 0.5);
        }
        button {
            padding: 0.8rem;
            background-color: #4299e1;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #2b6cb0;
        }
        .toggle-link {
            margin-top: 1rem;
            font-size: 0.9rem;
        }
        .toggle-link a {
            color: #4299e1;
            text-decoration: none;
            font-weight: bold;
        }
        .toggle-link a:hover {
            text-decoration: underline;
        }
        .error {
            color: #e53e3e;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Login Form -->
    <div id="login-form">
        <h1>Login</h1>

        @if(session('login_error'))
            <div class="error">{{ session('login_error') }}</div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <input type="email" name="email" placeholder="Email" required autofocus>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <div class="toggle-link">
            Don't have an account? <a href="#" onclick="showRegister()">Register</a>
        </div>
    </div>

    <!-- Register Form -->
    <div id="register-form" style="display:none;">
        <h1>Register</h1>

        @if(session('register_error'))
            <div class="error">{{ session('register_error') }}</div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>

        <div class="toggle-link">
            Already have an account? <a href="#" onclick="showLogin()">Login</a>
        </div>
    </div>
</div>

<script>
    function showRegister() {
        document.getElementById('login-form').style.display = 'none';
        document.getElementById('register-form').style.display = 'block';
    }
    function showLogin() {
        document.getElementById('register-form').style.display = 'none';
        document.getElementById('login-form').style.display = 'block';
    }
</script>

</body>
</html>
