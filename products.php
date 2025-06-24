<?php 
include_once('./userIncludes/connex.php');
include_once('./userIncludes/header.php');

  echo "<div class='fullcontent py-5'>";
  
  
echo "
  <div class='d-grid justify-content-center m-4 mt-0 gap-2 text-center'>
    <div><h3>Filtering by Category:</h3></div>
    <form action='filtered_products.php' method='post' class='d-flex justify-content-between gap-3 align-center fw-light'>
    ";
    $sqlCateg = 'select * from categories';
    $resultCateg = $conn->query($sqlCateg);
      if ($resultCateg->num_rows > 0) {
        echo "
        <select name='category' id='category' class='px-5 py-2 bg-success text-white fw-normal rounded'>";
        while ($row = $resultCateg->fetch_assoc()) {
          $ctgId = $row['id'];
          $ctgName = $row['ctgReference'];
          
          echo "
            <option value='".$ctgId."' class='p-3 color-warning fw-normal rounded'>".$ctgName."</option>
            ";
          }
          echo "</select>";
      }
      echo"
      <input type='submit' value='Search' class='px-2 btn btn-success'>
    </form>

  </div>
";


  $table = 'products';
  $sql = 'select * from '.$table;
  $result = $conn->query($sql);
  if ($result === false) {
    die('error: '.$conn->error());
  }
  if ($result->num_rows>0) {
    echo "<div class='products d-grid'>";
    while ($row = $result->fetch_assoc()) {
      $id = $row['id'];
      $image = $row['ImageName'];
      $name = $row['pdtName'];
      $qte = $row['pdtQte'];
      $price = $row['discountedPrice'];
      $notPrice = $row['fakePrice'];
      $brand = $row['pdtBrand'];
      $categ = $row['pdtCategory'];
      $rate = $row['pdtRate'];


      $sqlBrnd = 'select brndName from brands where id = '.$brand;
      $resultBrnd = $conn->query($sqlBrnd);
      if ($resultBrnd === false) {
        die('error: '.$conn->error());
      }

      while ($roww = $resultBrnd->fetch_assoc()) {
        $brandName = $roww['brndName'];
      }

      echo "
          <div class='product m-1'>
            <a href='./product.php?productId=".$id."'>
              <img src='./uploads/".$table."/".$image."' alt='Failed to Upload' class='productImg productsizing'>
              <div class='productCardDesc'>
              <h3 class='productTitle'>".$name."</h3>
              <div class='rating'>
                <span class='rate'>".$rate."<span class='countRate'>(483)</span></span>
              </div>
              <div class='pricePlace'>
                <span class='price'>".$price." MAD </span>";
              if ($row['discount']>0) {
                echo"<span class='notprice'>".$notPrice." MAD</span>";
              }
              echo"
                </div>
              <div class='brand'>
                <span>".$brandName."</span>
              </div>
              </div>
              <div class='button'>  
                <a href='wishlist.php?id=".$id."'><img src='Icons/wishlist.svg' alt='Checkout'></a>
              </div>
            </a>
          </div>
      ";
    }
    echo "</div>"; //products close
  }
  else  {
    echo '<div class="warningMessage bg-danger text-capitalize px-3 py-2 w-100">No Product Found on database</div>';
  }
  echo "</div>"; //fullcontent close
  $conn->close();
?>