<?php
session_start();

if (isset($_SESSION['user_id'])) {
  header('location: index.php');
  exit;
}

// このページからのエラーでないものを消す
if (isset($_SERVER['HTTP_REFERER'])) {
  $url = $_SERVER['HTTP_REFERER'];
  $pieces = explode('/', $url);
  if (end($pieces) !== 'signup.php') {
    unset($_SESSION['errored']);
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  function password_check()
  {
    if ($_POST['password'] !== $_POST['confirm']) {
      $_SESSION['errored'] = 'パスワードが一致しません';
      header('location: signup.php');
      exit;
    }
  }
  function user_exists()
  {
    $pdo = require 'connect.php';
    $sql = "SELECT user_id FROM users WHERE email = :email";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':email', $_POST['email']);
    $statement->execute();
    if ($statement->fetchColumn()) {
      $_SESSION['errored'] = 'すでに登録されています';
      header('location: signup.php');
      exit;
    }
  }
  function register_user()
  {
    $pdo = require 'connect.php';
    $sql = "INSERT INTO users (name, email, password, aboutme) VALUES (:name, :email, :password, 'プロフィール')";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':name', $_POST['name']);
    $statement->bindValue(':email', $_POST['email']);
    $statement->bindValue(':password', $_POST['password']);
    $statement->execute();
    if (!$pdo->lastInsertId()) {
      $_SESSION['errored'] = '登録に失敗しました';
      header('location: signup.php');
      exit;
    }
    unset($_SESSION['errored']);
    $_SESSION['user_id'] = $pdo->lastInsertId();
    header('location: index.php');
    exit;
  }

  password_check();
  user_exists();
  register_user();
  $_SESSION['errored'] = '';
}
?>
<!DOCTYPE html>
<html lang="jp">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規登録</title>
  <link rel="stylesheet" href="./css/common.css" />
  <link rel="stylesheet" href="./css/signup.css" />
</head>

<body>
  <div class="center">
    <div class="card">
      <img class="user-circle" src="./assets/user-circle.svg" width="50" height="50" alt="avatar" />
      <b class="form-name">新規登録</b>
      <?php
      if (isset($_SESSION['errored'])) {
        echo '<p class="form-error">' . $_SESSION['errored'] . '</p>';
      }
      ?>
      <form class="signup-form" action="signup.php" method="post">
        <label>ユーザーネーム</br>
          <input class="name-input" type="name" name="name" required>
        </label>
        <label>メールアドレス</br>
          <input class="email-input" type="email" name="email" required>
        </label>
        <label for="password">パスワード</br>
          <input class="password-input" type="password" name="password" required>
        </label>
        <label for="password">パスワード(確認)</br>
          <input class="confirm-input" type="password" name="confirm" required>
        </label>
        <button class="submit-btn" type="submit">登録</button>
        <a class="signin-link" href="signin.php">ログインはこちら</a>
      </form>
    </div>
  </div>
</body>

</html>