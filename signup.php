<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful. You can now <a href='login.php'>login</a>.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8" />
    <title>Sign Up</title>
    <link rel="stylesheet" href="style-form.css" />
  </head>
  <body>
    <div class="center">
      <h1>signup</h1>
      <form method="post">
        <div class="txt_field">
          <input type="text" required />
          <span></span>
          <label>Username</label>
        </div>
        <div class="txt_field">
          <input type="text" required />
          <span></span>
          <label>Email</label>
        </div>
        <div class="txt_field">
          <input type="password" required />
          <span></span>
          <label>Password</label>
        </div>
        <input type="submit" value="signup" />
        <div class="bottom-form"><a href="">Login</a></div>
      </form>
    </div>
  </body>
</html>

