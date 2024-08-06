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
    <style>
        /* .info-sections {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .best-employee,
        .discount-offers {
            width: 48%;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .best-employee h2,
        .discount-offers h2 {
            text-align: center;
            color: #333;
        }

        .employee-content {
            display: flex;
            align-items: center;
        }

        .employee-image {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            margin-right: 20px;
        }

        .employee-details {
            max-width: 70%;
        }

        .offers-content {
            padding: 10px;
        }

        .offer {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
        }

        .offer h3 {
            margin: 0;
            color: #007BFF;
        } */
    </style>
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
            <a href="employees.php">Employees</a>
        </div>
        <button class="logout-btn" onclick=Logout()>Logout</button>
    </div>

    <div class="services">
        <div class="service">
            <a href="promotions.php">
                <img src="promotion.png" alt="Service 1"> </a>
            <p>Promotions</p>
        </div>
        <div class="service">
            <a href="inventoryManagement.php">
                <img src="inventory.png" alt="Service 2"></a>
            <p>Inventory</p>
        </div>

        <div class="service">
            <a href="employee_stats.php">
                <img src="management.png" alt="Service 4"></a>
            <p>Employee Stats</p>
        </div>
        <div class="service">
            <a href="learning.php">
                <img src="campaign.png" alt="Service 5"></a>
            <p>Learning</p>
        </div>
        <div class="service">
            <a href="sales_report.php">
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
                <p id="sales-figures">$7700</p>
            </div>
            <div class="metric">
                <h3>Inventory Levels</h3>
                <p id="inventory-levels">Medium</p>
            </div>
            <div class="metric">
                <h3>Upcoming Promotions</h3>
                <p id="upcoming-promotions">Up to 50% off on summer collections</p>
            </div>
            <div class="metric">
                <h3>Employee Attendance</h3>
                <p id="employee-attendance">60/100</p>
            </div>
        </div>
        <div class="info-sections">
            <div class="best-employee">
                <h2>Best Employee of the Month</h2>
                <div class="employee-content">
                    <img src="john.jpeg" alt="Best Employee" class="employee-image">
                    <div class="employee-details">
                        <h3>Christopher</h3>
                        <p>Sales Associate</p>
                        <p>John has shown exceptional performance this month with the highest sales and excellent
                            customer feedback.</p>
                    </div>
                </div>
            </div>
            <div class="discount-offers">
                <h2>Employee Discount Offers</h2>
                <div class="offers-content">
                    <div class="offer">
                        <h3>20% Off on Electronics</h3>
                        <p>Available for the next 3 days.</p>
                    </div>
                    <div class="offer">
                        <h3>15% Off on Groceries</h3>
                        <p>Available this weekend only.</p>
                    </div>

                </div>
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

            // Function to update the current time every second
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

            // Function to start the personal clock
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

            // Function to stop the personal clock
            function stopPersonalClock() {
                clearInterval(clockInterval);
            }

            // Function to handle the Clock In button click
            function clockIn() {
                if (clockInterval) {
                    alert("You are already clocked in.");
                    return;
                }
                startPersonalClock();
            }

            // Function to handle the Clock Out button click
            function clockOut() {
                if (!clockInterval) {
                    alert("You need to clock in first.");
                    return;
                }
                stopPersonalClock();
                const hours = String(Math.floor(elapsedTime / 3600000)).padStart(2, '0');
                const minutes = String(Math.floor((elapsedTime % 3600000) / 60000)).padStart(2, '0');
                const seconds = String(Math.floor((elapsedTime % 60000) / 1000)).padStart(2, '0');
                alert(`You worked for ${hours}:${minutes}:${seconds}`);
                document.getElementById('personal-clock').innerText = `00:00:00`;
                elapsedTime = 0;
            }

            function Logout() {
                window.location.href = 'logout.php';
            }


        </script>
</body>

</html>