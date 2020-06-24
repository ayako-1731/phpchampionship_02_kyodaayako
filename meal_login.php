<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/meal.css">
  <title>ユーザーログイン登録</title>
</head>

<body>
  <form action="meal_login_act.php" method="POST">
    <div class="login_page">
      <div class="header_title">
        <h1>Enjoy rice with someone</h>
      </div>
      <p>【ユーザーログイン画面】</p>
      <div class="button">
        <button id="facebook_button"><a href="meal_input.php">Facebookでログイン
        <img src="img/oyayubi.jpg" alt="親指のアイコン"></a></button>
      </div>
      <p>or</p>
      <p>利用時にIDとパスワードをご入力ください☺</p>
  
      <div>
        user_id : <input type="text"  name="user_id">
      </div>
      <div>
        password: <input type="text" name="password">
      </div>
      <div>
        <button>Login</button>
      </div>
      <a href="meal_register.php">初回登録</a>
    </div>

  </form>
</body>

</html>