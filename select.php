<?php
//1.  DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  // 最後２つの'',''はxamppのidとパスワード。idはroot、pwはなしでOKなので空欄
  $pdo = new PDO('mysql:dbname=gs_db2;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  // 失敗したときexit文章を出す。''内は任意の言葉
  exit('DBConnection Error:'.$e->getMessage());
}

//２．データ登録SQL作成
// ここもSQLで習った引っ張り方。まるまるとるためfromの先はtable名
$stmt = $pdo->prepare("SELECT * FROM gs_an_table");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("**********:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  // $resはすべて入ってる(どこで設定してるか再確認)
  // ぐるぐる回して情報引っ張ってるらしい、どういうこと？
  while( $res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<p>';
    $view .= $res['id'].', '.$res['name'];
    $view .= '</p>';
  }

}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>フリーアンケート表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ登録</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
  <!-- phpで設定したviewを引っ張る -->
    <div class="container jumbotron"><?=$view?></div>
</div>
<!-- Main[End] -->

</body>
</html>
