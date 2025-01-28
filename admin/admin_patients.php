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
                                            <option value="staff">Staff</option>
                                          <option value="self-registered">Self-Registered</option>
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
                       <input type="text" class="form-control" id="patientName" name="patientName" required placeholder="Enter full name">
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
                       <input type="text" class="form-control" id="patientContact" name="patientContact" required placeholder="Enter contact number">
                    </div>
                      <div class="mb-3">
                         <label for="patientAddress" class="form-label">Address</label>
                         <input type="text" class="form-control" id="patientAddress" name="patientAddress" required placeholder="Enter full address">
                    </div>
                     <div class="mb-3">
                        <label for="admissionType" class="form-label">Admission Type</label>
                        <select class="form-select" id="admissionType" name="admissionType" required>
                            <option value="staff">Staff</option>
                            <option value="self-registered">Self-Registered</option>
                        </select>
                       </div>
                      <div class="mb-3">
                        <label for="patientStatus" class="form-label">Patient Status</label>
                           <select class="form-select" id="patientStatus" name="patientStatus" required>
                             <option value="active">Active</option>
                            <option value="discharged">Discharged</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="doctorAssigned" class="form-label">Assigned Doctor</label>
                         <select class="form-select" id="doctorAssigned" name="doctorAssigned" required>
                                <option value="">Select Doctor</option>
                                <?php foreach ($doctors as $doctor): ?>
                                    <option value="<?php echo $doctor['user_id']; ?>" ><?php echo $doctor['user_name']; ?></option>
                                <?php endforeach; ?>
                           </select>
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
    // Function to handle filter form
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
          fetch('/lguHealth/api/patients_management/get_patients.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
               },
                body: JSON.stringify({filterData: filterData})
             })
               .then(response => {
                  if (!response.ok) {
                     throw new Error('Failed to fetch patients');
                }
                    return response.json();
               })
               .then(patients => {
                    displayPatients(patients);
              })
               .catch(error => {
                   console.error('Error fetching patients:', error);
                     alert('Failed to fetch patients');
              });
    });
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
        const admissionType = document.getElementById('admissionType').value;
        const patientStatus = document.getElementById('patientStatus').value;
        const doctorAssigned = document.getElementById('doctorAssigned').value;
           // Prepare data
        const formData = {
             patientName: patientName,
            patientDob: patientDob,
            patientGender: patientGender,
             patientContact: patientContact,
            patientAddress: patientAddress,
           patientMedicalHistory: patientMedicalHistory,
            patientAllergies: patientAllergies,
            admissionType: admissionType,
            patientStatus: patientStatus,
            doctorAssigned: doctorAssigned
         };
        fetch('/lguHealth/api/patients_management/add_patient.php',{
           method: 'POST',
            headers: {
               'Content-Type': 'application/json',
               },
                body: JSON.stringify(formData)
           })
          .then(response => {
                if (!response.ok) {
                  throw new Error('Failed to add patient');
                }
               return response.json();
             })
            .then(data => {
               if (data.success) {
                   alert("Patient Added Successfully");
                     document.getElementById('patientFilterForm').dispatchEvent(new Event('submit')); //trigger submit for update table
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
      // Handle view patient button clicks using javascript
    document.querySelectorAll('.view-patient-btn').forEach(button => {
        button.addEventListener('click', function() {
           const patientId = this.getAttribute('data-patient-id');
             fetch(`/lguHealth/api/patients_management/get_patient.php?patientId=${patientId}`)
               .then(response => {
                  if (!response.ok) {
                    throw new Error('Failed to fetch patient details');
                   }
                  return response.json();
               })
            .then(patient => {
                   document.getElementById('patientIdDisplay').textContent = patient.patient_id;
                  document.getElementById('patientNameDisplay').textContent = patient.patient_name;
                 document.getElementById('patientDobDisplay').textContent = patient.date_of_birth;
                  document.getElementById('patientGenderDisplay').textContent = patient.gender;
                  document.getElementById('patientContactDisplay').textContent = patient.contact_number;
                 document.getElementById('patientAddressDisplay').textContent = patient.address;
                  document.getElementById('patientMedicalHistoryDisplay').textContent = patient.medical_history;
                  document.getElementById('patientAllergiesDisplay').textContent = patient.allergies;
                   document.getElementById('editPatientButton').href = `admin_edit_patient.php?id=${patient.patient_id}`;
             })
             .catch(error => {
                console.error('Error:', error);
                alert('Failed to fetch patient details');
            });
      });
    });
     function displayPatients(patients){
         const tableBody = document.getElementById('patient-table-body');
         tableBody.innerHTML = ''; // Clear existing data
           patients.forEach(patient => {
             const row = tableBody.insertRow();
                row.innerHTML = `
                  <td>${patient.patient_id}</td>
                   <td>${patient.patient_name}</td>
                   <td>${patient.date_of_birth}</td>
                   <td>${patient.gender}</td>
                    <td>${patient.contact_number}</td>
                    <td>
                    <button class="btn btn-sm btn-info view-patient-btn" data-bs-toggle="modal" data-bs-target="#viewPatientModal" data-patient-id="${patient.patient_id}">View</button>
                       </td>
               `;
            });
      }
         // Fetch the doctors data and populate the dropdown list
    fetch('/lguHealth/api/patients_management/get_doctors.php')
    .then(response => {
       if (!response.ok) {
          throw new Error('Failed to fetch doctors');
        }
        return response.json();
       })
      .then(doctors => {
            const doctorSelect = document.getElementById('doctorAssigned');
         doctors.forEach(doctor => {
                const option = document.createElement('option');
               option.value = doctor.user_id;
               option.text = doctor.user_name;
              if (doctor.patient_count >= 10) {
                  option.style.color = 'red'; // highlight if the doctor is assigned to 10 or more patients
               }
                doctorSelect.appendChild(option);
           });
        })
     .catch(error => {
          console.error('Error:', error);
           alert('Failed to fetch doctors');
     });
    // Fetch patients on page load
       document.getElementById('patientFilterForm').dispatchEvent(new Event('submit'));
</script>
</body>
</html>
</body>
</html>