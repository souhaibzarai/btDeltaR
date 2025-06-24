<?php
include_once('./userIncludes/connex.php');
include_once('./userIncludes/header.php');
?>
<section class="fullcontent">
  <div class="content">

    <!-- include whoweAre Section Start -->
    <?php include_once('./userIncludes/whoweare.php'); ?>
    <!-- include whoweAre Section End -->

    <div class="separator"></div>

    <!-- Products Included from database using products.php -->
    <?php include_once('./userIncludes/productsSlide.php'); ?> 
    <!-- end Products -->

    <div class="separator"></div>


    <div class="suggestions">
        <!-- <h1 class="part-title my-2">Categories</h1> -->
        <div class="multiParts">
          <div class="part topBrand">
            <h1 class="part-title">Top Brands</h1>
            <div class="brands">
                <div class="brand">
                  <a href="#1" class="brandCard">
                    <div class="brandLogo">
                      <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/HP_logo_2012.svg/1200px-HP_logo_2012.svg.png">
                    </div>
                    <h3 class="brandName">Hp</h3>
                    <h5 class="brandRef">Hewlett Packard</h5>
                  </a>
                </div>
                <div class="brand">
                  <a href="#1" class="brandCard">
                    <div class="brandLogo">
                      <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/HP_logo_2012.svg/1200px-HP_logo_2012.svg.png">
                    </div>
                    <h3 class="brandName">Hp</h3>
                    <h5 class="brandRef">Hewlett Packard</h5>
                  </a>
                </div>
            </div>
          </div>
          <div class="line"></div>
          <div class="part bestSelling">
            <h1 class="part-title">Bestselling</h1>
            <div class="bestProducts">
              <div class="product">
                <a href="#1">
                  <img src="images/products/Computer.jpg" alt="product" class="productImg productsizing">
                  <div class="productCardDesc">
                  <h3 class="productTitle">Dell core i3-4757Q</h3>
                  </div>
                </a>
              </div>
              <div class="product">
                <a href="#1">
                  <img src="images/products/Computer.jpg" alt="product" class="productImg productsizing">
                  <div class="productCardDesc">
                  <h3 class="productTitle">Dell core i3-4757Q</h3>
                  </div>
                </a>
              </div>
            </div>
          </div>
          <div class="line"></div>
          <div class="part recentlyAdded">
            <h1 class="part-title">Recently Added</h1>
            <div class="recently">
              <div class="product">
                <a href="#1">
                  <img src="images/products/Computer.jpg" alt="product" class="productImg productsizing">
                  <div class="productCardDesc">
                  <h3 class="productTitle">Dell core i3-4757Q</h3>
                  </div>
                </a>
              </div>
              <div class="product">
                <a href="#1">
                  <img src="images/products/Computer.jpg" alt="product" class="productImg productsizing">
                  <div class="productCardDesc">
                  <h3 class="productTitle">Dell core i3-4757Q</h3>
                  </div>
                </a>
              </div>
            </div>
            <a href="#" class="text-dark">All Products</a>
          </div>
        </div>
      </div>
    </div>
    <div class="separator"></div>

    <?php include_once('./userIncludes/contact.php'); ?>

    
</section>
<?php  $conn->close(); ?>

  <?php include('./userIncludes/footer.php'); ?>