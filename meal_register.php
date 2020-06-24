<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/meal.css">
  <title>Enjoy rice with someoneユーザー登録画面</title>
</head>

<body>
  <form action="meal_register_act.php" method="POST">
    <div class="login_page">
      <div class="header_title">
        <h1>Enjoy rice with someone</h>
      </div>
      <p>【ユーザー登録画面】</p>
      <div>
        user_id: <input type="text" name="user_id">
      </div>
      <div>
        password: <input type="text" name="password">
      </div>
      <div>
        <button>初回登録</button>
      </div>
      <a href="meal_login.php">or login</a>
    </div>  
  </form>
</body>

</html>