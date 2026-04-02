# 🗂️ TaskFlow – Laravel Personal Todo App

## 👤 Student Information

**Name:** Sunny Lorenz Perando
**Project Title:** TaskFlow: A Laravel Personal Task Management App

---

## 📌 Project Overview

TaskFlow is a web-based task management system built using Laravel. It helps users organize their daily tasks and projects efficiently, track progress, and stay productive.

---

## 🎯 Goal of the Application

The goal of TaskFlow is to help users:

* Stay organized with tasks and projects
* Track deadlines and progress
* Manage workload efficiently

---

## ❗ Problem It Solves

Many users struggle with:

* Forgetting tasks
* Poor organization
* Lack of visibility on deadlines

TaskFlow solves this by providing:

* A centralized dashboard
* Task categorization (Today, Upcoming, Overdue)
* Project-based organization
* Progress tracking

---

## ⚙️ Tech Stack

### 🔹 Laravel

* Backend framework used to handle logic, routing, and database interaction

### 🔹 Blade

* Laravel’s templating engine used to build dynamic UI

### 🔹 Database (MySQL)

* Stores users, tasks, projects, and roles

### 🔹 Eloquent ORM

* Handles relationships such as:

  * User → Projects
  * Project → Tasks
  * User → Roles

---

## 🔗 Key Features

* User authentication (Login/Register)
* Dashboard with task overview
* Project management
* Task creation and tracking
* Role-based access (Admin/User)
* Search functionality (tasks & projects)
* Dark mode support

---

## 📂 Project Structure (Important Files)

### Routes

```bash
routes/web.php
```

### Controllers

```bash
app/Http/Controllers/DashboardController.php
app/Http/Controllers/Admin/TaskController.php
app/Http/Controllers/Admin/ProjectController.php
```

### Models

```bash
app/Models/User.php
app/Models/Task.php
app/Models/Project.php
app/Models/Role.php
```

### Views (Blade)

```bash
resources/views/dashboard.blade.php
resources/views/admin/tasks/
resources/views/admin/projects/
```

---

## 🐞 Challenges & Bug Fix

### Bug Encountered

Tasks and projects were showing incorrect counts for new users.

### Problem Code

```php
Task::where('created_by', auth()->id())->count();
```

### Issue

Some parts of the app used:

```php
Task::count();
```

which showed ALL tasks instead of user-specific ones.

### Solution

Ensured all queries use:

```php
->where('created_by', auth()->id())
```

### What I Learned

* Importance of consistent filtering in multi-user systems
* Difference between global vs user-specific queries
* Debugging database-related issues

---

## 🚀 Installation Guide

1. Install dependencies:

```bash
composer install
```

2. Copy environment file:

```bash
cp .env.example .env
```

3. Generate app key:

```bash
php artisan key:generate
```

4. Run migrations:

```bash
php artisan migrate
```

5. Start server:

```bash
php artisan serve
```

---
