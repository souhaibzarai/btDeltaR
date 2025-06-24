<?php
include_once('./userIncludes/connex.php');
include_once('./userIncludes/header.php');
$table = 'products';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category'])) {
    $selectedCategoryId = $_POST['category'];


    $sqlCateg = 'SELECT ctgReference from categories where id='.$selectedCategoryId;
    $resultCtg = $conn->query($sqlCateg);
    while ($row = $resultCtg->fetch_assoc()) {
      $ref = $row['ctgReference'];
    }

    $sql = "SELECT * FROM products WHERE pdtCategory = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selectedCategoryId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        die('Error: '.$conn->error);
    }

    echo "<div class='fullcontent py-5'>";
    if ($result->num_rows > 0) {
        echo '
        <div class="d-flex justify-content-center text-center"><h3>All Products from Categorie:<br><span class="text-info">'.$ref.'</span></h3></div><br>
        ';
        //message showing which category is this for products selected

        

        echo "<div class='products d-grid'>";
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $image = $row['ImageName'];
            $name = $row['pdtName'];
            $qte = $row['pdtQte'];
            $price = $row['fakePrice'];
            $notPrice = $row['discountedPrice'];
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
                    <img src='./uploads/".$table."/".$image."' alt='product' class='productImg productsizing'>
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
        echo "</div>"; // products close
    } else {
        echo '<div class="warningMessage bg-danger text-capitalize px-3 py-2 w-100">No Products Found in this Category</div>';
    }
    echo "</div>"; // fullcontent close

    $conn->close();
} else {
    header("Location: products.php");
    exit();
}
?>
