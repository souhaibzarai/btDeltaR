<?php
include_once('connex.php');
include_once('nav.php');

$condition = $_GET['cond'];
echo "<h3 class='text-center text-secondary my-4 text-capitalize'>Products Almost Finished</h3>";
if ($condition === 'qte') {
  $qte = $_GET['value'];
  $sql = 'SELECT * FROM products where pdtQte <'.$qte;
  $result = $conn->query($sql);
  if ($result === false) {
    die('error: '.$conn->error());
  }

  $rows=$result->num_rows;
  if ($rows>0) {
    echo '
    <div class="d-grid gap-0 w-75 m-auto">
      <div class="pdt d-flex justify-content-between align-items-center w-100 text-left p-2">
          <span class="d-flex justify-content-center w-25">Id</span>
          <span class="d-flex justify-content-center w-25">Name</span>
          <span class="d-flex justify-content-center w-25">Quantity</span>
          <span class="opacity-0">Action Here</span>
      </div>
    ';
    while ($row=$result->fetch_assoc()) {
        $id =$row['id'];
        $name =$row['pdtName'];
        $qte =$row['pdtQte'];
        $image = $row['ImageName'];
        echo'
        <div class="pdt d-flex justify-content-between align-items-center w-100 text-center px-2">
          <span class="d-flex justify-content-center w-25">'.$id.'</span>
          <span class="d-flex justify-content-center w-25">'.$name.'</span>
          <span class="d-flex justify-content-center w-25">'.$qte.'</span>
          <a href="update.php?t=products&updateId='.$id.'" class="btn outline-0 text-primary">Update</a>
        </div>
    ';
    }
  }
}






include_once('footer.php');
$conn->close();
?>