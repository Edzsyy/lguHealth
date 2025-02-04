<?php
include('../api/config/dbconn.php');
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
                  <label for="filterAge" class="form-label">Age</label>
                  <input type="number" class="form-control" id="filterAge" name="filterAge" placeholder="Enter age">
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
                <div class="col-md-4 d-flex align-items-end">
                  <button type="submit" class="btn btn-secondary w-100" id="applyFiltersButton">Apply Filters</button>
                </div>
              </div>
              <div class="row g-3 mb-3">

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
                    <th>Admission Type</th>
                    <th>Patient Status</th>
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

  <!-- View Patient Modal -->
  <div class="modal fade" id="viewPatientModal" tabindex="-1" aria-labelledby="viewPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl"> <!-- Use modal-xl for a larger modal -->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewPatientModalLabel">Patient Details and Checkup</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <!-- Left Column: Patient Details -->
              <div class="col-md-4">
                <h4>Patient Details</h4>
                <p><strong>Patient ID:</strong> <span id="patientIdDisplay"></span></p>
                <p><strong>Name:</strong> <span id="patientNameDisplay"></span></p>
                <p><strong>Date of Birth:</strong> <span id="patientDobDisplay"></span></p>
                <p><strong>Gender:</strong> <span id="patientGenderDisplay"></span></p>
                <p><strong>Contact Number:</strong> <span id="patientContactDisplay"></span></p>
                <p><strong>Address:</strong> <span id="patientAddressDisplay"></span></p>
                <p><strong>Admission Type:</strong> <span id="patientAdmissionTypeDisplay"></span></p>
                <p><strong>Patient Status:</strong> <span id="patientStatusDisplay"></span></p>
                <p><strong>Medical History:</strong> <span id="patientMedicalHistoryDisplay"></span></p>
                <p><strong>Allergies:</strong> <span id="patientAllergiesDisplay"></span></p>
                <button id="editPatientButton" class="btn btn-sm btn-primary">Edit</button>
              </div>

              <!-- Middle Column: Diagnostic/Checkup Part -->
              <div class="col-md-4">
                <h4>Diagnostic or Checkup Part</h4>
                <div id="symptomsAccordion">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingGeneral">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGeneral" aria-expanded="true" aria-controls="collapseGeneral">
                        <i class="bi bi-plus-lg"></i> General Symptoms
                      </button>
                    </h2>
                    <div id="collapseGeneral" class="accordion-collapse collapse show" aria-labelledby="headingGeneral" data-bs-parent="#symptomsAccordion">
                      <div class="accordion-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="fever" id="symptomFever">
                              <label class="form-check-label" for="symptomFever">Fever</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="cough" id="symptomCough">
                              <label class="form-check-label" for="symptomCough">Cough</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="fatigue" id="symptomFatigue">
                              <label class="form-check-label" for="symptomFatigue">Fatigue</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="weakness" id="symptomWeakness">
                              <label class="form-check-label" for="symptomWeakness">Weakness</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="chills" id="symptomChills">
                              <label class="form-check-label" for="symptomChills">Chills</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="nightSweats" id="symptomNightSweats">
                              <label class="form-check-label" for="symptomNightSweats">Night sweats</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Respiratory Symptoms -->
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingRespiratory">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRespiratory" aria-expanded="false" aria-controls="collapseRespiratory">
                        <i class="bi bi-plus-lg"></i> Respiratory Symptoms
                      </button>
                    </h2>
                    <div id="collapseRespiratory" class="accordion-collapse collapse" aria-labelledby="headingRespiratory" data-bs-parent="#symptomsAccordion">
                      <div class="accordion-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="shortnessOfBreath" id="symptomShortnessOfBreath">
                              <label class="form-check-label" for="symptomShortnessOfBreath">Shortness of breath (dyspnea)</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="soreThroat" id="symptomSoreThroat">
                              <label class="form-check-label" for="symptomSoreThroat">Sore throat</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="runnyNose" id="symptomRunnyNose">
                              <label class="form-check-label" for="symptomRunnyNose">Runny or stuffy nose</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="sneezing" id="symptomSneezing">
                              <label class="form-check-label" for="symptomSneezing">Sneezing</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="wheezing" id="symptomWheezing">
                              <label class="form-check-label" for="symptomWheezing">Wheezing</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="chestPain" id="symptomChestPain">
                              <label class="form-check-label" for="symptomChestPain">Chest pain</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Digestive Symptoms -->
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingDigestive">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDigestive" aria-expanded="false" aria-controls="collapseDigestive">
                        <i class="bi bi-plus-lg"></i> Digestive Symptoms
                      </button>
                    </h2>
                    <div id="collapseDigestive" class="accordion-collapse collapse" aria-labelledby="headingDigestive" data-bs-parent="#symptomsAccordion">
                      <div class="accordion-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="nausea" id="symptomNausea">
                              <label class="form-check-label" for="symptomNausea">Nausea</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="vomiting" id="symptomVomiting">
                              <label class="form-check-label" for="symptomVomiting">Vomiting</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="diarrhea" id="symptomDiarrhea">
                              <label class="form-check-label" for="symptomDiarrhea">Diarrhea</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="constipation" id="symptomConstipation">
                              <label class="form-check-label" for="symptomConstipation">Constipation</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="abdominalPain" id="symptomAbdominalPain">
                              <label class="form-check-label" for="symptomAbdominalPain">Abdominal pain</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="bloating" id="symptomBloating">
                              <label class="form-check-label" for="symptomBloating">Bloating</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Neurological Symptoms -->
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingNeurological">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNeurological" aria-expanded="false" aria-controls="collapseNeurological">
                        <i class="bi bi-plus-lg"></i> Neurological Symptoms
                      </button>
                    </h2>
                    <div id="collapseNeurological" class="accordion-collapse collapse" aria-labelledby="headingNeurological" data-bs-parent="#symptomsAccordion">
                      <div class="accordion-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="headache" id="symptomHeadache">
                              <label class="form-check-label" for="symptomHeadache">Headache</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="dizziness" id="symptomDizziness">
                              <label class="form-check-label" for="symptomDizziness">Dizziness</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="confusion" id="symptomConfusion">
                              <label class="form-check-label" for="symptomConfusion">Confusion</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="numbness" id="symptomNumbness">
                              <label class="form-check-label" for="symptomNumbness">Numbness or tingling</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="muscleWeakness" id="symptomMuscleWeakness">
                              <label class="form-check-label" for="symptomMuscleWeakness">Muscle weakness</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Skin-Related Symptoms -->
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSkin">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSkin" aria-expanded="false" aria-controls="collapseSkin">
                        <i class="bi bi-plus-lg"></i> Skin-Related Symptoms
                      </button>
                    </h2>
                    <div id="collapseSkin" class="accordion-collapse collapse" aria-labelledby="headingSkin" data-bs-parent="#symptomsAccordion">
                      <div class="accordion-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="rash" id="symptomRash">
                              <label class="form-check-label" for="symptomRash">Rash</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="itching" id="symptomItching">
                              <label class="form-check-label" for="symptomItching">Itching</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="swelling" id="symptomSwelling">
                              <label class="form-check-label" for="symptomSwelling">Swelling</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="bruising" id="symptomBruising">
                              <label class="form-check-label" for="symptomBruising">Bruising</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="paleSkin" id="symptomPaleSkin">
                              <label class="form-check-label" for="symptomPaleSkin">Pale or bluish skin (cyanosis)</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Pain-Related Symptoms -->
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingPain">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePain" aria-expanded="false" aria-controls="collapsePain">
                        <i class="bi bi-plus-lg"></i> Pain-Related Symptoms
                      </button>
                    </h2>
                    <div id="collapsePain" class="accordion-collapse collapse" aria-labelledby="headingPain" data-bs-parent="#symptomsAccordion">
                      <div class="accordion-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="jointPain" id="symptomJointPain">
                              <label class="form-check-label" for="symptomJointPain">Joint pain</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="musclePain" id="symptomMusclePain">
                              <label class="form-check-label" for="symptomMusclePain">Muscle pain (myalgia)</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="backPain" id="symptomBackPain">
                              <label class="form-check-label" for="symptomBackPain">Back pain</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="chestPain" id="symptomChestPain2">
                              <label class="form-check-label" for="symptomChestPain2">Chest pain</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Eye & Ear Symptoms -->
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingEyeEar">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEyeEar" aria-expanded="false" aria-controls="collapseEyeEar">
                        <i class="bi bi-plus-lg"></i> Eye & Ear Symptoms
                      </button>
                    </h2>
                    <div id="collapseEyeEar" class="accordion-collapse collapse" aria-labelledby="headingEyeEar" data-bs-parent="#symptomsAccordion">
                      <div class="accordion-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="redEyes" id="symptomRedEyes">
                              <label class="form-check-label" for="symptomRedEyes">Red or itchy eyes</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="blurredVision" id="symptomBlurredVision">
                              <label class="form-check-label" for="symptomBlurredVision">Blurred vision</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="earPain" id="symptomEarPain">
                              <label class="form-check-label" for="symptomEarPain">Ear pain</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="hearingLoss" id="symptomHearingLoss">
                              <label class="form-check-label" for="symptomHearingLoss">Hearing loss</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="mt-3">
                  <h5>Detailed Explanation</h5>
                  <textarea class="form-control" id="detailedExplanation" rows="3"></textarea>
                </div>
                <div class="mt-3">
                  <h5>Gemini AI Suggestions for the Sickness</h5>
                  <textarea class="form-control" id="aiSuggestions" rows="3" readonly></textarea>
                </div>
                <button class="btn btn-secondary mt-3" id="generateResultButton">Generate Result</button>
                <button class="btn btn-secondary mt-3">Add to Result</button>
              </div>

              <!-- Right Column: Result -->
              <div class="col-md-4">
                <h4>Result</h4>
                <div>
                  <h5>Detailed Confirmed Sickness Description</h5>
                  <textarea class="form-control" id="sicknessDescription" rows="3" readonly></textarea>
                </div>
                <div class="mt-3">
                  <h5>Gemini AI Suggestions for Health Recovery</h5>
                  <textarea class="form-control" id="healthRecovery" rows="3" readonly></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Function to fetch and display patient data
  function fetchPatientsData(filterData = {}) {
    fetch('../api/patients_management/list_patients.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          filterData: filterData
        })
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
  }
  // Function to display patient data in the table
  function displayPatients(patients) {
    const tableBody = document.getElementById('patient-table-body');
    tableBody.innerHTML = ''; // Clear existing data
    patients.forEach(patient => {
      const row = tableBody.insertRow();
      row.innerHTML = `
                      <td>${patient.patient_id}</td>
                     <td>${patient.patient_name}</td>
                      <td>${patient.age}</td>
                      <td>${patient.gender}</td>
                      <td>${patient.admission_type}</td>
                      <td>${patient.patient_status}</td>
                       <td>
                         <button class="btn btn-sm btn-info view-patient-btn" data-bs-toggle="modal" data-bs-target="#viewPatientModal" data-patient-id="${patient.patient_id}">View</button>
                         <a href="admin_edit_patient.php?id=${patient.patient_id}" class="btn btn-sm btn-primary">Edit</a>
                         </td>
                      `;
    });
  }
  // handle filter form
  document.getElementById('patientFilterForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting normally
    // Get all the filter values
    const filterName = document.getElementById('filterName').value;
    const filterAge = document.getElementById('filterAge').value;
    const filterGender = document.getElementById('filterGender').value;
    const filterAdmissionType = document.getElementById('filterAdmissionType').value;
    const filterStatus = document.getElementById('filterStatus').value;
    // Prepare filter data
    const filterData = {
      filterName: filterName,
      filterAge: filterAge,
      filterGender: filterGender,
      filterAdmissionType: filterAdmissionType,
      filterStatus: filterStatus,
    };
    fetchPatientsData(filterData); // Fetch data with filters
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
    const patientAge = document.getElementById('patientAge').value;
    // Prepare data
    const formData = {
      patientName: patientName,
      patientDob: patientDob,
      patientGender: patientGender,
      patientContact: patientContact,
      patientAddress: patientAddress,
      patientMedicalHistory: patientMedicalHistory,
      patientAllergies: patientAllergies,
      patientAge: patientAge
    };
    fetch('../api/patients_management/add_patient.php', {
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
          document.getElementById('patientFilterForm').dispatchEvent(new Event('submit'));
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

  //age calculator
  document.getElementById('patientDob').addEventListener('change', function() {
    const dob = new Date(this.value);
    const today = new Date();
    let age = today.getFullYear() - dob.getFullYear();
    const month = today.getMonth() - dob.getMonth();
    if (month < 0 || (month === 0 && today.getDate() < dob.getDate())) {
      age--;
    }
    document.getElementById('patientAge').value = age;
  });


  //view modal function
  document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(event) {
      if (event.target.classList.contains('view-patient-btn')) {
        const patientId = event.target.getAttribute('data-patient-id');
        fetchPatientItem(patientId);
      }
    });
  });

  function fetchPatientItem(patientId) {
    fetch(`../api/patients_management/get_patient.php?patientId=${patientId}`)
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Populate the modal with item details
          const patient = data.data;
          document.getElementById('patientIdDisplay').textContent = patient.patient_id;
          document.getElementById('patientNameDisplay').textContent = patient.patient_name;
          document.getElementById('patientDobDisplay').textContent = patient.date_of_birth;
          document.getElementById('patientGenderDisplay').textContent = patient.gender;
          document.getElementById('patientContactDisplay').textContent = patient.contact_number;
          document.getElementById('patientAddressDisplay').textContent = patient.address;
          document.getElementById('patientMedicalHistoryDisplay').textContent = patient.medical_history;
          document.getElementById('patientAllergiesDisplay').textContent = patient.allergies;
          document.getElementById('patientAdmissionTypeDisplay').textContent = patient.admission_type;
          document.getElementById('patientStatusDisplay').textContent = patient.patient_status;
        } else {
          alert('Failed to retrieve item details.');
        }
      })
      .catch(error => console.error('Error:', error));
  }




  // Fetch patients on page load (initial display)
  fetchPatientsData();
</script>
</body>

</html>"