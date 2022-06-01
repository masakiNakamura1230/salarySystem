<?php

// 遷移前URL
$referer = $_SERVER['HTTP_REFERER'];
// パスワード再設定登録画面
$passwordRegistUrl = "passwordRegist.php"; 

// パスワード再設定登録画面以外から遷移
if(!strstr($referer, $passwordRegistUrl)){

  // ログイン画面へ遷移
  header('Location: login.php');
  exit;
}
?>

<!------------------ HTML -------------------->
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>給与管理システム</title>
    <link rel="stylesheet" type="text/css" href="/css/base.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
  </head>
  <body>

  <h1 class="pageTitle" data-en="PasswordReset"><span>パスワード再設定</span></h1>

    <main>
      <p id="completeMessage">パスワードの再設定が完了しました</p>

      <a href="login.php" id="passwordLink">ログイン画面へ戻る</a>
    </main>
  </body>
</html>
