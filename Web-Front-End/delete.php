<?php
  include_once("conn.php");

  $sql = ("DELETE FROM engineer_assignment WHERE board_id = '" .  $_POST["nextTDs"] . "'");
  $result = $conn->query($sql);

  echo $sql
?>
