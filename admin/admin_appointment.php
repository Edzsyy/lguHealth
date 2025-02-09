<?php
include('../api/config/dbconn.php');
include('../admin/assets/inc/header.php');
include('../admin/assets/inc/sidebar.php');
include('../admin/assets/inc/navbar.php');
?>
<main>
    <div class="container mt-4">
        <h1>Appointment Management</h1>
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">List of Appointments</h5>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">Add New Appointment</button>
                    </div>
                    <!-- Filter Options -->
                    <div class="card-body">
                        <form id="appointmentFilterForm">
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="filterPatient" class="form-label">Patient Name</label>
                                    <input type="text" class="form-control" id="filterPatient" name="filterPatient" placeholder="Enter Patient Name">
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
                                    <label for="filterDoctor" class="form-label">Doctor Name</label>
                                    <input type="text" class="form-control" id="filterDoctor" name="filterDoctor" placeholder="Enter Doctor Name">
                                </div>
                                <div class="col-md-4">
                                    <label for="filterStatus" class="form-label">Status</label>
                                    <select class="form-select" id="filterStatus" name="filterStatus">
                                        <option value="">All</option>
                                        <option value="scheduled">Scheduled</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-secondary  w-100" id="applyFiltersButton">Apply Filters</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Doctor</th>
                                        <th>Appointment Date</th>
                                        <th>Status</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody id="appointmentTableBody">
                                    <!-- Rows will be dynamically added here -->
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Appointment Modal -->
    <div class="modal fade" id="addAppointmentModal" tabindex="-1" aria-labelledby="addAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAppointmentModalLabel">Add New Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addAppointmentForm" method="post" action="">
                        <div class="mb-3" id="PatientNameDiv">
                            <label for="appointmentPatient" class="form-label">Patient Name</label>
                            <input type="text" class="form-control" id="appointmentPatient" name="appointmentPatient">
                        </div>
                        <div class="mb-3">
                            <label for="appointmentDoctor" class="form-label">Doctor</label>
                            <select class="form-select" id="appointmentDoctor" name="appointmentDoctor" required></select>
                        </div>
                        <div class="mb-3">
                            <label for="appointmentDate" class="form-label">Appointment Date</label>
                            <input type="datetime-local" class="form-control" id="appointmentDate" name="appointmentDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="appointmentNotes" class="form-label">Notes</label>
                            <textarea class="form-control" id="appointmentNotes" name="appointmentNotes"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Appointment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Appointment Modal -->
    <div class="modal fade" id="viewAppointmentModal" tabindex="-1" aria-labelledby="viewAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewAppointmentModalLabel">Appointment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="viewAppointmentModalBody">
                    <!-- Appointment details will be loaded here -->
                    <p><strong>Appointment ID:</strong> <span id="appointmentIdDisplay"></span></p>
                    <p><strong>Patient Name:</strong> <span id="appointmentPatientDisplay"></span></p>
                    <p><strong>Doctor Name:</strong> <span id="appointmentDoctorDisplay"></span></p>
                    <p><strong>Appointment Date:</strong> <span id="appointmentDateDisplay"></span></p>
                    <p><strong>Status:</strong> <span id="appointmentStatusDisplay"></span></p>
                    <p><strong>Notes:</strong> <span id="appointmentNotesDisplay"></span></p>
                    <a id="editAppointmentButton" href="" class="btn btn-sm btn-primary">Edit</a>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const addAppointmentForm = document.getElementById("addAppointmentForm");

        function populateDoctors() {
            fetch('../api/appointment_management/get_doctors.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch doctors');
                    }
                    return response.json();
                })
                .then(data => {
                    const doctorSelect = document.getElementById('appointmentDoctor');
                    doctorSelect.innerHTML = ''; // Clear existing options

                    if (data.success && data.doctors.length > 0) {
                        data.doctors.forEach(doctor => {
                            const option = document.createElement('option');
                            option.value = doctor.user_id;
                            option.textContent = doctor.user_name;
                            doctorSelect.appendChild(option);
                        });
                    } else {
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'No doctors available';
                        doctorSelect.appendChild(option);
                    }
                })
                .catch(error => {
                    console.error('Error fetching doctors:', error);
                    alert('Failed to fetch doctors');
                });
        }
        // Call populateDoctors to load the data
        populateDoctors();

        // Function to collect form data
        function getFormData(form) {
            const formData = new FormData(form);
            let formObject = {};
            formData.forEach((value, key) => {
                formObject[key] = value;
            });
            return formObject;
        }

        // Handle form submission with AJAX
        addAppointmentForm.addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent page reload

            const appointmentData = getFormData(addAppointmentForm);

            fetch("../api/appointment_management/add_appointment.php", { // Adjust API path accordingly
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(appointmentData),
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        alert("Appointment added successfully!");
                        addAppointmentForm.reset(); // Reset form fields
                        document.getElementById("addAppointmentModal").classList.remove("show"); // Hide modal
                        location.reload(); // Reload to update UI
                    } else {
                        alert("Error: " + result.message);
                    }
                })
                .catch(error => console.error("Error submitting appointment:", error));
        });
    });



    document.addEventListener("DOMContentLoaded", function() {
        const appointmentTableBody = document.getElementById("appointmentTableBody");
        const filterForm = document.getElementById("appointmentFilterForm");

        // Function to fetch and populate appointment data
        async function fetchAppointments(filters = {}) {
            try {
                let queryParams = new URLSearchParams(filters).toString();
                let response = await fetch(`../api/appointment_management/list_appointments.php?${queryParams}`);
                let data = await response.json();

                // Clear existing table rows
                appointmentTableBody.innerHTML = "";

                if (data.length === 0) {
                    appointmentTableBody.innerHTML = `<tr><td colspan="5" class="text-center">No appointments found</td></tr>`;
                    return;
                }

                // Populate the table
                data.forEach(appointment => {
                    let row = `
                    <tr>
                        <td>${appointment.patient_name}</td>
                        <td>${appointment.doctor_name}</td>
                        <td>${appointment.appointment_date}</td>
                        <td>${appointment.status}</td>
                        <td>${appointment.notes || "N/A"}</td>
                    </tr>
                `;
                    appointmentTableBody.innerHTML += row;
                });
            } catch (error) {
                console.error("Error fetching appointments:", error);
            }
        }

        // Fetch appointments initially (without filters)
        fetchAppointments();

        // Handle filter submission
        // Handle form submission for filtering
    filterForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const filters = {
            filterPatient: document.getElementById("filterPatient").value.trim(),
            filterStartDate: document.getElementById("filterStartDate").value,
            filterEndDate: document.getElementById("filterEndDate").value,
            filterDoctor: document.getElementById("filterDoctor").value.trim(),
            filterStatus: document.getElementById("filterStatus").value
        };

        fetchAppointments(filters);
    });
            
      
    });
</script>
</body>

</html>