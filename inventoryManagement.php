


<?php
$servername = 'cp3407-website-db.cfumcuommiak.ap-southeast-2.rds.amazonaws.com'; // Replace with your RDS endpoint
$username = 'CP3407admin';
$password = 'YFtG]?$4&+k}.WJ';
$dbname = 'EasyGrocer';
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT DISTINCT category_Type FROM STOCK";
$result = $conn->query($sql);
$categories = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['category_Type'];
    }
} else {
    echo "0 results";
}


$sql = "SELECT DISTINCT UOS FROM STOCK";
$result = $conn->query($sql);
$units_of_sale = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $units_of_sale[] = $row['UOS'];
    }
} else {
    echo "0 results";
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="mainstyles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Manager</title>
    <title>Add new item</title>
    
</head>
<body>
<div class="navbar">
        <div class="logo">
            <a href="index.php">Supermart Admin</a>
        </div>
        <div class="nav-links">
            <a href="index.php">Dashboard</a>
            <a href="inventoryManagement.php">Inventory</a>
            <a href="promotions.php">Promotions</a>
            <a href="employee_stats.php">Employees</a>
        </div>
        <button class="logout-btn" onclick=Logout()>Logout</button>
    </div>
    <h1>Inventory Manager</h1>
    <h1>Add new Item</h1>
    <div class="container">
    <div class="form-group">
        <label for="itemname">Item Name:</label>
        <input type="text" id="itemname" name="itemname">
    </div>
    <div class="form-group">
        <label for="itemquantity">Quantity:</label>
        <input type="text" id="itemquantity" name="itemquantity">
    </div>
    <div class="form-group">
        <label for="itemprice">Price:</label>
        <input type="text" id="itemprice" name="itemprice">
    </div>
    <div class="form-group">
        <label for="itemcategory">Category:</label>
        <select id="itemcategory" name="itemcategory">
            <?php
            // Assuming $categories is an array of category options fetched or defined elsewhere
            foreach ($categories as $category) {
                echo '<option value="' . $category . '">' . $category . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="itemunit">Unit of Sale:</label>
        <select id="itemunit" name="itemunit">
            <?php
            // Assuming $units_of_sale is an array of unit of sale options fetched or defined elsewhere
            foreach ($units_of_sale as $UOS) {
                echo '<option value="' . $UOS . '">' . $UOS . '</option>';
            }
            ?>
        </select>
    
        <div class="form-group">
            <button onclick="addNewItem()">Add Item</button>
        </div>
        <div class="form-group">
            <button onclick="fetchStock()">refresh</button>
        </div>

        <table id="inventoryTable">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Inventory data will be inserted here -->
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let inventory = [];

    function fetchStock() {
            // console.log($categories);
            $.ajax({
                url: 'fetchStock.php',
                dataType: 'json', // Expecting JSON response
                cache: false,
                success: function(response) {
                    console.log('PHP Response:', response); 
                    renderStockTable(response);
                    response = null;
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#rosterResults').html('<p>Error fetching data. Please try again.</p>');
                }
            });
        }

        function updateStock(stockID) {
            const itemName = document.querySelector(`#itemName_${stockID}`).value;
            const quantity = parseFloat(document.querySelector(`#quantity_${stockID}`).value);
            const price = parseFloat(document.querySelector(`#price_${stockID}`).value);
            const formData = new FormData();
            formData.append('stockID', stockID);
            formData.append('itemName', itemName); // Include itemName in FormData
            formData.append('quantity', quantity);
            formData.append('price', price);

            fetch('adjustStock.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(result => {
                console.log(result); // Output the result, you can handle this as needed
                // Optionally, update the UI or show a message based on the result
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }


        function renderStockTable(data) {
            const tableBody = document.querySelector('#inventoryTable tbody');
            tableBody.innerHTML = ''; // Clear existing table rows if any

            data.forEach(entry => {
                const itemName = entry.ITEM_NAME;
                const quantity = entry.COUNT_QTY;
                const price = entry.PRICE;
                const stockID = entry.STOCK_ID;

            // Create a new row
            const row = document.createElement('tr');
            row.setAttribute('data-stock-id', stockID); // Ensure data attribute is named correctly

            // Populate row HTML content
            row.innerHTML = `
                <td><input type="text" id="itemName_${stockID}" value="${itemName}"></td>
            <td><input type="number" id="quantity_${stockID}" value="${quantity}" step="1"></td>
            <td><input type="number" id="price_${stockID}" value="${price}" step="0.01"></td>
            <td>
                <button class="update-btn" onclick="updateStock(${stockID})">Update</button>
                <button class="delete-btn" onclick="deleteEntry(${stockID})">Delete</button></td>
                
            `;

            tableBody.appendChild(row);
    });
}
 // <td>${itemName}</td>
                    // <td>${quantity}</td>
                    // <td>${price}</td>
                    // <td><button class="delete-btn" onclick="deleteEntry('${stockID}')">Delete</button></td>
                // Append row to table body
                function addNewItem() {
        var formData = new FormData();
        formData.append('itemname', document.getElementById('itemname').value);
        formData.append('itemquantity', document.getElementById('itemquantity').value);
        formData.append('itemprice', document.getElementById('itemprice').value);
        formData.append('itemcategory', document.getElementById('itemcategory').value);
        formData.append('itemunit', document.getElementById('itemunit').value);

        fetch('addStock.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            if (data.trim() === 'Item added successfully') {
                console.log(data); // Log response from PHP script
                alert('Item added successfully!');
                fetchStock();
            } else {
                console.log(data); // Log response from PHP script
                alert('Error: ' + data); // Display PHP error message
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('There was an error adding the item.');
        });
    
    }           

    function deleteEntry(stockID) {
        $.ajax({
            url: 'removeStock.php',
            method: 'POST',
            dataType: 'json',
            data: { stockID: stockID },
            success: function(response) {
                if (response.success) {
                    // Assuming successful deletion, remove the row from the table
                    const tableRow = document.querySelector(`tr[data-stock-id="${stockID}"]`);
                    console.log(`Selector used: tr[data-stock-id="${stockID}"]`); // Debugging output
                    console.log('Selected row:', tableRow); // Debugging output
                    if (tableRow) {
                        tableRow.remove();
                        console.log('Entry deleted successfully');
                        fetchStock();
                    } else {
                        console.error('Table row not found');
                    }
                } else {
                    console.error('Failed to delete entry:', response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error deleting entry outside php:', error);
            }
        });
    }
        document.addEventListener('DOMContentLoaded', function() {
            console.log("DOM fully loaded and parsed.");
            fetchStock();
        });
    </script>
</body>
</html>




