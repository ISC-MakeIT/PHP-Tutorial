<?php
session_start();

if (isset($_SESSION['user_id'])) {
  header('location: index.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $pdo = require_once 'connect.php';
  $sql = "SELECT user_id FROM users WHERE email='{$_POST['email']}' AND password='{$_POST['password']}'";
  $statement = $pdo->query($sql);
  $user = $statement->fetch();
  if (!empty($user)) {
    unset($_SESSION['errored']);
    $_SESSION['user_id'] = $user['user_id'];
    header('location: index.php');
    exit;
  }
  $_SESSION['errored'] = true;
}
?>
<!DOCTYPE html>
<html lang="jp">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン</title>
  <link rel="stylesheet" href="./css/common.css" />
  <link rel="stylesheet" href="./css/signin.css" />
</head>

<body>
  <div class="center">
    <div class="card">
      <img class="user-circle" src="./assets/user-circle.svg" width="50" height="50" alt="avatar" />
      <b class="form-name">ログイン</b>
      <?php
      if (isset($_SESSION['errored'])) {
        echo '<p class="form-error">メールアドレスまたはパスワードが間違っています</p>';
      }
      ?>
      <form class="signin-form" action="signin.php" method="post">
        <label>メールアドレス</br>
          <input class="email-input" type="email" name="email" required>
        </label>
        <label for="password">パスワード</br>
          <input class="password-input" type="password" name="password" required>
        </label>
        <button class="submit-btn" type="submit">ログイン</button>
        <a class="register-link" href="register.php">新規登録はこちら</a>
      </form>
    </div>
  </div>
</body>

</html>