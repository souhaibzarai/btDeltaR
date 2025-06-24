<?php
include_once('connex.php');
include_once('nav.php');
if (isset($_GET['updateId']) && isset($_GET['t'])) {
  $id = $_GET['updateId'];
  $table = $_GET['t'];
  $allowedTypes = array('png', 'jpeg', 'jpg', 'webp');
  $targetDir = '../uploads/'.$table.'/';
  function result($conn, $table, $id) {
    $sql = 'SELECT * FROM ' . $table . ' WHERE id=' . $id;
    $result = $conn->query($sql);
    if ($result === false) {
        die('Error: ' . $conn->error);
    }
    return $result;
  }
  echo "
  <div class='warningMessage d-flex m-auto justify-content-center fs-4 bg-info text-dark px-4'>
    <span>Liste Of ".$table." - ID: </span>
    <span class='text-danger fs-4'>".$id."</span>
  </div>
  ";

  if ($table === 'products') {
    $result = result($conn, $table, $id);
    if ($id !== false) {
      
      $sqlFromBrands = 'select * from brands';
      $resultBrand = $conn->query($sqlFromBrands);
      
      $sqlFromCateg = 'select * from categories';
      $resultCateg = $conn->query($sqlFromCateg);
      if ($resultCateg === false or $resultBrand === false) {
        die("erreur: ".$conn->error());
      }

      while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $image = $row['ImageName'];
        $name = $row['pdtName'];
        $qte = $row['pdtQte'];
        $price = $row['discountedPrice'];
        $notprice = $row['fakePrice'];
        $discount = $row['discount'];
        $brand = $row['pdtBrand'];
        $categ = $row['pdtCategory'];
        $rate = $row['pdtRate'];
        $description = $row['pdtDescription'];
        echo "
        <div class='toCenterForm mt-3 w-75'>
          <form action method='post' enctype='multipart/form-data'>
            <!-- Image -->
            <div data-mdb-input-init class='form-outline mb-4 w-100'>
              <label class='form-label' for='productImage'>Product Image</label><br>
              <img id='productImage' src='".$targetDir.$image."' alt='Product Image' width='250'/>
            </div>
        
            <!-- Text input for product name -->
            <div data-mdb-input-init class='form-outline mb-4 w-100'>
              <label class='form-label' for='productName'>Product Name</label>
              <input type='text' id='productName' class='form-control' name='pdtName' value='".$name."'/>
            </div>

            <div class='d-flex gap-2'>
              <!-- Text input for product price -->
              <div data-mdb-input-init class='form-outline mb-4 w-100'>
                <label class='form-label' for='productPrice'>Product Price</label>
                <input type='number' min='0' id='productPrice' class='form-control' name='price' value='".$notprice."'/>
              </div>
              <!-- Text input for product discount price -->
              <div data-mdb-input-init class='form-outline mb-4 w-100'>
                <label class='form-label' for='productDiscountPrice'>Product Discount</label>
                <input type='number' min='0' id='productDiscountPrice' class='form-control' name='discount' min=0 max=100 value='".$discount."'/>
              </div>
            </div>
        
            <div class='d-flex gap-2'>
              <!-- Text input for product brand -->
              <div data-mdb-input-init class='form-outline mb-4 w-100'>
                <label class='form-label' for='productBrand'>Product Brand</label>
                <select id='productBrand' class='form-control' name='brand' required>
                <option value='' selected></option>";
                while ($row = $resultBrand->fetch_assoc()) {
                    $brandId = $row['id'];
                    $brndName = $row['brndName'];
                    echo "<option value='".$brandId."'>".$brndName."</option>";
                  }
                  echo "
                </select>
              </div>
              <!-- Text input for product category -->
              <div data-mdb-input-init class='form-outline mb-4 w-100'>
                <label class='form-label' for='productCategory'>Product Category</label>
                <select id='productCategory' class='form-control' name='category' required>
                <option value='' selected></option>";
                while ($row = $resultCateg->fetch_assoc()) {
                  $ctgId = $row['id'];
                  $ctgRef = $row['ctgReference'];
                  echo "<option value='".$ctgId."'>".$ctgRef."</option>";
                }
                echo"
                </select>
              </div>
            </div>
            <div class='d-flex gap-2'>
              <!-- Text input for product quantity -->
              <div data-mdb-input-init class='form-outline mb-4 w-100'>
                <label class='form-label' for='productQuantity'>Product Quantity</label>
                <input type='number' min='0' id='productQuantity' class='form-control' name='qte' value='".$qte."'/>
              </div>
              <!-- Text input for product rate -->
              <div data-mdb-input-init class='form-outline mb-4 w-100'>
              <label class='form-label' for='productRate'>Product Rate</label>
                <input type='number' id='productRate' class='form-control' name='rate' min='0' max='5' value='".$rate."'/>
              </div>
            </div>
            
        
            <!-- Text input for product description -->
            <div data-mdb-input-init class='form-outline mb-4 w-100'>
              <label class='form-label' for='productDescription'>Product Description</label>
              <textarea class='form-control' name='description' id='productDescription' rows='5'/>".$description."</textarea>
            </div>
        
            <!-- Submit button -->
            <input type='submit' name='submit' value='Update Product' class='btn btn-primary btn-block mb-4'>

          </form>
        
        </div>";
      }
      if (isset($_POST['submit'])) {
        $name = $_POST['pdtName'];
        $qte = $_POST['qte'];
        $price = $_POST['price'];
        $discount = $_POST['discount'];
        $brand = $_POST['brand'];
        $categ = $_POST['category'];
        $rate = $_POST['rate'];
        $desc = $_POST['description'];

        $sqlUpd = 'UPDATE products SET  pdtName= ?, pdtQte= ?, fakePrice= ?, discount= ?, pdtBrand= ?, pdtCategory= ?, pdtRate= ?, pdtDescription= ? WHERE id = ?';

        $stmt = $conn->prepare($sqlUpd);
        $stmt->bind_param('sssssssss', $name, $qte, $price, $discount, $brand, $categ, $rate, $desc, $id);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        echo '<script>
          window.location.href = "'.$table.'.php";  
          </script>';
        exit;
      }
    }
  }
  elseif ($table === 'categories') {
    $result = result($conn, $table, $id);
    if ($id !== false) {
      while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $image = $row['ImageName'];
        $ref = $row['ctgReference'];
        $desc = $row['ctgDescription'];

        echo "
        <div class='toCenterForm mt-3'>
          <form action method='post' enctype='multipart/form-data'>
            <!-- Image input -->
            <div data-mdb-input-init class='form-outline mb-4 w-100'>
                <img id='categoryImage' src='".$targetDir.$image."' alt='Product Image' width='250'>
            </div>

            <!-- Text input for category reference -->
            <div data-mdb-input-init class='form-outline mb-4 w-100'>
                <label class='form-label' for='ctgReference'>Category Reference</label>
                <input type='text' id='ctgReference' class='form-control' name='reference' value='".$ref."'/>
            </div>

            <!-- Text input for category description -->
            <div data-mdb-input-init class='form-outline mb-4 w-100'>
                <label class='form-label' for='ctgDescription'>Category Description</label>
                <textarea class='form-control' name='description' id='ctgDescription' rows='5'>".$desc."</textarea>    
            </div>

            <!-- Submit button -->
            <input type='submit' name='submit' value='Update Category' class='btn btn-primary btn-block   mb-4'>
          </form>
        </div>";    
      }
      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $ref= $_POST['reference'];
        $desc= $_POST['description'];

        $sqlUpd = 'UPDATE categories SET ctgReference= ?, ctgDescription= ? WHERE id = ?';
        $stmt = $conn->prepare($sqlUpd);
        $stmt->bind_param('sss', $ref, $desc, $id);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        echo '<script>  window.location.href = "'.$table.'.php";  </script>';
        exit;
      }
    }
  }
  elseif ($table === 'brands') {
    $result = result($conn, $table, $id);
    if ($id !== false) {
      
      while ($row = $result->fetch_assoc()) {
        $image = $row['ImageName'];
        $name = $row['brndName'];
        $desc = $row['brndDescription'];

        echo "
          <div class='toCenterForm mt-3'>
            <form action method='post'>
              <!-- Image input for brand -->
              <div data-mdb-input-init class='form-outline mb-4 w-100'>
                <img src='".$targetDir.$image."' width='250' id='brandImage'>
              </div>
          
              <!-- Text input for brand name -->
              <div data-mdb-input-init class='form-outline mb-4 w-100'>
                <label class='form-label' for='brandName'>Brand Name</label>
                <input type='text' id='brandName' class='form-control' name='name' value='".$name."'/>
              </div>
          
              <!-- Textarea input for brand description -->
              <div data-mdb-input-init class='form-outline mb-4 w-100'>
                <label class='form-label' for='brandDescription'>Brand Description</label>
                <textarea id='brandDescription' class='form-control' name='desc' rows='5'>".$desc."</textarea>
              </div>
          
              <!-- Submit button -->
              <input type='submit' name='submit' value='Update Brand' class='btn btn-primary btn-block mb-4'>
            </form>
          </div>
        ";
      }

      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $name = $_POST['name'];
        $desc = $_POST['desc'];

        $sqlUpd = 'UPDATE '.$table.' SET brndName = ?, brndDescription = ? WHERE id = ?';
        $stmt = $conn->prepare($sqlUpd);
        $stmt->bind_param('sss', $name, $desc, $id);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        echo '
        <script>
          window.location.href = "'.$table.'.php";
        </script>
        ';
        exit;
      }
    }
  }
  elseif ($table === 'whoweare') {
    $result = result($conn, $table, $id);
    if ($id !== false) {
      while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $title = $row['title'];
        $subT = $row['subTitle'];
        $desc = $row['description'];
        $image = $row['imageName'];

        echo"
          <div class='toCenterForm mt-3'>
            <form action method='post' enctype='multipart/form-data'>
              <div data-mdb-input-init class='form-outline mb-4 w-100'>
                <img src='".$targetDir.$image."' width='250' id='brandImage'>
              </div>
            
              <!-- title input -->
              <div data-mdb-input-init class='form-outline mb-4 w-100'>
                <label class='form-label' for='title'>about website Title</label>
                <input type='text' id='title' class='form-control' name='title' value='".$title."'/>
              </div>
              <!-- subtitle input -->
              <div data-mdb-input-init class='form-outline mb-4 w-100'>
                <label class='form-label' for='subtitle'>about website subtitle</label>
                <input type='text' id='subtitle' class='form-control' name='subtitle' value='".$subT."'/>
              </div>

              <!-- Textarea input for website description -->
              <div data-mdb-input-init class='form-outline mb-4 w-100'>
                <label class='form-label' for='websiteDescription'>Website Description</label>
                <textarea id='websiteDescription' class='form-control' name='description' rows='5'>".$desc."</textarea>
              </div>
              <!-- Image input for website about -->
              <div data-mdb-input-init class='form-outline mb-4 w-100'>
                <label class='form-label' for='webImage'>Website Image</label>
                <input type='file' id='webImage' class='form-control' name='image'/>
              </div>

              <!-- Submit button -->
              <input type='submit' name='submit' value='Update Content' class='btn btn-primary btn-block mb-4'>
            </form>
          </div>
        ";
      }
      if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $title = $_POST['title'];
        $sub = $_POST['subtitle'];
        $description = $_POST['description'];
        if (!empty($_FILES['image']['name'])) {
          $fileName = basename($_FILES['image']['name']);
          $targetFilePath = $targetDir.$fileName;
          $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
          if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
              $sql = 'UPDATE whoweare SET imageName= ?, title=?, subTitle= ?, description= ? where id= ?';
              $stmt=$conn->prepare($sql);
              $stmt->bind_param('ssssi', $fileName, $title, $sub, $description, $id);
              if ($stmt->execute()) {
                echo '<script>
                  alert("Successfully");
                </script>';
              }
              $stmt->close();
              $conn->close();
            }
          }
        }            
        echo'
          <script>
            window.location.href = "'.$table.'.php";
          </script>
          ';
        exit;
      }
      else if (isset($_POST['submit'])) {
        
        @$title = $_POST['title'];
        @$sub = $_POST['subtitle'];
        @$description = $_POST['description'];
        $sql = 'UPDATE whoweare SET title=?, subTitle= ?, description= ? where id=?';
        $stmt=$conn->prepare($sql);
        $stmt->bind_param('ssss', $title, $sub, $description, $id);
        if ($stmt->execute()) {
          echo '<script>
            alert("Successfully");
          </script>';
        }
        $stmt->close();
        $conn->close();
        echo'
          <script>
            window.location.href = "'.$table.'.php";
          </script>
          ';
        exit;
      }

    }
  }
  else {
    echo'
      <div class="toCenterForm d-flex align-items-center w-75">
        <h3 class="warningMessage bg-warning text-dark px-5 py-3 fs-3 align-items-center">Error, No Table with name '.$table.' Has been Founded in Database.</h3>
      </div>
    ';
  }
  $conn->close();

  include_once('footer.php');
}
else {
  echo '
    <script>
      alert("Error: Required parameters missing for update.");
      window.location.href = "index.php";
    </script>
  ';
}
?>