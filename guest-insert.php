<?php
    session_start();
$db = pg_connect("host=localhost port=5432 dbname=Hotel user=postgres password=123456");
if (isset($_POST['insert']))
{
    $query = "INSERT INTO employee (fname, mnit, lname, ssn, position_id, address, contact_number, email_address, department_id) VALUES ('$_POST[fname]','$_POST[mnit]',
    '$_POST[lname]','$_POST[ssn]', '$_POST[position]','$_POST[address]', '$_POST[contact_number]', '$_POST[email_address]','$_POST[department]')";

$result_insert = pg_query($query); 
    if (!$result_insert)
    {
        $_SESSION['insert_failed'] = "Insert failed!!";
    } else {
      $_SESSION['insert_guest_success'] = "Succesfully added $_POST[fname] $_POST[mnit] $_POST[lname]'s data!";
      header('Location:employee.php');
    }
}

$result_dno = pg_query($db, "select department_id,department_name from department");
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
        <h1>Add New Guest</h1>
      </div><!-- End Page Title -->
    
      <div class="pagetitle">
        <a href="guest.php">
        <button type="button" class="btn btn-dark">Go back</button>
        </a>
      </div>

      <?php        
            if(isset($_SESSION['insert_failed']))
            {
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['insert_failed']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
                  
                <?php 
                unset($_SESSION['insert_failed']);
            }
            
        ?>

      <section class="section">
        <div class="row">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Guest Personal Information</h5>

              <form class="row g-3" name="insert" action="employee-insert.php" method="POST">
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" name="ssn" class="form-control" id="floatingName" placeholder="First Name" required>
                    <label for="floatingName">SSN</label>                    
                  </div>                                  
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" name="fname" class="form-control" id="floatingName" placeholder="First Name" required>
                    <label for="floatingName">First Name</label>                    
                  </div>                                  
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" name="mnit" class="form-control" id="floatingName" placeholder="Middle Name" required>
                    <label for="floatingName">Middle Name</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" name="lname" class="form-control" id="floatingName" placeholder="Last Name" required>
                    <label for="floatingName">Last Name</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control" name="address" placeholder="Address" id="floatingTextarea" style="height: 100px;"></textarea>
                    <label for="floatingTextarea">Address</label>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" name="contact_number" class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Contact number</label>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="email" name="email_address" class="form-control" id="floatingEmail" placeholder="Your Email">
                    <label for="floatingEmail">Email Address</label>
                  </div>
                </div>               
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" name="credit_card" class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Credit Card</label>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-floating">
                    <select name="id-proof" class="form-select" id="floatingSelect" aria-label="ID Proof">
                      <option selected value="KTP">KTP</option>
                      <option value="Passport">Passport</option>
                      <option value="Other">Other</option>
                    </select>
                    <label for="floatingEmail">ID Proof</label>
                  </div>
                </div>  
            
                <!-- RESERVATION DETAILS -->
                <h5 class="card-title">Reservation Details</h5>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" name="booking_id" class="form-control" id="floatingName" placeholder="First Name" required>
                    <label for="floatingName">Booking id</label>                    
                  </div>                                  
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="date" name="booking_date" class="form-control" id="floatingName" required>
                    <label for="floatingName">Booking Date</label>                    
                  </div>                                  
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-2">
                  <div class="form-floating">
                    <input type="number" name="duration_of_stay" class="form-control" id="floatingName" placeholder="First Name" required>
                    <label for="floatingName">Duration of Stay</label>                    
                  </div>                                  
                </div>
                <div class="col-md-5">
                  <div class="form-floating">
                    <input type="date" name="check_in_date" class="form-control" id="floatingName" placeholder="First Name" required>
                    <label for="floatingName">Check In Date</label>                    
                  </div>                                  
                </div>
                <div class="col-md-5">
                  <div class="form-floating">
                    <input type="date" name="check_out_date" class="form-control" id="floatingName" placeholder="First Name" required>
                    <label for="floatingName">Check out date</label>                    
                  </div>                                  
                </div>
                <div class="col-md-2">
                  <div class="form-floating">
                    <select name="payment_type" class="form-select" id="floatingSelect" aria-label="ID Proof">
                      <option selected value="cash">Cash</option>
                      <option value="card">Card</option>
                      <option value="Other">Other</option>
                    </select>
                    <label for="floatingName">Payment Type</label>                    
                  </div>                                  
                </div>
                <div class="col-md-5">
                  <div class="form-floating">
                    <input type="number" name="check_out_date" class="form-control" id="floatingName" placeholder="First Name" required>
                    <label for="floatingName">Total Amount</label>                    
                  </div>                                  
                </div>
                <div class="col-md-5">
                  <div class="form-floating">
                    <input type="text" name="check_out_date" class="form-control" id="floatingName" placeholder="First Name" required>
                    <label for="floatingName">Employee</label>                    
                  </div>                                  
                </div>

                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Text</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputNumber" class="col-sm-2 col-form-label">Number</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputNumber" class="col-sm-2 col-form-label">File Upload</label>
                  <div class="col-sm-10">
                    <input class="form-control" type="file" id="formFile">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputDate" class="col-sm-2 col-form-label">Date</label>
                  <div class="col-sm-10">
                    <input type="date" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputTime" class="col-sm-2 col-form-label">Time</label>
                  <div class="col-sm-10">
                    <input type="time" class="form-control">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="inputColor" class="col-sm-2 col-form-label">Color Picker</label>
                  <div class="col-sm-10">
                    <input type="color" class="form-control form-control-color" id="exampleColorInput" value="#4154f1" title="Choose your color">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Textarea</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" style="height: 100px"></textarea>
                  </div>
                </div>
                <fieldset class="row mb-3">
                  <legend class="col-form-label col-sm-2 pt-0">Radios</legend>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
                      <label class="form-check-label" for="gridRadios1">
                        First radio
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                      <label class="form-check-label" for="gridRadios2">
                        Second radio
                      </label>
                    </div>
                    <div class="form-check disabled">
                      <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios" value="option" disabled>
                      <label class="form-check-label" for="gridRadios3">
                        Third disabled radio
                      </label>
                    </div>
                  </div>
                </fieldset>
                <div class="row mb-3">
                  <legend class="col-form-label col-sm-2 pt-0">Checkboxes</legend>
                  <div class="col-sm-10">

                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="gridCheck1">
                      <label class="form-check-label" for="gridCheck1">
                        Example checkbox
                      </label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="gridCheck2" checked>
                      <label class="form-check-label" for="gridCheck2">
                        Example checkbox 2
                      </label>
                    </div>

                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Disabled</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="Read only / Disabled" disabled>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Select</label>
                  <div class="col-sm-10">
                    <select class="form-select" aria-label="Default select example">
                      <option selected>Open this select menu</option>
                      <option value="1">One</option>
                      <option value="2">Two</option>
                      <option value="3">Three</option>
                    </select>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Multi Select</label>
                  <div class="col-sm-10">
                    <select class="form-select" multiple aria-label="multiple select example">
                      <option selected>Open this select menu</option>
                      <option value="1">One</option>
                      <option value="2">Two</option>
                      <option value="3">Three</option>
                    </select>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Submit Button</label>
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Submit Form</button>
                  </div>
                </div>

                <div class="text-center">
                  <a href="#"><button type="submit" class="btn btn-primary" name="insert" value="Add Employee">Submit</button></a>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>

              </form><!-- End General Form Elements -->

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