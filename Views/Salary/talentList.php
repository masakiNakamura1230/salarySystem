<?php
// タレント一覧

// コントローラー読み込み
require_once(ROOT_PATH. 'Controllers/UserController.php');
$userCon = new UserController();

session_start();

// 遷移前URL
$referer = $_SERVER['HTTP_REFERER'];
// ログイン画面
$loginUrl = 'login.php';
// ユーザー一覧画面
$userListUrl = 'userList.php';
// 給与一覧画面
$salaryListUrl = 'salaryList.php';


// ログイン画面,
// ユーザー登録画面,
// ユーザー登録確認画面,
// ユーザー登録完了画面,
// ユーザー削除画面,
// 給与一覧画面から遷移
if(strstr($referer, $loginUrl) || strstr($referer, $salaryListUrl) || strstr($referer, $userListUrl)){

// ログインしているユーザー情報
// [id,user]
$userInfo = $_SESSION['loginUser'];

// タレント一覧取得
try {

  // [id,name]
  $talents = $userCon->selectAllTalents();
} catch (Exception $e){
  echo $e->getMessage()." - ". $e->getLine();
  header('Location: error.php');
  exit;
}

// ログイン画面,
// ユーザー登録画面,
// ユーザー登録確認画面,
// ユーザー登録完了画面,
// ユーザー削除画面,
// 給与一覧画面以外から遷移
} else {

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

        <!-- 管理者ログインの場合表示 -->
        <?php if($userInfo['user'] == 0) {?>
          <a id="userList" href="userList.php" >ユーザー一覧</a>
        <?php }?>
      </div>
    </div>

    <h1 class="pageTitle" data-en="TalentList"><span>タレント一覧</span></h1>

    <main>
        <table id="talentTable">
          <?php foreach($talents['talents'] as $talent): ?>
              <tr>
                <td class="tableInput">
                  <form class="talentListName" action="salaryList.php" method="post">
                    <input type="hidden" name="talentId" value="<?php echo $talent['id'] ?>">
                    <input class="talentName" type="submit" value="<?php echo $talent['name'] ?>">
                  </form>
                </td>
              </tr>
          <?php endforeach; ?>
        </table>
    </main>

  </body>
</html>
