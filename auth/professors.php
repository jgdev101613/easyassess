<?php

// SESSION
require_once "includes/session/config.session.inc.php";

$department = null;
if ($user_type === "professor") {
  $department = $_SESSION['user']['department_name'];
}

?>

<div class="container">
  <!-- PROFESSOR DASHBOARD -->
  <div class="search-bar">
    <input type="text" id="searchStudentID" placeholder="Search by Student ID...">
  </div>
  <h2 class="section-title">Clearance Submissions (<?= $department?>)</h2>

  <div class="submission-box">
    <div class="submission-header">
      <div>
        <h3 class="student-name">Juan Dela Cruz</h3>
        <p class="student-details">BSIT - 4A</p>
      </div>
      <span class="status-label submitted">Submitted</span>
    </div>

    <div class="submission-body">
      <p><strong>Attachments:</strong></p>
      <ul class="attachment-list">
        <li><a href="#">Requirement1.pdf</a></li>
        <li><a href="#">GoodMoral.jpg</a></li>
      </ul>
      <button class="btn-review">Review & Sign</button>
    </div>
  </div>

  <div class="submission-box">
    <div class="submission-header">
      <div>
        <h3 class="student-name">Maria Santos</h3>
        <p class="student-details">BSCS - 3B</p>
      </div>
      <span class="status-label pending">Pending</span>
    </div>

    <div class="submission-body">
      <p><strong>Attachments:</strong></p>
      <ul class="attachment-list">
        <li><a href="#">FinalProject.zip</a></li>
      </ul>
      <button class="btn-review">Review & Sign</button>
    </div>
  </div>

  <!-- Add more cards dynamically as needed -->
</div>

<!-- REVIEW & SIGN MODAL -->
<div id="reviewModal" class="modal">
  <div class="modal-content">
    <span class="close-btn">&times;</span>
    <h2>Review Clearance Submission</h2>

    <div class="student-info">
      <p><strong>Name:</strong> <span id="modalStudentName">Juan Dela Cruz</span></p>
      <p><strong>Student ID:</strong> <span id="modalStudentID">202312345</span></p>
      <p><strong>Course & Year:</strong> <span id="modalStudentDetails">BSIT - 4A</span></p>
    </div>

    <div class="modal-attachments">
      <h3>Attachments:</h3>
      <ul id="modalAttachments">
        <li><a href="#">Requirement1.pdf</a></li>
      </ul>
    </div>

    <div class="modal-actions">
      <button class="btn-approve">Approve</button>
      <button class="btn-reject">Reject</button>
    </div>
  </div>
</div>

<script src="public/js/utils/professor.js"></script>

