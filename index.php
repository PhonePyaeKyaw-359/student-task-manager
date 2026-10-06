<?php
require __DIR__ . '/functions.php';
require __DIR__ . '/db.php';

// The challenge example is filtering the list to show incomplete tasks only.
$filter = $_GET['filter'] ?? 'all';
if (!in_array($filter, ['all', 'incomplete'], true)) {
    $filter = 'all';
}
$sql = 'SELECT * FROM tasks';
if ($filter === 'incomplete') {
    $sql .= ' WHERE completed = 0';
}
$sql .= ' ORDER BY due_date IS NULL, due_date ASC, id DESC';
$statement = $pdo->query($sql);
$tasks = $statement->fetchAll();
$flash = getFlash();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Task Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="container">
    <header class="page-header">
        <div><p class="eyebrow">Academic planner</p><h1>Student Task Manager</h1><p>Keep coursework and deadlines in one place.</p></div>
        <a class="button" href="create.php">Add a task</a>
    </header>

    <?php if ($flash): ?>
        <p class="notice <?= escape($flash['type']) ?>"><?= escape($flash['message']) ?></p>
    <?php endif; ?>

    <nav class="filters" aria-label="Task filters">
        <a class="<?= $filter === 'all' ? 'selected' : '' ?>" href="index.php">All tasks</a>
        <a class="<?= $filter === 'incomplete' ? 'selected' : '' ?>" href="index.php?filter=incomplete">Incomplete only</a>
    </nav>

    <?php if (!$tasks): ?>
        <section class="empty"><h2>No tasks found</h2><p>Add a task or switch the filter to see your list.</p></section>
    <?php else: ?>
        <section class="task-list" aria-label="Tasks">
            <?php foreach ($tasks as $task): ?>
                <article class="task-card <?= (int)$task['completed'] === 1 ? 'is-complete' : '' ?>">
                    <div class="task-main">
                        <div class="task-title-row">
                            <h2><?= escape($task['title']) ?></h2>
                            <span class="badge priority-<?= strtolower(escape($task['priority'])) ?>"><?= escape($task['priority']) ?></span>
                        </div>
                        <p class="description"><?= nl2br(escape($task['description'] ?: 'No description')) ?></p>
                        <p class="meta"><?= escape($task['category'] ?: 'Uncategorized') ?> · Due <?= escape($task['due_date'] ?: 'No date') ?> · <?= (int)$task['completed'] === 1 ? 'Completed' : 'Incomplete' ?></p>
                    </div>
                    <div class="actions">
                        <a class="button secondary" href="edit.php?id=<?= (int)$task['id'] ?>">Edit</a>
                        <form action="delete.php" method="post" onsubmit="return confirm('Delete this task?');">
                            <input type="hidden" name="id" value="<?= (int)$task['id'] ?>">
                            <button class="button danger" type="submit">Delete</button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>
    <footer>Showing <?= count($tasks) ?> task<?= count($tasks) === 1 ? '' : 's' ?>.</footer>
</main>
</body>
</html>