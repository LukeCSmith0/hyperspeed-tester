<?php
include_once("conn.php");
$value_to_search_on = $_POST["filter_criteria"];
//echo $value_to_search_on;
$date_search = False;

//perform some regex checks to see if the entered value is a Date
if (preg_match('/^[0-9\-]+$/', $value_to_search_on))
{
  //convert the date to the timestamp as well#
  $timestamp_entered = strtotime($value_to_search_on);
  $date_search = True;
}

$value_pattern = "'%" . $value_to_search_on . "%'";
$value_pattern_range = $timestamp_entered + 86399;

if ($date_search)
{
  $sql = ("SELECT * FROM test_logs INNER JOIN engineer_assignment ON test_logs.board_id = engineer_assignment.board_id WHERE connecting_to LIKE $value_pattern OR test_duration LIKE $value_pattern OR gbps_sent LIKE $value_pattern OR gbps_received LIKE $value_pattern OR test_logs.board_id LIKE $value_pattern OR engineer_name LIKE $value_pattern OR engineer_email LIKE $value_pattern OR file_hash LIKE $value_pattern OR timestamp BETWEEN $timestamp_entered AND $value_pattern_range ORDER BY timestamp DESC");
}
else
{
  $sql = ("SELECT * FROM test_logs INNER JOIN engineer_assignment ON test_logs.board_id = engineer_assignment.board_id WHERE connecting_to LIKE $value_pattern OR test_duration LIKE $value_pattern OR gbps_sent LIKE $value_pattern OR gbps_received LIKE $value_pattern OR test_logs.board_id LIKE $value_pattern OR engineer_name LIKE $value_pattern OR engineer_email LIKE $value_pattern OR file_hash LIKE $value_pattern ORDER BY timestamp DESC");
}

$result = $conn->query($sql);

$row = mysqli_fetch_all($result);

echo json_encode($row);

 ?>
