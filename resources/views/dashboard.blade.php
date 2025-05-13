<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - mr.wam Health System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #1a4b8c;       /* Deep trustworthy blue */
            --secondary-blue: #3b82f6;     /* Vibrant action blue */
            --light-blue: #f0f7ff;         /* Light background blue */
            --gold: #d4af37;               /* Premium gold accent */
            --light-gold: #faf3e0;         /* Subtle gold background */
            --dark-gray: #1f2937;          /* For text and dark elements */
            --medium-gray: #6b7280;        /* Secondary text */
            --light-gray: #f9fafb;         /* Page background */
            --success-green: #10b981;      /* For positive actions */
            --warning-orange: #f59e0b;     /* For alerts */
            --error-red: #ef4444;          /* For errors */
        }

        /* Base Styles */
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: var(--light-gray);
            color: var(--dark-gray);
            line-height: 1.6;
            margin: 0;
            min-height: 100vh;
            display: grid;
            grid-template-rows: auto 1fr;
        }

        /* Header/Navigation */
        .app-header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 0.75rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .logo-icon {
            color: var(--primary-blue);
            font-size: 1.75rem;
        }

        .logo-text {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary-blue);
        }

        .logo-subtext {
            color: var(--gold);
            font-size: 0.9rem;
            margin-left: 0.5rem;
        }

        .user-nav {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--light-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-blue);
            font-weight: bold;
        }

        /* Main Dashboard Layout */
        .dashboard-container {
            display: grid;
            grid-template-columns: 240px 1fr;
            min-height: 100%;
        }

        /* Sidebar Navigation */
        .sidebar {
            background: var(--primary-blue);
            color: white;
            padding: 1.5rem 0;
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-item {
            margin-bottom: 0.25rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            transition: all 0.2s;
            font-size: 0.95rem;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left: 3px solid var(--gold);
        }

        .nav-link i {
            width: 24px;
            text-align: center;
        }

        /* Main Content Area */
        .main-content {
            padding: 2rem;
            background-color: var(--light-gray);
        }

        .welcome-banner {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .welcome-banner::after {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .welcome-title {
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .welcome-subtitle {
            opacity: 0.9;
            font-size: 1rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .stat-title {
            color: var(--medium-gray);
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-gray);
            margin: 0.5rem 0;
        }

        .stat-change {
            display: flex;
            align-items: center;
            font-size: 0.85rem;
        }

        .stat-change.positive {
            color: var(--success-green);
        }

        .stat-change.negative {
            color: var(--error-red);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .icon-blue {
            background-color: var(--light-blue);
            color: var(--primary-blue);
        }

        .icon-gold {
            background-color: var(--light-gold);
            color: var(--gold);
        }

        .icon-green {
            background-color: #e6f6f0;
            color: var(--success-green);
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .action-btn {
            background: white;
            border: none;
            border-radius: 8px;
            padding: 1.25rem 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.1);
        }

        .action-btn i {
            font-size: 1.5rem;
            margin-bottom: 0.75rem;
            color: var(--primary-blue);
        }

        .action-btn .btn-text {
            font-weight: 600;
            color: var(--dark-gray);
        }

        /* Recent Activity */
        .activity-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark-gray);
        }

        .view-all {
            color: var(--primary-blue);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .activity-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .activity-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid #eee;
            display: flex;
            gap: 1rem;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--light-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-blue);
            flex-shrink: 0;
        }

        .activity-content {
            flex-grow: 1;
        }

        .activity-title {
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .activity-time {
            color: var(--medium-gray);
            font-size: 0.85rem;
        }

        /* Responsive Adjustments */
        @media (max-width: 1024px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }
            .sidebar {
                display: none; /* Consider a mobile menu instead */
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
            .app-header {
                padding: 0.75rem 1rem;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
            }
            .welcome-banner {
                padding: 1.5rem 1rem;
            }
            .main-content {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header with User Navigation -->
    <header class="app-header">
        <a href="/dashboard" class="brand-logo">
            <div class="logo-icon">
                <i class="fas fa-hospital"></i>
            </div>
            <div>
                <span class="logo-text">mr.wam</span>
                <span class="logo-subtext">hospital</span>
            </div>
        </a>

        <div class="user-nav">
            <button class="notification-btn" aria-label="Notifications">
                <i class="fas fa-bell"></i>
            </button>
            <div class="user-profile">
                <div class="avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <span>{{ Auth::user()->name }}</span>
            </div>
        </div>
    </header>

    <!-- Main Dashboard Layout -->
    <div class="dashboard-container">
        <!-- Sidebar Navigation -->
        <nav class="sidebar">
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link active">
                        <i class="fas fa-home"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/clients" class="nav-link">
                        <i class="fas fa-users"></i>
                        Client Management
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/programs" class="nav-link">
                        <i class="fas fa-project-diagram"></i>
                        Program Management
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/enrollments" class="nav-link">
                        <i class="fas fa-user-plus"></i>
                        Enrollment System
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/reports" class="nav-link">
                        <i class="fas fa-chart-bar"></i>
                        Reports & Analytics
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/api/documentation" class="nav-link" target="_blank">
                        <i class="fas fa-code"></i>
                        API Documentation
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/settings" class="nav-link">
                        <i class="fas fa-cog"></i>
                        Settings
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Welcome Banner -->
            <section class="welcome-banner">
                <h1 class="welcome-title">Welcome back, {{ Auth::user()->name }}!</h1>
                <p class="welcome-subtitle">Here's what's happening with your health system today</p>
            </section>

            <!-- Stats Overview -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Active Clients</span>
                        <div class="stat-icon icon-blue">
                            <i class="fas fa-user-injured"></i>
                        </div>
                    </div>
                    <div class="stat-value">1,248</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> 12% from last month
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Active Programs</span>
                        <div class="stat-icon icon-gold">
                            <i class="fas fa-procedures"></i>
                        </div>
                    </div>
                    <div class="stat-value">24</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> 2 new this month
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Enrollments</span>
                        <div class="stat-icon icon-green">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                    </div>
                    <div class="stat-value">327</div>
                    <div class="stat-change negative">
                        <i class="fas fa-arrow-down"></i> 5% from last month
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <button class="action-btn">
                    <i class="fas fa-user-plus"></i>
                    <span class="btn-text">Add New Client</span>
                </button>
                <button class="action-btn">
                    <i class="fas fa-procedures"></i>
                    <span class="btn-text">Create Program</span>
                </button>
                <button class="action-btn">
                    <i class="fas fa-clipboard-list"></i>
                    <span class="btn-text">Generate Report</span>
                </button>
                <button class="action-btn">
                    <i class="fas fa-calendar-check"></i>
                    <span class="btn-text">Schedule Appointment</span>
                </button>
            </div>

            <!-- Recent Activity -->
            <div class="activity-card">
                <div class="card-header">
                    <h2 class="card-title">Recent Activity</h2>
                    <a href="/activity" class="view-all">View All</a>
                </div>
                <ul class="activity-list">
                    <li class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">New client registered - John Doe</div>
                            <div class="activity-time">2 hours ago</div>
                        </div>
                    </li>
                    <li class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-procedures"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Cardiac Rehab program updated</div>
                            <div class="activity-time">5 hours ago</div>
                        </div>
                    </li>
                    <li class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">3 new enrollments completed</div>
                            <div class="activity-time">Yesterday</div>
                        </div>
                    </li>
                    <li class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-file-export"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Monthly report generated</div>
                            <div class="activity-time">Yesterday</div>
                        </div>
                    </li>
                </ul>
            </div>
        </main>
    </div>
</body>
</html>
