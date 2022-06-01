<?php
require_once(ROOT_PATH .'/Models/Db.php');

class User extends Db {
  public function __construct($dbh = null){
    parent::__construct($dbh);
  }

  /**
   * 入力されたユーザーIDとパスワードが一致する情報を担当者テーブルより検索
   * @param string  $userId ユーザーID
   * @return array id, ユーザー,パスワード
   */
  public function findLoginManagerUser($userId){
    $sql = 'SELECT id, user, password FROM managers WHERE user_id = :user_id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':user_id', $userId, PDO::PARAM_STR);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * 入力されたユーザーIDとパスワードが一致する情報をタレントテーブルより検索
   * @param string $userId ユーザーID
   * @return array id, パスワード
   */
  public function findLoginTalentUser($userId){
    $sql = 'SELECT id, password FROM talents WHERE user_id = :user_id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':user_id', $userId, PDO::PARAM_STR);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * 全タレント情報をタレントテーブルより取得
   * @return array ID,氏名
   */
  public function selectAllTalentsInfo(){
    $sql = 'SELECT id, name FROM talents';
    $sth = $this->dbh->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * 全管理者・担当者情報を担当者テーブルより取得
   * @return array ID,氏名
   */
  public function selectAllManagersInfo(){
    $sql = 'SELECT id, name FROM managers';
    $sth = $this->dbh->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * 該当IDのタレント名取得
   * @param integer $id ID
   * @return array 氏名
   */
  public function selectMatchTalentsName($id){
    $sql = 'SELECT name FROM talents WHERE id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * 該当IDの担当者名取得
   * @param integer $id ID
   * @return array 氏名
   */
  public function selectMatchManagersName($id){
    $sql = 'SELECT name FROM managers WHERE id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * 担当者テーブルにユーザー登録
   * @param integer $user ユーザー
   * @param string $userId ユーザーID
   * @param string $userName 氏名
   * @param string $password パスワード
   * @param integer $questionId 秘密の質問ID
   * @param string $question 秘密の質問
   */
  public function registUserManager($user, $userId, $userName, $password, $questionId, $question){
    $sql = 'INSERT INTO managers (user, user_id, name, password, question_id, question) VALUE (:user, :user_id, :name, :password, :question_id, :question)';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':user', $user, PDO::PARAM_INT);
    $sth->bindParam(':user_id', $userId, PDO::PARAM_STR);
    $sth->bindParam(':name', $userName, PDO::PARAM_STR);
    $sth->bindParam(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
    $sth->bindParam(':question_id', $questionId, PDO::PARAM_INT);
    $sth->bindParam(':question', $question, PDO::PARAM_STR);
    $sth->execute();
  }

  /**
   * タレントテーブルにユーザー登録
   * @param string $userId ユーザーID
   * @param string $userName 氏名
   * @param string $password パスワード
   * @param integer $questionId 秘密の質問ID
   * @param string $question 秘密の質問
   */
  public function registUserTalent($userId, $userName, $password, $questionId, $question){
    $sql = 'INSERT INTO talents (user_id, name, password, question_id, question) VALUE (:user_id, :name, :password, :question_id, :question)';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':user_id', $userId, PDO::PARAM_STR);
    $sth->bindParam(':name', $userName, PDO::PARAM_STR);
    $sth->bindParam(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
    $sth->bindParam(':question_id', $questionId, PDO::PARAM_INT);
    $sth->bindParam(':question', $question, PDO::PARAM_STR);
    $sth->execute();
  }

  /**
   * 担当者テーブルよりユーザー削除
   * @param integer $id ユーザーID
   */
  public function deleteManagersInfo($id){
    $sql = 'DELETE FROM managers WHERE id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
  }

  /**
   * タレントテーブルよりユーザー削除
   * @param integer $id ユーザーID
   */
  public function deleteTalentsInfo($id){
    $sql = 'DELETE FROM talents WHERE id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
  }
}
