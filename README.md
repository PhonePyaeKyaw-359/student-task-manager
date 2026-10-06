# Student Task Manager

A plain PHP and MySQL/MariaDB application for creating, viewing, editing, deleting, and filtering academic tasks. It uses PDO and does not require a framework or external package.

## Run with Laragon

1. Start Apache and MySQL in Laragon.
2. Import `database.sql` using phpMyAdmin or the MySQL command line.
3. Copy `db.example.php` to `db.php` and enter the correct local MySQL username and password in `db.php`. This file is ignored by Git and should stay on your computer.
4. Open `http://localhost/StudentTaskManager/` in your browser.

Do not publish database credentials or real task data. `database.sql` contains only the database and table structure.

## Files

- `index.php` displays tasks and filters to all or incomplete tasks.
- `create.php` adds a task.
- `edit.php` updates a task.
- `delete.php` deletes a task.
- `db.php` contains local database credentials and is excluded from Git.
- `db.example.php` is a credential-free starting template.
- `functions.php` contains validation, output escaping, and session flash messages.
- `database.sql` creates the database and `tasks` table.
- `style.css` contains the page styling.

## Requirements covered

The app uses HTML forms and GET/POST requests, server-side validation, PDO, prepared statements for user-provided values, SQL SELECT/INSERT/UPDATE/DELETE, reusable functions, arrays, conditionals, loops, sessions, and `htmlspecialchars()` for displayed user content. The current additional feature is a filter for incomplete tasks.

The exam brief leaves the individually assigned challenge blank. Confirm the challenge with your instructor and replace or extend the incomplete-task filter if a different challenge was assigned.

## Student details

Student Name: Phone Pyae Kyaw

Student ID: 202300359

## AI-use reflection

AI tool(s) used: OpenAI Codex

Three examples of how AI helped me:
1. It helped organize the project files around the PHP CRUD requirements.
2. It suggested using PDO prepared statements for database input.
3. It helped review the project against the exam brief.

One AI-generated suggestion or piece of code that I changed or rejected:

What was it? ______________________________________________

Why did I change or reject it? _______________________________

The part of this application I understand least: _______________

Complete the student details and reflection honestly. Before submission, verify the app with your exam database settings and make sure you can explain and modify the code independently during the code defense.
