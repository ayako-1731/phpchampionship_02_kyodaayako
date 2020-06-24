<?php
// var_dump($_POST);
// exit();
session_start(); // セッションの開始  

// 外部ファイル読み込み
include('functions.php');

// DB接続します
$pdo = connect_to_db();

// データ受け取り
$user_id = $_POST['user_id'];
$password = $_POST['password'];


// データ取得SQL作成&実行
$sql = 'SELECT * FROM mealusers_table             
          WHERE user_id=:user_id               
          AND password=:password               
          AND is_deleated=0';
// var_dump($sql);
// exit();                          
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$status = $stmt->execute();

// SQL実行時にエラーがある場合はエラーを表示して終了
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
}  

// うまくいったらデータ（1レコード）を取得
$val = $stmt->fetch(PDO::FETCH_ASSOC);

// ユーザ情報が取得できない場合はメッセージを表示
if (!$val) {
  echo "<p>ログイン情報が間違っています。再度ご入力ください。</p>";
  echo '<a href="meal_login.php">login</a>';
  exit();
} else {
  // ログインできたら情報をsession領域に保存して入力ページへ移動
  $_SESSION = array(); // セッション変数を空にする    
  $_SESSION["session_id"] = session_id();
  $_SESSION["is_admin"] = $val["is_admin"];
  $_SESSION["user_id"] = $val["user_id"];
  header("Location:meal_input.php"); // 入力ページへ移動 
  exit();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/meal.css">
  <title>Enjoy rice with someone</title>
</head>
<body>
  
</body>
</html>

