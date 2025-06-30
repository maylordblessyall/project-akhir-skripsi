<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #3b82f6; /* Blue from dashboard */
            --secondary-color: #10b981; /* Green for accents */
            --menu-bg: #1f2a44; /* Darker, modern sidebar */
            --menu-text: #e2e8f0; /* Light text for sidebar */
            --content-bg: #f5f7fa; /* Light background */
            --card-bg: #ffffff; /* White for content cards */
            --text-color: #2d3748; /* Dark text */
            --border-color: #e2e8f0; /* Light borders */
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--content-bg);
            color: var(--text-color);
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            line-height: 1.6;
        }

        #app {
            display: flex;
            flex: 1;
        }

        /* Header */
        #title {
            background: linear-gradient(135deg, var(--primary-color), #60a5fa);
            color: #fff;
            padding: 1rem 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1100;
        }

        #title h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* Sidebar */
        #left-menu {
            width: 260px;
            background: var(--menu-bg);
            color: var(--menu-text);
            padding: 1.5rem 0;
            margin-top: 60px; /* Height of header */
            position: fixed;
            height: calc(100vh - 60px);
            overflow-y: auto;
            transition: width 0.3s ease, transform 0.3s ease;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
            z-index: 1000;
        }

        #left-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        #left-menu li {
            margin: 0.25rem 0;
        }

        #left-menu a {
            color: var(--menu-text);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            border-radius: 0 6px 6px 0;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        #left-menu a:hover,
        #left-menu a.active {
            background: var(--primary-color);
            color: #fff;
            transform: translateX(4px);
        }

        #left-menu i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        /* Submenu */
        .sub-menu {
            padding-left: 1.5rem;
            display: none;
        }

        .staff-menu:hover .sub-menu,
        .staff-menu.active .sub-menu {
            display: block;
        }

        .sub-menu a {
            font-size: 0.9rem;
            padding: 0.5rem 1.5rem;
            opacity: 0.85;
        }

        .sub-menu a:hover {
            opacity: 1;
            background: rgba(255, 255, 255, 0.1);
        }

        /* Main Content */
        #main {
            flex: 1;
            margin-left: 260px;
            margin-top: 60px;
            padding: 2rem;
            background: var(--content-bg);
            min-height: calc(100vh - 60px);
            transition: margin-left 0.3s ease;
        }

        #content {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            max-width: 100%;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            font-weight: 500;
            color: var(--text-color);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .form-control {
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: var(--card-bg);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .table th,
        .table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .table th {
            background: #f9fafb;
            font-weight: 600;
            color: #4a5568;
            font-size: 0.95rem;
            text-transform: uppercase;
        }

        .table td {
            font-size: 0.95rem;
            color: var(--text-color);
        }

        .table tbody tr:hover {
            background: #f7fafc;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            #left-menu {
                width: 260px;
                transform: translateX(-260px);
                position: fixed;
                top: 60px;
                z-index: 1200;
            }

            #left-menu.active {
                transform: translateX(0);
            }

            #main {
                margin-left: 0;
                padding: 1.5rem;
            }

            #content {
                padding: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            #title h1 {
                font-size: 1.5rem;
            }

            #left-menu {
                width: 100%;
                transform: translateX(-100%);
            }

            #left-menu.active {
                transform: translateX(0);
            }
        }

        /* Toggle Button for Mobile */
        .menu-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1300;
            background: var(--primary-color);
            color: #fff;
            border: none;
            padding: 0.5rem;
            border-radius: 6px;
            cursor: pointer;
        }

        @media (max-width: 992px) {
            .menu-toggle {
                display: block;
            }
        }
    </style>
</head>
<body>
    <header id="title">
        <button class="menu-toggle" aria-label="Toggle Menu">
            <i class="fas fa-bars"></i>
        </button>
        <a class="navbar-brand" href="#">REKAM MEDIK</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </header>

    <div id="app">
        <nav id="left-menu">
            <ul class="main-menu">
                <li><a href="<?php echo e(route('manager.dashboard')); ?>" class="<?php echo e(Route::is('manager.dashboard') ? 'active' : ''); ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="<?php echo e(route('appointments.index')); ?>" class="<?php echo e(Route::is('appointments.*') ? 'active' : ''); ?>"><i class="fas fa-calendar-alt"></i> Kunjungan</a></li>
                <li><a href="<?php echo e(route('patients.index')); ?>" class="<?php echo e(Route::is('patients.*') ? 'active' : ''); ?>"><i class="fas fa-users"></i> Pasien</a></li>
                <li><a href="<?php echo e(route('doctors.menu')); ?>" class="<?php echo e(Route::is('doctors.menu') ? 'active' : ''); ?>"><i class="fas fa-user-md"></i> Tindakan Dokter</a></li>
                <li><a href="<?php echo e(route('medical_records.index')); ?>" class="<?php echo e(Route::is('medical_records.*') ? 'active' : ''); ?>"><i class="fas fa-file-medical"></i> Medical Records</a></li>
                <li class="staff-menu">
                    <a href="#" class="staff-link"><i class="fas fa-user-md"></i> Staff</a>
                    <ul class="sub-menu">
                        <li><a href="<?php echo e(route('doctors.index')); ?>" class="<?php echo e(Route::is('doctors.*') ? 'active' : ''); ?>"><i class="fas fa-user-md"></i> Dokter</a></li>
                        <li><a href="<?php echo e(route('registrationstaff.index')); ?>" class="<?php echo e(Route::is('registrationstaff.*') ? 'active' : ''); ?>"><i class="fas fa-user-nurse"></i> Petugas</a></li>
                        <li><a href="<?php echo e(route('register')); ?>" class="<?php echo e(Route::is('register') ? 'active' : ''); ?>"><i class="fas fa-user-plus"></i> Daftar Login User</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <main id="main">
            <div id="content">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleButton = document.querySelector('.menu-toggle');
            const sidebar = document.querySelector('#left-menu');

            toggleButton.addEventListener('click', () => {
                sidebar.classList.toggle('active');
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', (e) => {
                if (window.innerWidth <= 992 && !sidebar.contains(e.target) && !toggleButton.contains(e.target)) {
                    sidebar.classList.remove('active');
                }
            });
        });
    </script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html><?php /**PATH Z:\Laravel 8\rumah_sakit_advent\resources\views/layouts/admin.blade.php ENDPATH**/ ?>