<?php
    session_start();
$db = pg_connect("host=localhost port=5432 dbname=Hotel user=postgres password=123456");
if (isset($_POST['insert']))
{
    $guest = "INSERT INTO guests (fname, mnit, lname, ssn, id_proof, address, contact_number, email_address, credit_card) VALUES ('$_POST[fname]','$_POST[mnit]',
  '$_POST[lname]','$_POST[ssn]', '$_POST[id_proof]','$_POST[address]', '$_POST[contact_number]', '$_POST[email_address]','$_POST[credit_card]')";
      $result_insert_guest = pg_query($guest); 

    if (!$result_insert_guest)
    {
        $_SESSION['insert_failed'] = "Insert failed!!";
    } else {
      $booking = "INSERT INTO bookings(booking_id, booking_date, duration_of_stay, check_in_date, check_out_date, payment_type, guest_id, emp_id, total_amount) 
      VALUES ('$_POST[booking_id]','$_POST[booking_date]', '$_POST[duration_of_stay]','$_POST[check_in_date]', '$_POST[check_out_date]','$_POST[payment_type]', '$_POST[ssn]', '$_POST[employee]',$_POST[total_amount])";
      $result_insert_booking = pg_query($booking); 
  
      if (!$result_insert_booking )
      {
          $_SESSION['insert_failed'] = "Insert failed!!";
      } else {
        $rooms_booked = "INSERT INTO rooms_booked (booking_id, room_id ) VALUES ('$_POST[booking_id]','$_POST[room_id]')";
        $result_insert_rooms_booked = pg_query($rooms_booked); 
        $_SESSION['insert_guest_success'] = "Succesfully added $_POST[fname] $_POST[mnit] $_POST[lname]'s data!";
        header('Location:guest.php');
      }
  
    }

}

$result_employee = pg_query($db, "Select SSN, concat(fname, ' ', mnit, ' ', lname) as empname from employee where position_id = 2");
$result_room_type = pg_query($db, "select  rooms.room_id, room_number, room_type_name, room_cost, smoke_friendly, pet_friendly from rooms join room_type on rooms.rooms_type_id = room_type.room_type_id  left outer join rooms_booked on rooms.room_id = rooms_booked.room_id;");


?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Insert Guest</title>
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

              <form class="row g-3" name="insert" action="guest-insert.php" method="POST">
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
                    <select name="id_proof" class="form-select" id="floatingSelect" aria-label="ID Proof">
                      <option selected value="KTP">KTP</option>
                      <option value="Passport">Passport</option>
                      <option value="Other">Other</option>
                    </select>
                    <label for="floatingEmail">ID Proof</label>
                  </div>
                </div>  
            
                
                <!-- RESERVATION DETAILS -->
                <h5 class="card-title">Reservation Details</h5>
                <div class="col-md-3">
                  <div class="form-floating">
                    <input type="text" name="booking_id" class="form-control" id="floatingName" placeholder="First Name" required>
                    <label for="floatingName">Booking id (B00n)</label>                    
                  </div>                                  
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="date" name="booking_date" class="form-control" id="floatingName" required>
                    <label for="floatingName">Booking Date</label>                    
                  </div>                                  
                </div>
                <div class="col-md-5">
                  <div class="form-floating">
                  <select class="form-select" name="room_id" id="floatingSelect" aria-label="Employee">   
                      <?php while ($row = pg_fetch_row($result_room_type)) { ?>
                        <option value="<?php print($row[0]); ?>"><?php print($row[1]);  print(" - "); print($row[2]);  print(" - "); print($row[3]);?></option>
                        <?php } ?>
                    </select>
                    <label for="floatingName">Rooms number, type, cost</label>                    
                  </div>                                  
                </div>
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
                    <input type="number" name="total_amount" class="form-control" id="floatingName" placeholder="First Name" required>
                    <label for="floatingName">Total Amount</label>                    
                  </div>                                  
                </div>
                <div class="col-md-5">
                  <div class="form-floating">
                    <select class="form-select" name="employee" id="floatingSelect" aria-label="Employee">   
                      <?php while ($row = pg_fetch_row($result_employee)) { ?>
                        
                        <option value="<?php print($row[0]); ?>"><?php print($row[1]); ?></option>
                      <?php } ?>
                    </select>
                    <label for="floatingName">Employee</label>                    
                  </div>                                  
                </div>
                


                <div class="text-center">
                  <a href="#"><button type="submit" class="btn btn-primary" name="insert" value="Add Guest">Submit</button></a>
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