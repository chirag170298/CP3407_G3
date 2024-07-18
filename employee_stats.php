<?php
include 'auth.php';
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Performance Stats</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        
        main {
            margin: 20px;
        }
        
        .chart-container {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .table-container {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 1em;
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
        
        tbody tr:hover {
            background-color: #f1f1f1;
        }
        
        .top-employee {
            background: #e0ffe0;
            border: 1px solid #4CAF50;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        
        .training-completed {
            color: green;
        }
        
        .training-pending {
            color: red;
        }
    </style>
    
</head>
<body>
    <h1>Employee Performance Statistics</h1>
    
    <main>
    <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="roster.php">Roster</a></li>
                <li><a href="logout.php">logout</a></li>
            </ul>
        </nav>
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
