<?php
$pdo = require_once 'connect.php';
if (isset($_POST['comment'])) {
  $sql = "INSERT INTO comments (user_id, body) VALUES (1, '{$_POST['comment']}')";
  var_dump($sql);
  $statement = $pdo->query($sql);
  header("Location: index.php");
  exit;
}
$sql = 'SELECT body FROM comments';
$statement = $pdo->query($sql);
$comments = $statement->fetchAll(PDO::FETCH_COLUMN);
echo var_dump($comments);
