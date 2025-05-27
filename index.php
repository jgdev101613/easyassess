<?php
// SESSION
require_once "includes/session/config.session.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="public/css/main.css" />
    <link rel="stylesheet" href="public/css/loading.css" />
    <link rel="stylesheet" href="public/css/login.css" />
    <title>SACLI - Easy Assess</title>
  </head>
  <body>
    <!-- LOADING -->
    <div id="loadingMessage" class="loading-message" style="display: none;">
      <div class="spinner"></div>
      <p>Please wait, processing...</p>
    </div>

    <?php 
    if (isset($_SESSION['student'])) {
      echo '<button type="button" id="buttonSignOut">Logout</button>';
    } 
    ?>

    <div class="container">

      <div class="background"> 
        <img src="assets/saclibg.jpg" alt="Background Image" />
      </div>

      <div class="section-header">
        <div class="header-left">
          <div class="logo">
            <img src="assets/saclilogo.png" alt="Sacli Logo" height="64">
            <div class="logo-text">
              <h2>Saint Anne College Lucena INC.</h2>
              <p>Class Beyong Quezon</p>
            </div>
          </div>
        </div>
        <div class="header-right">
          <ul>
            <li><a href="https://sacli.edu.ph/" target="_blank">Home</a></li>
            <li><a href="https://portal.sacli.edu.ph/?admission=1" target="_blank">Admission</a></li>
            <li><a href="https://sacli.edu.ph/sacliportal" target="_blank">Student Portal</a></li>
            <li><a href="https://sacli.edu.ph/contact-us/" target="_blank">Contact Us</a></li>
          </ul>
        </div>
      </div>

      <div class="section-signin">
        <form class="form-signin">
          <div class="form-header">
            <img src="assets/saclilogo.png" alt="" height="80">
            <div class="form-header-text">
              <h2>Sign In</h2>
              <p>Welcome to SACLI Easy Assess</p>
            </div>
          </div>
          <div class="form-group">
            <label for="SIStudentID">Student ID</label>
            <input type="text" id="SIStudentID" name="SIStudentID" required />
          </div>
          <div class="form-group">
            <label for="SIStudentPassword">Password</label>
            <input type="password" id="SIStudentPassword" name="SIStudentPassword" required />
          </div>
          <button id="buttonSignIn" type="button">Sign In</button>
        </form>
      </div>

      <!-- Sign Up Section -->
      <!-- <div class="section-signup">
        <form class="form-signup">
          <div class="form-group">
            <label for="SUStudentID">Student ID</label>
            <input type="text" id="SUStudentID" name="SUStudentID" />
          </div>
          <div class="form-group">
            <label for="SUStudentFirstName">First Name</label>
            <input type="text" id="SUStudentFirstName" name="SUStudentFirstName" />
          </div>
          <div class="form-group">
            <label for="SUStudentMiddleName">Middle Name</label>
            <input type="text" id="SUStudentMiddleName" name="SUStudentMiddleName" />
          </div>
          <div class="form-group">
            <label for="SUStudentLastName">Last Name</label>
            <input type="text" id="SUStudentLastName" name="SUStudentLastName" />
          </div>
          <div class="form-group">
            <label for="SUStudentEmail">Email</label>
            <input type="email" id="SUStudentEmail" name="SUStudentEmail" />
          </div>
          <div class="form-group">
            <label for="SUStudentPassword">Password</label>
            <input type="password" id="SUStudentPassword" name="SUStudentPassword" />
          </div>
          <div class="form-group">
            <label for="SUStudentRePassword">Re-Password</label>
            <input type="password" id="SUStudentRePassword" name="SUStudentRePassword" />
          </div>
          <button id="buttonSignUp" type="button">Sign Up</button>
        </form>
      </div> -->

      <!-- Error Message -->
      <div class="error-message" id="errorMessage"></div>
    </div>
    

    <!-- JQUERY VENDOR -->
    <script src="public/vendor/jquery/jquery.min.js"></script>
    <!-- For Sign In & Sign Up AJAX -->
    <script src="public/js/signin.js"></script>
    <script src="public/js/signup.js"></script>
    <script src="public/js/signout.js"></script>
  </body>
</html>
