<?php
include('../admin/assets/config/dbconn.php');
include('../admin/assets/inc/header.php');
include('../admin/assets/inc/sidebar.php');
include('../admin/assets/inc/navbar.php');
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
                   <!-- Filter Options -->
                    <div class="card-body">
                         <form id="patientFilterForm">
                              <div class="row g-3 mb-3">
                                  <div class="col-md-4">
                                      <label for="filterName" class="form-label">Name</label>
                                      <input type="text" class="form-control" id="filterName" name="filterName" placeholder="Enter Patient Name">
                                 </div>
                                 <div class="col-md-4">
                                      <label for="filterStartDate" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="filterStartDate" name="filterStartDate">
                                 </div>
                                  <div class="col-md-4">
                                      <label for="filterEndDate" class="form-label">End Date</label>
                                      <input type="date" class="form-control" id="filterEndDate" name="filterEndDate">
                                  </div>
                            </div>
                            <div class="row g-3 mb-3">
                                   <div class="col-md-4">
                                     <label for="filterAdmissionType" class="form-label">Admission Type</label>
                                    <select class="form-select" id="filterAdmissionType" name="filterAdmissionType">
                                           <option value="">All</option>
                                            <option value="emergency">Emergency</option>
                                          <option value="planned">Planned</option>
                                    </select>
                                 </div>
                                  <div class="col-md-4">
                                       <label for="filterStatus" class="form-label">Patient Status</label>
                                      <select class="form-select" id="filterStatus" name="filterStatus">
                                           <option value="">All</option>
                                           <option value="active">Active</option>
                                            <option value="discharged">Discharged</option>
                                    </select>
                                  </div>
                                 <div class="col-md-4">
                                       <label for="filterGender" class="form-label">Gender</label>
                                      <select class="form-select" id="filterGender" name="filterGender">
                                           <option value="">All</option>
                                           <option value="male">Male</option>
                                           <option value="female">Female</option>
                                            <option value="other">Other</option>
                                     </select>
                                 </div>
                             </div>
                           <div class="row g-3 mb-3">
                              <div class="col-md-4">
                                   <label for="filterAge" class="form-label">Age</label>
                                  <input type="number" class="form-control" id="filterAge" name="filterAge" placeholder="Enter age">
                                </div>
                                 <div class="col-md-4">
                                      <label for="filterDoctor" class="form-label">Assigned Doctor</label>
                                      <input type="text" class="form-control" id="filterDoctor" name="filterDoctor" placeholder="Enter doctor name">
                                   </div>
                                  <div class="col-md-4 d-flex align-items-end">
                                        <button type="submit" class="btn btn-secondary w-100" id="applyFiltersButton">Apply Filters</button>
                                   </div>
                             </div>
                         </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Patient ID</th>
                                        <th>Name</th>
                                        <th>Date of Birth</th>
                                        <th>Gender</th>
                                        <th>Contact Number</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="patient-table-body">
                                     <tr>
                                         <td>12345</td>
                                        <td>Patient A</td>
                                        <td>1990-05-15</td>
                                        <td>Male</td>
                                        <td>123-456-7890</td>
                                          <td>
                                            <button class="btn btn-sm btn-info view-patient-btn" data-bs-toggle="modal" data-bs-target="#viewPatientModal" data-patient-id="12345">View</button>
                                        </td>
                                      </tr>
                                       <tr>
                                         <td>67890</td>
                                          <td>Patient B</td>
                                          <td>1988-12-24</td>
                                          <td>Female</td>
                                          <td>987-654-3210</td>
                                          <td>
                                             <button class="btn btn-sm btn-info view-patient-btn" data-bs-toggle="modal" data-bs-target="#viewPatientModal" data-patient-id="67890">View</button>
                                        </td>
                                      </tr>
                                       <tr>
                                           <td>13579</td>
                                          <td>Patient C</td>
                                          <td>2000-03-01</td>
                                          <td>Female</td>
                                         <td>555-123-4567</td>
                                          <td>
                                              <button class="btn btn-sm btn-info view-patient-btn" data-bs-toggle="modal" data-bs-target="#viewPatientModal" data-patient-id="13579">View</button>
                                         </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

     <!-- View Patient Modal -->
    <div class="modal fade" id="viewPatientModal" tabindex="-1" aria-labelledby="viewPatientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewPatientModalLabel">Patient Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                  <div class="modal-body" id="viewPatientModalBody">
                    <!-- Patient details will be loaded here -->
                   <p><strong>Patient ID:</strong> <span id="patientIdDisplay"></span></p>
                    <p><strong>Name:</strong> <span id="patientNameDisplay"></span></p>
                     <p><strong>Date of Birth:</strong> <span id="patientDobDisplay"></span></p>
                     <p><strong>Gender:</strong> <span id="patientGenderDisplay"></span></p>
                      <p><strong>Contact Number:</strong> <span id="patientContactDisplay"></span></p>
                     <p><strong>Address:</strong> <span id="patientAddressDisplay"></span></p>
                     <p><strong>Medical History:</strong> <span id="patientMedicalHistoryDisplay"></span></p>
                     <p><strong>Allergies:</strong> <span id="patientAllergiesDisplay"></span></p>
                     <a id="editPatientButton" href="" class="btn btn-sm btn-primary">Edit</a>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
       // Javascript implementation, You will have to implement the save data with php
      document.getElementById('addPatientForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

         // Get form values (you can add validation in here)
         const patientName = document.getElementById('patientName').value;
         const patientDob = document.getElementById('patientDob').value;
         const patientGender = document.getElementById('patientGender').value;
         const patientContact = document.getElementById('patientContact').value;
          const patientAddress = document.getElementById('patientAddress').value;
         const patientMedicalHistory = document.getElementById('patientMedicalHistory').value;
         const patientAllergies = document.getElementById('patientAllergies').value;

            // Prepare data
         const formData = {
             patientName: patientName,
            patientDob: patientDob,
            patientGender: patientGender,
             patientContact: patientContact,
            patientAddress: patientAddress,
            patientMedicalHistory: patientMedicalHistory,
             patientAllergies: patientAllergies
            };

        console.log(formData); // for debugging purposes

         // Reset the form
          document.getElementById('addPatientForm').reset();
       // close modal
        const modal = document.getElementById('addPatientModal');
        const modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();
         // Display a success message or redirect to the patient list page
          alert("Patient Added Successfully, data has been logged in the console")
           // redirect to the current page (after modal is hidden)
          window.location.href = "admin_patients.php";
    });
    // handle filter form
      document.getElementById('patientFilterForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally
        // Get all the filter values
         const filterName = document.getElementById('filterName').value;
        const filterStartDate = document.getElementById('filterStartDate').value;
        const filterEndDate = document.getElementById('filterEndDate').value;
        const filterAdmissionType = document.getElementById('filterAdmissionType').value;
        const filterStatus = document.getElementById('filterStatus').value;
        const filterGender = document.getElementById('filterGender').value;
         const filterAge = document.getElementById('filterAge').value;
        const filterDoctor = document.getElementById('filterDoctor').value;

           // Prepare filter data
         const filterData = {
              filterName: filterName,
            filterStartDate: filterStartDate,
            filterEndDate: filterEndDate,
             filterAdmissionType: filterAdmissionType,
            filterStatus: filterStatus,
             filterGender: filterGender,
             filterAge: filterAge,
             filterDoctor: filterDoctor
            };
       console.log(filterData); // for debugging purposes
         // you will have to make a php api to use this data and update the content of the table, using fetch
        // for the moment we are using a console log
          alert("Filters have been applied, see console")
    });

     // Handle view patient button clicks using javascript
    document.querySelectorAll('.view-patient-btn').forEach(button => {
        button.addEventListener('click', function() {
            const patientId = this.getAttribute('data-patient-id');
              // Example of hardcoded data, here you need to implement php for it.
              const patientDetails = {
              "12345": {
                  name: "Patient A",
                 dob: "1990-05-15",
                 gender: "Male",
                 contact: "123-456-7890",
                  address: "123 Main St",
                   medicalHistory: "No prior condition",
                    allergies: "none"
                },
                "67890": {
                     name: "Patient B",
                     dob: "1988-12-24",
                     gender: "Female",
                     contact: "987-654-3210",
                     address: "456 Oak Ave",
                    medicalHistory: "Heart Condition",
                     allergies: "Penicillin"
                   },
                  "13579": {
                     name: "Patient C",
                      dob: "2000-03-01",
                      gender: "Female",
                      contact: "555-123-4567",
                      address: "789 Pine Ln",
                     medicalHistory: "Asthma",
                     allergies: "Dust"
                  }
             };
         const patient = patientDetails[patientId];

         // Set the content of the modal based on the selected patient
           document.getElementById('patientIdDisplay').textContent = patientId;
            document.getElementById('patientNameDisplay').textContent = patient.name;
           document.getElementById('patientDobDisplay').textContent = patient.dob;
          document.getElementById('patientGenderDisplay').textContent = patient.gender;
           document.getElementById('patientContactDisplay').textContent = patient.contact;
           document.getElementById('patientAddressDisplay').textContent = patient.address;
           document.getElementById('patientMedicalHistoryDisplay').textContent = patient.medicalHistory;
           document.getElementById('patientAllergiesDisplay').textContent = patient.allergies;
           document.getElementById('editPatientButton').href = `admin_edit_patient.php?id=${patientId}`;
        });
    });
</script>
</body>
</html>