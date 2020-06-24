<?php
session_start();
include('functions.php');
check_session_id();
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
  <form action="meal_create.php" method="POST">
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
        <button>検索する</button>
      </div>

    </div>
  </form> 

</body>

</html>