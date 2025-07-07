<div class="container">
    <div class="clearance-box" data-allowed="true" data-pending="false">
      <div class="clearance-title" data-departmentid="LIB2025">Librarian</div>
      <div class="sub-items">View requirements & request signature</div>
      <div class="status">
        <span class="status-circle pending"></span>
        <p>Pending</p>
      </div>
    </div>

    <div class="clearance-box" data-allowed="false" data-pending="false"> 
      <div class="clearance-title" data-departmentid="OSA2025">Office of Student Affairs</div>
      <div class="sub-items">- POD</div>
      <div class="sub-items">- Psychology Test</div>
      <div class="sub-items">- Foundation</div>
      <div class="status">
        <span class="status-circle pending"></span>
        <p>Pending</p>
      </div>
    </div>

    <div class="clearance-box" data-allowed="false" data-pending="false">
      <div class="clearance-title" data-departmentid="DEAN2025">Dean</div>
      <div class="sub-items">View requirements & request signature</div>
      <div class="status">
        <span class="status-circle pending"></span>
        <p>Pending</p>
      </div>
    </div>

    <div class="clearance-box" data-allowed="false" data-pending="false">
      <div class="clearance-title" data-departmentid="REG2025">Registrar</div>
      <div class="sub-items">View requirements & request signature</div>
      <div class="status">
        <span class="status-circle pending"></span>
        <p>Pending</p>
      </div>
    </div>

    <div class="clearance-box" data-allowed="false" data-pending="false">
      <div class="clearance-title" data-departmentid="ACC2025" >Accounting</div>
      <div class="sub-items">View requirements & request signature</div>
      <div class="status">
        <span class="status-circle pending"></span>
        <p>Pending</p>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div id="requirementModal" class="modal">
    <div class="modal-content">
      <span class="close-btn">&times;</span>
      <h2>Submit Requirements</h2>
      <form id="requirementForm">
        <label for="attachment">Upload Attachment:</label>
        <input type="file" data-dapartmentid="" data-department="" id="attachment" name="attachments[]" multiple required>
        <button id="btnSubmitRequirements">Submit</button>
      </form>
      <div class="requirements-list">
        <h3>REMARKS:</h3>
        <p id="clearance-remarks">Remarks here.</p>
        <br>
        <p class="note">NOTE: If there's no remarks just click submit and if you need to return something please visit the particular department.</p>
      </div>
    </div>
  </div>

  <!-- Invalid Modal -->
  <div id="invalidModal" class="modal">
    <div class="modal-content invalid">
      <span class="close-btn">&times;</span>
      <h2>Access Denied</h2>
      <p>You must complete and submit the requirements for all previous sections before continuing.</p>
      <button class="ok-btn">Okay</button>
    </div>
  </div>
</div>

<!-- Main Script -->
<script type="module" src="public/js/main.js "></script>