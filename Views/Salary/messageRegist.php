<?php

// サニタイジング
$_POST['messageBody'] = htmlspecialchars($_POST['messageBody'],ENT_QUOTES);

// POSTメソッドでリクエストした値を取得
$messageTalentId = $_POST['messageTalentId'];
$messageUserName = $_POST['messageUserName'];
$messageBody = $_POST['messageBody'];

// データベース接続
$host = 'localhost';
$dbname = 'salary';
$dbuser = 'root';
$dbpass = 'root';

// データベース接続クラスPDOのインスタンス$dbhを作成する
try {
    $dbh = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4", $dbuser, $dbpass);
// PDOExceptionクラスのインスタンス$eからエラーメッセージを取得
} catch (PDOException $e) {
    // 接続できなかったらvar_dumpの後に処理を終了する
    var_dump($e->getMessage());
    exit;
}

// データ追加用SQL
// 値はバインドさせる
$sql = "INSERT INTO messages(talent_id, name, body) VALUES(?, ?, ?)";
// SQLをセット
$stmt = $dbh->prepare($sql);
// SQLを実行
$stmt->execute(array($messageTalentId, $messageUserName, $messageBody));

// 先ほど追加したデータを取得
// idはlastInsertId()で取得できる
$last_id = $dbh->lastInsertId();
// データ追加用SQL
// 値はバインドさせる
$sql = "SELECT id, name, body FROM messages WHERE id = ?";
// SQLをセット
$stmt = ($dbh->prepare($sql));
// SQLを実行
$stmt->execute(array($last_id));

// あらかじめ配列$productListを作成する
// 受け取ったデータを配列に代入する
// 最終的にhtmlへ渡される
$messageList = array();

// fetchメソッドでSQLの結果を取得
// 定数をPDO::FETCH_ASSOC:に指定すると連想配列で結果を取得できる
// 取得したデータを$productListへ代入する
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $messageList[] = array(
        'id'    => $row['id'],
        'name'    => $row['name'],
        'body'  => $row['body']
    );
}

// ヘッダーを指定することによりjsonの動作を安定させる
header('Content-type: application/json');
// htmlへ渡す配列$productListをjsonに変換する
echo json_encode($messageList);