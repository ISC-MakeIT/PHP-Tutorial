<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header('location: signin.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="jp">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ホーム</title>
  <link rel="stylesheet" href="./css/common.css" />
  <link rel="stylesheet" href="./css/header.css" />
  <link rel="stylesheet" href="./css/sidebar.css" />
  <link rel="stylesheet" href="./css/main.css" />
</head>

<body>
  <div class="header">
    <img src="./assets/menu-white.svg" height="40" width="40" />
    <div class="header-right">
      <form action="" method="get" class="form-example">
        <div class="search-box">
          <label for="keyword"><img src="./assets/search.svg" height="30" width="30" />
          </label>
          <input type="text" name="keyword" id="keyword" required />
        </div>
      </form>
      <a href="signout.php">ログアウト</a>
    </div>
  </div>
  <div class="container">
    <nav class="sidebar">
      <ul>
        <li>
          <a href="#">
            <img src="./assets/home.svg" height="40" width="40" /><strong>ホーム</strong>
          </a>
        </li>
        <li>
          <a href="profile.php"><img src="./assets/user.svg" height="40" width="40" />プロフィール</a>
        </li>
        <li>
          <a href="#"><img src="./assets/bell.svg" height="40" width="40" />通知</a>
        </li>
        <li>
          <a href="#"><img src="./assets/heart.svg" height="40" width="40" />いいね</a>
        </li>
      </ul>
    </nav>
    <main>
      <div class="comment">
        <img class="avatar" src="./assets/sample.png" height="57" width="57" alt="sample" />
        <form action="./comment.php" method="post" class="comment-form">
          <div class="comment-box">
            <label for="comment"> </label>
            <textarea name="comment" id="keyword" required></textarea>
          </div>
          <div class="submit-button-wrap">
            <button type="submit">投稿する</button>
          </div>
        </form>
      </div>
      <div class="timeline">
        <ul class="timeline-comments">
          <?php
          $pdo = require_once 'connect.php';
          $sql = 'SELECT comments.user_id, comments.body, users.name FROM comments INNER JOIN users ON comments.user_id = users.user_id';
          $statement = $pdo->query($sql);
          $comments = $statement->fetchAll();
          $reversed = array_reverse($comments);
          foreach ($reversed as $comment) {
            if ($comment['user_id'] === 1) {
              echo " <li>
            <img class='avatar' src='./assets/sample.png' height='57' width='57' alt='sample' />
            <div class='timeline-comments-right'>
              <strong>{$comment['name']}</strong>
              <p>{$comment['body']}</p>
              <div class='timeline-comments-reaction'>
                <img src='./assets/chat-light.svg' height='20' weight='20' alt='reply' />
                <img src='./assets/heart-light.svg' height='20' weight='20' alt='favorite' />
              </div>
            </div>
          </li>";
            } else {
              echo " <li>
            <img class='avatar' src='./assets/sample2.png' height='57' width='57' alt='sample' />
            <div class='timeline-comments-right'>
              <strong>{$comment['name']}</strong>
              <p>{$comment['body']}</p>
              <div class='timeline-comments-reaction'>
                <img src='./assets/chat-light.svg' height='20' weight='20' alt='reply' />
                <img src='./assets/heart-light.svg' height='20' weight='20' alt='favorite' />
              </div>
            </div>
          </li>";
            }
          }
          ?>
        </ul>
      </div>
    </main>
  </div>
</body>

</html>