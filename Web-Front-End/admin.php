<?php
include_once("conn.php");
?>

<html>
<head>
  <link rel="shortcut icon" href="images/favicon.ico" type="images/x-icon">
  <link rel="icon" href="images/favicon.ico" type="images/x-icon">
  <script
    src="https://code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
    crossorigin="anonymous"></script>
  <script src="semantic/dist/semantic.min.js"></script>
  <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
  <script>
    function validateForm() {
        var Mac_Address = document.forms["insert"]["Mac_Address"].value;
        var Name = document.forms["insert"]["Name"].value;
        var Email = document.forms["insert"]["Email"].value;
        if (Mac_Address == "") {
            alert("All Fields Must Be Filled Out");
            return false;
        }
        else if (Name == "") {
            alert("All Fields Must Be Filled Out");
            return false;
        }
        else if (Email == "") {
            alert("All Fields Must Be Filled Out");
            return false;
        }
        // {
        // var regexp1=new RegExp("((\d|([a-f]|[A-F])){2}:){5}(\d|([a-f]|[A-F])){2}");
        // if(regexp1.test(document.getElementById("Mac_Address").value)){
        //   alert("Only alphabets from a-z and A-Z are allowed");
        //   return false;
        //   }
        // }
    }

    $(document).ready(function () {
        $('.submit').click(function () {
            var nextTD = $(this).closest("td").next().text();
            //console.log(nextTD);
            // $.ajax({url: "delete.php", success: function(result){
            //     $("#div1").html(result);
            // }});
            $.post("delete.php", {nextTDs: nextTD}, function(result){
            });

            var prev = $(this).closest('tr').remove();
            //console.log(prev)
            // $('.submit').remove();
        });
    });

    function sync()
      {
        var Name = document.getElementById('Name');
        var Email = document.getElementById('Email');
        var LName = Name.value.toLowerCase();
        var split = LName.split(" ");
        var firstName = split[0];
        var secondName = split[1];
        var emailPrefix = "@email.com";
        var Email_Address = firstName.concat(".", secondName, emailPrefix);

        if (typeof secondName === "undefined") {
          document.getElementById('Name').focus();
          document.getElementById('Email').value = "";
          //alert("All Fields Must Be Filled Out");
          return false;

        } else {
          Email.value = Email_Address;
        }
      }

      function Mac_Address_Val()
        {

        }


  </script>

  <style>

  .btn_padding {
    padding-top: 16px;
    padding-left: 160px
  }

  .submit_btn_padding {
    padding-top: 23px
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

  .input_size {
    height: 100px;
    width: 300px
  }

  .table-grid {
    padding-top: 60px;
    padding-left: 40px;
    padding-right: 40px;
    padding-bottom: 40px

  }
  </style>

  <title>Speed Test</title>
  <link rel="stylesheet" type="text/css" href="semantic/dist/semantic.min.css">

</head>
<body>


      <div class="ui grid">
        <div class="ui stacked grey eight wide column">

              <p class="main_title">Line Tester Panel</p>
        </div>

          <div class="ui stacked grey eight wide column center aligned">
            <div class="btn_padding">
              <button class="ui primary button" onclick="location.href='line-tester.php'">
                Dashboard
              </button>
            </div>
          </div>
        </div>


        <br>
        <br>
        <br>
        <br>
	<div class="main ui container">
        <div class="ui grid center aligned">
	    <div class="ui secondary segment">
            <div class="ui form">
              <form name="insert"action="insert.php" method="post" onsubmit="return validateForm()">
                <div class="fields">
                  <div class="field">
                    <label>MAC Address</label>
                    <input type="text" placeholder="MAC Address" name="Mac_Address" >
                  </div>
                  <div class="field">
                    <label>Engineer Name</label>
                    <input type="text" placeholder="Engineer Name" name="Name" id="Name" onfocus="Mac_Address_Val()">
                  </div>
                  <div class="field">
                    <label>Engineer Email</label>
                    <input type="text" placeholder="Engineer Email" name="Email" id="Email" onfocus="sync()">
                  </div>
                  <div class="submit_btn_padding">
                    <button class= "ui button" type="submit">
                      Submit
                    </button>
                  </div>
		</div>
                </div>
              </form>
          </div>
        </div>

	<h2 class="ui dividing header">Assigned Boards</h2>
          <table class="ui sortable celled table">
            <thead>
              <tr>
              <th class="two wide">Trash/Edit</th>
              <th class="sorted descending">MAC Address</th>
              <th>Engineer</th>
              <th>Engineer Email</th>
            </tr></thead>
            <tbody>
              <?php
                $sql = "Select * from engineer_assignment";
                $result = $conn->query($sql);
                $num_rows = $result->num_rows;
                while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td>
                        <a href = # class ='submit'><i class=\"trash icon\"></i></a>
                        </td>";
                  echo "<td>"
                        . $row["board_id"]
                        . "</td>";
                  echo "<td>"
                        . $row["engineer_name"]
                        . "</td>";
                  echo "<td>"
                        . $row["engineer_email"]
                        . "</td>";
                  echo "</tr>";
                }
              ?>
            </tbody>
            <tfoot>
              <tr><th colspan="4">
		<?php
		if ($num_rows == 1){
			echo $num_rows . " Record";
		}
		else{
			echo $num_rows . " Records";
		}
		?>
            </tr></tfoot>
          </table>

		<h2 class="ui dividing header">Unassigned Boards</h2>
		<table class="ui sortable celled table">
			<thead>
				<tr>
					<th>MAC Address</th>
					<th>Last Used</th>
					<th>Test Amount</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$unused_sql = "SELECT DISTINCT test_logs.board_id FROM test_logs LEFT JOIN engineer_assignment ON test_logs.board_id = engineer_assignment.board_id WHERE engineer_assignment.engineer_id IS NULL";
				$unused_result = $conn->query($unused_sql);
				$unused_amount = $unused_result->num_rows;
				if ($unused_amount == 0){
					echo "<tr><td colspan='3'>No Unassigned Boards</td></tr>";
				}
				while ($row = mysqli_fetch_assoc($unused_result)) {
					//Get the number of logs we have for the unused mac address
					$board_mac = $row["board_id"];
					$record_query = "SELECT COUNT(board_id) as record_amount, MAX(timestamp) as latest_record FROM test_logs WHERE board_id = '" . $board_mac . "'";
					$record_result = $conn->query($record_query);
					$record_row = mysqli_fetch_row($record_result);
					$amount_of_records = $record_row[0];
					$latest_record_timestamp = $record_row[1];
					$latest_record_day = date('d-M-Y', $latest_record_timestamp);
					$latest_record_time = date('H:i', $latest_record_timestamp);
					echo "<tr>";
					echo "<td>" . $board_mac . "</td>";
					echo "<td>" . $latest_record_day . " at " . $latest_record_time . "</td>";
					echo "<td>" . $amount_of_records . "</td>";
					echo "</tr>";
				}
				?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="3">
					<?php
					if ($unused_amount == 1){
						echo $unused_amount . " Record";
					}
					else {
						echo $unused_amount . " Records";
					}
					?>
					</th>
				</tr>
			</tfoot>
		</table>

	</div>

      </body>


      </html>
