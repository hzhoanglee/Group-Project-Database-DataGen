<?php
require_once('../db.php');
require_once('head.php');
$quizID = $_POST["quizID"];
$sql = "INSERT INTO `quiz_enroll` (`quiz_id`, `user_id`, `time_limit`) VALUES ";
$arr = $_POST["que"];
$lastKey = key(array_slice($arr, -1, 1, true));
foreach ($_POST["que"] as $key => $question) {
    $sql .= "($quizID," . $key . ", 1)";
    if ($key == $lastKey) {
        $sql .= ";";
    } else {
        $sql .= ", ";
    }
}
echo "<pre>".$sql;
//$conn->query($sql);