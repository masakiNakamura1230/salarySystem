<?php
// エラー画面

// 遷移前URL
$referer = $_SERVER['HTTP_REFERER'];
// ログイン画面
$loginUrl = 'login.php';
// パスワード再設定ログイン画面
$passwordLoginUrl = 'passwordLogin.php';
// パスワード再設定登録画面
$passwordRegistUrl = 'passwordRegist.php';
// タレント一覧画面
$talentListUrl = 'talentList.php';
// ユーザー登録確認画面
$userConfirmUrl = 'userConfirm.php';
// ユーザー削除画面
$userDeleteUrl = 'userDelete.php';
// 給与一覧画面
$salaryListUrl = 'salaryList.php';
// 給与登録画面
$salaryRegistUrl = 'salaryRegist.php';
// 給与登録確認画面
$salaryConfirmUrl = 'salaryConfirm.php';
// 給与変更画面
$salaryChangeUrl = 'salaryChange.php';
// 給与変更確認画面
$salaryChangeConfirmUrl = 'salaryChangeConfirm.php';
// 給与削除画面
$salaryDeleteUrl = 'salaryDelete.php';

// 遷移先URL
$transitionUrl = 'login.php';
// 遷移先のタイトル
$transition = 'ログイン';

// ログイン画面から遷移
if(strstr($referer,$loginUrl)){
  $title = 'ログイン';
  $errorMsg = 'ログイン';
}

// パスワード再設定ログイン画面,
// パスワード再設定登録画面から遷移
if(strstr($referer, $passwordLoginUrl) || strstr($referer, $passwordRegistUrl)) {
  $title = 'パスワード再設定';
  $errorMsg = 'パスワードの再設定';
}

// タレント一覧画面から遷移
if(strstr($referer,$talentListUrl)){
  $title = 'タレント一覧';
  $errorMsg = 'タレント一覧の取得';
}

// ユーザー登録確認画面から遷移
if(strstr($referer,$userConfirmUrl)){
  $title = 'ユーザー登録';
  $errorMsg = 'ユーザー登録';
}

// ユーザー削除画面から遷移
if(strstr($referer, $userDeleteUrl)){
  $title = 'ユーザ一覧';
  $errorMsg = 'ユーザーの削除';
}

// 給与一覧画面から遷移
if(strstr($referer, $salaryListUrl)){
  $title = '給与一覧画面';
  $errorMsg = '給与一覧の表示';
}

// 給与登録画面から遷移
if(strstr($referer, $salaryRegistUrl) || strstr($referer, $salaryConfirmUrl)){
  $title = '給与登録';
  $errorMsg = '給与登録';
}

// 給与削除画面から遷移
if(strstr($referer, $salaryDeleteUrl)){
  $title = '給与削除';
  $errorMsg = '給与削除';
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
  </head>
  <body>

    <h1><?php echo $title; ?></h1>

    <main>
      <p id="completeMessage"><?php echo $errorMsg; ?>に失敗しました</p>

      <a href="<?php echo $transitionUrl; ?>" id="passwordLink"><?php echo $transition; ?>画面へ戻る</a>
    </main>
  </body>
</html>
