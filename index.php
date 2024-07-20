<?php
include 'auth.php';
?>



<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="mainstyles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supermart Admin Dashboard</title>
    
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <a href="index.php">Supermart Admin</a>
        </div>
        <div class="nav-links">
            <a href="employee_stats.php">Dashboard</a>
            <a href="inventoryManagement.php">Inventory</a>
            <a href="promotions.php">Promotions</a>
            <a href="#">Employees</a>
        </div>
        <button class="logout-btn" onclick=Logout()>Logout</button>
    </div>

    <div class="services">
        <div class="service">
            
            <img src="promotion.png" alt="Service 1">
            <p>Promotions</p>
        </div>
        <div class="service">
            <a href="inventoryManagement.php">
            <img src="inventory.png" alt="Service 2"></a>
            <p>Inventory</p>
        </div>
        <div class="service">
            <img src="businessman.png" alt="Service 3">
            <p>Employees</p>
        </div>
        <div class="service">
            <img src="management.png" alt="Service 4">
            <p>Management</p>
        </div>
        <div class="service">
            <a href="learning.php">
            <img src="campaign.png" alt="Service 5"></a>
            <p>Learning</p>
        </div>
        <div class="service">
            <a href="employee_stats.php">
            <img src="statistics.png" alt="Service 6"></a>
            <p>Sales Report</p>
        </div>
        <div class="service">
            <a href="feedback.php">
            <img src="rate.png" alt="Service 7"></a>
            <p>Customer Feedback</p>
        </div>
        <div class="service">
            <a href="store_schedule.php">
            <img src="schedule.png" alt="Service 8"></a>
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
            <button onclick="inventoryManagement()">Inventory Management</button>
            <button onclick="createPromotion()">Create Promotion</button>
            <button onclick="scheduleShift()">Schedule Shift</button>
            <button onclick="viewShifts()">View shifts -TEST BUTTON-</button>
            <button onclick="learningButton()">View learning -TEST BUTTON-</button>
            <button onclick="performanceButton()">View Performance -TEST BUTTON-</button>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 Supermart. All rights reserved.</p>
    </div>

    <script>

        function processData(data) {
            console.log('Processing JSON data...');
            document.getElementById('sales-figures').innerText = `$${data.total_sales_monthly || 'N/A'}`;
            document.getElementById('inventory-levels').innerText = `Inventory: ${data.inventory_apples || 'N/A'} apples, ${data.inventory_milk || 'N/A'} milk`;
            document.getElementById('upcoming-promotions').innerText = `Upcoming Promotions: ${data.upcoming_promotion_1 || 'N/A'}, ${data.upcoming_promotion_2 || 'N/A'}`;
            document.getElementById('employee-attendance').innerText = `${data.employee_present || 'N/A'} Present, ${data.employee_absent || 'N/A'} Absent`;
        }

        
        function inventoryManagement() {
            window.location.href = 'inventoryManagement.php';
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

       
        function learningButton() {
            // Redirect to store_schedule.php
            window.location.href = 'learning.php';
        }
        
        function performanceButton() {
            // Redirect to store_schedule.php
            window.location.href = 'employee_stats.php';
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