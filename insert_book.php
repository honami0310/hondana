<?php
//1. POSTデータ取得
//$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
//$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ
$bookname = $_POST['bookname'];
$author = $_POST['author'];
$bookurl = $_POST['bookurl'];
$comment = $_POST['comment'];
$category = $_POST['category'];
$star = $_POST['star'];




//2. DB接続します
// 直接$pdo = new PDO(～と書いて、try&catch書かなくてもいいのだけど、失敗した時の挙動を制御するため
try {
  //Password:MAMP='root',XAMPP=''
  // 以下(1)(2)切り替え注意。最後２つの'',''はxamppのidとパスワード。idはroot、pwはなしでOKなので空欄
  // (1)ローカル開発時用！！
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
  // (2)さくらサーバー用！！
  // $pdo = new PDO('mysql:dbname=gshycheese_gs_db;charset=utf8;host=mysql57.gshycheese.sakura.ne.jp','gshycheese','sirabasu0310');

} catch (PDOException $e) {
  // 失敗したときexit文章を出す。''内は任意の言葉
  exit('DBConnection Error:'.$e->getMessage());
}


//３．データ登録SQL作成
// databaseのSQLの時に学んだ書き方。バッククオート省略版、idは書かない
// VALUESはそれぞれの項目に:(コロン)をつける。
// まず型を作り、そこに後から内容を入れていくイメージ
$stmt = $pdo->prepare("INSERT INTO gs_bm_table ( bookname, author, bookurl, comment, category, star, indate )VALUES( :bookname, :author, :bookurl, :comment, :category, :star, sysdate())");
// :nameで型作ったところに後からbindValueで内容入れる。$nameはpostで飛ばしたname
// .$nameとかしないでbindValueとすることで不正なIDを入れてすべての情報を抜き出すようなことを防ぐ
$stmt->bindValue(':bookname', $bookname, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)parameter streemの略。strは文字
$stmt->bindValue(':author', $author, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':bookurl', $bookurl, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':category', $category, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':star', $star, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)

// stmt=statement
// statementを実行する指示
$status = $stmt->execute();
// 

//４．データ登録処理後
// うまくデータ取れなかったとき(statusがfalseの時)
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  // リダイレクト先を記載。insertを表記せずにindexに戻れる
  // リダイレクト先で問題が起きているか、送る元かは、リダイレクト先であえてエラーを起こすとわかる
  header("Location: index_book.php");
  exit();

}
?>
