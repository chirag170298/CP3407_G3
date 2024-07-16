<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Manager</title>
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
    <div class="container">
        <div class="form-group">
            <label for="item-name">Item Name:</label>
            <input type="text" id="item-name">
        </div>
        <div class="form-group">
            <label for="item-quantity">Quantity:</label>
            <input type="number" id="item-quantity">
        </div>
        <div class="form-group">
            <label for="item-price">Price:</label>
            <input type="number" step="0.01" id="item-price">
        </div>
        <div class="form-group">
            <button onclick="addItem()">Add Item</button>
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
