<?php 
  
  session_start(); //ovo ima u vecini fajlova i samo oznacava da uzme tu varijablu session i da moze vidjeti jeli neko logiran (globalna varijabla)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/bootstrap.min.css">
    <link rel="stylesheet" href="styles/style.css">
    <title>Log in</title>
</head>
<body>
    <?php include("templates/header.php") ?>
    <div class="text-center" style="margin-top: 20px;">
        <div class="form"> <!-- ovo je forma za logiranje --> 
            <form method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input class="form-control" type="text" name="username" id="username" minlength="5">
                </div>
                <div class="form-group">
                    <label for="username">Password</label>
                    <input class="form-control" type="password" name="password" id="password" minlength="8">
                </div>
                <div class="form-group">
                    <button class="btn btn-info btn-md" type="submit">Log in</button>
                </div>
            </form><!-- zavrsetak forme za logiranje -->
        </div>
    </div>
    <?php
        include "connection.php";
        $username = $_POST["username"]; //kad user klikne button za logiranje uzima iz forme username i sprema u varijablu
        $password = $_POST["password"]; //isto tako za password
        
        if (!empty($_POST)){
            $sql = "SELECT * FROM user WHERE username = '$username'"; //pogleda jel postoji taj user
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                if($row["password"] == $password) { //ako postoji pogleda jel password dobar
                  $_SESSION['username'] = $row["username"]; //onda u sessiju spremi podatke o useru, i tako da svaki fajl zna da je user logiran
                  $_SESSION['type'] = $row["type"];
                  $_SESSION['id'] = $row["id"];
                  header("location: index.php"); //posalje usera na glavnu stranicu
                } else {
                  echo "<center><p class='text-danger'>Wrong password<p></center>"; //ako je kriva lozinka samo prikaze da je kriva
                }
              }
            } else {
                echo "<center><p class='text-danger'>User does not exist please register<p></center>"; //ako user ne postoji samo mu prikaze tekst da se registriraa
            }
        }
        
    ?>
</body>
</html>
