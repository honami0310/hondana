<?php
// include("funcs.php");じゃないの？←pho01の時の書き方質問
require_once('funcs.php'); //php02発展の記載

//1.  DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  // 最後２つの'',''はxamppのidとパスワード。idはroot、pwはなしでOKなので空欄
  // (1)ローカルに保存用
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root', '');
    // (2)さくらサーバー用
    // $pdo = new PDO('mysql:dbname=gshycheese_gs_db;charset=utf8;host=mysql57.gshycheese.sakura.ne.jp','gshycheese','sirabasu0310');
} catch (PDOException $e) {
  // 失敗したときexit文章を出す。''内は任意の言葉
  exit('DBConnection Error:' . $e->getMessage());
}

//２．データ登録SQL作成
// ここもSQLで習った引っ張り方。まるまるとるためfromの先はtable名
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table");
$status = $stmt->execute();

//３．データ表示
$view = "";
if ($status == false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:" . $error[2]);
} else {
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  // $resはすべて入ってる(どこで設定してるか再確認)
  // fetchとするとぐるぐる回して情報引っ張ってるらしい、詳細不明
  while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // tableで表示、タイトルクリックすると別tabでURL先に飛ぶ
    // hでfuncs.php適用して守ってる
    $view .= '<tr><td class="id">' . h($res['id'] ). '</td><td><button onclick="window.open(\'' . h($res['bookurl']) . '\', \'_blank\')">' . h($res['bookname']) . '</button></td><td>' . h($res['author']) . '</td><td>' . h($res['category']) . '</td><td>' . h($res['star']) . '</td><td>' . h($res['indate']) . '</td></tr><tr><td colspan="6">' . h($res['comment']) . '</td></tr>';
  }
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>登録済み本棚表示</title>
  <link rel="stylesheet" href="css/range.css">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>
    div {
      padding: 10px;
      font-size: 16px;
    }
  </style>
</head>

<body id="main">
  <!-- Head[Start] -->
  <header>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="index.php">本棚</a>
        </div>
      </div>
    </nav>
  </header>
  <!-- Head[End] -->

  <!-- Main[Start] -->
  <div>
    <!-- phpで設定したviewを引っ張る -->
    <div class="container jumbotron">
    <!-- phpで設定したviewを引っ張る -->
    <table>
      <tr class="gray">
        <td>No.</td>
        <td>タイトル</td>
        <td>著者</td>
        <td>カテゴリ</td>
        <td>評価</td>
        <td>登録日時</td>
      </tr>
      <tr class="gray">
        <td colspan="6">コメント</td>
      </tr>
      <?= $view ?>
    </table>
  </div>
  <!-- Main[End] -->
<div style="height: 50px"></div>
<ul>
		<li><a href="index_book.php">本棚に新規登録</a></li>
	</ul>
</body>

</html>