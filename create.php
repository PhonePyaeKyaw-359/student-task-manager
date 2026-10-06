<?php
require __DIR__ . '/functions.php';
require __DIR__ . '/db.php';
$errors = [];
$values = ['title' => '', 'description' => '', 'category' => '', 'priority' => 'Medium', 'due_date' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$errors, $values] = validateTask($_POST);
    if (!$errors) {
        $statement = $pdo->prepare('INSERT INTO tasks (title, description, category, priority, due_date) VALUES (:title, :description, :category, :priority, :due_date)');
        $statement->execute($values);
        setFlash('Task added successfully.');
        header('Location: index.php');
        exit;
    }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Add Task</title><link rel="stylesheet" href="style.css"></head><body>
<main class="container narrow"><a class="back" href="index.php">← Back to tasks</a><h1>Add a task</h1>
<?php if ($errors): ?><div class="notice error"><ul><?php foreach ($errors as $error): ?><li><?= escape($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form class="form-card" method="post" action="create.php">
    <label>Title <input name="title" maxlength="150" required value="<?= escape($values['title']) ?>"></label>
    <label>Description <textarea name="description" rows="4"><?= escape($values['description']) ?></textarea></label>
    <label>Category <input name="category" maxlength="50" value="<?= escape($values['category']) ?>" placeholder="e.g. PHP"></label>
    <div class="form-row"><label>Priority <select name="priority"><?php foreach (['Low', 'Medium', 'High'] as $priority): ?><option value="<?= escape($priority) ?>" <?= $values['priority'] === $priority ? 'selected' : '' ?>><?= escape($priority) ?></option><?php endforeach; ?></select></label><label>Due date <input type="date" name="due_date" value="<?= escape($values['due_date'] ?? '') ?>"></label></div>
    <button class="button" type="submit">Save task</button>
</form></main></body></html>