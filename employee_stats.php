<?php
include 'auth.php';
?>




<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="mainstyles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Performance Stats</title>
    
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
    <h1>Employee Performance Statistics</h1>
    
    <main>
    
        <section class="top-employee" id="topEmployeeSection">
            <h2>Top Employee</h2>
            <p id="topEmployee"></p>
        </section>
        <section class="chart-container">
            <h2>Overall Performance</h2>
            <canvas id="salesChart"></canvas>
        </section>
        <section class="chart-container">
            <h2>Feedback Scores</h2>
            <canvas id="feedbackChart"></canvas>
        </section>
        <section class="table-container">
            <h2>Individual Performance</h2>
            <table id="performanceTable">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Sales</th>
                        <th>Feedback</th>
                        <th>Tasks Completed</th>
                        <th>Attendance</th>
                        <th>Efficiency</th>
                        <th>Training Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data rows will be inserted here -->
                </tbody>
            </table>
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Fetch data from the JSON file

        function fetchEmployeeStats(){
            $.ajax({
                    url: 'fetchEmployeeStats.php',
                    dataType: 'json', // Expecting JSON response
                    cache: false,
                    success: function(response) {
                        console.log('PHP Response:', response); 
                        renderEmployeeStats(response);
                        response = null;
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        $('#rosterResults').html('<p>Error fetching data. Please try again.</p>');
                    }
                });
            }
        


        function renderEmployeeStats(data){
                const employees = data;
                const tableBody = document.querySelector('#performanceTable tbody');
                let topEmployee = employees[0];
                
                // Populate the table with employee data
                employees.forEach(employee => {
                    const name = employee.FirstName + ' ' + employee.LastName;
                    const personID = parseInt(employee.PersonID);
                    const attendance = parseFloat(employee.ATTENDANCE);
                    const efficiency = parseFloat(employee.EFFICIENCY);
                    const feedback = parseFloat(employee.FEEDBACK);
                    const tasksCompleted = parseInt(employee.TASKS_COMPLETED);
                    const sales = parseFloat(employee.TotalSales);
                    let training = parseInt(employee.TRAINING_COMPLETED);
                    if (training === 1){
                        training = "Complete"
                    } else{
                        training = "Incomplete"
                    }

                    if (employee.EFFICIENCY > topEmployee.EFFICIENCY) {
                        topEmployee = employee;
                    }

                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${name}</td>
                        <td>$${sales}</td>
                        <td>${feedback}</td>
                        <td>${tasksCompleted}</td>
                        <td>${attendance}%</td>
                        <td>${efficiency*100}%</td>
                        <td>${training}</td>
                    `;
                    tableBody.appendChild(row);
                });
                
                
                document.getElementById('topEmployee').innerText = `${topEmployee.FirstName} (Efficiency: ${topEmployee.EFFICIENCY*100}%)`;
                
                
                
                const salesData = {
                    labels: employees.map(emp => emp.FirstName + ' ' + emp.LastName),
                    datasets: [{
                        label: 'Sales',
                        data: employees.map(emp => parseFloat(emp.TotalSales)),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                };
                const salesConfig = {
                    type: 'bar',
                    data: salesData,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                };

                const salesChart = new Chart(
                    document.getElementById('salesChart'),
                    salesConfig
                );
                const feedbackData = {
                    labels: employees.map(emp => emp.FirstName + ' ' + emp.LastName),
                    datasets: [{
                        label: 'Feedback',
                        data: employees.map(emp => parseFloat(emp.FEEDBACK)),
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }]
                };

                const feedbackConfig = {
                    type: 'bar',
                    data: feedbackData,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                };

                const feedbackChart = new Chart(
                    document.getElementById('feedbackChart'),
                    feedbackConfig
                );
            

        }
        document.addEventListener('DOMContentLoaded', function() {
            console.log("DOM fully loaded and parsed.");
            fetchEmployeeStats();
        });
    </script>
</body>
</html>
