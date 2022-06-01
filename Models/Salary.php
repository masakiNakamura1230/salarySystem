<?php

require_once(ROOT_PATH .'/Models/Db.php');


class Salary extends Db {
  public function __construct($dbh = null){
    parent::__construct($dbh);
  }

  /**
   * 給与テーブルから該当タレントの給与情報全件取得
   * @param integer $id 該当タレントのID
   * @param integer $selectMonth 選択された月
   * @return Array 該当タレントの給与情報
   */
  public function selectAllSalary($id, $selectMonth){
    $sql = "SELECT s.id as id, s.talent_id as talent_id, s.manager_id as manager_id, t.name as talentName, m.name as managerName, s.work as work, s.working_date as working_date, s.regist_date as regist_date, s.salary as salary FROM salaries s LEFT JOIN talents t ON s.talent_id = t.id LEFT JOIN managers m ON s.manager_id = m.id WHERE s.talent_id = :talent_id AND DATE_FORMAT(working_date,'%c') = :selectMonth ORDER BY working_date";
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':talent_id', $id);
    $sth->bindParam(':selectMonth', $selectMonth);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);

    return $result;
  }

  /**
   * 給与テーブルから該当タレントの選択された担当者の給与情報全件取得
   * @param integer $id 該当タレントのID
   * @param integer $selectMonth 選択された月
   * @param integer $selectManager 選択された担当者のID
   * @return Array 該当タレントの給与情報
   */
  public function selectManagerSalary($id, $selectMonth, $selectManager){
    $sql = "SELECT s.id as id, s.talent_id as talent_id, s.manager_id as manager_id, t.name as talentName, m.name as managerName, s.work as work, s.working_date as working_date, s.regist_date as regist_date, s.salary as salary FROM salaries s LEFT JOIN talents t ON s.talent_id = t.id LEFT JOIN managers m ON s.manager_id = m.id WHERE s.talent_id = :talent_id AND DATE_FORMAT(working_date,'%c') = :selectMonth AND s.manager_id = :manager_id ORDER BY working_date";
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':talent_id', $id);
    $sth->bindParam(':selectMonth', $selectMonth);
    $sth->bindParam(':manager_id', $selectManager);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);

    return $result;
  }
  
  /**
   * 給与情報登録
   * @param integer $talentId タレントID
   * @param integer $managerId 担当者ID
   * @param string $work 仕事内容
   * @param string $workingDate 稼働日
   * @param integer $salary 給与
   */
  public function registSalaryInfo($talentId, $managerId, $work, $workingDate, $salary){
    $sql = 'INSERT INTO salaries (talent_id, manager_id, work, working_date, salary) VALUES (:talent_id, :manager_id, :work, :working_date, :salary)';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':talent_id', $talentId, PDO::PARAM_INT);
    $sth->bindParam(':manager_id', $managerId, PDO::PARAM_INT);
    $sth->bindParam(':work', $work, PDO::PARAM_STR);
    $sth->bindParam(':working_date', $workingDate, PDO::PARAM_STR);
    $sth->bindParam(':salary', $salary, PDO::PARAM_INT);
    $sth->execute();

  }

  /**
   * 給与情報変更
   * @param integer $id ID
   * @param integer $talentId タレントID
   * @param integer $managerId 担当者ID
   * @param string $work 仕事内容
   * @param string $workingDate 稼働日
   * @param integer $salary 給与
   */
  public function changeSalaryInfo($id, $talentId, $managerId, $work, $workingDate, $salary){

    $sql = 'UPDATE salaries SET talent_id = :talent_id, manager_id = :manager_id, work = :work, working_date = :working_date, salary = :salary WHERE id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->bindParam(':talent_id', $talentId, PDO::PARAM_INT);
    $sth->bindParam(':manager_id', $managerId, PDO::PARAM_INT);
    $sth->bindParam(':work', $work, PDO::PARAM_STR);
    $sth->bindParam(':working_date', $workingDate, PDO::PARAM_STR);
    $sth->bindParam(':salary', $salary, PDO::PARAM_INT);
    $sth->execute();
  }

  /**
   * 給与情報削除
   * @param integer $id ID
   */
  public function deleteSalaryInfo($id){
    $sql = 'DELETE FROM salaries WHERE id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
  }

}

