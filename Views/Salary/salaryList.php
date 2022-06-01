<?php
// 給与一覧画面

// コントローラー読み込み
require_once(ROOT_PATH. 'Controllers/SalaryController.php');
require_once(ROOT_PATH. 'Controllers/UserController.php');
require_once(ROOT_PATH. 'Controllers/MessageController.php');
$salaryCon = new SalaryController();
$userCon = new UserController();
$messageCon = new MessageController();

session_start();

// 現画面に戻った場合
// 給与登録、給与変更データ保持解除
$_SESSION['salaryRegist'] = null;
$_SESSION['salaryChange'] = null;

// 遷移前URL
$referer = $_SERVER['HTTP_REFERER'];
// 現画面
$url = 'salaryList.php';
// ログイン画面
$loginUrl = 'login.php';
// タレント一覧画面
$talentListUrl = 'talentList.php';
// 給与登録画面
$salaryRegistUrl = 'salaryRegist.php';
// 給与登録確認画面
$salaryConfirmUrl = 'salaryConfirm.php';
// 給与登録完了画面
$salaryCompleteUrl = 'salaryComplete.php';
// 給与変更画面
$salaryChangeUrl = 'salaryChange.php';
// 給与変更確認画面
$salaryChangeConfirmUrl = 'salaryChangeConfirm.php';
// 給与削除画面
$salaryDeleteUrl = 'salaryDelete.php';

