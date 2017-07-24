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

    }

    $(document).ready(function () {
        $('.submit').click(function () {
            var nextTD = $(this).closest("td").next().text();
            $.post("delete.php", {nextTDs: nextTD}, function(result){
            });
            var prev = $(this).closest('tr').remove();

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
        var emailPrefix = "<email-prefix>";
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

  <title>Speed Test - Hyperoptic</title>
  <link rel="stylesheet" type="text/css" href="semantic/dist/semantic.min.css">

</head>
<body>

      <div class="ui grid">
        <div class="ui stacked grey eight wide column">
            <div class="img_padding">
              <img class="ui small image left floated " src="transparent_hyperoptic_logo.png"></img>
            </div>

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
        <div class="ui grid center aligned">
          <div class="seven wide column">
            <div class="ui form">
              <form name="insert"action="insert.php" method="post" onsubmit="return validateForm()">
                <div class="fields">
                  <div class="field">
                    <label>Mac Address</label>
                    <input type="text" style="text-transform:uppercase" placeholder="Mac Address" name="Mac_Address" >
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
              </form>
            </div>
          </div>
        </div>


        <div class="table-grid">
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
                <div class="ui right floated pagination menu"></div>
            </tr></tfoot>
          </table>
        </div>


      </body>


      </html>
