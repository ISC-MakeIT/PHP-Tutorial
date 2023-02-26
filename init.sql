-- DB作成、移動
CREATE DATABASE IF NOT EXISTS phptutorial;
USE phptutorial;
-- テーブル作成
CREATE TABLE IF NOT EXISTS users (
  user_id INT NOT NULL PRIMARY KEY auto_increment,
  name VARCHAR(20) NOT NULL,
  email VARCHAR(20) NOT NULL,
  password VARCHAR(20) NOT NULL
);
CREATE TABLE IF NOT EXISTS comments (
  comment_id INT NOT NULL PRIMARY KEY auto_increment,
  user_id INT NOT NULL,
  body VARCHAR(100) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(user_id)
);
-- サンプルデータ挿入
INSERT INTO users (name, email, password)
VALUES (
    'hoge',
    'hoge@example.com',
    'hogepassword'
  ),
  (
    'fuga',
    'fuga@example.com',
    'fugapassword'
  );
INSERT INTO comments (user_id, body)
VALUES (1, 'サンプルコメント１'),
  (1, 'サンプルコメント2'),
  (2, 'サンプルコメント3'),
  (2, 'サンプルコメント4');