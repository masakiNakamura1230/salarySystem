<?php
// ユーザー削除画面

// コントローラー読み込み
require_once(ROOT_PATH. 'Controllers/UserController.php');
$userCon = new UserController();

session_start();

// タレント一覧に戻った場合ユーザー登録データ保持解除
$_SESSION['userRegist'] = null;


// 遷移前URL
$referer = $_SERVER['HTTP_REFERER'];
// 現画面
$url = 'userList.php';
// タレント一覧画面
$talentListUrl = 'talentList.php';
// ユーザー登録画面
$userRegistUrl = 'userRegist.php';
// ユーザー登録確認画面
$userConfirmUrl = 'userConfirm.php';
// ユーザー登録完了画面
$userCompleteUrl = 'userComplete.php';

// 現画面,
// タレント一覧画面,
// ユーザー登録画面,
// ユーザー登録確認画面,
// ユーザー登録完了画面から遷移
if(strstr($referer, $url) || strstr($referer, $talentListUrl) || strstr($referer, $userRegistUrl) || strstr($referer, $userConfirmUrl) || strstr($referer, $userCompleteUrl)){

  // 現画面より遷移
  if(strstr($referer, $url)){

    // 管理者・担当者の場合[1]
    // タレントの場合[2]
    $user = $_POST['user'];

    // 削除するユーザーのID
    $deleteId = $_POST['deleteId'];

    // 担当者テーブルからユーザー削除
    if($user == 1){
      try {
        $userCon->deleteManagers($deleteId);
      } catch (Exception $e){
        echo $e->getMessage()." - ". $e->getLine();
        header('Location: error.php');
        exit;
      }
    
      // タレントテーブルからユーザー削除
    } else {
      try {
        $userCon->deleteTalents($deleteId);
      } catch (Exception $e){
        echo $e->getMessage()." - ". $e->getLine();
        header('Location: error.php');
        exit;
      }
    }
  }

  // 担当者一覧取得
  try {

    // [id,name]
    $managers = $userCon->selectAllManagers();
  } catch (Exception $e){
    echo $e->getMessage()." - ". $e->getLine();
    header('Location: error.php');
    exit;
  }

  // タレント一覧取得
  try {

    // [id,name]
    $talents = $userCon->selectAllTalents();
  } catch (Exception $e){
    echo $e->getMessage()." - ". $e->getLine();
    header('Location: error.php');
    exit;
  }

// 現画面,
// タレント一覧画面以外から遷移
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
        <a id="talentListBtn" href="talentList.php">タレント一覧</a>
        <a id="userRegist" href="userRegist.php">ユーザー登録</a>
      </div>
    </div>

    <h1 class="pageTitle" data-en="UserList"><span>ユーザー一覧</span></h1>

    <main id="deleteMain">
      <div>
        <diV class="userListSubTitle">
          <h3>担当者一覧</h3>
        </diV>
        <!-- <h3><span>担当者一覧</span></h3> -->
        <table id="userManagerTable">
          <?php foreach($managers['managers'] as $manager): ?>
            <tr>
              <td class="tableInput userListItem">
                <?php echo $manager['name'] ?>
              </td>
              <td class="userDeleteBtn">
                <form class="userDeleteBtnItem" action="userList.php" method="post">
                  <input type="hidden" name="user" value="1">
                  <input type="hidden" name="deleteId" value="<?php echo $manager['id'] ?> ">
                  <input type="submit" value="削除" onclick="return confirm('削除してよろしいですか？');">
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>

      <div>
        <diV class="userListSubTitle">
          <h3>タレント一覧</h3>
        </diV>
        <!-- <h3><span>タレント一覧</span></h3> -->
        <table id="userTalentTable">
          <?php foreach($talents['talents'] as $talent): ?>
            <tr>
              <td class="tableInput userListItem">
                <?php echo $talent['name'] ?>
              </td>
              <td class="userDeleteBtn">
                <form class="userDeleteBtnItem" action="userList.php" method="post">
                  <input type="hidden" name="user" value="2">
                  <input type="hidden" name="deleteId" value="<?php echo $talent['id'] ?> " checked>
                  <input type="submit" value="削除" onclick="return confirm('削除してよろしいですか？');">
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </main>
  </body>
</html>
