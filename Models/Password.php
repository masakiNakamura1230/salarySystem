<?php

require_once(ROOT_PATH .'/Models/Db.php');

class Password extends Db {
  public function __construct($dbh = null){
    parent::__construct($dbh);
  }

  /**
   * 担当者テーブルより入力された内容と一致するユーザーIDを検索
   * @param integer $user ユーザー
   * @param string $userId ユーザーID
   * @param integer $questionId 秘密の質問ID
   * @param string $question 秘密の質問の回答
   * @return array ユーザーID
   */
  public function findManagerUserId($user, $userId, $questionId, $question){

    $sql = 'SELECT user_id FROM managers WHERE user = :user AND user_id = :user_id AND question_id = :question_id AND question = :question';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':user', $user, PDO::PARAM_INT);
    $sth->bindParam(':user_id', $userId, PDO::PARAM_STR);
    $sth->bindParam(':question_id', $questionId, PDO::PARAM_INT);
    $sth->bindParam(':question', $question, PDO::PARAM_STR);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * タレントテーブルより入力された内容と一致するユーザーIDを検索
   * @param string $userId ユーザーID
   * @param integer $questionId 秘密の質問ID
   * @param string $question 秘密の質問
   * @return array ユーザーID
   */
  public function findTalentUserId($userId, $questionId, $question){

    $sql = 'SELECT user_id FROM talents WHERE user_id = :user_id AND question_id = :question_id AND question = :question';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':user_id', $userId, PDO::PARAM_STR);
    $sth->bindParam(':question_id', $questionId, PDO::PARAM_INT);
    $sth->bindParam(':question', $question, PDO::PARAM_STR);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * 担当者テーブルよりログインしているユーザーIDと一致するユーザーのパスワード変更
   * @param string $userId ユーザーID
   * @param string  $newPassword パスワード
   */
  public function updateManagerPassword($userId, $newPassword) {
    $sql = 'UPDATE managers SET password = :newPassword WHERE user_id = :user_id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':newPassword', password_hash($newPassword, PASSWORD_DEFAULT), PDO::PARAM_STR);
    $sth->bindParam(':user_id', $userId, PDO::PARAM_STR);
    $sth->execute();
  }

  /**
   * タレントテーブルよりログインしているユーザーIDと一致するユーザーのパスワード変更
   * @param string $userId ユーザーID
   * @param string  $newPassword パスワード
   */
  public function updateTalentPassword($userId, $newPassword) {
    $sql = 'UPDATE talents SET password = :newPassword WHERE user_id = :user_id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':newPassword', password_hash($newPassword, PASSWORD_DEFAULT), PDO::PARAM_STR);
    $sth->bindParam(':user_id', $userId, PDO::PARAM_STR);
    $sth->execute();
  }


}
