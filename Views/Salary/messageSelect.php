<?php

// POSTメソッドでリクエストした値を取得
$messageShowTalentId = $_POST['messageShowTalentId'];
$messageShowSelectMonth = $_POST['messageShowSelectMonth'];

// データベース接続
$host = 'localhost';
$dbname = 'salary';
$dbuser = 'root';
$dbpass = 'root';

// データベース接続クラスPDOのインスタンス$dbhを作成する
try {
    $dbh = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4", $dbuser, $dbpass);

} catch (PDOException $e) {
    // 接続できなかったらvar_dumpの後に処理を終了する
    var_dump($e->getMessage());
    exit;
}

// データ取得用SQL
$sql = "SELECT id, name, body FROM messages WHERE talent_id = ? AND DATE_FORMAT(regist_date,'%c') = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute(array($messageShowTalentId, $messageShowSelectMonth));

// 受け取ったデータを配列に代入
$messageList = array();

// SQLの結果を取得
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $messageList[] = array(
        'id'    => $row['id'],
        'name'    => $row['name'],
        'body'  => $row['body']
    );
}

header('Content-type: application/json');
// htmlへ渡す配列$messageListをjsonに変換する
echo json_encode($messageList);