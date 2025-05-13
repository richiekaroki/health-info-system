<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>mr.wam - Hospital Portal</title>
    <style>
        :root {
            --primary-blue: #1a4b8c;
            --secondary-blue: #2a75d6;
            --light-blue: #e6f0fa;
            --gold: #d4af37;
            --light-gold: #f8f0d0;
            --dark-gray: #2c3e50;
            --medium-gray: #6c757d;
            --light-gray: #f4f6f8;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-gray);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: linear-gradient(135deg, var(--light-blue) 0%, #ffffff 100%);
        }
        .container {
            width: 420px;
            padding: 40px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(26, 75, 140, 0.15);
            border-top: 4px solid var(--gold);
        }
        .hospital-brand {
            text-align: center;
            margin-bottom: 30px;
        }
        .hospital-logo {
            font-size: 36px;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 0;
            letter-spacing: -0.5px;
        }
        .hospital-subname {
            font-size: 22px;
            color: var(--gold);
            margin-top: -5px;
            font-weight: 600;
        }
        .subtext {
            text-align: center;
            color: var(--medium-gray);
            margin-bottom: 30px;
            font-size: 14px;
            letter-spacing: 0.5px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 14px;
            border-radius: 6px;
            border: 1px solid #d1d9e6;
            font-size: 15px;
            transition: all 0.3s ease;
        }
        input:focus {
            outline: none;
            border-color: var(--secondary-blue);
            box-shadow: 0 0 0 3px rgba(42, 117, 214, 0.1);
        }
        .btn {
            width: 100%;
            background: var(--primary-blue);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            margin: 10px 0 15px;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }
        .btn:hover {
            background: var(--secondary-blue);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(26, 75, 140, 0.2);
        }
        .btn-gold {
            background: var(--gold);
            color: var(--primary-blue);
        }
        .btn-gold:hover {
            background: #e6c352;
        }
        .error {
            color: #e74c3c;
            font-size: 14px;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #fdecea;
            border-radius: 4px;
            border-left: 3px solid #e74c3c;
        }
        .toggle-form {
            text-align: center;
            margin-top: 20px;
            color: var(--medium-gray);
            font-size: 14px;
        }
        .toggle-form a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
            border-bottom: 1px dotted var(--primary-blue);
            padding-bottom: 1px;
        }
        .toggle-form a:hover {
            color: var(--secondary-blue);
            border-bottom: 1px solid var(--secondary-blue);
        }
        .form-container {
            display: block;
            animation: fadeIn 0.4s ease;
        }
        .hidden {
            display: none;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="hospital-brand">
            <h1 class="hospital-logo">mr.wam</h1>
            <div class="hospital-subname">hospital</div>
            <div class="subtext">Health Information System Portal</div>
        </div>

        <!-- Login Form -->
        <div id="login-form" class="form-container">
            <h2 style="color: var(--primary-blue); text-align: center; margin-bottom: 25px;">Welcome Back</h2>
            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                <div class="form-group">
                    <label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required>
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <input type="password" name="password" placeholder="Password" required>
                    </label>
                </div>
                @if(session('login_error'))
                    <div class="error">{{ session('login_error') }}</div>
                @endif
                <button class="btn" type="submit">Sign In</button>
            </form>
            <div class="toggle-form">
                New to mr.wam? <a href="#" onclick="showRegister(); return false;">Create an account</a>
            </div>
        </div>

        <!-- Register Form -->
        <div id="register-form" class="form-container hidden">
            <h2 style="color: var(--primary-blue); text-align: center; margin-bottom: 25px;">Create Account</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" required>
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required>
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <input type="password" name="password" placeholder="Create Password" required>
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                    </label>
                </div>
                @if($errors->any())
                    <div class="error">
                        <ul style="margin: 0; padding: 0 0 0 1em;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <button class="btn btn-gold" type="submit">Register Now</button>
            </form>
            <div class="toggle-form">
                Already have an account? <a href="#" onclick="showLogin(); return false;">Sign in here</a>
            </div>
        </div>
    </div>

    <script>
        function showRegister() {
            document.getElementById('login-form').classList.add('hidden');
            document.getElementById('register-form').classList.remove('hidden');
            document.getElementById('register-form').style.animation = 'fadeIn 0.4s ease';
        }

        function showLogin() {
            document.getElementById('register-form').classList.add('hidden');
            document.getElementById('login-form').classList.remove('hidden');
            document.getElementById('login-form').style.animation = 'fadeIn 0.4s ease';
        }
    </script>
</body>
</html>
