<?php
include('../admin/assets/config/dbconn.php');
include('../admin/assets/inc/header.php');
include('../admin/assets/inc/sidebar.php');
include('../admin/assets/inc/navbar.php');
?>
<main>
    <div class="container mt-4">
        <h1>Inventory Management</h1>
         <!-- Summary Cards -->
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Items</h5>
                        <p class="card-text display-6 fw-bold" id="total-items">0</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Medicine</h5>
                        <p class="card-text display-6 fw-bold" id="total-medicine">0</p>
                    </div>
                </div>
            </div>
           <div class="col-sm-6 col-lg-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Supplies</h5>
                         <p class="card-text display-6 fw-bold" id="total-supplies">0</p>
                    </div>
                </div>
            </div>
              <div class="col-sm-6 col-lg-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Equipment</h5>
                        <p class="card-text display-6 fw-bold" id="total-equipment">0</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">List of Inventory Items</h5>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addInventoryModal">Add New Item</button>
                    </div>
                    <!-- Filter Options -->
                   <div class="card-body">
                       <form id="inventoryFilterForm">
                            <div class="row g-3 mb-3">
                                  <div class="col-md-4">
                                       <label for="filterName" class="form-label">Item Name</label>
                                       <input type="text" class="form-control" id="filterName" name="filterName" placeholder="Enter Item Name">
                                 </div>
                                  <div class="col-md-4">
                                      <label for="filterCategory" class="form-label">Category</label>
                                    <select class="form-select" id="filterCategory" name="filterCategory">
                                        <option value="">All</option>
                                          <option value="medicine">Medicine</option>
                                          <option value="supply">Supply</option>
                                           <option value="equipment">Equipment</option>
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
                                        <th>Item ID</th>
                                        <th>Item Name</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="inventory-table-body">
                                    <tr>
                                        <td>101</td>
                                        <td>Paracetamol</td>
                                        <td>Medicine</td>
                                        <td>500</td>
                                        <td>5.00</td>
                                        <td>
                                             <button class="btn btn-sm btn-info view-inventory-btn" data-bs-toggle="modal" data-bs-target="#viewInventoryModal" data-inventory-id="101">View</button>
                                        </td>
                                    </tr>
                                     <tr>
                                        <td>102</td>
                                        <td>Syringes</td>
                                        <td>Supply</td>
                                        <td>1000</td>
                                        <td>1.00</td>
                                        <td>
                                             <button class="btn btn-sm btn-info view-inventory-btn" data-bs-toggle="modal" data-bs-target="#viewInventoryModal" data-inventory-id="102">View</button>
                                         </td>
                                    </tr>
                                     <tr>
                                        <td>103</td>
                                        <td>Stethoscope</td>
                                        <td>Equipment</td>
                                         <td>50</td>
                                         <td>50.00</td>
                                        <td>
                                              <button class="btn btn-sm btn-info view-inventory-btn" data-bs-toggle="modal" data-bs-target="#viewInventoryModal" data-inventory-id="103">View</button>
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

     <!-- Add Inventory Modal -->
    <div class="modal fade" id="addInventoryModal" tabindex="-1" aria-labelledby="addInventoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addInventoryModalLabel">Add New Inventory Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                     <form id="addInventoryForm" method="post" action="">
                           <div class="mb-3">
                                <label for="itemName" class="form-label">Item Name</label>
                                <input type="text" class="form-control" id="itemName" name="itemName" required>
                          </div>
                           <div class="mb-3">
                                <label for="itemCategory" class="form-label">Category</label>
                                <select class="form-select" id="itemCategory" name="itemCategory" required>
                                        <option value="medicine">Medicine</option>
                                        <option value="supply">Supply</option>
                                         <option value="equipment">Equipment</option>
                                  </select>
                            </div>
                         <div class="mb-3">
                            <label for="itemQuantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="itemQuantity" name="itemQuantity" required>
                        </div>
                         <div class="mb-3">
                                <label for="itemUnitPrice" class="form-label">Unit Price</label>
                                  <input type="number" class="form-control" id="itemUnitPrice" name="itemUnitPrice" step="0.01" required>
                          </div>
                        <button type="submit" class="btn btn-primary">Add Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

      <!-- View Inventory Modal -->
    <div class="modal fade" id="viewInventoryModal" tabindex="-1" aria-labelledby="viewInventoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewInventoryModalLabel">Inventory Item Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                 <div class="modal-body" id="viewInventoryModalBody">
                    <!-- Inventory details will be loaded here -->
                   <p><strong>Item ID:</strong> <span id="inventoryIdDisplay"></span></p>
                    <p><strong>Item Name:</strong> <span id="inventoryNameDisplay"></span></p>
                   <p><strong>Category:</strong> <span id="inventoryCategoryDisplay"></span></p>
                   <p><strong>Quantity:</strong> <span id="inventoryQuantityDisplay"></span></p>
                   <p><strong>Unit Price:</strong> <span id="inventoryUnitPriceDisplay"></span></p>
                     <a id="editInventoryButton" href="" class="btn btn-sm btn-primary">Edit</a>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
       // Javascript implementation, You will have to implement the save data with php
    document.getElementById('addInventoryForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally
        // Get the data from the form
          const itemName = document.getElementById('itemName').value;
         const itemCategory = document.getElementById('itemCategory').value;
        const itemQuantity = document.getElementById('itemQuantity').value;
        const itemUnitPrice = document.getElementById('itemUnitPrice').value;

        // Prepare data
          const formData = {
            itemName: itemName,
             itemCategory: itemCategory,
             itemQuantity: itemQuantity,
            itemUnitPrice: itemUnitPrice
            };
          console.log(formData); // for debugging purposes

        // Reset the form
          document.getElementById('addInventoryForm').reset();
         // close modal
        const modal = document.getElementById('addInventoryModal');
        const modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();
         // Display a success message or redirect to the patient list page
        alert("Inventory Item Added Successfully, data has been logged in the console")
        window.location.href = "admin_inventory.php"; //redirect to the current page
   });

     // handle filter form
     document.getElementById('inventoryFilterForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally
        // Get all the filter values
         const filterName = document.getElementById('filterName').value;
         const filterCategory = document.getElementById('filterCategory').value;

           // Prepare filter data
         const filterData = {
             filterName: filterName,
            filterCategory: filterCategory
            };
       console.log(filterData); // for debugging purposes
       // you will have to make a php api to use this data and update the content of the table, using fetch
        // for the moment we are using a console log
         alert("Filters have been applied, see console")
    });

    // Handle view inventory button clicks using javascript
    document.querySelectorAll('.view-inventory-btn').forEach(button => {
        button.addEventListener('click', function() {
            const inventoryId = this.getAttribute('data-inventory-id');
           // Example of hardcoded data, here you need to implement php for it.
              const inventoryDetails = {
                "101": {
                 name: "Paracetamol",
                  category: "Medicine",
                 quantity: 500,
                 unitPrice: 5.00
                   },
                 "102": {
                    name: "Syringes",
                     category: "Supply",
                    quantity: 1000,
                    unitPrice: 1.00
                   },
                 "103": {
                     name: "Stethoscope",
                    category: "Equipment",
                     quantity: 50,
                    unitPrice: 50.00
                   }
             };
         const inventory = inventoryDetails[inventoryId];
         // Set the content of the modal based on the selected appointment
           document.getElementById('inventoryIdDisplay').textContent = inventoryId;
            document.getElementById('inventoryNameDisplay').textContent = inventory.name;
           document.getElementById('inventoryCategoryDisplay').textContent = inventory.category;
          document.getElementById('inventoryQuantityDisplay').textContent = inventory.quantity;
            document.getElementById('inventoryUnitPriceDisplay').textContent = inventory.unitPrice;
            document.getElementById('editInventoryButton').href = `admin_edit_inventory.php?id=${inventoryId}`;
        });
    });
    // You will have to implement the fetch and populate data with php
       // example using hardcoded numbers
       document.getElementById('total-items').textContent = '1553';
       document.getElementById('total-medicine').textContent = '650';
       document.getElementById('total-supplies').textContent = '785';
       document.getElementById('total-equipment').textContent = '118';
</script>
</body>
</html>