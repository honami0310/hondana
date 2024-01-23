<?php
//1. POSTデータ取得
//$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
//$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ
$name = $_POST['name'];
$email = $_POST['email'];
$naiyou = $_POST['naiyou'];

//2. DB接続します
// 直接$pdo = new PDO(～と書いて、try&catch書かなくてもいいのだけど、失敗した時の挙動を制御するため
try {
  //Password:MAMP='root',XAMPP=''
  // 最後２つの'',''はxamppのidとパスワード。idはroot、pwはなしでOKなので空欄
  $pdo = new PDO('mysql:dbname=gs_db2;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  // 失敗したときexit文章を出す。''内は任意の言葉
  exit('DBConnection Error:'.$e->getMessage());
}


//３．データ登録SQL作成
// databaseのSQLの時に学んだ書き方。バッククオート省略版、idは書かない
// VALUESはそれぞれの項目に:(コロン)をつける。
// まず型を作り、そこに後から内容を入れていくイメージ
$stmt = $pdo->prepare("INSERT INTO gs_an_table ( name, email, naiyou, indate )VALUES( :name, :email, :naiyou, sysdate())");
// :nameで型作ったところに内容入れる。$nameはpostで飛ばしたname
// .$nameとかしないでbindValueとすることで不正なIDを入れてすべての情報を抜き出すようなことを防ぐ
$stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)parameter streemの略。strは文字
$stmt->bindValue(':email', $email, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':naiyou', $naiyou, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
// stmt=statement
$status = $stmt->execute();

//４．データ登録処理後
// うまくデータ取れなかったとき(statusがfalseの時)
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  // リダイレクト先を記載
  header("Location: index.php");
  exit();

}
?>
