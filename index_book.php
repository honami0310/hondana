<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>お気に入りの本棚を作ろう</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select_book.php">お気に入りの本棚を作ろう</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<!-- insert.phpにpost方式で飛ばす -->
<!-- 質問：登録後にinsert_book.phpに飛べない、どうしたいいの？ -->
<form method="post" action="insert_book.php">
  <!-- このjumbotronが複雑、質問 -->
  <div class="jumbotron">
   <fieldset> 
    <legend>本棚に本を登録</legend>
    <table>
     <tr><td><label>タイトル：</td><td><input type="text" name="bookname"></label></td></tr>
     <tr><td><label>著者：</td><td><input type="text" name="author"></label></td></tr>
     <tr><td><label>URL：</td><td><input type="text" name="bookurl"></label></td></tr>
     <tr><td><label>感想：</td><td><textArea name="comment" rows="4" cols="40"></textArea></label></td></tr>
     <tr><td><label>カテゴリ：</td><td><input type="text" name="category"></label></td></tr>
     <tr><td><label>評価(1~5)：</td><td><input type="text" name="star"></label></td></tr>
     </table>
     <tr><input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>
