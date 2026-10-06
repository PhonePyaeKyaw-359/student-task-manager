<?php
require __DIR__ . '/functions.php';
require __DIR__ . '/db.php';
requirePost();
$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
if (!$id || $id < 1) { http_response_code(400); exit('A valid task ID is required.'); }
$statement = $pdo->prepare('DELETE FROM tasks WHERE id = :id');
$statement->execute(['id' => $id]);
setFlash($statement->rowCount() ? 'Task deleted.' : 'Task was already removed.', $statement->rowCount() ? 'success' : 'error');
header('Location: index.php');
exit;