<?php

require_once(ROOT_PATH .'/Models/Salary.php');

class SalaryController {

  private $Salary;

  public function __construct(){
    $this->Salary = new Salary();
  }

  /**
   * [給与一覧画面]
   * 該当タレントの給与情報取得
   * @param integer $id 該当タレントのID
   * @param integer $selectMonth 選択された月
   * @return array DBより取得した給与情報
   */
  public function selectSalary($id, $selectMonth){

    $selectSalary = $this->Salary->selectAllSalary($id, $selectMonth);

    $params = [
      'selectSalary' => $selectSalary
    ];
  
    return $params;
  }

  /**
   * [給与一覧画面]
   * 該当タレントの選択された担当者の給与情報取得
   * @param integer $id 該当タレントのID
   * @param integer $selectMonth 選択された月
   * @param integer $selectManager 選択された担当者のID
   * @return array DBより取得した給与情報
   */
  public function selectSalaryManager($id, $selectMonth, $selectManager){

    $selectSalary = $this->Salary->selectManagerSalary($id, $selectMonth, $selectManager);

    $params = [
      'selectSalary' => $selectSalary
    ];
  
    return $params;
  }

  /**
   * [給与登録確認画面]
   * 給与情報登録
   * @param integer $talentId タレントID
   * @param integer $managerId 担当者ID
   * @param string $work 仕事内容
   * @param string $workingDate 稼働日
   * @param integer $salary 給与
   */
  public function registSalary($talentId, $managerId, $work, $workingDate, $salary){

    $this->Salary->registSalaryInfo($talentId, $managerId, $work, $workingDate, $salary);

  }

  /**
   * [給与変更確認画面]
   * 給与情報変更
   * @param integer $id ID
   * @param integer $talentId タレントID
   * @param integer $managerId 担当者ID
   * @param string $work 仕事内容
   * @param string $workingDate 稼働日
   * @param integer $salary 給与
   */
  public function changeSalary($id, $talentId, $managerId, $work, $workingDate, $salary){

    $this->Salary->changeSalaryInfo($id, $talentId, $managerId, $work, $workingDate, $salary);

  }

  /**
   * [給与削除画面]
   * 給与情報削除
   * @param integer $id ID
   */
  public function deleteSalary($id){

    $this->Salary->deleteSalaryInfo($id);

  }

}

?>