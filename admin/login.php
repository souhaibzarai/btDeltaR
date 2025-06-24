<?php
session_start();
if (isset($_SESSION['username'])) {
  header('location: index.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BtDeltaR - Sign In</title>
  <link rel="stylesheet" href="admin-style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-dark text-white">
<style>
  div.contain {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
</style>
<div class="contain d-grid justify-content-center content-center text-center gap-4 p-5 border border-danger-subtle rounded">
  <h2 class="fs-4 fw-normal">Sign In{'admin':'admin'}</h2>
  <form method="post" class="">
    <div class="d-grid gap-3">
      <div class="inputs d-grid gap-2">
        <input class="bg-transparent border-primary text-white rounded-1 rounded-top-4 px-2" type="text" name="username" placeholder="Username">
        <input class="bg-transparent border-primary text-white rounded-1 rounded-top-4 px-2" type="password" name="password" placeholder="Password" id="password">
        <div class="d-flex gap-2">
          <input type="checkbox" name="showPsw" id="showPsw" class="form-check-input my-auto bg-primary border-0 p-2">
          <label for="showPsw">Show Password</label>
        </div>
      </div>
      <div class="">
        <input type="submit" name="submit" class="btn btn-outline-primary px-3 py-1" value="Sign In">
      </div>
    </div>
  </form>
</div>
<script>
  let showPswBtn = document.getElementById('showPsw');
  let passwordInput = document.getElementById('password');
  showPswBtn.addEventListener('click', function() {
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
    } else {
      passwordInput.type = 'password';
    }
  });
</script>


<?php
require_once 'connex.php';
if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $sql = "SELECT * FROM users WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $storedPassword = $row['password'];
    if (password_verify($password, $storedPassword)) {
      $_SESSION['username'] = $row['username'];
      $_SESSION['name'] = $row['name'];
      $_SESSION['type'] = $row['type'];
      header("Location: index.php");
      exit();
    }
    else {
      $ShowMessage = "Password Incorrect";
    }
  } 
  else {
    $ShowMessage = "Username Invalid";
  }
  echo '
  <script>
    alert("'.$ShowMessage.'");
  </script>';
}
include('footer.php');
?>