<?php 

require_once(ROOT_PATH. '/Models/Db.php');

class Message extends Db {

  public function __construct($dbh = null){
    parent::__construct($dbh);
  }

  /**
   * メッセージ情報登録
   * @param integer $talentId タレントID
   * @param string $name 登録したユーザー名
   * @param string $body メッセージ内容
   */
  public function messageInsertInfo($talentId, $name, $body){
    $sql = 'INSERT INTO messages (talent_id, name, body) VALUES (:talent_id, :name, :body)';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':talent_id', $talentId);
    $sth->bindParam(':name', $name);
    $sth->bindParam(':body', $body);
    $sth->execute();
  }

  /**
   * 該当のタレントIDのメッセージ取得
   * @param integer $id ID
   * @return array ユーザー名、メッセージ内容
   */
  public function selectMessageInfo($talentId){
    $sql = 'SELECT id, name, body FROM messages WHERE talent_id = :talent_id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam('talent_id', $talentId);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;

  }

  /**
   * 該当IDのメッセージ情報を削除
   * @param integer $id ID
   */
  public function messageDeleteInfo($id){
    $sql = 'DELETE FROM messages WHERE id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id);
    $sth->execute();


  }

}

?>