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
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Appointment ID</th>
                                        <th>Patient Name</th>
                                        <th>Doctor Name</th>
                                        <th>Appointment Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="appointment-table-body">
                                     <tr>
                                        <td>123</td>
                                        <td>Patient A</td>
                                          <td>Dr. Smith</td>
                                        <td>2024-08-10 10:00 AM</td>
                                          <td>Scheduled</td>
                                        <td>
                                             <button class="btn btn-sm btn-info view-appointment-btn" data-bs-toggle="modal" data-bs-target="#viewAppointmentModal" data-appointment-id="123">View</button>
                                        </td>
                                    </tr>
                                    <tr>
                                         <td>456</td>
                                        <td>Patient B</td>
                                          <td>Dr. Jones</td>
                                        <td>2024-08-12 2:00 PM</td>
                                           <td>Completed</td>
                                        <td>
                                               <button class="btn btn-sm btn-info view-appointment-btn" data-bs-toggle="modal" data-bs-target="#viewAppointmentModal" data-appointment-id="456">View</button>
                                        </td>
                                    </tr>
                                      <tr>
                                        <td>789</td>
                                         <td>Patient C</td>
                                          <td>Dr. Lee</td>
                                         <td>2024-08-15 9:00 AM</td>
                                          <td>Cancelled</td>
                                        <td>
                                             <button class="btn btn-sm btn-info view-appointment-btn" data-bs-toggle="modal" data-bs-target="#viewAppointmentModal" data-appointment-id="789">View</button>
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
                         <div class="mb-3">
                           <label for="appointmentPatient" class="form-label">Patient Name</label>
                            <input type="text" class="form-control" id="appointmentPatient" name="appointmentPatient" required>
                          </div>
                        <div class="mb-3">
                           <label for="appointmentDoctor" class="form-label">Doctor Name</label>
                            <input type="text" class="form-control" id="appointmentDoctor" name="appointmentDoctor" required>
                          </div>
                        <div class="mb-3">
                           <label for="appointmentDate" class="form-label">Appointment Date</label>
                           <input type="datetime-local" class="form-control" id="appointmentDate" name="appointmentDate" required>
                       </div>
                    <div class="mb-3">
                      <label for="appointmentStatus" class="form-label">Status</label>
                      <select class="form-select" id="appointmentStatus" name="appointmentStatus" required>
                        <option value="scheduled">Scheduled</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
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
        // Javascript implementation, You will have to implement the save data with php
    document.getElementById('addAppointmentForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally
      
        // Get the data from the form
         const appointmentPatient = document.getElementById('appointmentPatient').value;
         const appointmentDoctor = document.getElementById('appointmentDoctor').value;
          const appointmentDate = document.getElementById('appointmentDate').value;
         const appointmentStatus = document.getElementById('appointmentStatus').value;
         const appointmentNotes = document.getElementById('appointmentNotes').value;

            // Prepare data
          const formData = {
               appointmentPatient: appointmentPatient,
               appointmentDoctor: appointmentDoctor,
               appointmentDate: appointmentDate,
               appointmentStatus: appointmentStatus,
               appointmentNotes: appointmentNotes
            };
          console.log(formData); // for debugging purposes
          // Reset the form
          document.getElementById('addAppointmentForm').reset();
         // close modal
        const modal = document.getElementById('addAppointmentModal');
        const modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();
         // Display a success message or redirect to the patient list page
         alert("Appointment Added Successfully, data has been logged in the console")
          window.location.href = "admin_appointments.php"; //redirect to the current page
   });

     // handle filter form
    document.getElementById('appointmentFilterForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally
        // Get all the filter values
         const filterPatient = document.getElementById('filterPatient').value;
        const filterStartDate = document.getElementById('filterStartDate').value;
        const filterEndDate = document.getElementById('filterEndDate').value;
        const filterDoctor = document.getElementById('filterDoctor').value;
        const filterStatus = document.getElementById('filterStatus').value;
           // Prepare filter data
         const filterData = {
              filterPatient: filterPatient,
            filterStartDate: filterStartDate,
            filterEndDate: filterEndDate,
             filterDoctor: filterDoctor,
             filterStatus: filterStatus
            };
       console.log(filterData); // for debugging purposes
          // you will have to make a php api to use this data and update the content of the table, using fetch
        // for the moment we are using a console log
       alert("Filters have been applied, see console")
    });

    // Handle view appointment button clicks using javascript
      document.querySelectorAll('.view-appointment-btn').forEach(button => {
        button.addEventListener('click', function() {
            const appointmentId = this.getAttribute('data-appointment-id');
           // Example of hardcoded data, here you need to implement php for it.
              const appointmentDetails = {
              "123": {
                  patient: "Patient A",
                  doctor: "Dr. Smith",
                  date: "2024-08-10 10:00 AM",
                 status: "Scheduled",
                  notes: "Checkup"
                 },
              "456": {
                 patient: "Patient B",
                  doctor: "Dr. Jones",
                    date: "2024-08-12 2:00 PM",
                    status: "Completed",
                    notes: "Follow-up"
                },
                 "789": {
                     patient: "Patient C",
                      doctor: "Dr. Lee",
                      date: "2024-08-15 9:00 AM",
                    status: "Cancelled",
                       notes: "Reschedule"
                    }
             };
         const appointment = appointmentDetails[appointmentId];

         // Set the content of the modal based on the selected appointment
            document.getElementById('appointmentIdDisplay').textContent = appointmentId;
            document.getElementById('appointmentPatientDisplay').textContent = appointment.patient;
           document.getElementById('appointmentDoctorDisplay').textContent = appointment.doctor;
           document.getElementById('appointmentDateDisplay').textContent = appointment.date;
           document.getElementById('appointmentStatusDisplay').textContent = appointment.status;
           document.getElementById('appointmentNotesDisplay').textContent = appointment.notes;
           document.getElementById('editAppointmentButton').href = `admin_edit_appointment.php?id=${appointmentId}`;
        });
    });
</script>
</body>
</html>