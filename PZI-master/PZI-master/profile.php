<?php 
  session_start();
  if(empty($_SESSION["id"])) {
    header("location: login.php"); //ako user nije logiran posalje ga na login prozor
  }
  include "connection.php";
  $userid = $_SESSION["id"];
  $type = $_SESSION["type"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles/bootstrap.min.css">
  <link rel="stylesheet" href="styles/style.css">
  <title>Profile</title>
</head>
<body>
  <?php include("templates/header.php") ?>
  <div class="cont">
  <?php 
  if($type == 'guest') {//ako je user gost
    echo "<h3>My appointments today</h3>"; // u prijevodu (moji termini danas)
    $sql = "SELECT date, start, sport.name AS sport_name, playground.address AS playground_address
            FROM appointment
            INNER JOIN playground ON appointment.playground_id = playground.id
            INNER JOIN sport ON playground.sport_id = sport.id
            WHERE DATE(date) = CURDATE()
            AND user_id = $userid"; //pretrazi sve termine od toga usera za danasnji dan i poveze ih sa dvoranom i sportom
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        echo "Date: " . $row["date"] . ", Time: " . $row["start"] . ":00, Sport: " . $row["sport_name"] . ", Address: " . $row["playground_address"] . "<br>";
        //samo ispise u jednom redu npr: "Date 22.2, Time 12:00, Sport: Footbal, Address: Zirovic BB"
      }
    }
  } elseif ($type == 'admin') {//ako je user admin ispise tablicu svih usera i admin moze bilo kojem useru promjeniti status
    echo "<h3>Users</h3>";
    echo "<table>
            <tr>
              <td>ID</td>
              <td>Username</td>
              <td>Actions</td>
            </tr>";
    $sql = "SELECT id, username, type FROM user;";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>". $row["id"] . "</td>
                <td>". $row["username"] . "</td>";
        echo "<td>";
        if($row["username"] != 'admin'){
          if($row["type"] == 'guest') {
            echo "<a href='user.php?action=update&type=admin&id=". $row["id"] ."' class='btn btn-success btn-sm'>Set admin</a>";
          } elseif ($row["type"] == 'admin') {
            echo "<a href='user.php?action=update&type=guest&id=". $row["id"] ."' class='btn btn-warning btn-sm'>Set guest</a>";
          } 
          echo "<a href='user.php?action=delete&id=". $row["id"] ."' class='btn btn-danger btn-sm'>Delete</a>";
        }
        echo "</td>";
        echo  "</tr>";
      }
    }
    echo "</table>";
  }

  ?>

  </div>
  
</body>
</html>
