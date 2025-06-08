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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <title>SACLI - Easy Assess</title>
  </head>
  <body>
    <!-- LOADING -->
    <div id="loadingMessage" class="loading-message" style="display: none;">
      <div class="spinner"></div>
      <p>Please wait, processing...</p>
    </div>
    <!-- END OF LOADING -->

    <?php 
    if (isset($_SESSION['student'])) {
      echo '<button type="button" id="buttonSignOut">Logout</button>';
    } 
    ?>

    <!-- START OF CONTAINER -->
    <div class="container">

      <!-- BACKGROUND -->
      <div class="background"> 
        <img src="assets/saclibg.jpg" alt="Background Image" />
      </div>
      <!-- END OF BACKGROUND -->

      <!-- HEADER SECTION -->
      <div class="section-header">
        <div class="header-left">
          <div class="logo">
            <img src="assets/saclilogo.png" alt="Sacli Logo" height="64">
            <div class="logo-text">
              <h2>Saint Anne College Lucena INC.</h2>
              <p>Class Beyond Quezon</p>
            </div>
            <div class="short-text">
              <h2>Saint Anne College Lucena INC.</h2>
              <p>Class Beyond Quezon</p>
            </div>
          </div>
        </div>
        <div class="header-right">
          <ul>
            <li><a href="https://sacli.edu.ph/" target="_blank">Official Website</a></li>
            <li><a href="https://portal.sacli.edu.ph/?admission=1" target="_blank">Admission</a></li>
            <li><a href="https://sacli.edu.ph/sacliportal" target="_blank">Student Portal</a></li>
            <li><a href="https://sacli.edu.ph/contact-us/" target="_blank">Contact Us</a></li>
          </ul>
        </div>
      </div>
      <!-- END OF HEADER -->

      <!-- SIGNIN SECTIOn -->
      <div class="section-signin">
        <form class="form-signin">
          <div class="form-header">
            <img src="assets/saclilogo.png" alt="" height="80">
            <div class="form-header-text">
              <h2>Welcome to SACLI Easy Assess</h2>
              <p>Sign in to your account</p>
              
              <div class="error-message" id="signin-error"></div>
            </div>
          </div>
          <div class="form-body">
            <div class="form-group" id="StudentIDGroup">
              <i class="fas fa-user"></i>
              <input type="text" id="userId" name="userId" placeholder="User ID" required />
            </div>
            <div class="form-group" id="StudentPasswordGroup" >
              <i class="fas fa-lock"></i>
              <input type="password" class="password-field" id="SIPassword" name="SIPassword" placeholder="Password" required />
              <i class="fas fa-eye-slash toggle-password" data-target="SIPassword" style="cursor: pointer;"></i>
            </div>
            <button id="buttonSignIn" class="primary-button" type="button">Sign In</button>
            <div class="form-check">
              <div class="checkbox-container">
                <input type="checkbox" id="rememberMe" name="rememberMe" />
                <label for="rememberMe">Remember Me</label>
              </div>
              <p><a href="https://sacli.edu.ph/sacliportal" target="_blank">Forgot Password?</a></p>
            </div>
            <div class="form-footer">
              <div class="divider"></div>
              <p>Don't have an account? <a href="https://sacli.edu.ph/sacliportal" target="_blank">Sign Up</a></p>
            </div>
          </div>
        </form>
      </div>
      <!-- END OF SIGNIN -->

      <!-- SIGN UP SECTION -->
      <div class="section-signup">
        <form class="form-signup" enctype="multipart/form-data"> 
          <div class="form-header">
            <img src="assets/saclilogo.png" alt="" height="80">
            <div class="form-header-text">
              <h2>Welcome to SACLI Easy Assess</h2>
              <p>Signup</p>
              <div class="error-message" id="signup-error"></div>
              <div class="success-message" id="signup-message"></div>
            </div>
          </div>
          <div class="form-body form-body-signup">

            <div class="signup-top">
              <div class="signup-left">
                <div class="form-group">
                  <i class="fas fa-user"></i>
                  <input type="text" id="SUUserId" name="SUUserId" placeholder="User ID" />
                </div>
                <div class="form-group">
                  <i class="fa-solid fa-user-tag"></i>
                  <input type="text" id="SUFirstName" name="SUFirstName" placeholder="First Name" />
                </div>
                <div class="form-group">
                  <i class="fa-solid fa-user-tag"></i>
                  <input type="text" id="SUMiddleName" name="SUMiddleName" placeholder="Middle Name" />
                </div>
                <div class="form-group">
                  <i class="fa-solid fa-user-tag"></i>
                  <input type="text" id="SULastName" name="SULastName" placeholder="Last Name "/>
                </div>
              </div>
              
              <div class="signup-right">
                <div class="form-group">
                  <i class="fa-solid fa-envelope"></i>
                  <input type="email" id="SUEmail" name="SUEmail" placeholder="Email"/>
                </div>
                <div class="form-group">
                  <i class="fas fa-lock"></i>
                  <input type="password" class="password-field" id="SUPassword" name="SUPassword" placeholder="Password" />
                  <i class="fas fa-eye-slash toggle-password" data-target="SUPassword" style="cursor: pointer;"></i>
                </div>
                <div class="form-group">
                  <i class="fas fa-lock"></i>
                  <input type="password" class="password-field" id="SURePassword" name="SURePassword" placeholder="Re-Password" />
                  <i class="fas fa-eye-slash toggle-password" data-target="SURePassword" style="cursor: pointer;"></i>
                </div>
                <div class="form-group">
                  <div class="file-upload-wrapper">
                    <input type="file" id="SUPhoto" name="SUPhoto" hidden/>
                    <label for="SUPhoto" class="custom-file-upload">
                      <i class="fa-solid fa-upload"></i> Choose Photo
                    </label>
                    <span id="fileName">No file selected</span>
                  </div>  
                </div>
              </div>   
            </div>   

            <div class="signup-bottom">
              <button id="buttonSignUp" class="primary-button signup-button" type="button">Sign Up</button>   
            </div>
              
          </div>
        </form>
      </div>
      <!-- END OF SIGNUP -->


      <!-- FOOTER SECTION -->
      <div class="section-footer">
        <div class="footer-links">
          <a href="https://sacli.edu.ph/privacy-policy/" target="_blank">Privacy Policy</a>
          <span>|</span>
          <a href="https://sacli.edu.ph/terms-of-use/" target="_blank">Terms of Use</a>
          <span>|</span>
          <a href="https://sacli.edu.ph/sitemap/" target="_blank">Sitemap</a>
          <p>Design and Developed by <a class="programmer-name" href="https://www.facebook.com/sampalokin219" target="_blank">Jovan</a></p>
        </div>
      </div>
      <!-- END OF FOOTER -->
    </div>
    <!-- END OF CONTAINER -->

    <!-- JQUERY VENDOR -->
    <script src="public/vendor/jquery/jquery.min.js"></script>

    <!-- UTILS -->
    <script src="public/js/utils/form-utils.js"></script>

    <!-- MAIN JS -->
    <script src="public/js/main.js"></script>

    <!-- AUTHENTICATION -->
    <script src="public/js/auth/signin.js"></script>
    <script src="public/js/auth/signup.js"></script>

    <!-- TOASTIFY -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  </body>
</html>
