<?php
include 'auth.php';
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supermart Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: #ffffff;
            color: #000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
        }

        .navbar .logo a {
            color: #D52B1E;
            text-decoration: none;
            font-size: 24px;
            font-weight: bold;
        }

        .navbar .nav-links {
            display: flex;
            gap: 20px;
        }

        .navbar .nav-links a {
            color: #000;
            text-decoration: none;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        .navbar .nav-links a:hover {
            color: #D52B1E;
        }

        .navbar .logout-btn {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #D52B1E;
            color: #fff;
            transition: background-color 0.3s ease;

        }

        .navbar .logout-btn:hover {
            background-color: #b2241b;
        }

        .services {
            display: flex;
            justify-content: space-around;
            padding: 20px 0;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .services .service {
            text-align: center;
            flex: 1;
            padding: 10px;
            max-width: 100px;
        }

        .services .service img {
            width: 50px;
            height: 50px;
        }

        .services .service p {
            margin: 10px 0 0;
            font-size: 14px;
        }

        .clock-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .current-time {
            display: flex;
            align-items: center;
            font-size: 24px;
            color: #333;
        }

        .personal-clock {
            text-align: center;
            font-size: 24px;
            color: #333;
        }

        .clock-buttons {
            display: flex;
            gap: 20px;
        }

        .clock-buttons button {
            padding: 15px 25px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #D52B1E;
            color: #fff;
            transition: background-color 0.3s ease;
        }

        .clock-buttons button:hover {
            background-color: #b2241b;
        }

        .dashboard {
            padding: 20px;
        }

        .dashboard h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .metrics-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 40px;
        }

        .metric {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            flex: 1;
            min-width: 200px;
            text-align: center;
        }

        .metric h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .metric p {
            font-size: 24px;
            color: #D52B1E;
            margin: 10px 0 0;
        }

        .quick-actions {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }

        .quick-actions button {
            padding: 15px 25px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #D52B1E;
            color: #fff;
            transition: background-color 0.3s ease;
        }

        .quick-actions button:hover {
            background-color: #b2241b;
        }

        .footer {
            padding: 20px;
            background-color: #D52B1E;
            color: #fff;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <a href="#">Supermart Admin</a>
        </div>
        <div class="nav-links">
            <a href="#dashboard">Dashboard</a>
            <a href="#inventory">Inventory</a>
            <a href="#promotions">Promotions</a>
            <a href="#employees">Employees</a>
        </div>
        <button class="logout-btn" onclick=Logout()>Logout</button>
    </div>

    <div class="services">
        <div class="service">
            <img src="icons/promotion.png" alt="Service 1">
            <p>Promotions</p>
        </div>
        <div class="service">
            <img src="icons/inventory.png" alt="Service 2">
            <p>Inventory</p>
        </div>
        <div class="service">
            <img src="icons/businessman.png" alt="Service 3">
            <p>Employees</p>
        </div>
        <div class="service">
            <img src="icons/management.png" alt="Service 4">
            <p>Management</p>
        </div>
        <div class="service">
            <img src="icons/campaign.png" alt="Service 5">
            <p>Learning</p>
        </div>
        <div class="service">
            <img src="icons/statistics.png" alt="Service 6">
            <p>Sales Report</p>
        </div>
        <div class="service">
            <img src="icons/rate.png" alt="Service 7">
            <p>Customer Feedback</p>
        </div>
        <div class="service">
            <img src="icons/schedule.png" alt="Service 8">
            <p>Store Schedule</p>
        </div>
    </div>

    <div class="clock-section">
        <div class="current-time">
            <h3>Current Time: </h3>
            <div id="clock"></div>
        </div>
        <div class="personal-clock">
            <div id="personal-clock">00:00:00</div>
            <div class="clock-buttons">
                <button onclick="clockIn()">Clock In</button>
                <button onclick="clockOut()">Clock Out</button>
            </div>
        </div>
    </div>

    <div class="dashboard" id="dashboard">
        <h2>Dashboard Overview</h2>
        <h2>Welcome <?php echo $_SESSION['Name']; ?> !</h2>
        <div class="metrics-container">
            <div class="metric">
                <h3>Total Sales</h3>
                <p id="sales-figures"></p>
            </div>
            <div class="metric">
                <h3>Inventory Levels</h3>
                <p id="inventory-levels"></p>
            </div>
            <div class="metric">
                <h3>Upcoming Promotions</h3>
                <p id="upcoming-promotions"></p>
            </div>
            <div class="metric">
                <h3>Employee Attendance</h3>
                <p id="employee-attendance"></p>
            </div>
        </div>

        <h2>Quick Actions</h2>
        <div class="quick-actions">
            <button onclick="addNewProduct()">Add New Product</button>
            <button onclick="createPromotion()">Create Promotion</button>
            <button onclick="scheduleShift()">Schedule Shift</button>
            <button onclick="viewShifts()">View shifts -TEST BUTTON-</button>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 Supermart. All rights reserved.</p>
    </div>

    <script>
        // Function to fetch data from JSON file
        function fetchJSONData() {
            console.log('Fetching JSON data...');
            fetch('demo_data.json')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('JSON data fetched successfully');
                    processData(data);
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        function processData(data) {
            console.log('Processing JSON data...');
            document.getElementById('sales-figures').innerText = `$${data.total_sales_monthly || 'N/A'}`;
            document.getElementById('inventory-levels').innerText = `Inventory: ${data.inventory_apples || 'N/A'} apples, ${data.inventory_milk || 'N/A'} milk`;
            document.getElementById('upcoming-promotions').innerText = `Upcoming Promotions: ${data.upcoming_promotion_1 || 'N/A'}, ${data.upcoming_promotion_2 || 'N/A'}`;
            document.getElementById('employee-attendance').innerText = `${data.employee_present || 'N/A'} Present, ${data.employee_absent || 'N/A'} Absent`;
        }

        // Call fetchJSONData initially
        fetchJSONData();
        // You can optionally add a setInterval to update data periodically
        // setInterval(fetchJSONData, 5000); // Update every 5 seconds

        // Placeholder functions for the quick actions (replace with actual functionality)
        function addNewProduct() {
            alert("Add New Product button clicked");
        }

        function createPromotion() {
            alert("Create Promotion button clicked");
        }

        function scheduleShift() {
    // Redirect to store_schedule.php
    window.location.href = 'store_schedule.php';
}
        function viewShifts() {
            // Redirect to store_schedule.php
            window.location.href = 'roster.php';
        }

        // Clock functions
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const timeString = `${hours}:${minutes}:${seconds}`;
            document.getElementById('clock').innerText = timeString;
        }

        setInterval(updateClock, 1000);

        let clockInterval;
        let startTime;
        let elapsedTime = 0;

        function startPersonalClock() {
            startTime = new Date();
            clockInterval = setInterval(() => {
                const now = new Date();
                elapsedTime = now - startTime;
                const hours = String(Math.floor(elapsedTime / 3600000)).padStart(2, '0');
                const minutes = String(Math.floor((elapsedTime % 3600000) / 60000)).padStart(2, '0');
                const seconds = String(Math.floor((elapsedTime % 60000) / 1000)).padStart(2, '0');
                document.getElementById('personal-clock').innerText = `${hours}:${minutes}:${seconds}`;
            }, 1000);
        }

        function stopPersonalClock() {
            clearInterval(clockInterval);
        }

        function clockIn() {
            startPersonalClock();
        }

        function clockOut() {
            stopPersonalClock();
            document.getElementById('personal-clock').innerText = `00:00:00`;
            elapsedTime = 0;
            alert(`You worked for ${document.getElementById('personal-clock').innerText}`);
        }

        function Logout() {
            window.location.href = 'logout.php';
        }

    </script>
</body>
</html>