<?php

session_start();

if(!isset($_SESSION['Cxyzwet']))
 {
   header('location:index.php');
 };

require 'db/config.php';


$GetMax ="SELECT (SELECT MAX(IKeySortOrder) FROM i_keyperson) AS MaxSort";
$Resulter_max = $conn->query($GetMax);
$Rower_max = $Resulter_max->fetch_assoc();
$Max_sort=$Rower_max['MaxSort']+1;

$Query_C ="SELECT * FROM i_keypercategory ORDER BY IKeyCatID DESC";
$Result_C = $conn->query($Query_C);

if(isset($_POST['submit']))
{


$IKeyCategory=mysqli_real_escape_string($conn,$_POST['kpcname']);
$IkeyPName=mysqli_real_escape_string($conn,$_POST['kpname']);
$IkeyDesignation=mysqli_real_escape_string($conn,$_POST['kpdesignation']);
$IKeyPhone=mysqli_real_escape_string($conn,$_POST['kpphone']);
$IkeyEmail=mysqli_real_escape_string($conn,$_POST['kpemail']);
$IKeyListing=mysqli_real_escape_string($conn,$_POST['kplisting']);
$IKeyDescription=mysqli_real_escape_string($conn,$_POST['kpdescription']);



if (!file_exists($_FILES['kpimage']['tmp_name']) || !is_uploaded_file($_FILES['kpimage']['tmp_name'])) 
{



$Query="INSERT INTO i_keyperson (IKeyCategory, IkeyPName, IkeyDesignation, IKeyphoto, IKeyPhone, IkeyEmail, IKeyDescription, IKeyListing, IKeySortOrder) VALUES('$IKeyCategory', '$IkeyPName', '$IkeyDesignation', 'dummy.png', '$IKeyPhone', '$IkeyEmail', '$IKeyDescription', '$IKeyListing', '$Max_sort')";

if ($conn->query($Query) === TRUE) {

echo "<script> alert('Success');window.location.href = 'manage-keyperson.php';</script>";

}

else
{

echo "<script language='javascript'>alert('Error Try again')</script>";

}


}
else
{

$target_dir = "../uploads/keyperson-image/"; //directory details


$imageFileType = pathinfo($_FILES["kpimage"]["name"],PATHINFO_EXTENSION); //image type(png or jpg etc)

$SupportedImage = array('gif', 'jpg', 'jpeg','png');

if (in_array($imageFileType, $SupportedImage)) {


$target=$target_dir.time().'.'.$imageFileType;
$target_file = time().'.'.$imageFileType; //full path

if (move_uploaded_file($_FILES["kpimage"]["tmp_name"], $target)) {


$Query="INSERT INTO i_keyperson (IKeyCategory, IkeyPName, IkeyDesignation, IKeyphoto, IKeyPhone, IkeyEmail, IKeyDescription, IKeyListing, IKeySortOrder) VALUES('$IKeyCategory', '$IkeyPName', '$IkeyDesignation', '$target_file', '$IKeyPhone', '$IkeyEmail', '$IKeyDescription', '$IKeyListing', '$Max_sort')";

if ($conn->query($Query) === TRUE) {

echo "<script> alert('Success');window.location.href = 'manage-keyperson.php';</script>";

}

else
{

echo "<script language='javascript'>alert('Error Try again')</script>";

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

};

$conn->close();

?>



<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Internal | Key Person</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">




  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">

  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.css" rel="stylesheet">

</head>

<body>

<?php include 'partials/sidebar.php'?>

      <div class="main-content">

        <section class="section">
          <div class="section-header">
            <h1>Key Person</h1>
          </div>
          </section>


              <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Create Key Person</h4>
                  </div>
                  
                  



                  <form method="POST"  enctype="multipart/form-data">
                  <div class="card-body">

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Key Person Name</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" name="kpname" class="form-control" required>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category Name</label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control selectric" name="kpcname" required>
                          <option value="">----Select----</option>

                          <?php while($Row_C = $Result_C->fetch_assoc())
                          {
                          ?>

                          <option value="<?php echo $Row_C['IKeyCatID']; ?>"><?php echo $Row_C['IKeyCatName']; ?></option>

                          <?php }; ?> 
                          

                        </select>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Designation</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" name="kpdesignation" class="form-control" required>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Phone</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="number" name="kpphone" class="form-control" required>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="email" name="kpemail" class="form-control" required>
                      </div>
                    </div>


                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Image (Size: 400 * 400 Px)</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="file" name="kpimage" class="form-control">
                      </div>
                    </div>
                    
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Description</label>
                      <div class="col-sm-12 col-md-8">
                        <textarea id ="summernote" name="kpdescription"></textarea><br>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Top Listing</label>
                      <div class="col-sm-12 col-md-8">
                        <label class="radio-inline">
                        <input type="radio" value="True" name="kplisting" checked> True
                        </label> &nbsp&nbsp
                        <label class="radio-inline">
                        <input type="radio" value="False" name="kplisting"> False
                        </label>
                      </div>
                    </div>


                  
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                      <div class="col-sm-12 col-md-8">
                        <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                      </div>
                    </div>

                  </form>
                  </div>
                </div>
              </div>
            </div>



      </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.js"></script>

<script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });
</script>


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
