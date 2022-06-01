<?php
// パスワード再設定登録画面

// コントローラー読み込み
require_once(ROOT_PATH .'/Controllers/PasswordController.php');
$passwordCon = new PasswordController();

session_start();

// 遷移前URL
$referer = $_SERVER['HTTP_REFERER'];
// 現画面
$url = "passwordRegist.php"; 
// パスワード再設定ログイン画面
$passwordLoginUrl = 'passwordLogin.php';

// 現画面,
// パスワード再設定ログイン画面から遷移
if(strstr($referer, $url) || strstr($referer, $passwordLoginUrl)){

  // 保持されているデータ置き換え
  $user = $_SESSION['passwordUpdateUser'];
  $userId = $_SESSION['passwordUpdateUserId'];

  // 現画面から遷移(パスワード登録押下)
  if(strstr($referer, $url)){

    // サニタイジング
    $_POST['newPassword'] = htmlspecialchars($_POST['newPassword'],ENT_QUOTES);
    $_POST['newPasswordRe'] = htmlspecialchars($_POST['newPasswordRe'],ENT_QUOTES);

    // POST送信された値を置き換え
    $newPassword = $_POST['newPassword'];
    $newPasswordRe = $_POST['newPasswordRe'];

    // 新しいパスワード空白チェック
    if(mb_ereg_match("^(\s|　)+$", $newPassword)){
      $newPassword = '';
    }

    // 新しいパスワード未入力チェック
    if(empty($newPassword)){
      $errorMsg['newPassword'] = '※新しいパスワードが未入力です。';
    }

    // 新しいパスワード英数字チェック
    if(!preg_match("/^[a-zA-Z0-9]+$/", $newPassword)){
      $errorMsg['newPassword'] = '※パスワードは英数字でご入力ください。';
    }

    // 新しいパスワード16文字以内チェック
    if(16 < mb_strlen($newPassword)){
      $errorMsg['newPassword'] = '※パスワードは16文字以内でご入力ください。';
    }

    // パスワード再入力空白チェック
    if(mb_ereg_match("^(\s|　)+$", $newPasswordRe)){
      $newPasswordRe = '';
    }

    // パスワード再入力未入力チェック
    if(empty($newPasswordRe)){
      $errorMsg['newPasswordRe']  = '※新しいパスワードを再入力してください。';
    }

    // エラーメッセージなし
    if(empty($errorMsg)){

      // 入力された新しいパスワードと再入力の値が一致
      if($newPassword == $newPasswordRe){

        // ユーザーIDと一致するユーザーのパスワード変更
        try {
          $passwordCon->updatePassword($user, $userId, $newPassword);
        } catch (Exception $e) {
          echo $e->getMessage()." - ". $e->getLine();
          header('Location: error.php');
          exit;
        }
        
        // パスワード再設定完了画面へ遷移
        header('Location: passwordComplete.php');
        exit;

      // 入力された新しいパスワードと再入力の値が一致しない
      } else {
        $errorMsg['noMatch'] = '入力されたパスワードが一致しません';
      }
    }
  }

// 現画面,
// パスワード再設定ログイン画面以外から遷移
} else {
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

    <h1 class="pageTitle" data-en="PasswordReset"><span>パスワード再設定</span></h1>

    <main>

      <!-- パスワード再設定登録フォーム -->
      <form action="passwordRegist.php" method="post">

        <!-- 新しいパスワード -->
        <div class="playTextboxWrap">
          <input id="newPassword" class="textInput playTextboxPassword" type="text" name="newPassword">
          <label class="playLabelPassword" for="newPassword">新しいパスワード</label>
          <span class="errorMsg">
            <?php echo !empty($errorMsg['newPassword']) ? $errorMsg['newPassword'] : '';?>
          </span>
        </div>

        <!-- 新しいパスワード再入力 -->
        <div class="playTextboxWrap">
          <input id="newPasswordRe" class="textInput playTextboxPasswordRe" type="text" name="newPasswordRe">
          <label class="playLabelPasswordRe" for="newPasswordRe">パスワード再入力</label>
          <span class="errorMsg">
            <?php echo !empty($errorMsg['newPasswordRe']) ? $errorMsg['newPasswordRe'] : '';?>
          </span>
        </div>

        <!-- 一致しな場合エラーメッセージ表示 -->
        <span class="errorMsg centerErrorMsg">
          <?php echo !empty($errorMsg['noMatch']) ? $errorMsg['noMatch'] : '';?>
        </span>
        <input id="passwordBtn" class="btn" type="submit" value="パスワード登録">
      </form>

    </main>
    <!-- JSファイル読み込み -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/js/main.js"></script>
  </body>
</html>
