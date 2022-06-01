<?php
// ユーザー登録確認画面

// コントローラー読み込み
require_once(ROOT_PATH .'/Controllers/UserController.php');
$userCon = new UserController();

session_start();

// 遷移前URL
$referer = $_SERVER['HTTP_REFERER'];
// 現画面
$url = 'userConfirm.php';
// ユーザー登録画面
$registUrl = 'userRegist.php';

// 現画面,
// ユーザー登録画面から遷移
if(strstr($referer, $url) || strstr($referer, $registUrl)){

  // ユーザー登録画面から遷移
  if(strstr($referer, $registUrl)){

    // 登録するユーザー情報をPOSTに代入
    // [user, userId, userName, password, questionId, question]
    $_POST = $_SESSION['userRegist'];
  }

  // POST送信された値を置き換え
  $user = $_POST['user'];
  $userId = $_POST['userId'];
  $userName = $_POST['userName'];
  $password = $_POST['password'];
  $questionId = $_POST['questionId'];
  $question = $_POST['question'];
  
  // 現画面から遷移
  if(strstr($referer, $url)){
    try{

      // ユーザー情報登録
      $userCon->registUser($user, $userId, $userName, $password, $questionId, $question);

      // ユーザー登録完了画面へ遷移
      header('Location: userComplete.php');
      exit;

    } catch(PDOException $e){
      echo $e->getMessage()." - ". $e->getLine();
      header('Location: error.php');
      exit;
    } 
  }

// 現画面,
// ユーザー登録画面以外から遷移
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

    <!-- ユーザー登録確認フォーム -->
      <form action="userConfirm.php" method="post">
        <table id="confirmTable">
        <tr>
            <td class="tableContent">ユーザー</td>
            <td class="tableInput">
              <?php if($user == 0) {echo '管理者';} else if($user == 1) {echo '担当者';}else {echo 'タレント';} ?>
            </td>
          </tr>
          <tr>
            <td class="tableContent">ユーザーID</td>
            <td class="tableInput">
            <?php echo $userId ?>
            </td>
          </tr>
          <tr>
            <td class="tableContent">氏名</td>
            <td class="tableInput">
            <?php echo $userName ?>
            </td>
          </tr>
          <tr>
            <td class="tableContent">パスワード</td>
            <td class="tableInput">
            <?php echo $password ?>
            </td>
          </tr>
          <tr>
            <td class="tableContent">秘密の質問</td>
            <td class="tableInput">
            <?php if($questionId == 1) {echo '母親の旧姓は？';} else if($questionId == 2) {echo 'ペットの名前は？';}else {echo '中学三年生の担任は？';} ?>
            </td>
          </tr>
          <tr>
            <td class="tableContent"></td>
            <td class="tableInput">
            <?php echo $question ?>
            </td>
          </tr>
        </table>

        <input type="hidden" name="user" value="<?php echo $_POST['user'] ?>">
        <input type="hidden" name="userId" value="<?php echo htmlspecialchars($_POST['userId']) ?>">
        <input type="hidden" name="userName" value="<?php echo htmlspecialchars($_POST['userName']) ?>">
        <input type="hidden" name="password" value="<?php echo htmlspecialchars($_POST['password']) ?>">
        <input type="hidden" name="questionId" value="<?php echo $_POST['questionId'] ?>">
        <input type="hidden" name="question" value="<?php echo htmlspecialchars($_POST['question']) ?>">

        <input class="btn" type="submit" value="登録">
        <a href="userRegist.php" id="backBtn">戻る</a>
      </form>
    </main>
  </body>
</html>
