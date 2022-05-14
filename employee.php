<?php
    session_start();

try {
	$dbuser = 'postgres';
	$dbpass = '123456';
	$dbhost = 'localhost';
	$dbname='Hotel';
	$connec = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
}catch (PDOException $e) 
{
	echo "Error : " . $e->getMessage() . "<br/>";
	die();
}

$employee = "select concat(e.fname, ' ', e.mnit, ' ', e.lname) as empname, e.ssn, p.position_name as position, e.address, e.contact_number, e.email_address, d.department_name
		from employee e inner join department d on (e.department_id = d.department_id) inner join position p on (e.position_id = p.position_id) ORDER BY empname ASC";

    $position = "select * from position ORDER BY position_id ASC";

    $department = "select * from department ORDER BY department_id ASC"

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Employees</title>
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


  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
    
      <a href="index.html" class="logo d-flex align-items-center">
        <span class="d-none d-lg-block">Admin</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <span class="d-none d-md-block dropdown-toggle ps-2">Hi! Admin</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Admin</h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="index.html">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="guest.php">
          <i class="bi bi-card-list"></i>
          <span>Guests</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="room.php">
          <i class="bi bi-question-circle"></i>
          <span>Room Details</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="service.php">
          <i class="bi bi-envelope"></i>
          <span>Services</span>
        </a>
      </li><!-- End Contact Page Nav -->

      <li class="nav-item">
        <a class="nav-link " href="employee.php">
          <i class="bi bi-person"></i>
          <span>Employees</span>
        </a>
      </li><!-- End Register Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">
  <?php        
            if(isset($_SESSION['status']))
            {
                ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['status']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
                  
                <?php 
                unset($_SESSION['status']);
            }
            if(isset($_SESSION['status_deleted']))
            {
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['status_deleted']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
                  
                <?php 
                unset($_SESSION['status_deleted']);
            }
            if(isset($_SESSION['update_success']))
            {
                ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['update_success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
                  
                <?php 
                unset($_SESSION['update_success']);
            }
        ?>
    <div class="pagetitle">
    
      <h1>Employees</h1>
    </div><!-- End Page Title -->
    
    <div class="pagetitle">
    
        <a href="employee-insert.php">
        <button type="button" class="btn btn-success">Add Employee</button>
        </a>
    </div>

    <div class="card">
    
            <div class="card-body">
              <h5 class="card-title"></h5>

              <!-- Table with hoverable rows -->
              <table class="table table-hover datatable">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
		            <th scope="col">SSN</th>
		            <th scope="col">Position</th>
		            <th scope="col">Address</th>
		            <th scope="col">Contact Number</th>
		            <th scope="col">Email Address</th>
		            <th scope="col">Department</th>
		            <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
foreach ($connec->query($employee) as $row) 
{
	?>
	<tr>
		<td> <?php print $row['empname'] ?> </td>
		<td> <?php print $row['ssn'] ?> </td>		
		<td> <?php print $row['position'] ?> </td>
		<td> <?php print $row['address'] ?> </td>
		<td> <?php print $row['contact_number'] ?> </td>
		<td> <?php print $row['email_address'] ?> </td>
		<td> <?php print $row['department_name'] ?> </td>
		<td>
            <a href="employee-update.php?ssn=<?php echo $row['ssn']?>"><button type="button" class="btn btn-primary"><i class="bi bi-pencil-square"></i></button></a>
            <a href="employee-delete.php?ssn=<?php echo $row['ssn']?>" onclick="return confirm('You sure want to delete the data of <?php echo $row['empname'];?> ?')"><button type="button" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button></a>
        </td>
	<?php 
}
?>

                </tbody>
              </table>
              <!-- End Table with hoverable rows -->

            </div>
          </div>

          <!-- START POSItION -->
          <section class="section">
            <div class="row">
              <div class="col-lg-6">
                <div class="card">
                  <div class="card-body">
                  <div class="pagetitle">
    
    <h1 class="card-title">Position</h1>
  </div><!-- End Page Title -->
  
  <div class="pagetitle">
                  <?php        
            if(isset($_SESSION['insert_position_success']))
            {
                ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['insert_position_success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
                  
                <?php 
                unset($_SESSION['insert_position_success']);
            }
            if(isset($_SESSION['insert_position_failed']))
            {
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['insert_position_failed']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
                  
                <?php 
                unset($_SESSION['insert_position_failed']);
            }
            if(isset($_SESSION['update_position_success']))
            {
                ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['update_position_success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
                  
                <?php 
                unset($_SESSION['update_position_success']);
            }
        ?>

    
        
        <form class="row g-3" action="position-insert.php" method="post">
        <div class="col-md-4">
                  <div class="form">
                    <input type="text" name="position" class="form-control" id="floatingName" placeholder="Position" required>
                  </div>
                </div>
                <div class="col-md-4">
                <a href="position-insert.php" onclick="return confirm('You sure want to add a new position?')">
        <button type="submit" class="btn btn-success" value="Add Position">Add Position</button>
        </a>
                </div>
                
        </form>
        
    </div>

    <div class="card">
    
            <div class="card-body">
              <h5 class="card-title"></h5>

              <!-- Table with hoverable rows -->
              <table class="table table-hover datatable">
                <thead>
                  <tr>
                    <th scope="col">number</th>
		            <th scope="col">Position</th>
                <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                $no=1;
foreach ($connec->query($position) as $row) 
{
	?>
	<tr>
		<td> <?php print $row['position_id'] ?> </td>
		<td> <?php print $row['position_name'] ?> </td>		
    <td>
            <a href="position-update.php?id=<?php echo $row['position_id']?>"><button type="button" class="btn btn-primary"><i class="bi bi-pencil-square"></i></button></a>
        </td>
	<?php 
}
?>

                </tbody>
              </table>
              <!-- End Table with hoverable rows -->

            </div>
          </div>

                  </div>
                </div>
              </div>

              <!-- DEPARTMENT START -->

              <div class="col-lg-6">
                <div class="card">
                  <div class="card-body">
                  <div class="pagetitle">
    
    <h1 class="card-title">Department</h1>
  </div><!-- End Page Title -->
  
  <div class="pagetitle">
                  <?php        
            if(isset($_SESSION['insert_department_success']))
            {
                ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['insert_department_success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
                  
                <?php 
                unset($_SESSION['insert_department_success']);
            }
            if(isset($_SESSION['insert_department_failed']))
            {
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['insert_department_failed']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
                  
                <?php 
                unset($_SESSION['insert_department_failed']);
            }
            if(isset($_SESSION['update_department_success']))
            {
                ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['update_department_success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
                  
                <?php 
                unset($_SESSION['update_department_success']);
            }
            
        ?>

    
        
        <form class="row g-3" action="department-insert.php" method="post">
        <div class="col-md-4">
                  <div class="form">
                    <input type="text" name="department" class="form-control" id="floatingName" placeholder="Department" required>
                  </div>
                </div>
                <div class="col-md-4">
                <a href="department-insert.php" onclick="return confirm('You sure want to add a new department?')">
        <button type="submit" class="btn btn-success" value="Add Department">Add Department</button>
        </a>
                </div>
                
        </form>
        
    </div>

    <div class="card">
    
            <div class="card-body">
              <h5 class="card-title"></h5>

              <!-- Table with hoverable rows -->
              <table class="table table-hover datatable">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
		            <th scope="col">Department</th>
                <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                $no=1;
foreach ($connec->query($department) as $row) 
{
	?>
	<tr>
		<td> <?php print $row['department_id'] ?> </td>
		<td> <?php print $row['department_name'] ?> </td>		
    <td>
            <a href="department-update.php?id=<?php echo $row['department_id']?>"><button type="button" class="btn btn-primary"><i class="bi bi-pencil-square"></i></button></a>
        </td>
	<?php 
}
?>

                </tbody>
              </table>
              <!-- End Table with hoverable rows -->

            </div>
          </div>

                  </div>
                </div>
              </div>
            </div>
          </section>

          <!-- START DEPARTMENT -->
          <section class="section">
            <div class="row">
              
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