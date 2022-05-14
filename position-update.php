<?php
    session_start();
$db = pg_connect("host=localhost port=5432 dbname=Hotel user=postgres password=123456");
$id=$_GET['id'];

if (isset($_POST['update']))
{
    $query = "UPDATE position SET position_id = '$_POST[position_id]', position_name='$_POST[position_name]' WHERE position_id= '$_POST[position_id]';";                                                                                           
    

    $result_update = pg_query($query); 

    if (!$result_update)
    {
      $_SESSION['update_position_failed'] = "Update failed!!";
    } else {
      $_SESSION['update_position_success'] = "Succesfully updates $_POST[position_name]'s data!";
      header('Location:employee.php');
    }
}

$result_retrieve = pg_query($db, "select * from position WHERE position_id=$id");


?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Update Position</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
    * Template Name: NiceAdmin - v2.2.2
    * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
  </head>

  <body>

    <main id="main" class="main">
      <div class="pagetitle">
        <h1>Update Position Data</h1>
      </div><!-- End Page Title -->
    
      <div class="pagetitle">
        <a href="employee.php">
        <button type="button" class="btn btn-dark">Go back</button>
        </a>
      </div>

      <?php        
            if(isset($_SESSION['update_position_failed']))
            {
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['update_position_failed']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
                  
                <?php 
                unset($_SESSION['update_position_failed']);
            }
        ?>

      <section class="section">
        <div class="row">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"> </h5>
              <!-- Floating Labels Form -->
              <form class="row g-3" name="update" action="position-update.php" method="POST">
                <?php while($data=pg_fetch_array($result_retrieve)){?>
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" name="position_id" class="form-control" id="floatingName" placeholder="Position ID" value="<?php print $data['position_id'] ?>"required>
                    <label for="floatingName">Position ID</label>                    
                  </div>                                  
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" name="position_name" class="form-control" id="floatingName" placeholder="Position Name" value="<?php print $data['position_name'] ?>" required>
                    <label for="floatingName">Position Name</label>                    
                  </div>                                  
                </div>
                <div class="text-center">
                  <a href="employee.php"><button type="submit" class="btn btn-primary" name="update" value="Update Position">Update</button></a>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
                <?php }?>
              </form><!-- End floating Labels Form -->
            </div>
          </div>
        </div>
      </section>
    </main><!-- End Main -->
  

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.min.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

  </body>
</html>