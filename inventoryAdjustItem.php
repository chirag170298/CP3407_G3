
<?php include 'auth.php'; ?>

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
    </style>
</head>
<body>
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
            <button onclick="">Adjust Item</button>
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

        </body>
        </html>

        <script>
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
