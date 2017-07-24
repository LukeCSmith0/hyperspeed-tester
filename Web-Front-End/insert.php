<?php
  include_once("conn.php");

  $strLow = $_POST["Mac_Address"];
  $strUpper = strtoupper($strLow);
  $engineer_name = filter_var($_POST["Name"], FILTER_SANITIZE_STRING);
  $engineer_email = filter_var($_POST["Email"], FILTER_SANITIZE_STRING);
  $engineer_mac = filter_var($strUpper, FILTER_SANITIZE_STRING);

  //prepare statement
  $sql_statement = $conn->prepare("INSERT INTO engineer_assignment (engineer_name, engineer_email, board_id) VALUES (?, ?, ?)");
  $sql_statement->bind_param("sss", $engineer_name, $engineer_email, $engineer_mac);

  $result = $sql_statement->execute();
?>
  <meta http-equiv="refresh" content="0; url=admin.php" />
