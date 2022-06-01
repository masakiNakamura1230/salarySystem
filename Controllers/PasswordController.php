<?php
require_once(ROOT_PATH .'/Models/Password.php');

class PasswordController {

  private $Password;

  public function __construct(){
    $this->Password = new Password();
  }

  /**
   * パスワード再設定ログイン画面
   * 入力された内容と一致する担当者を検索
   * @param integer $user ユーザー
   * @param string $userId ユーザーID
   * @param integer $questionId 秘密の質問ID
   * @param string $question 秘密の質問
   * @return array DBより取得したユーザーID
   */
  public function findManager($user, $userId, $questionId, $question){
    $findUserId = $this->Password->findManagerUserId($user, $userId, $questionId, $question);

    $params = [
      'findUserId' => $findUserId
    ];

    return $params;
  }

  /**
   * パスワード再設定ログイン画面
   * 入力された内容と一致するタレントを検索
   * @param string $userId ユーザーID
   * @param integer $questionId 秘密の質問ID
   * @param string $question 秘密の質問
   * @return array DBより取得したユーザーID
   */
  public function findTalent($userId, $questionId, $question){
    $findUser = $this->Password->findTalentUserId($userId, $questionId, $question);

    $params = [
      'findUserId' => $findUser
    ];

    return $params;
  }

  /**
   * パスワード再設定登録画面
   * ユーザーIDと一致するユーザーのパスワード変更
   * @param integer $user ユーザー
   * @param string $userId ユーザーID
   * @param string $newPassword パスワード
   */
  public function updatePassword($user, $userId, $newPassword){

    if(($user == 0 || $user == 1)){
      $this->Password->updateManagerPassword($userId, $newPassword);
    } else if($user == 2){
      $this->Password->updateTalentPassword($userId, $newPassword);
    }
  }
}
?>