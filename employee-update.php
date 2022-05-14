<?php
    session_start();
$db = pg_connect("host=localhost port=5432 dbname=Hotel user=postgres password=123456");
$ssn=$_GET['ssn'];

if (isset($_POST['update']))
{
    $query = "UPDATE employee SET fname = '$_POST[fname]', mnit='$_POST[mnit]', lname='$_POST[lname]', ssn='$_POST[ssn]', contact_number='$_POST[contact_number]', address='$_POST[address]', email_address='$_POST[email_address]', department_id='$_POST[department]', position_id='$_POST[position]' WHERE ssn= '$_POST[ssn]';";                                                                                           
    

$result_update = pg_query($query); 

    if (!$result_update)
    {
      $_SESSION['update_failed'] = "Update failed!!";
    } else {
      $_SESSION['update_success'] = "Succesfully updates $_POST[fname] $_POST[mnit] $_POST[lname]'s data!";
      header('Location:employee.php');
    }
}

$result_dno = pg_query($db, "select * from department");

$result_retrieve = pg_query($db, "select e.fname, e.mnit, e.lname, e.ssn, p.position_name as position, e.address, e.contact_number, e.email_address, d.department_name
from employee e inner join department d on (e.department_id = d.department_id) inner join position p on (e.position_id = p.position_id) WHERE e.ssn='$ssn'");

$result_position = pg_query($db, "select * from position");


?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Insert Employee</title>
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
        <h1>Add New Employees</h1>
      </div><!-- End Page Title -->
    
      <div class="pagetitle">
        <a href="employee.php">
        <button type="button" class="btn btn-dark">Go back</button>
        </a>
      </div>

      <?php        
            if(isset($_SESSION['update_failed']))
            {
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['update_failed']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
                  
                <?php 
                unset($_SESSION['update_failed']);
            }
            
        ?>

      <section class="section">
        <div class="row">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"> </h5>
              <!-- Floating Labels Form -->
              <form class="row g-3" name="update" action="employee-update.php" method="POST">
                <?php while($data=pg_fetch_array($result_retrieve)){?>
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" name="ssn" class="form-control" id="floatingName" placeholder="First Name" value="<?php print $data['ssn'] ?>"required>
                    <label for="floatingName">SSN</label>                    
                  </div>                                  
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" name="fname" class="form-control" id="floatingName" placeholder="First Name" value="<?php print $data['fname'] ?>" required>
                    <label for="floatingName">First Name</label>                    
                  </div>                                  
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" name="mnit" class="form-control" id="floatingName" placeholder="Middle Name" value="<?php print $data['mnit'] ?>" required>
                    <label for="floatingName">Middle Name</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" name="lname" class="form-control" id="floatingName" placeholder="Last Name" value="<?php print $data['lname'] ?>" required>
                    <label for="floatingName">Last Name</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control" name="address" placeholder="Address" id="floatingTextarea" style="height: 100px;" value=""><?php print $data['address'] ?></textarea>
                    <label for="floatingTextarea">Address</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating mb-3">
                    <select class="form-select" name="position" id="floatingSelect" aria-label="Position">
                      <?php while ($row = pg_fetch_row($result_position)) { ?>
                        <option value="<?php print($row[0]); ?>"><?php print($row[1]); ?></option>
                      <?php } ?>
                    </select>
                    <label for="floatingSelect">Position</label>
                  </div>
                </div><div class="col-md-4">
                  <div class="form-floating mb-3">
                    <select class="form-select" name="department" id="floatingSelect" aria-label="Department">
                    <?php while ($row = pg_fetch_row($result_dno)) { ?>
                        <option value="<?php print($row[0]); ?>"><?php print($row[1]); ?></option>
                      <?php } ?>
                    </select>
                    <label for="floatingSelect">Department</label>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" name="contact_number" class="form-control" id="floatingPassword" placeholder="Password" value="<?php print $data['contact_number'] ?>">
                    <label for="floatingPassword">Contact number</label>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="email" name="email_address" class="form-control" id="floatingEmail" placeholder="Your Email" value="<?php print $data['email_address'] ?>">
                    <label for="floatingEmail">Email Address</label>
                  </div>
                </div>               
            
                <div class="text-center">
                  <a href="employee.php"><button type="submit" class="btn btn-primary" name="update" value="Update Employee">Update</button></a>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
                <?php }?>
              </form><!-- End floating Labels Form -->
            </div>
          </div>
        </div>
      </section>
    </main><!-- End Main -->
  
      <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
      <div class="copyright">
        &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </footer><!-- End Footer -->

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