<?php
include_once('./userIncludes/connex.php');
include_once('./userIncludes/header.php');
$id = $_GET['productId'];
$table = 'products';
$viwesSql = 'UPDATE products SET views = views+1 where id = ?';
$view = $conn->prepare($viwesSql);
$view->bind_param('i', $id);
$view->execute();
$view->close();


$sqlProduct = 'select * from products where id ='.$id;

$result = $conn->query($sqlProduct);
$rows= $result->num_rows;
if ($rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $image = $row['ImageName'];
    $name =  $row['pdtName'];
    $qte =  $row['pdtQte'];
    $price =  $row['discountedPrice'];
    $notPrice =  $row['fakePrice'];
    $brand =  $row['pdtBrand'];
    $categ =  $row['pdtCategory'];
    $rate =  $row['pdtRate'];
    $desc =  $row['pdtDescription'];
  }
  $sqlBrnd = 'select brndName from brands where id = '.$brand;
  $resultBrnd = $conn->query($sqlBrnd);

  $sqlFromCateg = 'select * from categories where id='.$categ;
  $resultCateg = $conn->query($sqlFromCateg);
  
  if ($resultCateg === false or $resultBrnd === false) {
    die("erreur: ".$conn->error());
  }

  while ($row = $resultBrnd->fetch_assoc()) {
    $brandName = $row['brndName'];
  }
  while ($row = $resultCateg->fetch_assoc()) {
    $ctgName = $row['ctgReference'];
  }
}
echo '
</head>
<body>
<div class="container">
<p><strong>Category:</strong> '.$ctgName.'</p>
  <div class="">
    <img src="./uploads/'.$table.'/'.$image.'" height=350>
    <h2><?php echo $name; ?></h2>
    <p class="name">'.$name.'</p>
    <p class="price">'.$price.'</p>
    <p class="not-price">'.$notPrice.'</p>
    <p><strong>Brand:</strong>'.$brandName.'</p>
    <p><strong>Description:</strong>'.$desc.'</p>
    <p><strong>Rating:</strong>'.$rate.'</p>
    <!-- Add more details here if needed -->
    <p><strong>Quantity:</strong>'.$qte.'</p>
  </div>
</div>
</body>
';
$conn->close();
?>