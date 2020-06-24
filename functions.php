<?php


function connect_to_db()
{
  $dbn = 'mysql:dbname=gsacf_l03_02;charset=utf8;port=3306;host=localhost';
  $user = 'root';
  $pwd = '';
  try {
    return new PDO($dbn, $user, $pwd);
  } catch (PDOException $e) {
    exit('dbError:' . $e->getMessage());
  }
}

// ログイン状態のチェック関数
function check_session_id () {
  if (!isset($_SESSION['session_id']) || 
      $_SESSION['session_id']!=session_id()) {      
    header('Location: meal_login.php'); // ログイン画面へ移動  
  } else {      
    session_regenerate_id(true); // セッションidの再生成      
    $_SESSION['session_id'] = session_id(); // セッション変数に格納  
    // exit(); 
  } 
}

