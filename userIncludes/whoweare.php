<?php 
include('connex.php');
$table = 'whoweare';
$sql = 'select * from '.$table.' limit 1';

$result = $conn->query($sql);
if ($result === false) {
  die('Die: '.connect_error());
}

if ($result->num_rows>0) {
  while ($row = $result->fetch_assoc()) {
    $title = $row['title'];
    $subT = $row['subTitle'];
    $desc = $row['description'];
    $imageDt = $row['imageName'];
    echo'
    <div class="whoweare">
      <div class="description">
        <div class="half">
          <h2>'.$title.'</h2>
          <h3>'.$subT.'</h3>
          <p>'.$desc.'</p>
        </div>
        <div class="half">
          <img src="./uploads/'.$table.'/'.$imageDt.'" height="300" class="about">
        </div>
      </div>
    </div>
    ';
  }
}
else {
  echo '<span class="warningMessage bg-warning text-dark fs-4 d-flex mx-auto my-3 px-5 py-3">No '.$table.' Found on Database</span>';
}



?>