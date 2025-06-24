<?php
session_start();
if (!isset($_SESSION['username'])) {
  echo '
  <script>
    alert("You Are Not Connected To Log Out");
    window.location.href = "login.php";
  </script>';
}
else {
  session_destroy();
  header('location: login.php');
}
exit();
?>