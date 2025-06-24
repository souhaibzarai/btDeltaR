<?php 
include_once('connex.php');
include('nav.php');
$table = "categories";
$sql = "select * from ".$table."";
$result = $conn->query($sql);
if ($result === false) {
  die("error: ".$conn->error());
}
echo "<h3 class='text-center text-secondary my-4 text-capitalize'>".$table."</h3>";

echo "<div class='toCenterForm'>";
if ($result ->num_rows>0) {
  echo "
  <div class='d-flex justify-content-between mb-3'>
    <div>
      <a href='insert.php?i=".$table."' class='btn btn-outline-primary'>Add New ".$table."</a>
    </div>
    <div class=''>
      <input id='searchInput' class='form-control text-primary' type='search' placeholder='Search' aria-label='Search'>
    </div>
    <div class='d-flex justify-content-start'>
      <select id='rowCount' class='form-select text-primary bg-dark border-primary'>
        <option value='10'>10</option>
        <option value='20'>20</option>
        <option value='50'>50</option>
        <option value='100'>100</option>
      </select>
    </div>
    <div class='d-flex justify-content-between gap-1'>
      <button id='prevButton' class='btn btn-outline-primary'>Previous</button>
      <button id='nextButton' class='btn btn-outline-primary'>Next</button>
    </div>
  </div>
  <table id='dataTable' class='table table-dark table-bordered border-primary'>
  <thead>
      <tr class='text-center'>
        <th scope='col'></th>
        <th scope='col'>Image</th>
        <th scope='col'>Name</th>
        <th scope='col'>Description</th>
        <th scope='col' colspan=2>Button</th>
      <tr>
    </thead>
    <tbody>
  ";
  while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $image = $row['ImageName'];
    $ref = $row['ctgReference'];
    $desc = $row['ctgDescription'];

    if ($id % 2 == 0) {
      $color = 'warning';
    }
    else {
      $color = 'info';
    }
    echo "
    <tr>

    <td class='text-".$color." fw-bold id'>".$id."</td>
    <td><img class='card-img-top object-fit-contain' height='' src='../uploads/".$table."/".$image."' alt='Failed to Upload'</td>
    <td class='name'>".$ref."</td>
    <td class='description'>".$desc."</td>
    <td><a href='update.php?t=".$table."&updateId=".$id."' class='btn btn-success mx-1'><i class='fa-solid fa-pen-to-square fs-3'></i></a></td>
    <td><a href='javascript:void(0);' onclick='confirmDelete(".$id.", \"".$table."\")' class='btn btn-outline-danger mx-1'><i class='fa-solid fa-trash-can fs-3'></a></td>
    </tr>
    ";
  }
  echo "
    </tbody>
  </table>";
}
else  {
  echo '<span class="warningMessage bg-warning text-dark fs-4 d-flex mx-auto my-3 px-5 py-3">No '.$table.' Found on Database</span>';
}
echo "</div>";




$conn->close();
include('footer.php');
?>