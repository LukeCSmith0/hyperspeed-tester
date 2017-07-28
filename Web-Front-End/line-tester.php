<?php
include_once("conn.php");
?>

<html>
<head>
  <style>

  .btn_padding {
    padding-top: 16px;
    padding-left: 160px
  }

  .img_padding {
    padding-top: 16px;
    padding-left: 16px
  }
  .main_title {
    font-size: 1.5rem;
    /*padding-left: 4px;*/
    /*padding-top: 4px*/
  }

  .filter-bar{
    padding-top: 30px;
    padding-left: 30px;
  }

  .table-grid {
    padding-top: 60px;
    padding-left: 40px;
    padding-right: 40px;
    padding-bottom: 40px

  }
  </style>

  <title>Speed Test</title>
  <link rel="shortcut icon" href="images/favicon.ico" type="images/x-icon">
  <link rel="icon" href="images/favicon.ico" type="images/x-icon">
  <link rel="stylesheet" type="text/css" href="semantic/dist/semantic.min.css">
  <script
    src="https://code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
    crossorigin="anonymous"></script>
  <script src="semantic/dist/semantic.min.js"></script>
  <script>
  function removeSearch(){
    $(".filter-bar").hide()
  }
  </script>
</head>
<body>
      <div class="ui grid">

        <div class="ui stacked grey eight wide column">

          <p class="main_title">Line Tester Panel</p>
        </div>

          <div class="ui stacked grey eight wide column center aligned">
            <div class="btn_padding">
                <?php
                  if (!isset($_GET["test-id"]))
                  {
                    echo "<button class=\"ui primary button\" onclick=\"location.href='admin.php'\">";
                    echo "Admin";
                  }
                ?>
              </button>
            </div>
          </div>
        </div>

  <div class="ui form filter-bar">
    <h4 class="ui dividing header">Filter Results</h4>
    <div class="ui icon input">
      <input type="text" placeholder="Search..." class="filter_results">
      <i class="search icon"></i>
    </div>
  </div>

  <div class="table-grid">
      <table class="ui celled table">
      <thead>
        <th>Test ID</th>
        <th>Time</th>
        <th>Date</th>
        <th>Engineer</th>
        <th>Upload (Mbps)</th>
        <th>Download (Mbps)</th>
        <th>Peak (Mbps)</th>
        <th>MAC Address</th>
        <th>Switch Port Number</th>
        <th>Switch IP Address</th>
        <th>Switch Name</th>
        <th>JSON</th>
      </tr></thead>
      <tbody class="result_tbody">
          <?php
            if (isset($_GET["test-id"]))
            {
              $sql = "Select * from test_logs inner join engineer_assignment on test_logs.board_id = engineer_assignment.board_id WHERE file_hash = '" . $_GET['test-id'] .  "' ORDER BY `test_logs`.`timestamp` DESC";
              echo '<script type="text/javascript">removeSearch();</script>';
            }
            else
            {
              $sql = "Select * from test_logs inner join engineer_assignment on test_logs.board_id = engineer_assignment.board_id ORDER BY `test_logs`.`timestamp` DESC";
            }
            $result = $conn->query($sql);
            $num_rows = $result->num_rows;
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>"
                  . $row["file_hash"]
                  . "</td>";
              echo "<td>"
                  . date("H:i", $row["timestamp"])
                  . "</td>";
              echo "<td>"
                  . date("d-m-Y", $row["timestamp"])
                  . "</td>";
              echo "<td>"
                  . $row["engineer_name"] .
                  "</td>";
              echo "<td>
                  <i class='arrow circle up icon'></i>"
                  . $row["gbps_sent"]
                  . "</td>";
              echo "<td>
                  <i class='arrow circle down icon'></i>"
                  . $row["gbps_received"]
                  . "</td>";
              echo "<td>
                  <i class='line chart icon'></i>"
                  . $row["peak_gbps"]
                  . "</td>";
              echo "<td>" . $row["board_id"] . "</td>";
              echo "<td>" . $row["switchPortNumber"] . "</td>";
              echo "<td>" . $row["switchIPAddress"] . "</td>";
              echo "<td>" . $row["switchName"] . "</td>";
              echo "<td>
                    <a href=\"/test-logs/" . $row["file_hash"] .
                    "\" download>
                    <i class='large save icon'></i>
                    </a>
                  </td>";

              echo "</tr>";
            }
          ?>
      </tbody>
      <tfoot>
        <tr><th colspan="9">
          <div class="ui grid">
            <div class="four wide column center aligned">
                <p><i class="archive icon"></i><b class="num_row_amount"><?php echo $num_rows; ?></b> Test Results</p>
            </div>

            <div class="four wide column"></div>
            <div class="four wide column"></div>
            <div class="four wide column center aligned">

            </div>
          </div>
        </th>
      </tr></tfoot>
    </table>

  </div>

</body>
</html>

<script>
$(document).ready(function(){


  var ajax_sent = "";

  $(".filter_results").on("focusout", function(){
    if (ajax_sent != "")
    {
      ajax_sent.abort();
    }
    var value_from_field = $(".filter_results").val();
    ajax_sent = $.post("filter_table.php", {filter_criteria:value_from_field}, function(result){
      var json_result = JSON.parse(result);
      var result_length = json_result.length;
      $(".num_row_amount").text(result_length);

      //destroy the current table
      $(".result_tbody").closest("tbody").empty();

      for (var x = 0; x < result_length; x++)
      {
        var timestamp_date = new Date(json_result[x][2] * 1000);
        var year = timestamp_date.getFullYear();
        var day = timestamp_date.getDate();
        if (day < 10)
        {
          day = "0" + day;
        }
        var month = timestamp_date.getMonth() + 1;
        if (month < 10)
        {
          month = "0" + month;
        }
        var formatted_date = day + "-" + month + "-" + year;
        var hour = timestamp_date.getHours();
        if (hour < 10)
        {
          hour = "0" + hour;
        }
        var minutes = timestamp_date.getMinutes();
        if (minutes < 10)
        {
          minutes = "0" + minutes;
        }
        var seconds = timestamp_date.getSeconds();
        if (seconds < 10)
        {
          seconds = "0" + seconds;
        }

        var formatted_time = hour + ":" + minutes;
        var hash_to_append = "<td>" + json_result[x][1] + "</td>"
        var engineer_to_append = "<td>" + json_result[x][11] + "</td>"
        var upload_to_append = "<td><i class='arrow circle up icon'></i>" + json_result[x][5] + "</td>"
        var download_to_append = "<td><i class='arrow circle down icon'></i>" + json_result[x][6] + "</td>"
        var peak_to_append = "<td><i class='line chart icon'></i>" + json_result[x][9] + "</td>"
        var mac_to_append = "<td>" + json_result[x][13] + "</td>"
        var switchport_to_append = "<td>" + json_result[x][10] + "</td>";
        var switchaddress_to_append = "<td>" + json_result[x][11] + "</td>";
        var switchname_to_append = "<td>" + json_result[x][12] + "</td>";
        var save_to_append = "<td><a href=\"/test-logs/" + json_result[x][1] + "\" download><i class='large save icon'></i></a></td>";
        var full_string = "<tr>" + hash_to_append + "<td>" + formatted_time + "</td>" + "<td>" + formatted_date + "</td>" + engineer_to_append + upload_to_append + download_to_append + peak_to_append + mac_to_append + switchport_to_append + switchaddress_to_append + switchname_to_append + save_to_append + "</tr>";

      }
    })

  })
})

</script>