if(strstr($referer, $url) || strstr($referer, $loginUrl) || strstr($referer, $talentListUrl) || strstr($referer, $salaryRegistUrl) || strstr($referer, $salaryConfirmUrl) || strstr($referer, $salaryCompleteUrl) || strstr($referer, $salaryChangeUrl) || strstr($referer, $salaryChangeConfirmUrl) || strstr($referer, $salaryDeleteUrl)){

  // ログインしているユーザー情報
  // 管理者・担当者の場合 [id,user]
  // タレントの場合 [id]
  $loginUserInfo = $_SESSION['loginUser'];

  // タレント一覧画面から遷移(管理者・担当者)
  if(strstr($referer, $talentListUrl)){

    // タレント一覧画面で選んだタレントのID
    $_SESSION['talentId'] = $_POST['talentId'];

    // ログインしている担当者のID
    $_SESSION['managerId'] = $loginUserInfo['id'];

    // メッセージ投稿のユーザー名表示分岐
    $_SESSION['messageUser'] = 0;
  }

  // ログイン画面から遷移(タレント)
  if(strstr($referer, $loginUrl)){

    // ログインしているタレントのID
    $_SESSION['talentId'] = $loginUserInfo['id'];

    // 担当者のID
    $_SESSION['managerId'] = null;

    // メッセージ投稿のユーザー名表示分岐
    $_SESSION['messageUser'] = 1;
  }

  // 保持したタレントのID
  $listId = $_SESSION['talentId'];

  // 保持した担当者のID
  $manager = $_SESSION['managerId'];

  // 保持したメッセージ投稿のユーザー名表示分岐
  $messageUser = $_SESSION['messageUser'];

  // 現画面から遷移
  if(strstr($referer, $url)){

    // 月が選択されて検索押下時、選択月情報保持
    if(!empty($_POST['selectMonth'])){
      $_SESSION['selectMonth'] = $_POST['selectMonth'];
      $_SESSION['selectManager'] = 9999;
    }
    // 担当者が選択されて絞込押下時、選択担当者情報保持
    // 
    if(!empty($_POST['selectManager'])){
      $_SESSION['selectManager'] = $_POST['selectManager'];
    }

  // 現画面以外から遷移
  } else {
    // 現在月保持
    $_SESSION['selectMonth'] = date('n');

    // 担当者全て表示
    $_SESSION['selectManager'] = 9999;
  }

  // 月・担当者保持
  $selectMonth = $_SESSION['selectMonth'];
  $selectManager = $_SESSION['selectManager'];

  try{

    // 担当者の絞込選択のため担当者一覧取得
    // [id, name]
    $selectManagers = $userCon->selectAllManagers();

    // 給与テーブルから給与情報取得
    // 全給与情報取得
    if($selectManager == 9999){

      // [id, talent_id, manager_id, talentName, managerName, work, working_date, regist_date, salary]
      $params = $salaryCon->selectSalary($listId, $selectMonth);

      // 選択された担当者で絞り込んだ給与情報取得
    } else {
      $params = $salaryCon->selectSalaryManager($listId, $selectMonth, $selectManager);
    }

    // メッセージ投稿のユーザー名表示
    // 管理者・担当者
    if($messageUser == 0){

      // [name]
      $messageUserInfo = $userCon->selectMatchManagers($manager);

    // タレント
    } else {

      // [name]
      $messageUserInfo = $userCon->selectMatchTalents($listId);
    }
    
  } catch (Exception $e){
    echo $e->getMessage()." - ". $e->getLine();
  }

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    
  </head>
  <body>

    <div id="logOutWrap">
      <div id="logOutBox">
        <a id="logOut" href="login.php">ログアウト</a>
        <?php if(!empty($manager)) {?>
          <a id="talentListBtn" href="talentList.php">タレント一覧</a>
        <?php }?>
      </div>
    </div>

    <h1 class="pageTitle" data-en="SalaryList"><span>給与一覧画面</span></h1>

    <main>
      <div id="listHead">
        <div class="listHeadItem">
          <?php if(!empty($manager)) { ?>
            <form action='salaryRegist.php' method='post'>
              <input type="hidden" name="registUser" value="<?php echo $listId; ?>">
              <input type="hidden" name="managerUser" value="<?php echo $manager; ?>">
              <input class="aaa bbb" type="submit" value="登録">
            </form>
          <?php } ?>
        </div>
        <p class="listHeadItem listHeadItemMonth">
          <?php echo !empty($selectMonth) ? $selectMonth : date('n')?>月
        </p>
        <div id="managerSelect" class="listHeadItem">
          <form action="salaryList.php" method="post" class="listHeadForm">
            <span>担当者</span>
            <select name="selectManager">
              <?php if($selectManager == 0){ ?>
                <option value="9999" selected>全て</option> 
              <?php } else { ?>
                <option value="9999">全て</option> 
                <?php } ?>
              <?php foreach($selectManagers['managers'] as $selectMana): ?>
                <?php if($selectManager == $selectMana['id']){ ?>
                  <option value="<?php echo $selectMana['id'] ?>" selected><?php echo $selectMana['name'] ?></option>
                <?php } else { ?>
                <option value="<?php echo $selectMana['id'] ?>"><?php echo $selectMana['name'] ?></option>
                <?php } ?>
              <?php endforeach; ?>
            </select>
            <input type="submit" value="絞込">
          </form>
          <form action="salaryList.php" method="post" class="listHeadForm">
            <select name="selectMonth">
              <!-- 現在月 -->
              <option selected><?php echo !empty($selectMonth) ? $selectMonth : date('n') ?>月</option>
                <!-- 1〜12月 -->
              <?php for($i = 1; $i <= 12; $i++){ ?>
              <option value="<?php echo $i ?>">
                <?php echo $i .'月'; ?></option>
              <?php } ?>
            </select>
            <input type="submit" value="検索">
          </form>
        </div>
      </div>

      <table id="listTable" class="salaryTableDesign salaryTableDesignDetail">
        <thead>
          <tr>
            <th class="centerItem">氏名</th>
            <th class="centerItem">担当者</th>
            <th class="centerItem">仕事内容</th>
            <th class="centerItem">稼働日</th>
            <th class="centerItem">登録日</th>
            <th class="centerItem">給与</th>
            <?php if(!empty($params['selectSalary'])){ ?>
            <?php if(!empty($manager)){ ?>
            <th colspan="2">

            </th>
            <?php } ?>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
          <?php $salarySum = 0; ?>
          <?php foreach($params['selectSalary'] as $param): ?>
          <tr>
            <td class="centerItem listTableData"><?php echo $param['talentName'] ?></td>
            <td class="centerItem listTableData"><?php echo $param['managerName'] ?></td>
            <td class="centerItem listTableData workData"><?php echo $param['work'] ?></td>
            <td class="centerItem listTableData"><?php echo date('Y年n月j日', strtotime($param['working_date'])) ?></td>
            <td class="centerItem listTableData"><?php echo date('Y年n月j日', strtotime($param['regist_date'])) ?></td>
            <td class="rightItem listTableData"><?php echo $param['salary'] ?></td>
            
            <?php if(!empty($manager)){ ?>
            <td class="salaryChange">
              <form action="salaryChange.php" method="post" class="centerItem">
                <input type="hidden" name="id" value="<?php echo $param['id'] ?>">
                <input type="hidden" name="talentId" value = "<?php echo $param['talent_id'] ?>">
                <input type="hidden" name="managerId" value = "<?php echo $param['manager_id'] ?>">
                <input type="hidden" name="work" value = "<?php echo $param['work'] ?>">
                <input type="hidden" name="workingDateYear" value = "<?php echo date('Y', strtotime($param['working_date'])) ?>">
                <input type="hidden" name="workingDateMonth" value = "<?php echo date('n', strtotime($param['working_date'])) ?>">
                <input type="hidden" name="workingDateDay" value = "<?php echo date('j', strtotime($param['working_date'])) ?>">
                <input type="hidden" name="salary" value = "<?php echo $param['salary'] ?>">
                <input class="centerItem" type="submit" value="変更">
              </form>
            </td>
            <td class="salaryDelete">
              <form action="salaryDelete.php" method="post" class="centerItem">
                <input type="hidden" name="id" value="<?php echo $param['id'] ?>">
                <input class="centerItem" type="submit" value="削除" onclick='return confirm("削除してよろしいですか？");' >
              </form>
            </td>
            <?php } ?>
          </tr>
          <?php $salarySum += $param['salary']; ?>
          <?php endforeach; ?>
          <tr class="salaryTableSum">
            <td colspan="5" class="centerItem listTableData salaryTableSumItem">合計</td>
            <td class="rightItem listTableData salaryTableSumItem">
              <?php echo $salarySum ?>
            </td>
            <?php if(!empty($params['selectSalary'])){ ?>
            <?php if(!empty($manager)){ ?>
            <td colspan="2">

            </td>
            <?php } ?>
            <?php } ?>
          </tr>
        </tbody>
      </table>
      

      <!-- メッセージ -->
      <div id="messageWrap">

        <!-- メッセージ表示 -->
        <div id="messageMainWrap">
          <div id="messageMain">
            <diV class="heading3Box">
              <h3>メッセージ</h3>
            </diV>
            
            <!-- Ajax -->
            <input type="hidden" id="messageShowTalentId" value="<?php echo $listId ?>">
            <input type="hidden" id="messageShowSelectMonth" value="<?php echo $selectMonth ?>">
            <input type="hidden" id="messageShowUserName" value="<?php echo $messageUserInfo['matchUser']['name'] ?>">
            <div id="messageDisplay">
            </div>
          </div>
        </div>

        <!-- メッセージ投稿 -->
        <div id="messagePostWrap">
        <div id="messagePost">
          <div class="heading3Box">
            <h3>メッセージ投稿</h3>
          </div>
          
            <table id="messageRegistTable">
              <tr>
                <td>氏名</td>
                <td>
                  <?php echo $messageUserInfo['matchUser']['name'] ?>
                  <input type="hidden" id="messageUserName"  name="messageUserName" value="<?php echo $messageUserInfo['matchUser']['name'] ?>">
                </td>
              </tr>
              <tr>
                <td>内容</td>
                <td>
                  <textarea id="messageBody" name="messageBody" ></textarea>
                </td>
              </tr>
            </table>
            <input type="hidden" id="messageTalentId" name="messageTalentId" value="<?php echo $listId ?>">
            <input type="submit" id="messageSend" value="投稿">
        </div>
        </div>
      </div>
    </main>
    
    <script src="/js/ajax.js"></script>
  </body>
</html>
