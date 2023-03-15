<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header('location: signin.php');
  exit;
}

$user_id = $_SESSION['user_id'];
$pdo = require_once 'connect.php';
if (isset($_POST['comment'])) {
  $sanitized  = htmlspecialchars($_POST['comment']);
  $sql = "INSERT INTO comments (user_id, body) VALUES ({$user_id}, '{$sanitized}')";
  var_dump($sql);
  $statement = $pdo->query($sql);
  header("Location: index.php");
  exit;
}
$sql = 'SELECT body FROM comments';
$statement = $pdo->query($sql);
$comments = $statement->fetchAll(PDO::FETCH_COLUMN);
echo var_dump($comments);
