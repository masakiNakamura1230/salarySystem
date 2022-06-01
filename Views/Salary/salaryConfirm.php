<?php
// 給与登録確認画面

// コントローラー読み込み
require_once(ROOT_PATH .'/Controllers/UserController.php');
require_once(ROOT_PATH .'Controllers/SalaryController.php');
$userCon = new UserController();
$salaryCon = new SalaryController();

session_start();

// 遷移前URL
$referer = $_SERVER['HTTP_REFERER'];
// 現画面
$url = 'salaryConfirm.php';
// 給与登録画面
$salaryRegistUrl = 'salaryRegist.php';

// 現画面,
// 給与登録画面から遷移
if(strstr($referer, $url) || strstr($referer, $salaryRegistUrl)){

  // 給与登録画面から遷移
  if(strstr($referer, $salaryRegistUrl)){

    // 登録する給与情報をPOSTに代入
    // [talentId, managerId, work, workingDateYear, workingDateMonth, workingDateDay, salary]
    $_POST = $_SESSION['salaryRegist'];
  }

  // POST送信された値を置き換え
  $talentId = $_POST['talentId'];
  $managerId = $_POST['managerId'];
  $work = $_POST['work'];
  $workingDateYear = $_POST['workingDateYear'];
  $workingDateMonth = $_POST['workingDateMonth'];
  $workingDateDay = $_POST['workingDateDay'];
  $salary = $_POST['salary'];

  try {

    // 該当のIDのタレント情報取得
    // [name]
    $talent = $userCon->selectMatchTalents($talentId);

    // 該当のIDの担当者情報取得
    // [name]
    $manager = $userCon->selectMatchManagers($managerId);

  } catch(PDOException $e){
    echo $e->getMessage()." - ". $e->getLine();
    header('Location: error.php');
    exit;
  } 

  // 給与登録するタレント名
  $talentName = $talent['matchUser']['name'];

  // 給与登録する担当者名
  $managerName = $manager['matchUser']['name'];

  // 現画面から遷移
  if(strstr($referer, $url)){

    // 稼働日の月と日が1桁の場合前に0を置く 
    $workingDateMonth = str_pad($workingDateMonth, 2, '0', STR_PAD_LEFT);
    $workingDateDay = str_pad($workingDateDay, 2, '0', STR_PAD_LEFT);

    // 稼働日の年月日連結
    $workingDate = $workingDateYear. $workingDateMonth. $workingDateDay;

    try{

      // 給与情報登録
      $salaryCon->registSalary($talentId, $managerId, $work, $workingDate, $salary);

      // 給与登録完了画面に遷移
      header('Location: salaryComplete.php');
      exit;

    }catch(PDOException $e){

      // エラーメッセージ表示
      echo $e->getMessage()." - ". $e->getLine();
      header('Location: error.php');
      exit;
    }
  }

// 現画面,
// 給与登録画面以外から遷移
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
        <a id="userRegist" href="salaryList.php">一覧画面</a>
      </div>
    </div>

    <h1 class="pageTitle" data-en="SalaryRegist"><span>給与登録</span></h1>

    <main>

      <!-- 給与登録確認フォーム -->
      <form action="salaryConfirm.php" method="post">
        <table id="confirmTable">
        <tr>
            <td class="tableContent">氏名</td>
            <td class="tableInput">
              <?php echo $talentName ?>
            </td>
          </tr>
          <tr>
            <td class="tableContent">担当者</td>
            <td class="tableInput">
            <?php echo $managerName ?>
            </td>
          </tr>
          <tr>
            <td class="tableContent">仕事内容</td>
            <td class="tableInput">
            <?php echo $work ?>
            </td>
          </tr>
          <tr>
            <td class="tableContent">稼働日</td>
            <td class="tableInput">
            <?php echo $workingDateYear ?>年
            <?php echo $workingDateMonth ?>月
            <?php echo $workingDateDay ?>日
            </td>
          </tr>
          <tr>
            <td class="tableContent">給与</td>
            <td class="tableInput">
            <?php echo $salary ?>
            </td>
          </tr>
        </table>

        <input type="hidden" name="talentId" value="<?php echo $talentId ?>">
        <input type="hidden" name="managerId" value="<?php echo $managerId ?>">
        <input type="hidden" name="work" value="<?php echo htmlspecialchars($work) ?>">
        <input type="hidden" name="workingDateYear" value="<?php echo $workingDateYear ?>">
        <input type="hidden" name="workingDateMonth" value="<?php echo $workingDateMonth ?>">
        <input type="hidden" name="workingDateDay" value="<?php echo $workingDateDay ?>">
        <input type="hidden" name="salary" value="<?php echo $salary ?>">

        <input class="btn" type="submit" value="登録">
        <a href="salaryRegist.php" id="backBtn">戻る</a>
      </form>
    </main>
  </body>
</html>
