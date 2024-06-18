<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $sql = "INSERT INTO patients (name, email) VALUES ('$name', '$email')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New patient added successfully";
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
    <title>Add Patient</title>
    <link rel="stylesheet" href="style-form.css" />
  </head>
  <body>
    <div class="center">
      <h1>Add New Patient</h1>
      <form method="post" action="">
        <div class="txt_field">
          <input type="text" name="name" required />
          <span></span>
          <label>Name</label>
        </div>
        <div class="txt_field">
          <input type="email" name="email" required />
          <span></span>
          <label>Email</label>
        </div>
        <input type="submit" value="Add Patient" />
        <div class="bottom-form"></div>
      </form>
    </div>
  </body>
</html>
