<?php
// SESSION
require_once "includes/session/config.session.inc.php";


if (!isset($_SESSION['user'])) {
  header('Location: index.php');
  exit();
}

$user_type = $_SESSION['user']['user_type'];
$userid = $_SESSION['user']['id'];
$profile_photo = $_SESSION['user']['profile_image'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- CSS -->
  <link rel="stylesheet" href="public/css/main.css" />
  <link rel="stylesheet" href="public/css/loading.css" />
  <link rel="stylesheet" href="public/css/component.css" />
  <link rel="stylesheet" href="public/css/profile.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <!-- ICON -->
  <link rel="icon" type="image/png" href="assets/saclilogo.png">

  <!-- TOASTIFY -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

  <title>Easy Assess - Profile</title>
</head>
<body data-userid="<?= htmlspecialchars($userid) ?>">

  <?php
  // Header
  include_once "includes/components/header.html";
  ?>

  <div class="container">
    <div class="profile-box">
      <div class="profile-header">
        <div class="profile-photo-wrapper">
          <img src="assets/default-profile.jpg" alt="Profile Photo" class="profile-photo" id="profileImage">
          <button class="edit-photo-btn" title="Edit Photo" id="editPhotoBtn">✎</button>
          <input type="file" id="photoInput" accept="image/*" style="display: none;">
        </div>
        <div class="user-info">
          <h2 class="user-name">Mark Jovan Canca</h2>
          <p class="user-status active">Status: Active</p>
        </div>
      </div>

      <div class="profile-details">
        <div class="detail-row"><span>User ID:</span> <strong id="userIdText"></strong></div>
        <div class="detail-row"><span>Student ID:</span> <strong id="studentIdText"></strong></div>
        <div class="detail-row"><span>First Name:</span> <strong id="firstNameText"></strong></div>
        <div class="detail-row"><span>Middle Name:</span> <strong id="middleNameText"></strong></div>
        <div class="detail-row"><span>Last Name:</span> <strong id="lastNameText"></strong></div>
        <div class="detail-row"><span>Email:</span> <strong id="emailText"></strong></div>
        <div class="detail-row"><span>Course:</span> <strong id="courseText"></strong></div>
        <div class="detail-row"><span>Year:</span> <strong id="yearText"></strong></div>
        <div class="detail-row"><span>Section:</span> <strong id="sectionText"></strong></div>
        <div class="detail-row"><span>Department:</span> <strong id="departmentText"></strong></div>
      </div>

      <button class="edit-profile-btn" id="editProfileBtn">Edit Profile</button>
      <!-- <button class="edit-profile-btn" style="background:#e67e22; margin-top:10px;" id="changePasswordBtn">Change Password</button> -->
    </div>
  </div>

  <!-- Edit Profile Modal -->
  <div id="editProfileModal" class="modal">
    <div class="modal-content">
      <span class="close-btn" id="closeProfileModal">&times;</span>
      <h2>Edit Profile Information</h2>
      <form id="editProfileForm">
        <input type="text" placeholder="First Name" required>
        <input type="text" placeholder="Middle Name">
        <input type="text" placeholder="Last Name" required>
        <input type="email" placeholder="Email" required>
        <input type="text" placeholder="Course">
        <input type="text" placeholder="Year">
        <input type="text" placeholder="Section">
        <input type="text" placeholder="Department">
        <button type="submit">Save Changes</button>
      </form>
    </div>
  </div>

  <!-- Change Password Modal -->
  <div id="changePasswordModal" class="modal">
    <div class="modal-content">
      <span class="close-btn" id="closePasswordModal">&times;</span>
      <h2>Change Password</h2>
      <form id="changePasswordForm">
        <input type="password" placeholder="Current Password" required>
        <input type="password" placeholder="New Password" required>
        <input type="password" placeholder="Confirm New Password" required>
        <button type="submit">Update Password</button>
      </form>
    </div>
  </div>

  <!-- View Full Image Modal -->
  <div id="viewImageModal" class="modal">
    <div class="modal-content" style="max-width: 600px; padding: 0; background: transparent; box-shadow: none;">
      <span class="close-btn" id="closeImageModal" style="color: black; font-size: 32px; right: 20px; top: 3px;">&times;</span>
      <img id="fullImagePreview" src="" alt="Full Size" style="width: 100%; border-radius: 12px;">
    </div>
  </div>

  <?php
  // Navigation
  include_once "includes/components/navigation.html";
  ?>

  <script type="module" src="public/js/utils/profile.js"></script>

  <!-- UPDATE PROFILE JS -->
  <script type="module" src="public/js/auth/updateProfile.js"></script>
    
</body>
</html>