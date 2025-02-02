document.addEventListener("DOMContentLoaded", function () {
    fetchInventoryData();

    // Fetch inventory data with optional filters
    function fetchInventoryData(filterData = {}) {
        $.ajax({
            url: '../api/inventory_management/get_inventory.php',
            type: 'POST',
            data: filterData,
            dataType: 'json',
            success: function (response) {
                let inventoryTable = $('#inventory-table-body');
                inventoryTable.empty();
                response.forEach(item => {
                    inventoryTable.append(`
                        <tr>
                            <td>${item.item_id}</td>
                            <td>${item.item_name}</td>
                            <td>${item.category}</td>
                            <td>${item.quantity}</td>
                            <td>${item.unit_price}</td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick="viewItem(${item.item_id})">View</button>
                                <button class="btn btn-warning btn-sm" onclick="editItem(${item.item_id})">Edit</button>
                            </td>
                        </tr>
                    `);
                });
            }
        });
    }

    // Apply filters
    $('#inventoryFilterForm').on('submit', function (e) {
        e.preventDefault();
        let filterData = {
            filterName: $('#filterName').val(),
            filterCategory: $('#filterCategory').val()
        };
        fetchInventoryData(filterData);
    });

    // Add new item
    $('#addInventoryForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '../api/inventory_management/add_inventory.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function () {
                $('#addInventoryModal').modal('hide');
                fetchInventoryData();
            }
        });
    });

    // Edit item (load data into form)
    window.editItem = function (id) {
        $.ajax({
            url: '../api/inventory_management/get_inventory_item.php',
            type: 'POST',
            data: { item_id: id },
            dataType: 'json',
            success: function (data) {
                $('#editItemId').val(data.item_id);
                $('#editItemName').val(data.item_name);
                $('#editItemCategory').val(data.category);
                $('#editItemQuantity').val(data.quantity);
                $('#editItemUnitPrice').val(data.unit_price);
                $('#editInventoryModal').modal('show');
            }
        });
    };

    // Save edited item
    $('#editInventoryForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '../api/inventory_management/update_inventory.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function () {
                $('#editInventoryModal').modal('hide');
                fetchInventoryData();
            }
        });
    });
});
