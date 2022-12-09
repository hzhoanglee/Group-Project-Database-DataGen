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
$sql = "SELECT * FROM `users` WHERE `group` = 2";
$result = $conn->query($sql);
$userList = [];
while($user = mysqli_fetch_array($result)) {
    $userList[] = $user;
}
//print_r($userList); die();
?>
<form action="enroll_save.php" method="POST">
    <input hidden name="quizID" value="<?php echo $quiz_id; ?>">
    <?php
    foreach ($userList as $user) {
        echo '<div class="form-check">
              <input class="form-check-input" type="checkbox" name="que[' . $user[0] . ']" id="flexCheckDefault">
              <label class="form-check-label" for="flexCheckDefault">
                ' . $user["fullname"] . '
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