<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$name = 'btdeltar';

$conn = new mysqli($host, $user, $pass, $name);

if ($conn->connect_errno) {
  die("connection error: ". $conn->connect_error);
}
try {
  $price = 'update products set discountedPrice = fakePrice - (fakePrice*discount/100)';
  $result = $conn->prepare($price);
  $result->execute();
} catch (\Throwable $th) {
  throw $th;
}
?>