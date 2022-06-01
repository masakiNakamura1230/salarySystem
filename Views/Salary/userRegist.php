<?php
// ユーザー登録画面

session_start();

// 遷移前URL
$referer = $_SERVER['HTTP_REFERER'];
// 現画面
$url = 'userRegist.php';
// ユーザー一覧画面
$userListUrl = 'userList.php';
// ユーザー登録確認画面
$confirmUrl = 'userConfirm.php';

// 現画面,
// タレント一覧画面,
// ユーザー登録確認画面から遷移
if(strstr($referer, $url) || strstr($referer, $userListUrl) || strstr($referer, $confirmUrl)){

  // 現画面から遷移（確認押下）
  if(strstr($referer, $url)){

    // サニタイジング
    $_POST['userId'] = htmlspecialchars($_POST['userId'] ,ENT_QUOTES);
    $_POST['userName'] = htmlspecialchars($_POST['userName'] ,ENT_QUOTES);
    $_POST['password'] = htmlspecialchars($_POST['password'] ,ENT_QUOTES);
    $_POST['question'] = htmlspecialchars($_POST['question'] ,ENT_QUOTES);

    // POST送信された値を置き換え
    $user = $_POST['user'];
    $userId = $_POST['userId'];
    $userName = $_POST['userName'];
    $password = $_POST['password'];
    $questionId = $_POST['questionId'];
    $question = $_POST['question'];

    // ユーザーID空白チェック
    if(mb_ereg_match("^(\s|　)+$", $userId )){
      $userId  = '';
    }

    // ユーザーID未入力チェック
    if(empty($userId )){
      $errorMsg['userId'] = '※ユーザーIDは必須入力です。';
    }

    // ユーザーID20文字以内チェック
    if(20 < mb_strlen($userId , 'UTF-8')){
      $errorMsg['userId'] = '※ユーザーIDは20文字以内でご入力ください。';
    }

    // 氏名空白チェック
    if(mb_ereg_match("^(\s|　)+$", $userName)){
      $userName = '';
    }

    // 氏名未入力チェック
    if(empty($userName)){
      $errorMsg['userName'] = '※氏名は必須入力です。';
    }

    // 氏名20文字以内チェック
    if(20 < mb_strlen($userName, 'UTF-8')){
      $errorMsg['userName'] = '※氏名は20文字以内でご入力ください。';
    }

    // パスワード空白チェック
    if(mb_ereg_match("^(\s|　)+$", $password)){
      $password = '';
    }

    // パスワード未入力チェック
    if(empty($password)){
      $errorMsg['password'] = '※パスワードは必須入力です。';
    }

    // パスワード英数字チェック
    if(!preg_match("/^[a-zA-Z0-9]+$/", $password)){
      $errorMsg['password'] = '※パスワードは英数字でご入力ください。';
    }

    // パスワード16文字以内チェック
    if(16 < mb_strlen($password, 'UTF-8')){
      $errorMsg['password'] = '※パスワードは16文字以内でご入力ください。';
    }

    // 秘密の質問空白チェック
    if(mb_ereg_match("^(\s|　)+$", $question)){
      $question = '';
    }

    // 秘密の質問未入力チェック
    if(empty($question)){
      $errorMsg['question'] = '※秘密の質問は必須入力です。';
    }

    // 秘密の質問20文字以内チェック
    if(20 < mb_strlen($question, 'UTF-8')){
      $errorMsg['question'] = '※秘密の質問は20文字以内でご入力ください。';
    }

    // エラーメッセージなし
    if(empty($errorMsg)){

      // 登録するユーザー情報保持
      // [user, userId, userName, password, questionId, question]
      $_SESSION['userRegist'] = $_POST;

      // ユーザー登録確認画面へ遷移
      header('Location: userConfirm.php');
      exit;
    }

  // ユーザー登録確認画面から戻る押下
  } else if (!empty($_SESSION['userRegist'])){

    // 登録するユーザー情報をPOSTに代入
    // [user, userId, userName, password, questionId, question]
    $_POST = $_SESSION['userRegist'];
  }

// 現画面,
// タレント一覧画面,
// ユーザー登録確認画面以外から遷移
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
        <a id="talentListBtn" href="userList.php">ユーザー一覧</a>
      </div>
    </div>

    <h1 class="pageTitle" data-en="UserRegist"><span>ユーザー登録</span></h1>

    <main>

      <!-- ユーザー登録フォーム -->
      <form action="userRegist.php" method="post">

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
                <input id="userId" class="textInput playTextboxUserId" type="text" name="userId" value="<?php echo !empty($_POST['userId']) ? htmlspecialchars_decode($_POST['userId'],ENT_NOQUOTES) : ''; ?>">
                <label class="playLabelUserId" for="userId">ユーザーID</label>
                <span class="errorMsg">
                  <?php echo !empty($errorMsg['userId']) ? $errorMsg['userId'] : ''; ?>
                </span>
              </div>

              <!-- 氏名 -->
              <div class="playTextboxWrap">
                <input id="userName" class="textInput playTextboxUserName" type="text" name="userName" value="<?php echo !empty($_POST['userName']) ? htmlspecialchars_decode($_POST['userName'], ENT_NOQUOTES) : ''; ?>">
                <label class="playLabelUserName" for="userName">氏名</label>
                <span class="errorMsg">
                  <?php echo !empty($errorMsg['userName']) ? $errorMsg['userName'] : '';?>
                </span>
              </div>
            
              <!-- パスワード -->
              <div class="playTextboxWrap">
                <input id="password" class="textInput playTextboxPassword" type="text" name="password" value="<?php echo !empty($_POST['password']) ? htmlspecialchars_decode($_POST['password'],ENT_NOQUOTES) : ''; ?>">
                <label class="playLabelPassword" for="password">パスワード</label>
                <span class="errorMsg">
                  <?php echo !empty($errorMsg['password']) ? $errorMsg['password'] : '';?>
                </span>
              </div>

              <!-- 秘密の質問 -->
              <div id="questionContent">
                <select id="questionId"  name="questionId">
                  <option value="1" selected>母親の旧姓は？</option>
                  <option value="2">ペットの名前は？</option>
                  <option value="3">中学三年生の担任は？</option>
                </select>
              </div>
              
              <!-- 秘密の質問回答 -->
              <div class="playTextboxWrap">
                <input id="question" class="textInput playTextboxQuestion" type="text" name="question" value="<?php echo !empty($_POST['question']) ? htmlspecialchars_decode($_POST['question'],ENT_NOQUOTES) : ''; ?>">
                <label class="playLabelQuestion" for="question">秘密の質問</label>
                <span class="errorMsg">
                  <?php echo !empty($errorMsg['question']) ? $errorMsg['question'] : '';?>
                </span>
              </div>

        <input class="btn" type="submit" value="確認">
      </form>

    </main>
    <!-- JSファイル読み込み -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/js/main.js"></script>
  </body>
</html>
