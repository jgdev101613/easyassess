<div class="container">
    <div class="clearance-box" data-allowed="true">
      <div class="clearance-title">Librarian</div>
      <div class="sub-items">View requirements & request signature</div>
      <div class="status">
        <span class="status-circle pending"></span>
        <p>Pending</p>
      </div>
    </div>

    <div class="clearance-box" data-allowed="false"> 
      <div class="clearance-title">Office of Student Affairs</div>
      <div class="sub-items">- POD</div>
      <div class="sub-items">- Psychology Test</div>
      <div class="sub-items">- Foundation</div>
      <div class="status">
        <span class="status-circle pending"></span>
        <p>Pending</p>
      </div>
    </div>

    <div class="clearance-box" data-allowed="false">
      <div class="clearance-title">Dean</div>
      <div class="sub-items">View requirements & request signature</div>
      <div class="status">
        <span class="status-circle pending"></span>
        <p>Pending</p>
      </div>
    </div>

    <div class="clearance-box" data-allowed="false">
      <div class="clearance-title">Registrar</div>
      <div class="sub-items">View requirements & request signature</div>
      <div class="status">
        <span class="status-circle pending"></span>
        <p>Pending</p>
      </div>
    </div>

    <div class="clearance-box" data-allowed="false">
      <div class="clearance-title">Accounting</div>
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
        <input type="file" id="attachment" name="attachment" required>
        <button type="submit">Submit</button>
      </form>
      <div class="requirements-list">
        <h3>Requirements:</h3>
        <ul>
          <li>None</li>
        </ul>
        <p>NOTE: If there's no requirements just click submit to request to be signed.</p>
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