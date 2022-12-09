<?php
require_once('../db.php');
require_once('head.php');
$quiz_id = $_GET["id"];
$sql = "SELECT * FROM `quizzes` WHERE id = $quiz_id";
$result = $conn->query($sql);
?>
<div class="container">
<?php
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo '<h1>Selected Quiz: ' . $row["name"] . '</h1>';
  }
} else {
  echo "There is no Quiz";
}
?>
<?php
$sql = "SELECT * FROM `quiz_questions` INNER JOIN categories ON categories.id = quiz_questions.category";
$result = $conn->query($sql);
$questionList = [];
while($question = mysqli_fetch_array($result))
{
    $questionList[] = $question;
}
//print_r($questionList); die();
?>
<form action="question_save.php" method="POST">
    <input hidden name="quizID" value="<?php echo $quiz_id; ?>">
    <?php
    foreach ($questionList as $question) {
        echo '<div class="form-check">
              <input class="form-check-input" type="checkbox" name="que[' . $question[0] . ']" id="flexCheckDefault">
              <label class="form-check-label" for="flexCheckDefault">
                ' . $question["name"] . ' - ' . $question["title"] . '
              </label>
            </div>';
    }
    ?>
    <button class="btn btn-success" type="submit">Submit here</button>
</form>
</div>
<?php
require_once('foot.php');
?>