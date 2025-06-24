<?php
include_once('connex.php');

$id = $_GET['deleteId'];
$table = $_GET['t'];

$sql = "delete from ".$table." where id=".$id."";
$result=$conn->query($sql);

if($result !== true) {
  echo'<script>
  
  alert("Failed! Try Again");
  
  </script>';
  die("error: ".$conn_error());
}
else {
  echo'
  <script>
  alert("Record Has been deleted successfully");
  window.location.href = "'.$table.'.php";
  </script>
  ';
}
$conn->close();

exit;
?>