# Student Attendance Tracking System

A modern, web-based attendance management system built with PHP and a custom MVC framework. Designed for schools and educational institutions to track student attendance efficiently across various subjects.

> [!IMPORTANT]
> This system is currently **UNDER PRODUCTION**. Updates and features are being actively developed.
Developed by: **sonjeb**

## Table of Contents
- [Features](#features)
- [How it Works](#how-it-works)
- [Tech Stack](#tech-stack)
- [Installation / How to Clone](#installation--how-to-clone)
- [Default Credentials](#default-credentials)

## Features
- **Dashboard**: Real-time statistics including total students, subjects, teachers, and today's attendance overview.
- **Attendance Details**: Clickable student counts on the dashboard to view detailed attendance lists for the day.
- **Student Management**: Full CRUD (Create, Read, Update, Delete) for student records including LRN and personal info.
- **Subject Management**: Manage subjects and enroll students into specific classes.
- **Attendance Tracking**: Easy-to-use interface for teachers to mark student attendance as Present or Absent.
- **Reports**: Daily attendance reports and student-specific summaries.
- **User Management**: Admin-only section for managing teachers and system users.
- **Premium UI**: Modern Slate & Indigo design with glassmorphism and responsiveness.

## How it Works
1.  **Architecture**: The system follows the **Model-View-Controller (MVC)** architectural pattern for clean code separation.
2.  **Authentication**: Users must log in to access the system. Roles (Admin/Teacher) determine dashboard access and permissions.
3.  **Workflow**:
    - **Admins** create subjects and manage teachers/students.
    - **Teachers** enroll students into their subjects.
    - **Attendance** is marked daily per subject. The dashboard automatically aggregates this data for an at-a-glance overview.
4.  **Database**: All data is persisted in a MySQL database with relation integrity (foreign keys).

## Tech Stack
- **Backend**: PHP (Custom MVC Framework)
- **Frontend**: Vanilla CSS, JavaScript
- **Database**: MySQL
- **Icons**: Emoji Glyphs / Google Fonts (Inter & Outfit)

## Installation / How to Clone

### Prerequisites
- **XAMPP** (or any LAMP/WAMP stack with PHP 8.0+)
- **Git**

### Steps
1.  **Clone the Repository**:
    ```bash
    git clone https://github.com/yourusername/Student_Att.git
    ```
    *Note: Move the project folder to `C:\xampp\htdocs\Student_Att`.*

2.  **Database Setup**:
    - Open **phpMyAdmin**.
    - Create a new database named `student_att_db`.
    - Import the SQL file located at `sql/schema.sql`.

3.  **Configuration**:
    - Open `config/config.php`.
    - Ensure `BASE_URL` matches your local path (default: `http://localhost/Student_Att/`).
    - Verify database credentials if they differ from the default (root/no password).

4.  **Run**:
    - Start Apache and MySQL in XAMPP.
    - Access the system at `http://localhost/Student_Att/`.

## Default Credentials
- **Username**: `admin`
- **Password**: `admin123`

---
Copyright &copy; 2026 sonjeb. All rights reserved.
