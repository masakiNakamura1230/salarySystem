<?php
// 給与削除画面

// コントローラー読み込み
require_once(ROOT_PATH. 'Controllers/SalaryController.php');
$salary = new SalaryController();


// 削除する給与情報のID
$id = $_POST['id'];

try{

  // 該当IDの給与情報削除
  $salary->deleteSalary($id);
} catch (Exception $e){

  echo $e->getMessage()." - ". $e->getLine();
  header('Location: error.php');
  exit;

}

// 一覧画面へ遷移
header("Location: salaryList.php");
?>