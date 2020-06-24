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
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>位置＆map表示</title>

  <style>
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
        width: 960px;
    }

    body h1 {
      text-align: center;
      font-size: 20px;
      color: #505050;
      background-color: #99CCFF;
      margin-bottom: 0px;
    }

    #map {
        height: calc(100% - 102px);
        margin: 0;
        padding: 0;
        width: 960px;
    }
 </style>
</head>

<body>
  <h1>【MAP表示】</h1>
  <div id="map"></div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=AuN7Ao98PCWAnz6p7g6jB-PJqeHDmeNsLD1dw072JK3OYe1EWVASIXyHRWupVkL5" async defer></script>

  <script>
    let map;

    // 現在地を取得するときのオプション
    const set = {
        enableHighAccuracy: true,   //より高精度な位置を求める
        maximumAge: 20000,          //最後の現在地情報取得が20秒以内であればその情報を再利用する設定
        timeout: 10000              //10秒以内に現在地情報を取得できなければ、処理を終了
    };

    // 現在地を中心にして地図を表示する関数
    function mapsInit(position) {
        // 座標を変数に入れる処理
        const lat = position.coords.latitude;    
        const lng = position.coords.longitude;
        // console.log(lat,lng);


        // 変数を中心にして地図を表示する処理
        map = new Microsoft.Maps.Map('#map', {      
            center: {         
                latitude: 33.586537,         
                longitude: 130.394467 
            },      
            mapTypeId: Microsoft.Maps.MapTypeId.load,      
            zoom: 15    
        });
    }

    // 現在位置の取得に失敗したときに実行する関数
    function mapsError(error) {
        let e = "";
        if (error.code == 1) {
            e = "位置情報が許可されてません";
        }
        if (error.code == 2) {
            e = "現在位置を特定できません";
        }
        if (error.code == 3) {
            e = "位置情報を取得する前にタイムアウトになりました";
        }
        alert("error：" + e);
    }

       // 現在地を取得し，成功したら地図を表示する関数
    function GetMap() {
        // 位置情報を取得する処理と，成功時と失敗時の関数を記述
        navigator.geolocation.getCurrentPosition(mapsInit, mapsError, set); 
    }

    function pushpin(lat, lng, now) {    
      const location = new Microsoft.Maps.Location(lat, lng);    
      const pin = new Microsoft.Maps.Pushpin(location, {      
        color: 'red',      
        visible: true
      });    
      now.entities.push(pin);  
    };  
    pushpin(lat, lng, map);

    
    
  </script>

</body>
</html>
