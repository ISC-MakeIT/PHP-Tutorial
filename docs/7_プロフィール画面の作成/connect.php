<?php
$dsn = "mysql:host=localhost;dbname=phptutorial;charset=utf8";
$user = 'root';
$password = '';
try {
  return new PDO($dsn, $user, $password);
} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
}
