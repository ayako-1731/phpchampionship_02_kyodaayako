<?php

// 送信データのチェック
// var_dump($_POST);
// exit();

// 関数ファイルの読み込み
include('functions.php'); 

// 送信データ受け取り
$id = $_POST['id']; 
$sex = $_POST['sex'];
$budget = $_POST['budget'];
$items = $_POST['items'];
$age = $_POST['age'];

// DB接続
$pdo = connect_to_db();

// UPDATE文を作成&実行
$sql = "UPDATE meals_table SET sex=:sex,budget=:budget,items=:items,age=:age,updated_at=sysdate() WHERE id=:id";  
$stmt = $pdo->prepare($sql);  
$stmt->bindValue(':sex',   $product,  PDO::PARAM_STR);  
$stmt->bindValue(':budget',$budget,   PDO::PARAM_STR);  
$stmt->bindValue(':id',    $id,       PDO::PARAM_INT);
$stmt->bindValue(':items', $items,    PDO::PARAM_STR); 
$stmt->bindValue(':age',   $age,      PDO::PARAM_STR); 
$status = $stmt->execute();
 

// データ登録処理後
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  // 正常にSQLが実行された場合は一覧ページファイルに移動し，一覧ページの処理を実行する
  header("Location:meal_read.php");    
  exit(); 
}
