document.addEventListener("DOMContentLoaded", () => {
  fetchClearanceSubmissions();
  setupReviewButtons();

  let debounceTimer;
  document.getElementById("searchStudentID").addEventListener("input", (e) => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
      const studentId = e.target.value.trim();
      fetchClearanceSubmissions(studentId);
    }, 300); // wait 300ms before triggering
  });
});

async function fetchClearanceSubmissions(studentId = "") {
  try {
    let student = studentId.replace("-", "").trim();
    // const res = await fetch("includes/api/fetch-clearance.api.php");
    const res = await fetch(
      "includes/api/fetch-clearance.api.php?student_id=" +
        encodeURIComponent(student)
    );
    const data = await res.json();

    const container = document.querySelector(".container");
    const existingBoxes = document.querySelectorAll(".submission-box");
    existingBoxes.forEach((box) => box.remove()); // Clear old content

    data.forEach((submission) => {
      const box = document.createElement("div");
      box.classList.add("submission-box");

      const statusClass =
        submission.status === "approved"
          ? "submitted"
          : submission.status === "pending"
          ? "pending"
          : "needs-submission";

      box.innerHTML = `
        <div class="submission-header">
          <div>
            <h3 class="student-name">${submission.full_name}</h3>
            <p class="student-details">${submission.course} - ${
        submission.year_level
      }${submission.section}</p>
          </div>
          <span class="status-label ${statusClass}">${submission.status}</span>
        </div>

        <div class="submission-body">
          <p><strong>Attachments:</strong></p>
          <ul class="attachment-list">
            ${submission.attachments
              .map(
                (att) =>
                  `<li><a href="${att.attachment}" target="_blank"><img height="30" src="${att.attachment}"></img></a></li>`
              )
              .join("")}
          </ul>
          <button 
            class="btn-review" 
            data-id="${submission.student_id}"
            data-name="${submission.full_name}"
            data-details="${submission.course} - ${submission.year_level}${
        submission.section
      }"
            data-attachments='${JSON.stringify(submission.attachments)}'
          >
            Review & Sign
          </button>
        </div>
      `;

      container.appendChild(box);
    });

    // 👇 Call this AFTER all buttons are created
    setupReviewButtons();
  } catch (error) {
    console.error("Fetch error:", error);
  }
}

function setupReviewButtons() {
  const reviewButtons = document.querySelectorAll(".btn-review");
  reviewButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const modal = document.getElementById("reviewModal");

      // Get data from button attributes
      const name = button.dataset.name;
      const studentId = button.dataset.id;
      const details = button.dataset.details;
      const attachments = JSON.parse(button.dataset.attachments);

      // Set modal content
      document.getElementById("modalStudentName").textContent = name;
      document.getElementById("modalStudentID").textContent = studentId;
      document.getElementById("modalStudentDetails").textContent = details;

      const attachmentList = document.getElementById("modalAttachments");
      attachmentList.innerHTML = "";

      attachments.forEach((att) => {
        const fileName = att.attachment;
        const fileUrl = `assets/clearance-requirements/Users/${studentId}/${fileName}`;
        const fileExt = fileName.split(".").pop().toLowerCase();

        const li = document.createElement("li");

        // Check if file is image
        if (["jpg", "jpeg", "png", "gif", "webp"].includes(fileExt)) {
          const img = document.createElement("img");
          img.src = fileName;
          img.alt = fileName;
          img.style.maxWidth = "100%";
          img.style.maxHeight = "200px";
          img.style.borderRadius = "8px";
          img.style.marginBottom = "10px";
          li.appendChild(img);
        } else {
          // Default to download link
          const a = document.createElement("a");
          a.href = fileUrl;
          a.textContent = fileName;
          a.target = "_blank";
          a.style.display = "inline-block";
          a.style.marginBottom = "10px";
          a.style.fontWeight = "bold";
          li.appendChild(a);
        }

        attachmentList.appendChild(li);
      });

      // Show modal
      modal.style.display = "block";
    });
  });

  const approveBtn = document.querySelector(".btn-approve");

  approveBtn.onclick = async () => {
    const studentId = document.getElementById("modalStudentID").textContent;
    try {
      const response = await fetch(
        "includes/api/professor/approve-clearance.api.php",
        {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ student_id: studentId }),
        }
      );

      const result = await response.json();

      if (result.success) {
        alert("Clearance approved successfully.");
        document.getElementById("reviewModal").style.display = "none";
        fetchClearanceSubmissions(); // refresh list
      } else {
        alert("Failed to approve: " + result.message);
      }
    } catch (err) {
      console.error("Approval error:", err);
      alert("Something went wrong.");
    }
  };
}

document.querySelector(".close-btn").addEventListener("click", () => {
  document.getElementById("reviewModal").style.display = "none";
});

window.addEventListener("click", (e) => {
  const modal = document.getElementById("reviewModal");
  if (e.target === modal) {
    modal.style.display = "none";
  }
});
