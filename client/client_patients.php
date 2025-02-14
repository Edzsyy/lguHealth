<?php
include('../api/config/dbconn.php');
include('../client/assets/inc/header.php');
include('../client/assets/inc/sidebar.php');
include('../client/assets/inc/navbar.php');
?>
<main>
  <div class="container mt-4">
    <h1>Patient Management</h1>
    <div class="row">
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">List of Patients</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPatientModal">Add New Patient</button>
          </div>

  <!-- Add Patient Modal -->
  <div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addPatientModalLabel">Add New Patient</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addPatientForm" method="post" action="">
            <div class="mb-3">
              <label for="patientName" class="form-label">Name</label>
              <input type="text" class="form-control" id="patientName" name="patientName" required>
            </div>
            <div class="mb-3">
              <label for="patientDob" class="form-label">Date of Birth</label>
              <input type="date" class="form-control" id="patientDob" name="patientDob" required>
            </div>
            <div class="mb-3">
              <label for="patientGender" class="form-label">Gender</label>
              <select class="form-select" id="patientGender" name="patientGender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="mb-3">
              <input type="hidden" class="form-control" id="patientAge" name="patientAge" required>
            </div>
            <div class="mb-3">
              <label for="patientContact" class="form-label">Contact Number</label>
              <input type="text" class="form-control" id="patientContact" name="patientContact" required>
            </div>
            <div class="mb-3">
              <label for="patientAddress" class="form-label">Address</label>
              <input type="text" class="form-control" id="patientAddress" name="patientAddress" required>
            </div>
            <div class="mb-3">
              <label for="patientMedicalHistory" class="form-label">Medical History</label>
              <textarea class="form-control" id="patientMedicalHistory" name="patientMedicalHistory"></textarea>
            </div>
            <div class="mb-3">
              <label for="patientAllergies" class="form-label">Allergies</label>
              <textarea class="form-control" id="patientAllergies" name="patientAllergies"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Patient</button>
          </form>
        </div>
      </div>
    </div>
  </div>


  
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>


document.getElementById('addPatientForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Ensure patientAge is calculated
    const dobInput = document.getElementById('patientDob').value;
    if (dobInput) {
        const dob = new Date(dobInput);
        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        if (today.getMonth() < dob.getMonth() || (today.getMonth() === dob.getMonth() && today.getDate() < dob.getDate())) {
            age--;
        }
        document.getElementById('patientAge').value = age;  // Set in form field
    }

    // Now fetch all form values correctly
    const formData = {
        patientName: document.getElementById('patientName').value,
        patientDob: document.getElementById('patientDob').value,
        patientGender: document.getElementById('patientGender').value,
        patientContact: document.getElementById('patientContact').value,
        patientAddress: document.getElementById('patientAddress').value,
        patientMedicalHistory: document.getElementById('patientMedicalHistory').value,
        patientAllergies: document.getElementById('patientAllergies').value,
        patientAge: document.getElementById('patientAge').value  // Now patientAge is guaranteed to be set
    };

    console.log("Sending Payload:", formData); // Debugging step to verify data

    fetch('../api/client/patient_management/add_patient.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Patient Added Successfully");
            const modal = document.getElementById('addPatientModal');
            const modalInstance = bootstrap.Modal.getInstance(modal);
            modalInstance.hide();
            document.getElementById('addPatientForm').reset();
        } else {
            alert('Failed to add patient: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to add patient!');
    });
});

  
</script>
</body>

</html>"