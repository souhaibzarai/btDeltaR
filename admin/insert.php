<?php
include_once('connex.php');
include_once('nav.php');
// get table from link!
$table = $_GET['i'];
$targetDir = '../uploads/'.$table.'/';
$allowedTypes = array('png', 'jpeg', 'jpg', 'webp');

// for table products
if ($table === 'products') {
  $sqlFromBrands = 'select * from brands';
  $resultBrand = $conn->query($sqlFromBrands);
  
  $sqlFromCateg = 'select * from categories';
  $resultCateg = $conn->query($sqlFromCateg);
  
  if ($resultCateg === false or $resultBrand === false) {
    die("erreur: ".$conn->error());
  }
  
  echo "
  <div class='toCenterForm mt-3 w-75'>
  <form action method='post' enctype='multipart/form-data'>
    <div class='d-flex gap-2'>
      <!-- Image input -->
      <div data-mdb-input-init class='form-outline mb-4 w-100'>
        <label class='form-label' for='productImage'>Product Image</label>
        <input type='file' id='productImage' class='form-control' name='image'/>
      </div>
      <!-- Text input for product name -->
      <div data-mdb-input-init class='form-outline mb-4 w-100'>
        <label class='form-label' for='productName'>Product Name</label>
        <input type='text' id='productName' class='form-control' name='pdtName'/>
      </div>
    </div>

    <div class='d-flex gap-2'>
      <!-- Text input for product price -->
      <div data-mdb-input-init class='form-outline mb-4 w-100'>
        <label class='form-label' for='productPrice'>Product Price</label>
        <input type='number' min='0' id='productPrice' class='form-control' name='price'/>
      </div>

      <!-- Text input for product discount price -->
      <div data-mdb-input-init class='form-outline mb-4 w-100'>
        <label class='form-label' for='productDiscountPrice'>Product Discount Price</label>
        <input type='number' min='0' id='productDiscountPrice' class='form-control' name='notPrice'/>
      </div>
    </div>

    <div class='d-flex gap-2'>
      <!-- Text input for product brand -->
      <div data-mdb-input-init class='form-outline mb-4 w-100'>
        <label class='form-label' for='productBrand'>Product Brand</label>
        <select id='productBrand' class='form-control' name='brand'>
        <option value='' disabled></option>";
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
        <select id='productCategory' class='form-control' name='category'>
        <option value='' disabled></option>";
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
        <input type='number' min='0' id='productQuantity' class='form-control' name='qte'/>
      </div>
      <!-- Text input for product rate -->
      <div data-mdb-input-init class='form-outline mb-4 w-100'>
      <label class='form-label' for='productRate'>Product Rate</label>
        <input type='number' id='productRate' class='form-control' name='rate' min='0' max='5'/>
      </div>
    </div>

    <!-- Text input for product description -->
    <div data-mdb-input-init class='form-outline mb-4'>
      <label class='form-label' for='productDescription'>Product Description</label>
      <textarea class='form-control' name='description' id='productDescription' rows='5'></textarea>
    </div>

    <!-- Submit button -->
    <input type='submit' name='submit' value='Add new Product' class='btn btn-primary btn-block mb-4'>
  </form>

  </div>";
      
  if (isset($_POST['submit'])) {
    $name = $_POST['pdtName'];
    $qte = $_POST['qte'];
    $price = $_POST['price'];
    $notPrice = $_POST['notPrice'];
    $brand = $_POST['brand'];
    $category = $_POST['category'];
    $rate = $_POST['rate'];
    $description = $_POST['description'];
   
    if (!empty($_FILES['image']['name'])) {
      $fileName = basename($_FILES['image']['name']);
      $targetFilePath = $targetDir.$fileName;
      $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
      if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
          $sql = 'INSERT INTO products(ImageName,	pdtName,	pdtQte,	fakePrice,	discountedPrice,	pdtBrand,	pdtCategory,	pdtRate,	pdtDescription) VALUES(?,?,?,?,?,?,?,?,?)';

          $stmt = $conn->prepare($sql);
          $stmt->bind_param('sssssssss',	$fileName,	$name,	$qte,	$price,	$notPrice,	$brand,	$category, $rate,	$description);
          if ($stmt->execute()) {
            echo '
            <script>
              window.location.href = "'.$table.'.php";
            </script>';
          } 
          else {
            $showAllert = 'Sorry, Error while uploading images to Database';
          }
        }
        else {
          $showAllert = 'Error, image couldn`t upload';
        }
      }
      else {
        $showAllert = 'This Type '.$fileType.' is not allowed';
      }
    }
    else {
      $showAllert = 'Please Select File to upload';
    }
    echo '<script>
    alert("'.$showAllert.'");
    </script>';
  }
}
// insert for table categories
elseif ($table === 'categories') {
  echo "
  <div class='toCenterForm mt-3 w-75'>
    <form action method='post' enctype='multipart/form-data'>
      <!-- Image input -->
      <div class='d-flex gap-2'>
        <div data-mdb-input-init class='form-outline mb-4 w-100'>
          <label class='form-label' for='categoryImage'>Category Image</label>
          <input type='file' id='categoryImage' class='form-control' name='image'/>
        </div>
    
        <!-- Text input for category reference -->
        <div data-mdb-input-init class='form-outline mb-4 w-100'>
          <label class='form-label' for='ctgReference'>Category Reference</label>
          <input type='text' id='ctgReference' class='form-control' name='reference'/>
        </div>
      </div>

  
      <!-- Text input for category description -->
      <div data-mdb-input-init class='form-outline mb-4'>
        <label class='form-label' for='ctgDescription'>Category Description</label>
        <textarea class='form-control' name='description' id='ctgDescription' rows='5'></textarea>    
      </div>
  
      <!-- Submit button -->
      <input type='submit' name='submit' value='Add new Category' class='btn btn-primary btn-block mb-4'>
    </form>
  </div>";
  
  
  if (isset($_POST['submit'])) {
    $ref = $_POST['reference'];
    $description = $_POST['description'];
    if (!empty($_FILES['image']['name'])) {
      $fileName = basename($_FILES['image']['name']);
      $targetFilePath = $targetDir.$fileName;
      $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
      if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
          $sql = 'INSERT INTO categories(ImageName,	ctgReference,	ctgDescription) VALUES(?,?,?)';
          $stmt = $conn->prepare($sql);
          $stmt->bind_param('sss', $fileName, $ref, $description);
          if ($stmt->execute()) {
            echo '
            <script>
              window.location.href = "'.$table.'.php";
            </script>';
          } 
          else {
            $showAllert = 'Sorry, Error while uploading images to Database';
          }
        }
        else {
          $showAllert = 'Error, image couldn`t upload';
        }
      }
      else {
        $showAllert = 'This Type '.$fileType.' is not allowed';
      }
    }
    else {
      $showAllert = 'Please Select File to upload';
    }
    echo '<script>
    alert("'.$showAllert.'");
    </script>';
  }
}
// insert for table brands
elseif ($table === 'brands') {
  echo "
  <div class='toCenterForm mt-3  w-75'>
    <form action method='post' enctype='multipart/form-data'>
      <!-- Image input for brand -->
      <div class='d-flex gap-2'>
        <div data-mdb-input-init class='form-outline mb-4 w-100'>
          <label class='form-label' for='brandImage'>Brand Image</label>
          <input type='file' id='brandImage' class='form-control' name='image'/>
        </div>
    
        <!-- Text input for brand name -->
        <div data-mdb-input-init class='form-outline mb-4 w-100'>
          <label class='form-label' for='brandName'>Brand Name</label>
          <input type='text' id='brandName' class='form-control' name='name'/>
        </div>
      </div>
  
      <!-- Textarea input for brand description -->
      <div data-mdb-input-init class='form-outline mb-4'>
        <label class='form-label' for='brandDescription'>Brand Description</label>
        <textarea id='brandDescription' class='form-control' name='description' rows='5'></textarea>
      </div>
  
      <!-- Submit button -->
      <input type='submit' name='submit' value='Add new Brand' class='btn btn-primary btn-block mb-4'>
    </form>
  </div>";
  
  if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    if (!empty($_FILES['image']['name'])) {
      $fileName = basename($_FILES['image']['name']);
      $targetFilePath = $targetDir.$fileName;
      $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
      if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
          $sql = 'INSERT INTO brands(ImageName,	brndName,	brndDescription) VALUES(?,?,?)';
          $stmt = $conn->prepare($sql);
          $stmt->bind_param('sss', $fileName, $name, $description);
          if ($stmt->execute()) {
            echo '
            <script>
              window.location.href = "'.$table.'.php";
            </script>';
          } 
          else {
            $showAllert = 'Sorry, Error while uploading images to Database';
          }
        }
        else {
          $showAllert = 'Error, image couldn`t upload';
        }
      }
      else {
        $showAllert = 'This Type '.$fileType.' is not allowed';
      }
    }
    else {
      $showAllert = 'Please Select File to upload';
    }
    echo '<script>
    alert("'.$showAllert.'");
    </script>';
  }
}
// insert for table brands
elseif ($table === 'whoweare') {
  $sqlSlct = 'select * from '.$table;
  $resultSlct = $conn->query($sqlSlct);
  if ($resultSlct->num_rows>=1) {
    echo'
      <script>
      alert("Table able to accept only one row You may go update current row available");
      window.location.href = "whoweare.php";
      </script>
      ';
  }
  else {
    echo"
    <div class='toCenterForm mt-3 w-75'>
      <form action method='post' enctype='multipart/form-data'>
        
    
        <!-- title input -->
        <div data-mdb-input-init class='form-outline mb-4'>
          <label class='form-label' for='title'>about website Title</label>
          <input type='text' id='title' class='form-control' name='title'/>
        </div>
        <!-- subtitle input -->
        <div data-mdb-input-init class='form-outline mb-4'>
          <label class='form-label' for='subtitle'>about website subtitle</label>
          <input type='text' id='subtitle' class='form-control' name='subtitle'/>
        </div>
    
        <!-- Textarea input for website description -->
        <div data-mdb-input-init class='form-outline mb-4'>
          <label class='form-label' for='websiteDescription'>Website Description</label>
          <textarea id='websiteDescription' class='form-control' name='description' rows='5'></textarea>
        </div>
    
    
        <!-- Image input for website about -->
        <div data-mdb-input-init class='form-outline mb-4'>
          <label class='form-label' for='webImage'>Website Image</label>
          <input type='file' id='webImage' class='form-control' name='image'/>
        </div>
    
        <!-- Submit button -->
        <input type='submit' name='submit' value='Upload Content' class='btn btn-primary btn-block mb-4'>
      </form>
    </div>";


    $showAllert = '';
    if (isset($_POST['submit'])) {
      $title = $_POST['title'];
      $sub = $_POST['subtitle'];
      $description = $_POST['description'];
      if (!empty($_FILES['image']['name'])) {
        $fileName = basename($_FILES['image']['name']);
        $targetFilePath = $targetDir.$fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        if (in_array($fileType, $allowedTypes)) {
          if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            $sql = 'INSERT INTO whoweare(imageName, title, subTitle, description) VALUES (?, ?, ?, ?)';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $fileName, $title, $sub, $description);

            if ($stmt->execute()) {
              echo '
              <script>
                window.location.href = "'.$table.'.php";
              </script>';
            } 
            else {
              $showAllert = 'Sorry, Error while uploading images to Database';
            }
          }
          else {
            $showAllert = 'Error, image couldn`t upload';
          }
        }
        else {
          $showAllert = 'This Type '.$fileType.' is not allowed';
        }
      }
      else {
        $showAllert = 'Please Select File to upload';
      }
      echo '<script>
      alert("'.$showAllert.'");
      </script>';
    }
  }
}
// error in case table error
else {
  echo '
    <script>
      alert("This table '.$table.' does not exist");
      window.location.href = "./insertIntoDB.php";
    </script>
  ';
}







$conn->close();
include_once('footer.php');
?>