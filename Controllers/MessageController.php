<?php

require_once(ROOT_PATH. '/Models/Message.php');

class MessageController {

  private $Message;

  public function __construct(){
    $this->Message = new Message();
  }

  /**
   * [[給与一覧画面]
   * メッセージ取得
   * @param integer $talentId タレントのID
   * @return array DBより取得したメッセージ情報
   */
  public function selectMessage($talentId){
    $message = $this->Message->selectMessageInfo($talentId);

    $params = [
      'messageInfo' => $message
    ];

    return $params;
  }

  /**
   * [給与削除画面]
   * メッセージ削除
   * @param integer $id メッセージのID
   */
  public function deleteMessage($id){
    $this->Message->messageDeleteInfo($id);
  }

}

?>