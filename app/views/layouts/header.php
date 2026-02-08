<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo isset($data['title']) ? $data['title'] . ' | Student Attendance' : 'Student Attendance System'; ?>
    </title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
    <!-- Utility classes for layout -->
    <style>
        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .mt-4 {
            margin-top: 1.5rem;
        }

        .d-flex {
            display: flex;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .align-items-center {
            align-items: center;
        }

        .gap-2 {
            gap: 0.5rem;
        }

        .gap-3 {
            gap: 1rem;
        }

        .p-0 {
            padding: 0;
        }

        .overflow-hidden {
            overflow: hidden;
        }

        .text-primary {
            color: var(--accent);
        }

        .text-muted {
            color: var(--text-muted);
        }

        .text-danger {
            color: var(--danger);
        }

        .text-success {
            color: var(--success);
        }

        .fw-bold {
            font-weight: 700;
        }

        .font-monospace {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        }

        .small {
            font-size: 0.875rem;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .text-accent {
            color: var(--accent);
        }
    </style>
</head>

<body>
    <?php if (isLoggedIn()): ?>
        <div class="app-container">
            <aside class="sidebar">
                <h2><span>🏛️</span> <span>Attendance</span></h2>
                <nav>
                    <?php
                    $current_page = $_SERVER['REQUEST_URI'];
                    $base = BASE_URL;
                    ?>
                    <ul>
                        <li>
                            <a href="<?php echo $base; ?>dashboard"
                                class="<?php echo strpos($current_page, 'dashboard') !== false ? 'active' : ''; ?>">
                                <span>📊</span> <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $base; ?>students"
                                class="<?php echo strpos($current_page, 'students') !== false ? 'active' : ''; ?>">
                                <span>👨‍🎓</span> <span>Students</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>subjects"
                                class="<?php echo strpos($current_page, 'subjects') !== false ? 'active' : ''; ?>">
                                <span>📚</span> <span>Subjects</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $base; ?>attendances"
                                class="<?php echo strpos($current_page, 'attendances') !== false ? 'active' : ''; ?>">
                                <span>📝</span> <span>Mark Attendance</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $base; ?>reports"
                                class="<?php echo strpos($current_page, 'reports') !== false ? 'active' : ''; ?>">
                                <span>📈</span> <span>Reports</span>
                            </a>
                        </li>
                        <?php if (isAdmin()): ?>
                            <li>
                                <a href="<?php echo $base; ?>users/manage"
                                    class="<?php echo strpos($current_page, 'users/manage') !== false ? 'active' : ''; ?>">
                                    <span>👥</span> <span>User Management</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </aside>
            <main class="main-content">
                <header class="top-nav">
                    <div class="user-info">
                        <span class="text-muted">Welcome back,</span>
                        <strong class="fw-bold"><?php echo $_SESSION['full_name']; ?></strong>
                        <span class="badge badge-outline ms-2">
                            <?php echo $_SESSION['user_role']; ?>
                        </span>
                    </div>
                    <div class="nav-actions">
                        <a href="<?php echo BASE_URL; ?>users/logout" class="btn btn-secondary">
                            <span>Logout</span>
                        </a>
                    </div>
                </header>
                <section class="content-body">
                <?php endif; ?>