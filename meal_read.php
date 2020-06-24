<?php


// // メッセージを保存するファイルのパス設定
// define('FILENAME','./message.txt');

// タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

// // 変数の初期化
// $now_date = null;
// $data = null;
// $file_handle = null;
// $split_data = null;
// $message = array();
// $message_array = array();

// if(!empty($_POST['btn_submit'])) {
//   if($file_handle = fopen(FILENAME,"a")){

//     // 書き込み日時を取得
//     $now_date = date("Y-m-d H:i:s");

//     // 書き込むデータを作成
//     $data = "'".$_POST['view_name']."','".$_POST['message']."','".$now_date."'\n";

//     // 書き込み
//     fwrite($file_handle,$data);
//     // ファイルを閉じる
//     fclose($file_handle);
//   }
// }

// if($file_handle = fopen(FILENAME,'r')){
//   while($data = fgets($file_handle)){
//     $split_data = preg_split('/\'/',$data);

//     $message = array(
//       'view_name'=> $split_data[1],
//       'message'=> $split_data[3],
//       'post_date'=> $split_data[5],
//     );
//     array_unshift($message_array,$message);

//   }
//   // ファイルを閉じる
//   fclose($file_handle);
// }

session_start();
include('functions.php');
check_session_id();


// ユーザ名取得
$user_id = $_SESSION['id'];


// DB接続の設定

$pdo = connect_to_db();
// DB名は`gsacf_x00_00`にする
// $dbn = 'mysql:dbname=YOUR_DB_NAME;charset=utf8;port=3306;host=localhost';
// $user = 'root';
// $pwd = '';

// try {
//   // ここでDB接続処理を実行する
//   $pdo = new PDO($dbn, $user, $pwd);
// } catch (PDOException $e) {
//   // DB接続に失敗した場合はここでエラーを出力し，以降の処理を中止する
//   echo json_encode(["db error" => "{$e->getMessage()}"]);
//   exit();
// }

// いいね数カウント
$sql = 'SELECT like_id, COUNT(id) AS cnt FROM meatlike_table GROUP BY like_id';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();
if ($status == false) {    // エラー処理  
} else {
  $like_count = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetchAllで全件取得  
  // var_dump($like_count);    
  // exit();  
}

// データ取得SQL作成
$sql = 'SELECT * FROM meals_table           
        LEFT OUTER JOIN (SELECT like_id, COUNT(id) AS cnt           
        FROM meatlike_table GROUP BY like_id) AS likes           
        ON meals_table.id = likes.like_id';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  // echo json_encode(["error_msg" => "{$error[2]}"]);
  // exit();
} else {
  // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
  // fetchAll()関数でSQLで取得したレコードを配列で取得できる
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定

  // データの出力用変数（初期値は空文字）を設定
  $output = "";
  // <tr><td>deadline</td><td>todo</td><tr>の形になるようにforeachで順番に$outputへデータを追加
  // `.=`は後ろに文字列を追加する，の意味
  foreach ($result as $record) {
    $output .= "<tr>";
    $output .= "<td>{$record["sex"]}</td>";
    $output .= "<td>{$record["budget"]}</td>";
    $output .= "<td>{$record["items"]}</td>";
    $output .= "<td>{$record["age"]}</td>";

    $output .= "<td><a href='meallike_create.php?user_id={$user_id}&like_id={$record["id"]}'>💛{$record["cnt"]}</a></td>";
    $output .= "<td><a href='map.php?id={$record["id"]}'>現在地</a></td>";
    $output .= "<td><a href='meal_edit.php?id={$record["id"]}'>編集</a></td>";
    $output .= "<td><a href='meal_delete.php?id={$record["id"]}'>消去</a></td>";
  }
  // $valueの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
  // 今回は以降foreachしないので影響なし
  //   unset($record);
}

// ファイルの指定
$dataFile = 'datafile.dat';

// エスケープする関数
function h($s)
{
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

//name="send_message"のPOST送信があった時
if (isset($_POST["send_message"])) {
  //送信されたname="message"とname="view_name"の値を取得する
  $message = trim($_POST['message']);
  $view_name = trim($_POST['view_name']);
  $img = trim($_POST['img']);

  //messageが空じゃなかったら
  if (!empty($message)) {
    //userが空の場合、名無しにする
    if (empty($view_name)) {
      $view_name = "名無し";
    }
    // 日付を取得する
    $postDate = date('Y年m月d日 H時i分');
    // ファイルに書き込むメッセージを作成する
    $newData = $view_name . "/" . $message . "/" . $postDate . "\n";
    // ファイルを開く
    $fp = fopen($dataFile, 'a');
    // ファイルに書き込む
    fwrite($fp, $newData);
    // ファイルを閉じる
    fclose($fp);
  }
}
// 一行ずつデータを取り出して配列に入れる
$post_list = file($dataFile, FILE_IGNORE_NEW_LINES);
$post_list = array_reverse($post_list);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/meal.css">
  <title>チャット履歴（一覧画面）</title>
</head>

<body>
  <div id="tbl_bdr">
    <table width="100%">
      <thead>
        <tr>
          <th>性 別</th>
          <th>金 額</th>
          <th>種 類</th>
          <th>年 代</th>
          <th>イイネ</th>
          <th>操作①</th>
          <th>操作②</th>
          <th>操作③</th>
        </tr>
      </thead>
      <tbody>
        <!-- ここに<tr><td>deadline</td><td>todo</td><tr>の形でデータが入る -->
        <?= $output ?>
      </tbody>
    </table>
  </div>

  <form action="meal_read.php" method="POST" enctype="multipart/form-data">
    <h2 id="conversation">■ チャット ■</h2>
    <div>
      <label for="view_name">名前:</label><br>
      <input id="view_name" type="text" name="view_name" value="">
    </div>
    <div>
      <label for="message">メッセージ:</label><br>
      <textarea id="message" name="message"></textarea>
    </div>

    <!-- <div>
      <input type="file" name="upfile" accept="image/*" capture="camera">
    </div> -->
    </div>
    <input type="submit" name="send_message" value="投稿する"><br>
    
    <a href="news.php" target="_blank">※世界の気になるニュースを見る</a>
  </form>
  <hr>
  <section>
    <h2 id="postlist">■ 投稿一覧 ■</h2>
    <ul>
      <!-- post_listがある場合 -->
      <?php if (!empty($post_list)) { ?>
        <!-- post_listの中身を一つづつ取り出し表示する -->
        <?php foreach ($post_list as $post) { ?>
          <li><?php echo h($post); ?></li><br>
        <?php } ?>
      <?php } else { ?>
        <li>まだ投稿はありません</li>
      <?php } ?>
    </ul>
  </section>
    <!-- <p><a href="meal_input.php">入力画面</a></p> -->
    <p><a href="meal_logout.php">ログアウト</a></p>

</body>

</html>