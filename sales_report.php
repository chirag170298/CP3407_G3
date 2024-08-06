<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="mainstyles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
 
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <a href="index.php">Supermart Admin</a>
        </div>
        <div class="nav-links">
            <a href="sales_report.php">Dashboard</a>
            <a href="inventoryManagement.php">Inventory</a>
            <a href="promotions.php">Promotions</a>
            <a href="employees.php">Employees</a>
        </div>
        <button class="logout-btn" onclick=Logout()>Logout</button>
    </div>
    <div class="container">
        <h1>Sales Report</h1>
        <div class="report-section">
            <h2>Report</h2>
            <table id="report-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Total Sales</th>
                        <th>Number of Transactions</th>
                        <th>Average Sale Value</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Report data will be injected here -->
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>


        function getSalesData(){
            $.ajax({
                url: 'fetchSalesReport.php',
                dataType: 'json', // Expecting JSON response
                cache: false,
                success: function(response) {
                    console.log('PHP Response:', response); 
                    updateSalesTable(response);
                    response = null;
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });


        }
        function updateSalesTable(data) {
            const tableBody = document.querySelector('#report-table tbody');
            tableBody.innerHTML = ''; // Clear existing table rows if any

            data.forEach(entry => {
                const date = entry.WeekPeriod;
                const TotalSales = entry.TotalSales;
                const NumberOfSales = entry.NumberOfSales;
                const AverageSale = entry.AverageSale;

            // Create a new row
            const row = document.createElement('tr');

            // Populate row HTML content
            row.innerHTML = `
            <td>${entry.WeekPeriod}</td>
            <td>${TotalSales}</td>
            <td>${NumberOfSales}</td>
            <td>${AverageSale}</td>
                
            `;

            tableBody.appendChild(row);
    });
        }


        document.addEventListener('DOMContentLoaded', function() {
            console.log("DOM fully loaded and parsed.");
            getSalesData();
        });
        </script>