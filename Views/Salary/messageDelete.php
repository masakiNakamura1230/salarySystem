<?php

require_once(ROOT_PATH. 'Controllers/MessageController.php');
$message = new MessageController();

$id = $_POST['deleteId'];

try{

  $message->deleteMessage($id);
} catch (Exception $e){

  echo $e->getMessage()." - ". $e->getLine();
  header('Location: error.php');
  exit;
}
header("Location: salaryList.php");

?>
