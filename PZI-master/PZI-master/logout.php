<?php 
//stranica odjave
  session_start(); 
  session_destroy(); //znaci da sve podatke o prijavi izbrise i tako je user odjavljen 
  header("location: index.php");
?>
