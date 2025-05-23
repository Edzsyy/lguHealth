<?php
include('../doctor/assets/inc/header.php');
include('../doctor/assets/inc/sidebar.php');
include('../doctor/assets/inc/navbar.php');
?>
<main>
    <div class="container mt-4">
        <h1>Appointment Management</h1>
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">List of Appointments</h5>
                        <!-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">Add New Appointment</button> -->
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
                                        <th>Appointment Time</th>
                                        <th>Status</th>
                                        <th>Notes</th>
                                        <th>Actions</th>
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
                    <form id="addAppointmentForm">
                        <div class="mb-3">
                            <label for="appointmentPatient" class="form-label">Patient Name</label>
                            <input type="text" class="form-control" id="appointmentPatient" name="appointmentPatient">
                        </div>
                        <div class="mb-3">
                            <label for="appointmentDoctor" class="form-label">Doctor</label>
                            <select class="form-select" id="appointmentDoctor" name="appointmentDoctor" required></select>
                        </div>

                        <!-- Calendar Panel -->
                        <div class="mb-3">
                            <label for="appointmentDate" class="form-label">Appointment Date</label>
                            <input type="date" class="form-control" id="appointmentDate" name="appointmentDate" required>
                        </div>

                        <!-- Time Slot Selection -->
                        <div class="mb-3">
                            <label class="form-label">Available Time Slots(if time slot are missing it is already taken)</label>
                            <div id="timeSlots" class="d-flex flex-wrap gap-2">
                                <!-- Time slots will be dynamically added here -->
                            </div>
                            <input type="hidden" id="selectedTimeSlot" name="appointmentTime" required>
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

    <!-- Reschedule Appointment Modal -->
    <div class="modal fade" id="rescheduleAppointmentModal" tabindex="-1" aria-labelledby="rescheduleAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rescheduleAppointmentModalLabel">Reschedule Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="rescheduleAppointmentForm">
                        <input type="hidden" id="rescheduleAppointmentId">
                        <div class="mb-3">
                            <label for="reschedulePatient" class="form-label">Patient Name</label>
                            <input type="text" class="form-control" id="reschedulePatient" name="reschedulePatient" required>
                        </div>
                        <div class="mb-3">
                            <label for="rescheduleDoctor" class="form-label">Doctor</label>
                            <select class="form-select" id="rescheduleDoctor" name="rescheduleDoctor" required></select>
                        </div>
                        <div class="mb-3">
                            <label for="rescheduleDate" class="form-label">New Appointment Date(if time slot are missing it is already taken)</label>
                            <input type="date" class="form-control" id="rescheduleDate" name="rescheduleDate" required>
                        </div>
                        <div id="rescheduleTimeSlots" class="time-slot-container"></div>
                        <input type="hidden" id="rescheduleTime" name="appointmentTime"> <!-- Store selected time -->

                        <div class="mb-3">
                            <label for="rescheduleNotes" class="form-label">Notes</label>
                            <textarea class="form-control" id="rescheduleNotes" name="rescheduleNotes"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Elements
        const addAppointmentForm = document.getElementById("addAppointmentForm");
        const appointmentDate = document.getElementById("appointmentDate");
        const timeSlotsContainer = document.getElementById("timeSlots");
        const selectedTimeSlot = document.getElementById("selectedTimeSlot");
        const appointmentTableBody = document.getElementById("appointmentTableBody");
        const filterForm = document.getElementById("appointmentFilterForm");

        // Function to populate doctors
        function populateDoctors(selectId) {
            fetch('../api/appointment_management/get_doctors.php')
                .then(response => response.json())
                .then(data => {
                    const doctorSelect = document.getElementById(selectId);
                    if (!doctorSelect) return; // Prevent errors if element doesn't exist

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
        populateDoctors('appointmentDoctor'); // For Add Appointment Modal
        populateDoctors('rescheduleDoctor'); // For Reschedule Modal

        // Handle appointment date selection to fetch available slots
        appointmentDate.addEventListener("change", function() {
            const selectedDate = this.value;
            if (selectedDate) {
                fetch(`../api/appointment_management/get_available_slots.php?date=${selectedDate}`)
                    .then(response => response.json())
                    .then(data => {
                        timeSlotsContainer.innerHTML = ""; // Clear previous slots

                        if (data.availableSlots.length === 0) {
                            timeSlotsContainer.innerHTML = `<span class="text-danger">No available slots for this date.</span>`;
                            return;
                        }

                        data.availableSlots.forEach(time => {
                            const btn = document.createElement("button");
                            btn.type = "button";
                            btn.className = "btn btn-outline-primary";
                            btn.textContent = time;
                            btn.onclick = function() {
                                selectedTimeSlot.value = time;
                                document.querySelectorAll("#timeSlots .btn").forEach(b => b.classList.remove("btn-primary"));
                                btn.classList.add("btn-primary");
                            };
                            timeSlotsContainer.appendChild(btn);
                        });
                    })
                    .catch(error => console.error("Error fetching available slots:", error));
            }
        });

        // Function to collect form data
        function getFormData(form) {
            const formData = new FormData(form);
            let formObject = {};
            formData.forEach((value, key) => {
                formObject[key] = value;
            });
            return formObject;
        }

        // Handle form submission with AJAX for Adding Appointment
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


        // Fetch and Populate Appointment Data
        async function fetchAppointments(filters = {}) {
            try {
                let queryParams = new URLSearchParams(filters).toString();
                let response = await fetch(`../api/appointment_management/list_appointments.php?${queryParams}`);
                let data = await response.json();

                // Clear existing table rows
                appointmentTableBody.innerHTML = "";

                if (data.length === 0) {
                    appointmentTableBody.innerHTML = `<tr><td colspan="7" class="text-center">No appointments found</td></tr>`;
                    return;
                }

                // Populate the table
                data.forEach(appointment => {
                    let row = document.createElement('tr');

                    // Check if the status is 'completed' and modify the button
                    let completeButtonHtml = `
                <button class="btn btn-success btn-sm complete-btn" 
                        data-id="${appointment.appointment_id}" 
                        data-patient="${appointment.patient_name}" 
                        data-doctor="${appointment.doctor_id}" 
                        data-date="${appointment.appointment_date}" 
                        data-time="${appointment.appointment_time}" 
                        data-notes="${appointment.notes}">
                    Mark as Completed
                </button>
            `;

                    // If the status is 'completed', modify the button appearance and disable it
                    if ((appointment.status === "Completed") || (appointment.status === "Cancelled")) {
                        completeButtonHtml = `
                    <button class="btn btn-secondary btn-sm complete-btn" 
                            disabled 
                            data-id="${appointment.appointment_id}" 
                            data-patient="${appointment.patient_name}" 
                            data-doctor="${appointment.doctor_id}" 
                            data-date="${appointment.appointment_date}" 
                            data-time="${appointment.appointment_time}" 
                            data-notes="${appointment.notes}">
                        Completed
                    </button>
                `;
                    }

                    row.innerHTML = `
                <td>${appointment.patient_name}</td>
                <td>${appointment.doctor_name}</td>
                <td>${appointment.appointment_date}</td>
                <td>${appointment.appointment_time || "N/A"}</td>
                <td>${appointment.status}</td>
                <td>${appointment.notes || "N/A"}</td>
                <td>
                    ${completeButtonHtml}
                </td>
            `;

                    appointmentTableBody.appendChild(row);
                });
            } catch (error) {
                console.error("Error fetching appointments:", error);
            }
        }


        // Fetch appointments initially (without filters)
        fetchAppointments();

        // Handle filter submission
        filterForm.addEventListener("submit", function(event) {
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

        // Handle 'Mark as Completed' button click with confirmation
        document.addEventListener("click", function(event) {
            if (event.target && event.target.classList.contains("complete-btn")) {
                const appointmentId = event.target.getAttribute("data-id");
                const doctorId = event.target.getAttribute("data-doctor");
                const patientName = event.target.getAttribute("data-patient");
                const appointmentDate = event.target.getAttribute("data-date");
                const appointmentTime = event.target.getAttribute("data-time");
                const notes = event.target.getAttribute("data-notes");

                // Show confirmation prompt
                const confirmComplete = window.confirm("Are you sure you want to mark this appointment as completed?");

                if (confirmComplete) {
                    const completedAt = new Date().toISOString();

                    const requestData = {
                        appointmentId: appointmentId,
                        doctorId: doctorId,
                        completedAt: completedAt,
                    };

                    fetch("../api/appointment_management/mark_as_completed.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify(requestData),
                        })
                        .then(response => response.json())
                        .then(result => {
                            if (result.success) {
                                alert("Appointment marked as completed!");
                                fetchAppointments(); // Reload appointments to reflect changes
                            } else {
                                alert("Error: " + result.message);
                            }
                        })
                        .catch(error => console.error("Error marking appointment as completed:", error));
                }
            }
        });
    });
</script>


</body>

</html>