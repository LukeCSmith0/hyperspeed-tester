<?php
  include_once("conn.php");

  $strLow = $_POST["Mac_Address"];

  $strUpper = strtoupper($strLow);

  $sql = ("INSERT INTO engineer_assignment (engineer_name, engineer_email, board_id) VALUES ('" .  $_POST["Name"] . "', '" . $_POST["Email"] . "', '" . $strUpper . "')");
  $result = $conn->query($sql);
?>
  <meta http-equiv="refresh" content="0; url=admin.php" />
