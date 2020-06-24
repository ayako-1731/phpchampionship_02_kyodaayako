<?php
// 送信データのチェック
// var_dump($_GET);
// exit();

// 関数ファイルの読み込み
include("functions.php");
 

// idの受け取り
$id = $_GET['id'];

// DB接続
$pdo = connect_to_db();  



// データ取得SQL作成
$sql = 'SELECT * FROM meals_table WHERE id=:id';  
$stmt = $pdo->prepare($sql);  
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  
$status = $stmt->execute();

// SQL準備&実行
$sql = '';


// データ登録処理後
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  // 正常にSQLが実行された場合は指定の11レコードを取得
  // fetch()関数でSQLで取得したレコードを取得できる
  $record = $stmt->fetch(PDO::FETCH_ASSOC); 
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/meal.css">
  <title>Enjoy rice with someone（編集画面）</title>
</head>

<body>
  <form action="meal_update.php" method="POST">
   <input type="hidden" name="id" value="<?=$record['id']?>">
      <!-- <p>（編集画面）</p> -->
      <a href="meal_read.php">一覧画面</a>
      <div class="login_page">
        <div class="header_title">
          <h1>Enjoy rice with someone</h>
        </div>
      <div class="sex" name="sex">
      <img src="img/icon.png" alt="食事の画像です"> 誰と一緒に？ : 
        <select type="text" name="sex">
          <option value="性別" selected>性別を選択</option>
          <option value="男性">男性</option>
          <option value="女性">女性</option>
          <option value="問わず">異性問わず</option>
        </select> 
      </div>
      
      <div class="budget">
      <img src="img/icon.png" alt="食事の画像です"> 予　算 : 
        <select type="text" name="budget">
          <option value="金額の予算" selected>金額の予算を選択</option>
          <option value="千円以内">~1,000</option>
          <option value="二千円以内">1,000~2,000</option>
          <option value="三千円以内">2,000~3,000</option>
          <option value="四千円以内">3,000~4,000</option>
          <option value="四千円以上">4,000~</option>
        </select> 円
      </div>

      <div class="items">
      <img src="img/icon.png" alt="食事の画像です"> 食べたいジャンルは？ : 
        <select type="text" name="items">
          <option value="選択肢" selected>ジャンルを選択</option>
          <option value="イタリアン">イタリアン</option>
          <option value="フレンチ">フレンチ</option>
          <option value="中華">中華</option>
          <option value="和食">和食</option>
          <option value="エスニック">エスニック料理</option>
          <option value="スペイン">スペイン料理</option>
          <option value="軽食類">軽食・スナック</option>
          <option value="その他">その他（ローカルフード）</option>
        </select>
      </div>

      <div class="age">
      <img src="img/icon.png" alt="食事の画像です"> 一緒に食事をしたい年代は？ :
        <select type="text" name="age">
          <option value="10代">10代</option>
          <option value="20代">20代</option>
          <option value="30代">30代</option>
          <option value="40代">40代</option>
          <option value="50代">50代以上</option>
          <option value="年代問わず">年代問わず</option>
        </select>
      </div> 

      <div>
        <button><a href="meal_read.php">編集する</a></button>
      </div>
    </div>
   
  </form>

</body>

</html>