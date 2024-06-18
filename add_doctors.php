<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];

    $sql = "INSERT INTO doctors (name, specialization) VALUES ('$name', '$specialization')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New doctor added successfully";
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
    <title>Add Doctor</title>
    <link rel="stylesheet" href="style-form.css" />
  </head>
  <body>
    <div class="center">
      <h1>Add New Doctor</h1>
      <form method="post" action="">
        <div class="txt_field">
          <input type="text" name="name" required />
          <span></span>
          <label>Name</label>
        </div>
        <div class="txt_field">
          <input type="text" name="specialization" required />
          <span></span>
          <label>Specialization</label>
        </div>
        <input type="submit" value="Add Doctor" />
        <div class="bottom-form"></div>
      </form>
    </div>
  </body>
</html>
