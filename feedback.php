<!DOCTYPE html>
<html lang="en">
<head>
<!-- <link rel="stylesheet" href="mainstyles.css"> -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Feedback Manager</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
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
        .response-btn, .quick-response-btn {
            padding: 5px 10px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 5px;
        }
        .response-btn:hover, .quick-response-btn:hover {
            background: #45a049;
        }
        .pending {
            color: red;
        }
        .responded {
            color: green;
        }
    </style>
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
            <a href="employees.php">Employees</a>
        </div>
        <button class="logout-btn" onclick=Logout()>Logout</button>
    </div>
    <h1>Customer Feedback Manager</h1>
    <div class="container">
        <table id="feedbackTable">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Feedback Type</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Response</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Feedback data will be inserted here -->
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        async function fetchFeedback() {
            $.ajax({
                url: 'fetchFeedback.php',
                dataType: 'json', // Expecting JSON response
                cache: false,
                success: function(response) {
                    console.log('PHP Response:', response); 
                    renderFeedbackTable(response);
                    response = null;
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#feedbackTable').html('<p>Error fetching data. Please try again.</p>');
                }
            });
        }
        
        function fetchStock() {
            // console.log($categories);
            $.ajax({
                url: 'fetchFeedback.php',
                dataType: 'json', // Expecting JSON response
                cache: false,
                success: function(response) {
                    console.log('PHP Response:', response); 
                    renderFeedbackTable(response);
                    response = null;
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#feedbackTable').html('<p>Error fetching data. Please try again.</p>');
                }
            });
        }





        function renderFeedbackTable(date_add) {
            const tableBody = document.querySelector('#feedbackTable tbody');
            tableBody.innerHTML = '';
            date_add.forEach(feedback => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${feedback.CUSTOMER_NAME}</td>
                    <td>${feedback.FEEDBACKTYPE}</td>
                    <td>${feedback.MESSAGE}</td>
                    <td class="${feedback.STATUS.toLowerCase()}">${feedback.STATUS}</td>
                    <td>${feedback.RESPONSE || ''}</td>
                    <td>
                        <button class="response-btn" onclick="respondToFeedback(${feedback.FEEDBACK_ID})">Respond</button>
                        <button class="quick-response-btn" onclick="quickRespond(${feedback.FEEDBACK_ID}, 'Thank you')">Thank you</button>
                        <button class="quick-response-btn" onclick="quickRespond(${feedback.FEEDBACK_ID}, 'Okay')">Okay</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        function respondToFeedback(feedbackId) {
            const response = prompt('Enter your response:');
            if (response) {
                sendResponse(feedbackId, response);
            }
        }

        function quickRespond(feedbackId, message) {
            sendResponse(feedbackId, message);
        }

        async function sendResponse(feedbackId, response) {
            try {
                const res = await fetch(`http://localhost:3002/api/feedback/${feedbackId}/response`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ response })
                });
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                fetchFeedback();
            } catch (error) {
                console.error('Error responding to feedback:', error);
            }
        }

        // Initial fetch
        fetchFeedback();
    </script>
</body>
</html>
