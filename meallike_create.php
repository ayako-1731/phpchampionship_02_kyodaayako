<?php
session_start();
include("functions.php");
check_session_id();

$user_id = $_SESSION['id'];

// var_dump($_GET);  
// exit();

// 関数ファイルの読み込み  
include('functions.php');

// GETデータ取得  
$user_id = $_GET['user_id'];  
$like_id = $_GET['like_id'];

// DB接続  
$pdo = connect_to_db();

 // 購入状態のチェック（COUNTで件数を取得できる！）
$sql = 'SELECT COUNT(*) FROM meatlike_table WHERE user_id=:user_id AND like_id=:like_id'; 
$stmt = $pdo->prepare($sql);  
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);  
$stmt->bindValue(':like_id', $like_id, PDO::PARAM_INT);  
$status = $stmt->execute();  

if ($status == false) {    
  // エラー処理  
} else {    
  $like_count = $stmt->fetch();    
  // var_dump($like_count[0]); // データの件数を確認しよう！   
  // exit(); 
}

// いいねしていれば削除，していなければ追加のSQLを作成  
if ($like_count[0] != 0) {    
  $sql =        
  'DELETE FROM meatlike_table WHERE user_id=:user_id AND like_id=:like_id';  
} else {    
  $sql = 'INSERT INTO meatlike_table(id, user_id, like_id, created_at)VALUES(NULL, :user_id, :like_id, sysdate())'; // 1行で記述！  
}
  // INSERTのSQLは前項で使用したものと同じ！   // 以降（SQL実行部分と一覧画面への移動）は変更なし！
 
// SQL作成
$stmt = $pdo->prepare($sql);  
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);  
$stmt->bindValue(':like_id', $like_id, PDO::PARAM_INT);  
$status = $stmt->execute(); 
// SQL実行
if ($status == false) {    
  // エラー処理  
} else {    
  header('Location:meal_read.php');
}

