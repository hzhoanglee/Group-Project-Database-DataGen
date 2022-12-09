<?php
require_once('../db.php');
require_once('head.php');
$quizID = $_POST["quizID"];
$sql = "INSERT INTO `quiz_assign` (`quiz_id`, `question_id`) VALUES ";
$arr = $_POST["que"];
$lastKey = key(array_slice($arr, -1, 1, true));
foreach ($_POST["que"] as $key => $question) {
    $sql .= "($quizID," . $key . ")";
    if ($key == $lastKey) {
        $sql .= ";";
    } else {
        $sql .= ", ";
    }
}
echo $sql;
//$conn->query($sql);