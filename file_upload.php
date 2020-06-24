<?php

 // コード  
 if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] == 0) {
    $uploadedFileName = $_FILES['upfile']['name'];//ファイル名の取得  
    $tempPathName  = $_FILES['upfile']['tmp_name']; //tmpフォルダの場所  
    $fileDirectoryPath = 'upload/'; //アップロード先フォルダ （↑自分で決める
    $extension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);  
    $uniqueName = date('YmdHis').md5(session_id()) . "." . $extension;  
    $fileNameToSave = $fileDirectoryPath.$uniqueName;

    $img='';  
    if (is_uploaded_file($tempPathName)) {    
      if (move_uploaded_file($tempPathName, $fileNameToSave)) {      
        chmod($fileNameToSave, 0644); // 権限の変更      
        $img = '<img src="'. $fileNameToSave . '" >'; // imgタグを設定    
      } else {      
        exit('Error:アップロードできませんでした'); // 画像の保存に失敗    
      }   
    } else {    
      exit('Error:画像がありません'); // tmpフォルダにデータがない 
    }
 
 } else {    // 送られていない，エラーが発生，などの場合    
  exit('Error:画像が送信されていません');  }
 
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>file_upload</title>
  
</head>

<body>
  <?= $img ?>
</body>

</html>