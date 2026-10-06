<?php
require __DIR__ . '/functions.php';
require __DIR__ . '/db.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) { http_response_code(400); exit('A valid task ID is required.'); }
$statement = $pdo->prepare('SELECT * FROM tasks WHERE id = :id');
$statement->execute(['id' => $id]);
$task = $statement->fetch();
if (!$task) { http_response_code(404); exit('Task not found.'); }
$errors = [];
$values = $task;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$errors, $values] = validateTask($_POST);
    $values['completed'] = isset($_POST['completed']) ? 1 : 0;
    if (!$errors) {
        $update = $pdo->prepare('UPDATE tasks SET title = :title, description = :description, category = :category, priority = :priority, due_date = :due_date, completed = :completed WHERE id = :id');
        $update->execute($values + ['id' => $id]);
        setFlash('Task updated successfully.');
        header('Location: index.php');
        exit;
    }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Edit Task</title><link rel="stylesheet" href="style.css"></head><body>
<main class="container narrow"><a class="back" href="index.php">← Back to tasks</a><h1>Edit a task</h1>
<?php if ($errors): ?><div class="notice error"><ul><?php foreach ($errors as $error): ?><li><?= escape($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form class="form-card" method="post" action="edit.php?id=<?= (int)$id ?>">
    <label>Title <input name="title" maxlength="150" required value="<?= escape($values['title']) ?>"></label>
    <label>Description <textarea name="description" rows="4"><?= escape($values['description'] ?? '') ?></textarea></label>
    <label>Category <input name="category" maxlength="50" value="<?= escape($values['category'] ?? '') ?>"></label>
    <div class="form-row"><label>Priority <select name="priority"><?php foreach (['Low', 'Medium', 'High'] as $priority): ?><option value="<?= escape($priority) ?>" <?= $values['priority'] === $priority ? 'selected' : '' ?>><?= escape($priority) ?></option><?php endforeach; ?></select></label><label>Due date <input type="date" name="due_date" value="<?= escape($values['due_date'] ?? '') ?>"></label></div>
    <label class="check"><input type="checkbox" name="completed" value="1" <?= (int)($values['completed'] ?? 0) === 1 ? 'checked' : '' ?>> Mark as completed</label>
    <button class="button" type="submit">Save changes</button>
</form></main></body></html>