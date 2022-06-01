<?php

// 遷移前URL
$referer = $_SERVER['HTTP_REFERER'];
// 給与登録確認画面
$registUrl = 'salaryConfirm.php';
// 給与変更確認画面　
$changeUrl = 'salaryChangeConfirm.php';

// 給与登録確認画面,
// 給与変更確認画面から遷移
if(strstr($referer, $registUrl) || strstr($referer, $changeUrl)){

  // 給与登録確認画面から遷移
  if(strstr($referer, $registUrl)){
    $title = '登録';
  }

  // 給与変更確認画面から遷移
  if(strstr($referer, $changeUrl)){
    $title = '変更';
  }

// 給与登録確認画面,
// 給与変更確認画面以外から遷移
}else {
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

    <h1 class="pageTitle" data-en="Salary<?php if($title == '登録'){echo 'Regist';} else {echo 'Change';} ?>"><span>給与<?php echo $title; ?></span></h1>

    <main>
      <p id="completeMessage">給与<?php echo $title; ?>が完了しました</p>

      <a href="salaryList.php" id="passwordLink">給与一覧へ戻る</a>
    </main>
  </body>
</html>
