<?php
require_once(ROOT_PATH .'/Models/User.php');

class UserController {

  private $User;

  public function __construct(){
    $this->User = new User();
  }

  /**
   * [ログイン画面]
   * 入力された内容と一致する担当者を検索
   * @param string $userId ユーザーID
   * @param string $password パスワード
   * @return array DBより取得したid,user
   */
  public function findLoginManager($userId, $password){
    $findUser = $this->User->findLoginManagerUser($userId);
    $params = null;

    // 入力されたユーザーIDと一致するユーザーあり
    if(!empty($findUser)){
      if(password_verify($password, $findUser['password'])){
        $params = [
          'userInfo' => $findUser
        ];
      }else {
        $params = null;
      }
    }
    return $params;
  }

  /**
   * [ログイン画面]
   * 入力された内容と一致するタレントを検索
   * @param string $userId ユーザーID
   * @param string $password パスワード
   * @return array DBより取得したid
   */
  public function findLoginTalent($userId, $password){
    $findUser = $this->User->findLoginTalentUser($userId);
    $params = null;

    // 入力されたユーザーIDと一致するユーザーあり
    if(!empty($findUser)){
      if(password_verify($password, $findUser['password'])){
        $params = [
          'userInfo' => $findUser
        ];
      }else {
        $params = null;
      }
    }
    return $params;
  }

  /**
   * [タレント一覧画面]
   * [ユーザー削除画面]
   * [給与一覧画面]
   * [給与登録画面]
   * [給与変更画面]
   * 全タレント名取得
   * @return array DBより取得したID,氏名
   */
  public function selectAllTalents(){
    $talents = $this->User->selectAllTalentsInfo();

    $params = [
      'talents' => $talents
    ];

    return $params;
  }

  /**
   * [ユーザー削除画面]
   * [給与登録画面]
   * [給与変更画面]
   * 全担当者名取得
   * @return array DBより取得したID,氏名
   */
  public function selectAllManagers(){
    $managers = $this->User->selectAllManagersInfo();

    $params = [
      'managers' => $managers
    ];

    return $params;
  }

  /**
   * [給与一覧画面]
   * [給与登録確認画面]
   * [給与変更確認画面]
   * IDと一致するタレント名取得
   * @param integer $id ID
   * @return string タレント名
   */

  public function selectMatchTalents($id){
    $talent = $this->User->selectMatchTalentsName($id);

    $params = [
      'matchUser' => $talent
    ];

    return $params;
  }

  /**
   * [給与一覧画面]
   * [給与登録確認画面]
   * [給与変更確認画面]
   * IDと一致する担当者名取得
   * @param integer $id ID
   * @return string 担当者名
   */

  public function selectMatchManagers($id){
    $manager = $this->User->selectMatchManagersName($id);

    $params = [
      'matchUser' => $manager
    ];

    return $params;
  }

  /**
   * [ユーザー登録確認画面]
   * ユーザー登録
   * @param integer $user ユーザー
   * @param string $userId ユーザーID
   * @param string $userName 氏名
   * @param string $password パスワード
   * @param integer $questionId 秘密の質問ID
   * @param string $question 秘密の質問
   */
  public function registUser($user, $userId, $userName, $password, $questionId, $question){

    // 管理者・担当者の場合
    if(($user == 0 || $user == 1)){
      $this->User->registUserManager($user, $userId, $userName, $password, $questionId, $question);

    // タレントの場合
    } else if($user == 2){
      $this->User->registUserTalent($userId, $userName, $password, $questionId, $question);
    }
  }

  /**
   * [ユーザー一覧画面]
   * 担当者テーブルよりユーザー削除
   * @param integer $id 削除するID
   */
  public function deleteManagers($id){
    $this->User->deleteManagersInfo($id);
  }

  /**
   * [ユーザー一覧画面]
   * タレントテーブルよりユーザー削除
   * @param integer $id 削除するID
   */
  public function deleteTalents($id){
    $this->User->deleteTalentsInfo($id);
  }

}
?>