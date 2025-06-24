<?php
include_once('connex.php');
include_once('nav.php');

$condition = 'qte';
$qte = 10;

$sqlAll = 'select * from products';
$sqlQte = 'select * from products where pdtQte <= '.$qte;

$resultAll = $conn->query($sqlAll);
$resultQte = $conn->query($sqlQte);

$totalRows = $resultAll->num_rows;
$checkQte = $resultQte->num_rows;

if ($totalRows>0) {
    $pdts = number_format(($checkQte / $totalRows) * 100,1);
    //to show only 1 number after comma
}
else {
    $pdts = 0;
}
#Color Check
    if ($pdts>50) {
        $color = "success";
    }
    else if ($pdts===50) {
        $color = 'info';
    }
    else {
        $color = "danger";
    }
echo "<div class='toCenterForm  w-100 d-grid mt-5'>";
echo '
<div class="container">
    <div class="row text-dark fs-5">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="child d-grid gap-3 w-100 shadow-sm p-3 bg-body-tertiary rounded">
                <span class="">Almost Finished Products</span>
                <div class="details text-end">
                    <span class="d-block opacity-50">'.$pdts.'%</span>
                </div>
                <div class="progress d-flex justify-content-start fs-6 text-uppercase w-100">
                    <div class="progressValue bg-'.$color.'" style="width: '.$pdts.'%">
                    </div>
                </div>
                <div>
                    <a href="show.php?cond='.$condition.'&value='.$qte.'" class="btn border-0">See Details</a>
                </div>
            </div>
        </div>
         
    </div>
</div>
';


// products related
echo'

';

// Products Number




// Categories Number

// Brands Number




echo"</div>";
$conn->close();
include_once('footer.php');
?>