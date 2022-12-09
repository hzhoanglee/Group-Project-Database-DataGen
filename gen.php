<pre>
<?php
function dd($var){ 
    echo "<pre>";
    print_r($var);
    exit;
}
function getQuery($sql) {
    global $conn;
    $result = $conn->query($sql);
    echo $sql . "\n";
    if ($result != TRUE) {
        echo $sql . "\n";
        echo "Cannot create attempt: " . $conn->error;
        die();
    }
    $arrg = [];
    while($element = mysqli_fetch_array($result)) {
        $arrg[] = $element;
    }
    return $arrg;
}
require_once('db.php');
if(!isset($_GET["user"])) {
    echo "LMEO??";
    die();
}
$user_id = $_GET["user"];
//Get Enrolled
$sql = "SELECT * FROM `quiz_enroll` WHERE `user_id` = $user_id";
$quizList = getQuery($sql);
//Get Completed Quiz
$sql = "SELECT * FROM `user_attempts` WHERE `user_id` = $user_id";
$completedList = getQuery($sql);
$cpl = [];
foreach ($completedList as $completed) {
    array_push($cpl, $completed["id"]);
}
foreach ($quizList as $quizz) {
    $quiz_id = $quizz['quiz_id'];
    if(in_array($quiz_id, $cpl)) {
        break;
    }
    $sql = "SELECT quiz_questions.id, title, correct_option FROM `quiz_assign` INNER JOIN quiz_questions ON quiz_questions.id = quiz_assign.question_id WHERE `quiz_id` = $quiz_id";
    $questionList = getQuery($sql);

    if(count($questionList) > 0) {
        $cnt = 0;
        $resultSQL = "INSERT INTO `user_attempt_details`(`attempt_id`, `question_id`, `selected_option`) VALUES ";
        //Create new attempt
        $mark = 0;
        $minute = rand(0,2);
        $date_now = date("Y-m-d H:i:s");
        $date_later = date("Y-m-d H:i:s", strtotime("+$minute minutes"));
        $sql = "INSERT INTO `user_attempts`(`user_id`, `mark`, `quiz_id`, `start_time`) VALUES ($user_id, $mark, $quiz_id, '$date_now');";
        if ($conn->query($sql) === TRUE) {
            echo $sql . "\n";
            $last_id = $conn->insert_id;
        } else {
            echo "Cannot create attempt: " . $conn->error;
            die();
        }
        //Create attempt list
        $lastKey = key(array_slice($questionList, -1, 1, true));
        foreach ($questionList as $questionKey => $question) {
            $question_id = $question["id"];
            $correct_option = $question["correct_option"];
            if(rand(0,1) == 1) {
                $cnt += 1;
                $resultSQL .= "($last_id, $question_id, $correct_option)";
            } else {
                while($selected != $correct_option) {
                    $selected = rand(1,4);
                }
                $resultSQL .= "($last_id, $question_id, $selected)";
            }
            if ($lastKey == $questionKey) {
                $resultSQL .= ";";
            } else {
                $resultSQL .= ",";
            }
        }
        echo $sql . "\n";
        if ($conn->query($resultSQL) != TRUE) {
            echo $resultSQL;
            echo "Cannot create attempt: " . $conn->error;
            die();
        }   
        echo $resultSQL . "\n";
        //Set Mark
        $resultSQL = "UPDATE `user_attempts` SET `mark`= " . round((($cnt/count($questionList))*100),2) . ", `finish_time`= '$date_later' WHERE id=" . $last_id;
        echo $resultSQL . "\n";
        $conn->query($resultSQL);
        $resultSQL = "";
        unset($last_id); 
    }
    
}