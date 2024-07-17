


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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Manager</title>
    <title>Add new item</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .container {
            max-width: 10000px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group button {
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group button:hover {
            background: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .edit-btn, .delete-btn {
            padding: 5px 10px;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .edit-btn {
            background: #2196F3;
        }
        .edit-btn:hover {
            background: #1976D2;
        }
        .delete-btn {
            background: #f44336;
        }
        .delete-btn:hover {
            background: #e53935;
        }
        .home-button {
    position: fixed;
    top: 10px; /* Adjust to position vertically */
    left: 10px; /* Adjust to position horizontally */
    background-color: #007bff; /* Example background color */
    color: #fff; /* Text color */
    padding: 10px 20px;
    text-decoration: none; /* Remove underline */
    border-radius: 5px;
    border: none;
    cursor: pointer;
}

.home-button:hover {
    background-color: #0056b3; /* Darker color on hover */
}
    </style>
</head>
<body>
<a href="index.php" class="home-button">Home</a>
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
