<?php
session_start();
include('functions.php');
check_session_id();
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>NewsAPI Sample</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      #newsList {
        display:flex;
        flex-wrap:wrap;
        justify-content: space-around;
      }
      #newsList img {
        width: 200px;
        height: 150px;
      }
      .content {
        width: 200px;
        border: 1px solid #aaa;
      }
    </style>
  </head>
  <body>
    
    <!-- //ここにニュースの一覧を表示する -->
    <div id="newsList"></div>
    
    
    <!-- //無料プランの場合は帰属表示をしておきましょう -->
    <footer>
      <small>powered by <a href="https://newsapi.org">NewsAPI.org</a></small>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/script.js"></script>   
    <script>
      const newslist = document.getElementById('newsList');

      //サーバーにアクセスしてNode.jsで取得したニュースデータを得る
      fetch('/data')
      .then(data => data.json())
      .then(json => {
        json['articles'].forEach(item => createContents(item));
      });


      //取得したニュースデータからタイトル・画像・URLを1つにまとめて表示する
      function createContents(item) {
        const div = document.createElement('div');

        //記事画像が無い場合を考慮して別の画像に差し替える処理も追記すると良いかも
        //const image = item.urlToImage || 'sample.jpg';

        div.classList.add('content');
        div.innerHTML = `<a href="${item.url}">
                            <img src="${item.urlToImage}">
                            <p>${item.title}</p>
                         </a>`;

        newslist.appendChild(div);  

      }
    </script>
  </body>
</html>
