<?php
require_once('../db.php');
require_once('head.php');
$sql = "SELECT * FROM `quizzes`";
$result = $conn->query($sql);
?>
<div class="container">
  <h1>List of Quiz</h1>
  <table class="table">
  <thead>
    <tr>
      <th scope="col">Quiz ID</th>
      <th scope="col">Name</th>
      <th scope="col">Edit</th>
      <th scope="col">Enroll</th>
    </tr>
  </thead>
  <tbody>
      <?php
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                echo '<tr>
                  <td>' . $row["id"] . '</td>
                  <td>' . $row["name"] . '</td>
                  <td><a href="assign_question.php?id=' . $row["id"] . '">Assign Question</a></td>
                  <td><a href="quiz_enroll.php?id=' . $row["id"] . '">Enroll</a></td>
                </tr>';
              }
            } else {
              echo "0 results";
            }
          ?>
        </div>
    
  </tbody>
</table>
<?php
require_once('foot.php');
?>