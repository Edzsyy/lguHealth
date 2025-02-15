<?php
include('../api/config/session_start.php');
include('../api/config/dbconn.php');
include('../nurse/assets/inc/header.php');
include('../nurse/assets/inc/sidebar.php');
include('../nurse/assets/inc/navbar.php');
?>
<body>
    <div class="container mt-4">
        <h1 class="h3 mb-4">Admin Dashboard</h1>

        <div class="row g-4">
            <!-- Statistics Cards -->
            <div class="col-12">
                <div class="row g-4">
                   <div class="col-sm-6 col-lg-4">
                        <div class="card shadow-sm text-center">
                            <div class="card-body">
                                <h5 class="card-title">Total Patients</h5>
                                <p class="card-text display-6 fw-bold" id="total-patients">0</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card shadow-sm text-center">
                            <div class="card-body">
                                <h5 class="card-title">Total Appointments</h5>
                                <p class="card-text display-6 fw-bold" id="total-appointments">0</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                         <div class="card shadow-sm text-center">
                            <div class="card-body">
                                <h5 class="card-title">Available Doctors</h5>
                                <p class="card-text display-6 fw-bold" id="available-doctors">0</p>
                            </div>
                         </div>
                    </div>
                     <div class="col-sm-6 col-lg-4">
                         <div class="card shadow-sm text-center">
                            <div class="card-body">
                                <h5 class="card-title">Pending Appointments</h5>
                                <p class="card-text display-6 fw-bold" id="pending-appointments">0</p>
                            </div>
                         </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card shadow-sm text-center">
                           <div class="card-body">
                              <h5 class="card-title">Low Stock Items</h5>
                              <p class="card-text display-6 fw-bold" id="low-stock-items">0</p>
                           </div>
                        </div>
                   </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card shadow-sm text-center">
                            <div class="card-body">
                                <h5 class="card-title">Total Revenue</h5>
                                <p class="card-text display-6 fw-bold"><span class="currency">₱</span> <span id="total-revenue">0</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Recent Activity Card-->
       <div class="row g-4 mt-4">
            <div class="col-12">
              <div class="card shadow-sm">
                   <div class="card-body">
                         <h5 class="card-title">Recent Activities</h5>
                            <ul class="list-unstyled" id="recent-activities">
                                 <li>Patient A registered on 2024-07-28</li>
                                 <li>Patient B appointment for checkup on 2024-07-27</li>
                                 <li>Dr. C added new medication on 2024-07-26</li>
                              </ul>
                      </div>
                </div>
            </div>
        </div>

        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
         // You will have to implement the fetch and populate data with php
       // example using hardcoded numbers
        document.getElementById('total-patients').textContent = '100';
        document.getElementById('total-appointments').textContent = '25';
        document.getElementById('available-doctors').textContent = '5';
        document.getElementById('pending-appointments').textContent = '3';
         document.getElementById('low-stock-items').textContent = '10';
          document.getElementById('total-revenue').textContent = '5000';
        
       
    </script>
</body>
</html>