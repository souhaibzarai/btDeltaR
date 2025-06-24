<?php
include_once('./userIncludes/connex.php');
include_once('./userIncludes/header.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $searchTerm = $_POST['search'];

    $sql = "SELECT * FROM products WHERE pdtName LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchParam = "%{$searchTerm}%"; // Add wildcards to search for partial matches
    $stmt->bind_param("s", $searchParam);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<div class='fullcontent py-5'>";
    if ($result->num_rows > 0) {
        echo '
        <div class="d-flex justify-content-center text-center"><h3>Search Results for: <br><span class="text-info">'.$searchTerm.'</span></h3></div><br>
        ';

        echo "<div class='products d-grid'>";
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $image = $row['ImageName'];
            $name = $row['pdtName'];
            $price = $row['fakePrice'];
            $notPrice = $row['discountedPrice'];
            $brand = $row['pdtBrand'];
            $rate = $row['pdtRate'];

            echo "
                <div class='product m-1'>
                    <a href='./product.php?productId=".$id."'>
                        <img src='./uploads/products/".$image."' alt='product' class='productImg productsizing'>
                        <div class='productCardDesc'>
                            <h3 class='productTitle'>$name</h3>
                            <div class='rating'>
                                <span class='rate'>$rate <span class='countRate'>(483)</span></span>
                            </div>
                            <div class='pricePlace'>
                                <span class='price'>MAD $price</span>
                                <span class='notprice'>MAD $notPrice</span>
                            </div>
                            <div class='brand'>
                                <span>$brand</span>
                            </div>
                        </div>
                        <div class='button'>  
                            <a href='wishlist.php?id=".$id."'><img src='Icons/wishlist.svg' alt='Add to Wishlist'></a>
                        </div>
                    </a>
                </div>
            ";
        }
        echo "</div>"; // products close
    } else {
        echo '<div class="warningMessage bg-danger text-capitalize px-3 py-2 w-100">No Products Found matching your search.</div>';
    }
    echo "</div>"; // fullcontent close

    $stmt->close();
} else {
    header("Location: products.php"); // Redirect if accessed without a search term
    exit();
}

include_once('./userIncludes/footer.php'); // Include footer after content
$conn->close();
?>
