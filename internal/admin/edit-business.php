<?php

session_start();

if(!isset($_SESSION['Cxyzwet']))
 {
   header('location:index.php');
 };

 require 'db/config.php';

 $IBSID=$_GET['bs-id'];

$Queryer ="SELECT * FROM i_business WHERE IBSID='$IBSID'";
$Resulter = $conn->query($Queryer);
$Rower = $Resulter->fetch_assoc();
$Old_sort=$Rower['IBSSortOrder'];


if(isset($_POST['update']))
{

$IBSName=mysqli_real_escape_string($conn,$_POST['bsname']);
$IBSUrl=mysqli_real_escape_string($conn,$_POST['bsurl']);

$SortOrder=mysqli_real_escape_string($conn,$_POST['sortorder']);

if (!file_exists($_FILES['bimage']['tmp_name']) || !is_uploaded_file($_FILES['bimage']['tmp_name'])) 
{



if($SortOrder==$Old_sort)
{

$Query="UPDATE i_business SET IBSName='$IBSName', IBSUrl='$IBSUrl' WHERE IBSID='$IBSID'";

if ($conn->query($Query) === TRUE) {

echo "<script> alert('Success');window.location.href = 'manage-business.php';</script>";

}

else
{

echo "<script language='javascript'>alert('Error Try again')</script>";

}

}
else
{

$GetOld ="SELECT * FROM i_business WHERE IBSSortOrder='$SortOrder'";
$Resulter_old = $conn->query($GetOld);
$Rower_old = $Resulter_old->fetch_assoc();
$Last_sort_id=$Rower_old['IBSID'];

$Query="UPDATE i_business SET IBSName='$IBSName', IBSUrl='$IBSUrl', IBSSortOrder='$SortOrder' WHERE IBSID='$IBSID'";

if ($conn->query($Query) === TRUE) {

$UPDATE_SORT="UPDATE i_business SET IBSSortOrder='$Old_sort' WHERE IBSID='$Last_sort_id'";
$conn->query($UPDATE_SORT);  

echo "<script> alert('Success');window.location.href = 'manage-business.php';</script>";

}

else
{

echo "<script language='javascript'>alert('Error Try again')</script>";

}

}



}
else
{



$target_dir = "../uploads/sisconcern-logo/"; //directory details




$imageFileType = pathinfo($_FILES["bimage"]["name"],PATHINFO_EXTENSION); //image type(png or jpg etc)

$SupportedImage = array('gif', 'jpg', 'jpeg','png');

if (in_array($imageFileType, $SupportedImage)) {


$target=$target_dir.time().'.'.$imageFileType;
$target_file = time().'.'.$imageFileType; //full path

if (move_uploaded_file($_FILES["bimage"]["tmp_name"], $target)) {



if($SortOrder==$Old_sort)
{

$Query="UPDATE i_business SET IBSName='$IBSName', IBSUrl='$IBSUrl', IBSLogo='$target_file' WHERE IBSID='$IBSID'";

if ($conn->query($Query) === TRUE) {

echo "<script> alert('Success');window.location.href = 'manage-business.php';</script>";

}

else
{

echo "<script language='javascript'>alert('Error Try again')</script>";

}


}
else
{

$GetOld ="SELECT * FROM i_business WHERE IBSSortOrder='$SortOrder'";
$Resulter_old = $conn->query($GetOld);
$Rower_old = $Resulter_old->fetch_assoc();
$Last_sort_id=$Rower_old['IBSID'];

$Query="UPDATE i_business SET IBSName='$IBSName', IBSUrl='$IBSUrl', IBSLogo='$target_file', IBSSortOrder='$SortOrder' WHERE IBSID='$IBSID'";

if ($conn->query($Query) === TRUE) {

$UPDATE_SORT="UPDATE i_business SET IBSSortOrder='$Old_sort' WHERE IBSID='$Last_sort_id'";
$conn->query($UPDATE_SORT);  

echo "<script> alert('Success');window.location.href = 'manage-business.php';</script>";

}

else
{

echo "<script language='javascript'>alert('Error Try again')</script>";

}



}


}

else
{

echo "<script language='javascript'>alert('Upload Error')</script>";

}

}

else
{

echo "<script language='javascript'>alert('Unsupported File Type')</script>";

}

}


$conn->close();

};





?>



<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Internal | Sister Concerns</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>

<body>

<?php include 'partials/sidebar.php'?>

      <div class="main-content">

        <section class="section">
          <div class="section-header">
            <h1>Sister Concerns</h1>
          </div>

              <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Edit Sister Concerns</h4>
                  </div>


                  <form method="POST"  enctype="multipart/form-data">
                  <div class="card-body">

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Name</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="bsname" class="form-control" value="<?php echo $Rower['IBSName'];?>" required>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Url</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="bsurl" class="form-control" value="<?php echo $Rower['IBSUrl'];?>" required>
                      </div>
                    </div>

                    <div class="form-group row mb-4">


                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Image</label>
                      
                      <div class="col-sm-12 col-md-7">
                        <img src="../uploads/sisconcern-logo/<?php echo $Rower['IBSLogo']; ?>" width="200">
                      </div>
                    </div>


                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Update Image (Size:270 * 140 Px)</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="file" name="bimage" class="form-control">
                      </div>
                    </div>


                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Sort Order</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="sortorder" class="form-control" value="<?php echo $Old_sort;?>" required>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                      <div class="col-sm-12 col-md-7">
                        <button class="btn btn-primary" type="submit" name="update">Update</button>
                      </div>
                    </div>
                  </form>
                  </div>
                </div>
              </div>
            </div>

        </section>

      </div>


  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
</body>
</html>
