<?php
// Start the session once so pages can show one-time messages after redirects.
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function setFlash(string $message, string $type = 'success'): void
{
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}

function getFlash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

function validateTask(array $input): array
{
    $errors = [];
    $title = trim((string)($input['title'] ?? ''));
    $description = trim((string)($input['description'] ?? ''));
    $category = trim((string)($input['category'] ?? ''));
    $priority = (string)($input['priority'] ?? 'Medium');
    $dueDate = trim((string)($input['due_date'] ?? ''));

    if ($title === '' || mb_strlen($title) > 150) {
        $errors[] = 'Title is required and must be 150 characters or fewer.';
    }
    if (mb_strlen($category) > 50) {
        $errors[] = 'Category must be 50 characters or fewer.';
    }
    if (!in_array($priority, ['Low', 'Medium', 'High'], true)) {
        $errors[] = 'Choose Low, Medium, or High priority.';
    }
    if ($dueDate !== '') {
        $date = DateTime::createFromFormat('!Y-m-d', $dueDate);
        if (!$date || $date->format('Y-m-d') !== $dueDate) {
            $errors[] = 'Enter a valid due date.';
        }
    }

    return [$errors, [
        'title' => $title,
        'description' => $description,
        'category' => $category,
        'priority' => $priority,
        'due_date' => $dueDate === '' ? null : $dueDate,
    ]];
}

function requirePost(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit('This action requires a POST request.');
    }
}