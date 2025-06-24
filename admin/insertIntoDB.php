<?php
include_once('connex.php');
include_once('nav.php');

echo "
<div class='toCenterForm'>
<form action='insertIntoDB.php' method='post' enctype='multipart/form-data'>
  <div class='d-flex justify-content-around align-content-center my-3 gap-3'>
    <label for='table' class='form-label d-flex align-items-center m-0 fs-5'>Table: </label>
    <select name='table' id='table' class='form-select shadow-none text-capitalize'>
      <option value=''></option>
      <option value='products'>products</option>
      <option value='categories'>Categories</option>
      <option value='brands'>brands</option>
      <option value='whoweare'>Who we are</option>
    </select>
    <input type='submit' name='submit' value='Check' class='btn btn-primary'>
  </div>


</form>
</div>
";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the 'table' value is set in the POST data
    if (isset($_POST['table'])) {
        $checkSelected = $_POST['table'];
        switch ($checkSelected) {
            case 'products':
                $table = 'products';
                header("location: insert.php?i=".$table."");
                break;
            case 'categories':
                $table = 'categories';
                header("location: insert.php?i=".$table."");
                break;
            case 'brands':
                $table = 'brands';
                header("location: insert.php?i=".$table."");
                break;
            case 'whoweare':
                $table = 'whoweare';
                header("location: insert.php?i=".$table."");
                break;
            default:
                echo "
                <div class='toCenterForm text-center'>
                <h3>No table selected!</h3>
                <a href='insertintoDB.html' class='btn btn-danger'>Back</a>
                </div>
                ";
                break;
        }
    } else {
        // Handle case where 'table' value is not set
        echo 'select table first';
    }
}

$conn->close();


include('footer.php')
?>