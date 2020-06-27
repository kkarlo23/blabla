<?php
  session_start();
  if(empty($_SESSION["id"])) {
      header("location: login.php");
  }
  include "connection.php";
  $playgroundid = $_GET['id']; //dobije id terena koji je user klikno
  $userid = $_GET['user']; //user ID isto tako
  $time = $_GET['time']; //i vrijeme koje je estisno

  $sql = "INSERT INTO `appointment`( `playground_id`, `user_id`, `date`, `start`) VALUES ($playgroundid, $userid, CURDATE(), $time)"; //spremi podatke o terminu 
  if ($conn->query($sql) === TRUE) {
    header("location: appointments.php?id=$playgroundid"); //ovde samo refresha link rezervacija
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
