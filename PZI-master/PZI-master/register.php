<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/bootstrap.min.css">
    <link rel="stylesheet" href="styles/style.css">
    <title>Register</title>
</head>
<body>
    <?php include("templates/header.php") ?>
    <div class="text-center" style="margin-top: 20px;">
        <div class="form"> <!-- forma za registracciju -->
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
                    <button class="btn btn-info btn-md" type="submit">Register</button>
                </div>
            </form>
        </div><!-- kraj forme za registracciju -->
    </div>
    <?php
        include "connection.php";
        $username = $_POST["username"]; //ako je register gumb stisnut spremi username u vaarijablu
        $password = $_POST["password"];//ako je register gumb stisnut spremi password u vaarijablu
        
        if (!empty($_POST)){
            $sql = "SELECT * FROM user WHERE username = '$username'"; //pogleda da li username postoji
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<center><p class='text-danger'>Username already exists<p></center>"; //ako postoji to mu ispise
            } else {
                $sqlCreate = "INSERT INTO user (username, password, type) VALUES ('$username', '$password', 'guest')"; //ako user ne postoji kreira usera
                if ($conn->query($sqlCreate) === TRUE) {
                    echo "<center><p class='text-success'>Registered succesfully<p></center>";
                  } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                  }
            }
        }
        
    ?>
</body>
</html>