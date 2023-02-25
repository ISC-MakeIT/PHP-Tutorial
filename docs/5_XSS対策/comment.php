<?php
$json = file_get_contents('./comments.json');
$comments = json_decode($json);
if (isset($_POST['comment'])) {
  var_dump($_POST['comment']);
  $sanitized = htmlspecialchars($_POST['comment']);
  array_push($comments, $sanitized);
  file_put_contents('./comments.json', json_encode($comments));
  header("Location: index.php");
  exit;
}
echo var_dump($comments);
