<?php
include('../api/config/dbconn.php');
include('../admin/assets/inc/header.php');
include('../admin/assets/inc/sidebar.php');
include('../admin/assets/inc/navbar.php');
?>
<main>
    <div class="container mt-4">
        <h1>User Management</h1>
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">List of Users</h5>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add New User</button>
                    </div>
                     <!-- Filter Options -->
                     <div class="card-body">
                       <form id="userFilterForm">
                            <div class="row g-3 mb-3">
                                 <div class="col-md-4">
                                      <label for="filterName" class="form-label">Name</label>
                                      <input type="text" class="form-control" id="filterName" name="filterName" placeholder="Enter User Name">
                                 </div>
                                 <div class="col-md-4">
                                     <label for="filterRole" class="form-label">Role</label>
                                      <select class="form-select" id="filterRole" name="filterRole">
                                           <option value="">All</option>
                                           <option value="admin">Admin</option>
                                            <option value="doctor">Doctor</option>
                                            <option value="nurse">Nurse</option>
                                            <option value="receptionist">Receptionist</option>
                                    </select>
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
                                        <th>User ID</th>
                                        <th>Name</th>
                                         <th>Email</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="user-table-body">
                                     <tr>
                                        <td>1</td>
                                        <td>Admin User</td>
                                         <td>admin@example.com</td>
                                        <td>Admin</td>
                                        <td>
                                            <button class="btn btn-sm btn-info view-user-btn" data-bs-toggle="modal" data-bs-target="#viewUserModal" data-user-id="1">View</button>
                                            <a href="admin_edit_user.php" class="btn btn-sm btn-primary">Edit</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                         <td>Doctor Smith</td>
                                         <td>doctor@example.com</td>
                                        <td>Doctor</td>
                                           <td>
                                              <button class="btn btn-sm btn-info view-user-btn" data-bs-toggle="modal" data-bs-target="#viewUserModal" data-user-id="2">View</button>
                                              <a href="admin_edit_user.php" class="btn btn-sm btn-primary">Edit</a>
                                          </td>
                                     </tr>
                                    <tr>
                                         <td>3</td>
                                         <td>Nurse Jane</td>
                                        <td>nurse@example.com</td>
                                        <td>Nurse</td>
                                       <td>
                                            <button class="btn btn-sm btn-info view-user-btn" data-bs-toggle="modal" data-bs-target="#viewUserModal" data-user-id="3">View</button>
                                             <a href="admin_edit_user.php" class="btn btn-sm btn-primary">Edit</a>
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

    <!-- Add User Modal -->
     <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form id="addUserForm" method="post" action="">
                        <div class="mb-3">
                            <label for="userName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="userName" name="userName" required>
                        </div>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="userEmail" name="userEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="userPassword" class="form-label">Password</label>
                             <input type="password" class="form-control" id="userPassword" name="userPassword" required>
                         </div>
                         <div class="mb-3">
                            <label for="userRole" class="form-label">Role</label>
                            <select class="form-select" id="userRole" name="userRole" required>
                                 <option value="admin">Admin</option>
                                 <option value="doctor">Doctor</option>
                                <option value="nurse">Nurse</option>
                                 <option value="receptionist">Receptionist</option>
                            </select>
                        </div>
                     <button type="submit" class="btn btn-primary">Add User</button>
                 </form>
                </div>
            </div>
        </div>
     </div>

     <!-- View User Modal -->
    <div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewUserModalLabel">User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                 <div class="modal-body" id="viewUserModalBody">
                    <!-- User details will be loaded here -->
                     <p><strong>User ID:</strong> <span id="userIdDisplay"></span></p>
                    <p><strong>Name:</strong> <span id="userNameDisplay"></span></p>
                   <p><strong>Email:</strong> <span id="userEmailDisplay"></span></p>
                   <p><strong>Role:</strong> <span id="userRoleDisplay"></span></p>
                   <a id="editUserButton" href="" class="btn btn-sm btn-primary">Edit</a>
                </div>
            </div>
        </div>
    </div>
</main>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
     // Javascript implementation, You will have to implement the save data with php
    document.getElementById('addUserForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally
         // Get the data from the form
         const userName = document.getElementById('userName').value;
          const userEmail = document.getElementById('userEmail').value;
          const userPassword = document.getElementById('userPassword').value;
         const userRole = document.getElementById('userRole').value;

         // Prepare data
        const formData = {
              userName: userName,
              userEmail: userEmail,
              userPassword: userPassword,
              userRole: userRole
           };
       console.log(formData); // for debugging purposes
         // Reset the form
          document.getElementById('addUserForm').reset();
        // close modal
        const modal = document.getElementById('addUserModal');
        const modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();
         // Display a success message or redirect to the patient list page
       alert("New user added successfully, data has been logged in the console")
       window.location.href = "admin_users.php"; //redirect to the current page
    });

     // handle filter form
    document.getElementById('userFilterForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

        // Get all the filter values
       const filterName = document.getElementById('filterName').value;
      const filterRole = document.getElementById('filterRole').value;

         // Prepare filter data
        const filterData = {
             filterName: filterName,
             filterRole: filterRole
            };
       console.log(filterData); // for debugging purposes
         // you will have to make a php api to use this data and update the content of the table, using fetch
        // for the moment we are using a console log
        alert("Filters have been applied, see console")
    });
    // Handle view user button clicks using javascript
    document.querySelectorAll('.view-user-btn').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
           // Example of hardcoded data, here you need to implement php for it.
              const userDetails = {
                "1": {
                    name: "Admin User",
                     email: "admin@example.com",
                    role: "Admin"
                   },
                 "2": {
                      name: "Doctor Smith",
                     email: "doctor@example.com",
                     role: "Doctor"
                    },
                 "3": {
                     name: "Nurse Jane",
                      email: "nurse@example.com",
                      role: "Nurse"
                    }
            };
         const user = userDetails[userId];
         // Set the content of the modal based on the selected user
           document.getElementById('userIdDisplay').textContent = userId;
            document.getElementById('userNameDisplay').textContent = user.name;
           document.getElementById('userEmailDisplay').textContent = user.email;
           document.getElementById('userRoleDisplay').textContent = user.role;
           document.getElementById('editUserButton').href = `admin_edit_user.php?id=${userId}`;
        });
    });
</script>
</body>
</html>