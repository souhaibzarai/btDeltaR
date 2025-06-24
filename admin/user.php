<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User</title>
</head>
<?php
session_start();
if (!isset($_SESSION['username'])) {
  header('location: login.php');
  exit();
}
else {
echo'
<body>
  <form method="post">
    <input type="text" name="user" placeholder="Username">
    <br><br>
    <input type="password" name="pass" placeholder="Password">
    <br><br>
    <label for="type">Type of account</label>
    <select name="type" id="type">
      <option value="admin">Admin</option>
      <option value="user">user</option>
      <option value="guest">guest</option>
    </select>
    <br><br>
    <input type="submit" value="Create" name="submit">
  </form>
</body>
</html>
';

try {
  include('connex.php');
  if (isset($_POST['submit'])) {
    $username = $_POST['user'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $type = $_POST['type'];
    $sql = 'INSERT INTO users(username,password,type) values(?,?,?)';
    $stmt=$conn->prepare($sql);
    $stmt->bind_param('sss',$username,$pass,$type);

    if ($stmt->execute()) {
      echo'
      <script>
      showMessage = "This Type: --'.$type.'-- Has been Added successfully";
        alert(showMessage.ToUpperCase());
      </script>
      ';
    }
  }
} catch (\Throwable $th) {
  $th = "Duplicate entry for: [ '$username' ]";
  echo '
  <script>
    alert("'.$th.'");
  </script>
  ';
}
$conn->close();
}
?>