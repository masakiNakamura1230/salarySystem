<?php
// ログイン画面

// コントローラー読み込み
require_once(ROOT_PATH .'Controllers/UserController.php');
$userCon = new UserController();

session_start();

// ログイン画面に戻った場合全データ保持解除
$_SESSION = array();

// 遷移前URL(なければnull）
$referer = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER'] : null;;
// 現画面
$url = "login.php"; 

// 現画面から遷移（ログイン押下）
if(strstr($referer,$url)){

  // サニタイジング
  $_POST['userId']  = htmlspecialchars($_POST['userId'] ,ENT_QUOTES);
  $_POST['password'] = htmlspecialchars($_POST['password'],ENT_QUOTES);

  // POST送信された値を置き換え
  $user = $_POST['user'];
  $userId = $_POST['userId'];
  $password = $_POST['password'];

  // ユーザーID空白チェック
  if(mb_ereg_match("^(\s|　)+$", $userId)){
    $userId  = '';
  }

  // ユーザーID未入力チェック
  if(empty($userId)){
    $errorMsg['userId'] = '※ユーザーIDは必須入力です。';
  }

  // パスワード空白チェック
  if(mb_ereg_match("^(\s|　)+$", $password)){
    $password = '';
  }

  // パスワード未入力チェック
  if(empty($password)){
    $password = '※パスワードは必須入力です。';
  }

  // エラーメッセージなし
  if(empty($errorMsg)){

    // ログインしたのが管理者・担当者
    if(($user == 0 || $user == 1)){

      // 担当者テーブルより入力したユーザーIDとパスワードが一致するユーザー検索
      try{

        // [id,user]
        $params = $userCon->findLoginManager($userId, $password);
      } catch (Exception $e){
        echo $e->getMessage()." - ". $e->getLine();
        header('Location: error.php');
        exit;
      }
      
      // 一致するユーザーなし
      if($params == null){
        $errorMsg['noMatch'] = '※一致するユーザーがいません';

      // 一致するユーザーあり
      } else {

        // ログインしている管理者・担当者情報保持
        // [id,user]
        $_SESSION['loginUser'] = $params['userInfo'];

        // タレント一覧へ遷移
        header('Location: talentList.php');
        exit;
      }

    // ログインしたのがタレント
    }else if($user == 2){

      // タレントテーブルより入力したユーザーIDとパスワードが一致するユーザー検索
      try {

        // [id]
        $params = $userCon->findLoginTalent($userId, $password);
      } catch (Exception $e){
        echo $e->getMessage()." - ". $e->getLine();
        header('Location: error.php');
        exit;
      }
      
      // 一致するユーザーなし
      if($params == null){
        $errorMsg['noMatch'] = '※一致するユーザーがいません';

      // 一致するユーザーあり
      } else {

        // ログインしているタレント情報保持
        // [id]
        $_SESSION['loginUser'] = $params['userInfo'];

        // 一覧画面へ遷移
        header('Location: salaryList.php');
        exit;
      }
    }
  }
}
?>

<!------------------ HTML -------------------->
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>給与管理システム</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link href="https://fonts.googleapis.com/earlyaccess/kokoro.css" rel="stylesheet">
  </head>
  <body>

  <!-- ヘッダー -->
    <header>
      <h1 class="pageTitle" data-en="Salary"><span>給与管理システム</span></h1>
    </header>
    
    <!-- ログインフォーム -->
    <main>
      <form action="login.php" method="post">

        <!-- ユーザー選択 -->
        <div id="userSelect">
          <input id="admin" class="userSelectRadio admin" type="radio" name="user" value="0" checked><label class="admin" for="admin">管理者</label>
          <input id="manager" class="userSelectRadio manager" type="radio" name="user" value="1"><label class="manager" for="manager">担当者</label>
          <input id="talent" class="userSelectRadio talent" type="radio" name="user" value="2"><label class="talent" for="talent">タレント</label>
        </div>
        
        <!-- ユーザーID入力 -->
        <div class="playTextboxWrap">
          <input id="userId" class="textInput playTextboxUserId" type="text" name="userId">
          <label class="playLabelUserId" for="userId">ユーザーID</label>
          <span class="errorMsg">
          <?php echo !empty($errorMsg['userId']) ? $errorMsg['userId'] : ''; ?>
          </span>
        </div>
        
        <!-- パスワード入力 -->
        <div class="playTextboxWrap">
          <input id="password" class="textInput playTextboxPassword" type="password" name="password">
          <label class="playLabelPassword" for="password">パスワード</label>
          <span class="errorMsg">
                <?php echo !empty($errorMsg['password']) ? $errorMsg['password'] : ''; ?>
          </span>
        </div>

        <!-- 一致しない場合エラーメッセージ表示 -->
        <span class="errorMsg centerErrorMsg">
          <?php echo !empty($errorMsg['noMatch']) ? $errorMsg['noMatch'] : ''; ?>
        </span>

        <!-- ログインボタン -->
        <input id="loginBtn" class="btn" type="submit" value="ログイン">
      </form>
    </main>

    <!-- パスワード変更 -->
    <a href="passwordLogin.php" id="passwordLink">パスワードを忘れた方はこちら</a>

    <!-- JSファイル読み込み -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/js/main.js"></script>
  </body>
</html>
