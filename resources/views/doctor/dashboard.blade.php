@extends('layouts.app')

@section('title', 'Doctor Dashboard')

@section('content')
<style>
    :root {
        --primary-color: #007bff;
        --secondary-color: #10b981;
        --text-color: #333;
        --card-bg: #ffffff;
        --content-bg: #f8f9fa;
        --danger-color: #dc3545;
        --shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .container {
        max-width: 100%;
        padding: 2rem;
    }

    .dashboard-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .dashboard-header h1 {
        font-size: 2.25rem;
        font-weight: 700;
        color: var(--text-color);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }

    .dashboard-header p {
        font-size: 1.1rem;
        color: #6c757d;
        font-weight: 400;
    }

    .stats-card {
        background: var(--card-bg);
        border-radius: 12px;
        box-shadow: var(--shadow);
        padding: 1.5rem;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        transition: width 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .stats-card h3 {
        font-size: 1.25rem;
        color: #4a5568;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 0.75rem;
    }

    .stats-card p {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-color);
        margin: 0;
    }

    .nav-card {
        background: var(--card-bg);
        border-radius: 12px;
        box-shadow: var(--shadow);
        padding: 1.5rem;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 1.5rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .nav-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--primary-color);
        transition: width 0.3s ease;
    }

    .nav-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .nav-card a, .nav-card .btn-link {
        text-decoration: none;
        color: var(--primary-color);
        font-size: 1.1rem;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .nav-card a:hover {
        color: #0056b3;
    }

    .nav-card i {
        font-size: 2.5rem;
        color: var(--primary-color);
        margin-bottom: 0.75rem;
        transition: transform 0.3s ease;
    }

    .nav-card:hover i {
        transform: scale(1.1);
    }

    .logout-card .btn-link {
        color: var(--danger-color);
        font-size: 1.1rem;
        font-weight: 600;
        background: none;
        border: none;
    }

    .logout-card .btn-link:hover {
        color: #a71d2a;
    }

   —not-found .logout-card::before {
        background: var(--danger-color);
    }

    .nav-cards-row {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
    }

    .nav-card-wrapper {
        flex: 0 0 auto;
        width: 200px;
    }

    @media (max-width: 768px) {
        .container {
            padding: 1.5rem;
        }

        .dashboard-header h1 {
            font-size: 1.75rem;
        }

        .dashboard-header p {
            font-size: 1rem;
        }

        .stats-card, .nav-card {
            margin-bottom: 1rem;
            padding: 1rem;
        }

        .stats-card p {
            font-size: 1.5rem;
        }

        .nav-card i {
            font-size: 2rem;
        }

        .nav-cards-row {
            flex-wrap: wrap;
            gap: 1rem;
        }

        .nav-card-wrapper {
            width: 160px;
        }
    }

    @media (max-width: 576px) {
        .dashboard-header h1 {
            font-size: 1.5rem;
        }

        .stats-card h3, .nav-card a, .nav-card .btn-link {
            font-size: 1rem;
        }

        .nav-card-wrapper {
            width: 100%;
            max-width: 200px;
        }
    }
</style>

<div class="container">
    <!-- Session Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Header -->
    <div class="dashboard-header">
        <h1>Doctor Dashboard</h1>
        <p>Welcome, {{ Auth::user()->username }}! Manage hospital operations efficiently.</p>
    </div>

    <!-- Navigation Cards -->
    <div class="nav-cards-row">
        <!-- Temporarily disable the "Manage Admissions" link for doctors -->
        <div class="nav-card-wrapper">
            <div class="nav-card">
                <i class="bi bi-calendar-check"></i>
                <a href="{{ route('doctors.menu') }}">Manage Appointments</a>
            </div>
        </div>
        <div class="nav-card-wrapper">
            <div class="nav-card">
                <i class="bi bi-hospital"></i>
                <p style="color: #6c757d; font-size: 1.1rem; font-weight: 600;">Manage Admissions (Not Available)</p>
            </div>
        </div>
        <div class="nav-card-wrapper">
            <div class="nav-card logout-card">
                <i class="bi bi-box-arrow-right"></i>
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Are you sure you want to logout?')">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger p-0 m-0">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Add any JavaScript if needed
    });
</script>
@endsection