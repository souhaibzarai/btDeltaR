<?php
include_once('connex.php');
$table = "products";
$sql = 'select * from '.$table.' limit 10';
$result = $conn->query($sql);

if ($result === false) {
  die('Error: '.$conn_error);
}
if ($result->num_rows>0) {
  echo "
  <div class='productsPart'>
    <h1 class='part-title'>products</h1>
    <div class='container'>
      <div class='slide-wrapper'>
        <button id='slidePrev' class='slide-button material-symbols-outlined'>arrow_back_ios_new</button>
        <div class='products-list'>
  ";
  while($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $image = $row['ImageName'];
    $title = $row['pdtName'];
    $price = $row['fakePrice'];
    $notPrice = $row['discountedPrice'];
    $brand = $row['pdtBrand'];
    $categ = $row['pdtCategory'];
    $rate = $row['pdtRate'];
    $desc = $row['pdtDescription'];
    

    $sqlBrnd = 'select brndName from brands where id = '.$brand;
    $resultBrnd = $conn->query($sqlBrnd);
    if ($resultBrnd === false) {
      die('error: '.$conn->error());
    }

    while ($row = $resultBrnd->fetch_assoc()) {
      $brandName = $row['brndName'];
    }
    echo "
    <div class='product'>
      <a href='product.php?productId=".$id."'>
        <img src='./uploads/".$table."/".$image."' alt='product' class='productImg productsizing'>

        <div class='productCardDesc'>
        <h3 class='productTitle'>".$title."</h3>
        <div class='rating'>
          <span class='rate'>".$rate."<span class='countRate'>(483)</span></span>
        </div>
        <div class='pricePlace'>
          <span class='price'>MAD ".$price."</span>
          <span class='notprice'>".$notPrice."</span>
        </div>
        <div class='brand'>
          <span>".$brandName."</span>
        </div>
        </div>
        <div class='button'>  
          <a href='wishlist.php?addItem=".$id."'><img src='Icons/wishlist.svg' alt='Checkout'></a>
        </div>
      </a>
    </div>
    ";
  }
  echo "
      </div>
      <button id='slideNext' class='slide-button material-symbols-outlined'>arrow_forward_ios</button>
    </div>
    <div class='slider-scrollbar'>
      <div class='scrollbar-track'>
        <div class='scrollbar-thumb'>
        </div>
      </div>
    </div>
  </div>
  <a href='products.php' class='seeMore buttonSpecial'>Discover More</a>
</div>";
}
else {
  echo '<span class="warningMessage bg-warning text-dark fs-4 d-flex mx-auto my-3 px-5 py-3">No '.$table.' Found on Database</span>';
}
?>