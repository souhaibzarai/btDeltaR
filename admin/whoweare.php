<?php 
include_once('connex.php');
include('nav.php');

echo "<h3 class='text-center my-5 text-secondary'>Content</h3>";

$table = 'whoweare';
$select = 'select * from '.$table;

$result =$conn->query($select);
echo "<div class='toCenterForm'>";
if ($result->num_rows>0) {
  echo '
  <table class="table table-dark table-bordered border-primary">
  <tr class="text-center">
    <th scope="col">Image</th>
    <th scope="col">Title</th>
    <th scope="col">subTitle</th>
    <th scope="col">Description</th>
    <th colspan=2>Action</th>
  </tr>
    ';
  while ($row= $result->fetch_assoc()) {
    $id = $row['id'];
    $title = $row['title'];
    $subT = $row['subTitle'];
    $desc = $row['description'];
    $image = $row['imageName'];

    echo '
    <tr>
    <td><img src="../uploads/'.$table.'/'.$image.'" alt="Failed to Upload" class="card-img-top object-fit-contain" height="100"></td>
    <td>'.$title.'</td>
    <td class="description">'.$subT.'</td>
    <td class="description">'.$desc.'</td>
    <td><a href="update.php?t='.$table.'&updateId='.$id.'" class="btn btn-success mx-1"><i class="fa-solid fa-pen-to-square fs-3"></i></a></td>
    <td><a href="javascript:void(0);" onclick="confirmDelete('.$id.', \''.$table.'\')" class="btn btn-outline-danger mx-1"><i class="fa-solid fa-trash-can fs-3 "></a></td>
    </tr>
    ';
  }
  echo '</table>';
}
else {
  echo '
    <span class="warningMessage bg-warning text-dark fs-4 d-flex mx-auto my-3 px-5 py-3">No '.$table.' row Found on Database</span><br>
    <div class="w-100 d-flex">
    <a href="insert.php?i=whoweare" class="Centerbutton btn btn-outline-info mb-3">Add new row to database</a>
    </div>
  ';
}
echo "</div>";

$conn->close();
include('footer.php');
?>