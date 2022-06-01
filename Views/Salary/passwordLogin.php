<?php
// パスワード再設定ログイン画面

// コントローラー読み込み
require_once(ROOT_PATH .'/Controllers/PasswordController.php');
$passwordCon = new PasswordController();

session_start();

// 遷移前URL
$referer = $_SERVER['HTTP_REFERER'];
// 現画面
$url = "passwordLogin.php"; 
// ログイン画面
$loginUrl = "login.php";

// 現画面,
// ログイン画面から遷移
if(strstr($referer, $url) || strstr($referer, $loginUrl)){

  // 現画面から遷移(パスワード変更押下)
  if(strstr($referer,$url)){

    // サニタイジング
    $_POST['userId'] = htmlspecialchars($_POST['userId'],ENT_QUOTES);
    $_POST['question'] = htmlspecialchars($_POST['question'],ENT_QUOTES);

    // POST送信された値を置き換え
    $user = $_POST['user'];
    $userId = $_POST['userId'];
    $questionId = $_POST['questionId'];
    $question = $_POST['question'];

    // ユーザーID空白チェック
    if(mb_ereg_match("^(\s|　)+$", $userId)){
      $userId = '';
    }

    // ユーザーID未入力の場合
    if(empty($userId)){
      $errorMsg['userId'] = '※ユーザーIDは必須入力です。';
    }

    // 秘密の質問空白チェック
    if(mb_ereg_match("^(\s|　)+$", $question)){
      $question = '';
    }

    // 秘密の質問未入力チェック
    if(empty($question)){
      $errorMsg['question'] = '※秘密の質問は必須入力です。';
    }

    // エラーメッセージなし
    if(empty($errorMsg)){

      // パスワード変更ログインしたのが管理者・担当者
      if(($user == 0 || $user == 1)){

        // 担当者テーブルより入力したユーザーIDと秘密の質問が一致するユーザー検索
        try {

          // [ユーザーID]
          $params = $passwordCon->findManager($user, $userId, $questionId, $question);
        } catch (Exception $e){
          echo $e->getMessage()." - ". $e->getLine();
          header('Location: error.php');
          exit;
        }
        
      // パスワード変更ログインしたのがタレント
      } else if($user == 2){

        // タレントテーブルより入力したユーザーIDと秘密の質問が一致するユーザー検索
        try {

          // [ユーザーID]
          $params = $passwordCon->findTalent($userId, $questionId, $question);
        } catch (Exception $e){
          echo $e->getMessage()." - ". $e->getLine();
          header('Location: error.php');
          exit;
        }
      }

      // 一致するユーザーなし
      if(count(array_filter($params)) == 0){
        $errorMsg['noMatch'] = '※一致するユーザーがいません';

      // 一致するユーザーあり
      } else {

        // 選択されたユーザー保持
        $_SESSION['passwordUpdateUser'] = $user;

        // 一致したユーザーID保持
        $_SESSION['passwordUpdateUserId'] = $params['findUserId']['user_id'];

        // パスワード再設定登録画面へ遷移
        header('Location: passwordRegist.php');
        exit;
      }
    }
  } 

// 現画面,
// ログイン画面以外から遷移
}else {

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

    <h1 class="pageTitle" data-en="PasswordReset"><span>パスワード再設定</span></h1>

    <main>

      <!-- パスワード再設定ログインフォーム -->
      <form action="passwordLogin.php" method="post">

        <!-- ユーザー選択 -->
        <div id="userSelect">
          <input id="admin" class="userSelectRadio admin" type="radio" name="user" value="0" checked>
          <label class="admin" for="admin">管理者</label>
          <input id="manager" class="userSelectRadio manager" type="radio" name="user" value="1">
          <label class="manager" for="manager">担当者</label>
          <input id="talent" class="userSelectRadio talent" type="radio" name="user" value="2">
          <label class="talent" for="talent">タレント</label>   
        </div>

        <!-- ユーザーID -->
        <div class="playTextboxWrap">
          <input id="userId" class="textInput playTextboxUserId" type="text" name="userId">
          <label class="playLabelUserId" for="userId">ユーザーID</label>
          <span class="errorMsg">
            <?php echo !empty($errorMsg['userId']) ? $errorMsg['userId'] : ''; ?>
          </span>
        </div>

        <!-- 秘密の質問 -->
        <div id="questionContent">
          <select id="questionId"  name="questionId">
            <option value="1" selected>母親の旧姓は？</option>              <option value="2">ペットの名前は？</option>
            <option value="3">中学三年生の担任は？</option>
          </select>
        </div>

        <!-- 秘密の質問回答 -->
        <div class="playTextboxWrap">
          <input id="question" class="textInput playTextboxQuestion" type="text" name="question">
          <label class="playLabelQuestion" for="question">秘密の質問</label>
          <span class="errorMsg">
            <?php echo !empty($errorMsg['question']) ? $errorMsg['question'] : '';?>
          </span>
        </div>

        <!-- 一致しない場合エラーメッセージ表示 -->
        <span class="errorMsg centerErrorMsg">
          <?php echo !empty($errorMsg['noMatch']) ? $errorMsg['noMatch'] : ''; ?>
        </span>
        <input class="btn" type="submit" value="パスワード変更">
      </form>

    </main>
    <!-- JSファイル読み込み -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/js/main.js"></script>
  </body>
</html>
