<?php
define('INDEX_INCLUDED', true);
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: login.php');
}
else {
$username = $_SESSION['username'];
$sql = 'SELECT * FROM users WHERE username = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 1) {
  $row = $result->fetch_assoc();
  $name = $row['name'];
  $type = $row['type'];
}
echo '
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BtDeltaR - Dashboard</title>
  <link rel="stylesheet" href="admin-style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-dark text-white">
<nav class="navbar navbar-dark bg-dark navbar-expand-lg ">
  <div class="container-fluid">
    <a class="navbar-brand text-capitalize">
      '.$name.' | '.$type.'
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mb-2 mb-lg-0 justify-content-around gap-2 m-auto">
        <li>
          <a class="nav-link active" aria-current="page" href="index.php">Index</a>
        </li>
        <li>
          <a class="nav-link active" aria-current="page" href="insertIntoDB.php">Global Insert</a>
        </li>          
        <!-- Content Management -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Content Management</a>
          <ul class="dropdown-menu dropdown-menu-dark p-2">
              <li><a class="nav-link" aria-current="page" href="whoweare.php">Who We Are</a></li>
              
          </ul>
        </li>
        <!-- Stock Management -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Stock Management</a>
          <ul class="dropdown-menu dropdown-menu-dark">
            <li><a class="nav-link active" aria-current="page" href="products.php">Products</a></li>
            <li><a class="nav-link active" aria-current="page" href="categories.php">Categories</a></li>
            <li><a class="nav-link active" aria-current="page" href="brands.php">Brands</a></li>
          </ul>
        </li>
        
        
      </ul>
      <ul class="navbar-nav mb-2 mb-lg-0 justify-content-around gap-2">
        <li class="nav-item">
          <a href="logout.php" class="btn btn-outline-danger">Sign out</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
';
}