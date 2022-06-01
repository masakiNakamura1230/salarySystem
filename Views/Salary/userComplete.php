<?php

// 遷移前URL
$referer = $_SERVER['HTTP_REFERER'];
// ユーザー登録確認画面
$userConfirmUrl = 'userConfirm.php'; 

// ユーザー登録確認画面以外から遷移
if(!strstr($referer, $userConfirmUrl)){

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

  <div id="logOutWrap">
      <div id="logOutBox">
        <a id="logOut" href="login.php">ログアウト</a>
      </div>
    </div>

    <h1 class="pageTitle" data-en="UserRegist"><span>ユーザー登録</span></h1>

    <main>
      <p id="completeMessage">ユーザー登録が完了しました</p>

      <a href="userList.php" id="passwordLink">ユーザー一覧へ戻る</a>
    </main>
  </body>
</html>
