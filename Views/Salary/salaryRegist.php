<?php
// 給与登録画面

// コントローラー読み込み
require_once(ROOT_PATH. 'Controllers/UserController.php');
$userCon = new UserController();

session_start();

// 遷移前URL
$referer = $_SERVER['HTTP_REFERER'];
// 現画面
$url = 'salaryRegist.php';
// 給与登録確認画面
$salaryConfirmUrl = 'salaryConfirm.php';
// 給与一覧画面
$salaryListUrl = 'salaryList.php';

// 現画面,
// 給与登録確認画面,
// 給与一覧画面から遷移
if(strstr($referer, $url) || strstr($referer, $salaryConfirmUrl) || strstr($referer, $salaryListUrl)){

  try {
    // タレント名取得
    $talents = $userCon->selectAllTalents();

    // 担当者名取得
    $managers = $userCon->selectAllManagers(); 
  } catch (Exception $e) {
    echo $e->getMessage()." - ". $e->getLine();
    header('Location: error.php');
    exit;
  }

  // 現画面から遷移(確認押下)
  if(strstr($referer, $url)){

    // サニタイジング
    $_POST['work'] = htmlspecialchars($_POST['work'],ENT_QUOTES);
    $_POST['salary'] = htmlspecialchars($_POST['salary'],ENT_QUOTES);

    // POST送信された値を置き換え
    $talentId = $_POST['talentId'];
    $managerId = $_POST['managerId'];
    $work = $_POST['work'];
    $workingDateYear = $_POST['workingDateYear'];
    $workingDateMonth = $_POST['workingDateMonth'];
    $workingDateDay = $_POST['workingDateDay'];
    $salary = $_POST['salary'];

    // 仕事内容空白チェック
    if(mb_ereg_match("^(\s|　)+$", $work)){
      $work = '';
    }

    // 仕事内容未入力チェック
    if(empty($work)){
      $errorMsg['work'] = '※仕事内容は必須入力です。';
    }

    // 仕事内容30文字以内チェック
    if(30 < mb_strlen($work, 'UTF-8')){
      $errorMsg['work'] = '※仕事内容は30文字以内でご入力ください。';
    }

    // 給与空白チェック
    if(mb_ereg_match("^(\s|　)+$", $salary)){
      $salary = '';
    }

    // 給与未入力チェック
    if(empty($salary)){
      $errorMsg['salary'] = '※給与は必須入力です。';
    }

    // 給与数字チェック
    if((!empty($salary)) && !is_numeric($salary)){
      $errorMsg['salary'] = '※給与は数字のみでご入力ください。';
    }

    // 給与8文字以内チェック
    if(8 < mb_strlen($salary, 'UTF-8')){
      $errorMsg['salary'] = '※給与は8文字以内でご入力ください。';
    }

    // エラーメッセージなし
    if(empty($errorMsg)){

      // 登録する給与情報保持
      // [talentId, managerId, work, workingDateYear, workingDateMonth, workingDateDay, salary]
      $_SESSION['salaryRegist'] = $_POST;

      // 給与登録確認画面へ遷移
      header('Location: salaryConfirm.php');
      exit;
    }
  
  // 給与登録確認画面から戻る押下
  } else if (!empty($_SESSION['salaryRegist'])){

    // 登録する給与情報をPOSTに代入
    // [talentId, managerId, work, workingDateYear, workingDateMonth, workingDateDay, salary]
    $_POST = $_SESSION['salaryRegist'];
  }

// 現画面,
// 給与登録確認画面,
// 給与一覧画面以外から遷移
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
        <a id="salaryListBack" href="salaryList.php">一覧画面</a>
      </div>
    </div>

    <h1 class="pageTitle" data-en="SalaryRegist"><span>給与登録</span></h1>

    <main>

      <!-- 給与登録フォーム -->
      <form action="salaryRegist.php" method="post">

        <!-- 氏名 -->
        <div class="playTextboxWrap">
          <label class="playLabelSelectTalentId" for="userId">氏名</label>
          <select class="textInput" name="talentId">
            <?php foreach($talents['talents'] as $talent): ?>
              <?php if($talent['id'] == $_POST['registUser']){ ?>
                <option value="<?php echo $talent['id'] ?>" selected>
                  <?php echo $talent['name'] ?>
                </option>
              <?php } else if ($talent['id'] == $_POST['talentId']) { ?>
                <option value="<?php echo $talent['id'] ?>" selected>
                  <?php echo $talent['name'] ?>
                </option>
              <?php } ?>
              <option value="<?php echo $talent['id'] ?>" ><?php echo $talent['name'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- 担当者 -->
        <div class="playTextboxWrap">
          <label class="playLabelSelectManagerId" for="userId">担当者</label>
          <select class="textInput" name="managerId">
            <?php foreach($managers['managers'] as $manager): ?>
              <?php if($manager['id'] == $_POST['managerUser']){ ?>
                <option value="<?php echo $manager['id'] ?>" selected><?php echo $manager['name'] ?></option>
              <?php } else if ($manager['id'] == $_POST['managerId']) { ?>
                <option value="<?php echo $manager['id'] ?>" selected><?php echo $manager['name'] ?></option>
              <?php } ?>
              <option value="<?php echo $manager['id'] ?>" ><?php echo $manager['name'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- 仕事内容 -->
        <div class="playTextboxWrap">
          <input id="work" class="textInput playTextboxWork" type="text" name="work" value="<?php echo !empty($_POST['work']) ? htmlspecialchars_decode($_POST['work'],ENT_NOQUOTES) : ''; ?>">
          <label class="playLabelWork" for="work">仕事内容</label>            
          <span class="errorMsg">
            <?php echo !empty($errorMsg['work']) ? $errorMsg['work'] : ''; ?>
          </span>
        </div>

        <!-- 稼働日 -->
        <div class="playTextboxWrap">
          <div id="selectItem">
            <select class="textInput" name="workingDateYear">
              <option value="<?php echo date('Y') ?>" selected>
                <?php echo date('Y') ?>
              </option>
            </select>年
            <select class="textInput" name="workingDateMonth">
              <?php for($i = 1; $i <= 12; $i++){ ?>
                <?php if(date('n') == $i) { ?>
                  <option value="<?php echo $i ?>" selected>
                    <?php echo $i ?>
                  </option>
                <?php } ?>
                <option value="<?php echo $i ?>">
                  <?php echo $i ?>
                </option>
              <?php } ?>
            </select>月
            <select class="textInput" name="workingDateDay">
              <?php for($i = 1; $i <= 31; $i++){ ?>
                <?php if(date('j') == $i) { ?>
                  <option value="<?php echo $i ?>" selected>
                    <?php echo $i ?>
                  </option>
                <?php } ?>
                <option value="<?php echo $i ?>">
                  <?php echo $i ?>
                </option>
              <?php } ?>
            </select>日
          </div>
        </div>

        <!-- 給与 -->
        <div class="playTextboxWrap">
          <input id="salary" class="textInput playTextboxSalary" type="text" name="salary" value="<?php echo !empty($_POST['salary']) ? htmlspecialchars_decode($_POST['salary'],ENT_NOQUOTES) : ''; ?>">
          <label class="playLabelSalary" for="salary">給与</label>            
          <span class="errorMsg">
            <?php echo !empty($errorMsg['salary']) ? $errorMsg['salary'] : '';?>
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
