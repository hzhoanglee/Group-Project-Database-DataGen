<?php
$servername = "localhost";
$username = "tmpdb";
$password = "tmpdb";
$dbname = "tmpdb";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}