<!-- TODO
 
Rework this to grab the ENTIRE roster into a json, work with Chirags shit from there on out-->




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


$sql = "SELECT id, FirstName, LastName FROM users join Person on id = PersonID";
$result = $conn->query($sql);

$userIDs = [];
if ($result->num_rows > 0) {
    // Fetch all user IDs and store them in an array
    while ($row = $result->fetch_assoc()) {
        // Store both ID and full name in an array
        $userIDs[] = [
            'id' => $row['id'],
            'firstname' => $row['FirstName'],
            'lastname' => $row['LastName']
        ];
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
    <title>Employee Schedule Manager</title>
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
        .container {
            max-width: 10000px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .form-group label {
            margin-right: 10px;
            flex: 1;
        }
        .form-group select,
        .form-group input {
            flex: 3;
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
        .delete-btn {
            padding: 5px 10px;
            background: #f44336;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background: #e53935;
        }
        .roster {
            margin-top: 30px;
        }
        .roster-table {
            width: 100%;
            border-collapse: collapse;
        }
        .roster-table th, .roster-table td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 10px;
        }
        .roster-table th {
            background-color: #f2f2f2;
        }
        .roster-table .empty {
            background-color: #ffebee;
        }
        .roster-table .filled {
            background-color: #c8e6c9;
        }
        
/* Home button styles */
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
<a href="newIndex.php" class="home-button">Home</a>
    <h1>Employee Schedule Manager</h1>
    <div class="container">
        <form>
        <div class="form-group">
            <label for="employee">Employee:</label>
            <select id="employee" name="employee">  
            <?php
    foreach ($userIDs as $user) {
        echo '<option value="' . $user['id'] . '">' . $user['firstname'] . ' ' . $user['lastname'] . ' (' . $user['id'] . ')' . '</option>';
    }
    ?>   
</select>
        </div>
        <div class = form-group>
        <form id="dateForm">
        <label for="selectedDate">Select Date:</label>
        <input type="date" id="selectedDate" name="selectedDate">
        
    </form>
</div>
        <div class="form-group">
            <label for="shift">Shift:</label>
            <select id="shift" name="shift">
                <option value="morning">Morning</option>
                <option value="afternoon">Afternoon</option>
                <option value="evening">Evening</option>
            </select>
        </div>
        <div class="form-group">
                <button type="button" onclick="addSchedule()">Add Schedule</button>
                
            </div>
        <div class="form-group">
        <button type="button" onclick="submitDate()">Refresh Roster</button>
</div>
        </form>
    </div>
    
        <table id="scheduleTable">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Date</th>
                    <th>Shift</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Schedule data will be inserted here -->
            </tbody>
        </table>
    </form>

        <div class="roster">
            <h2>Weekly Roster</h2>
            <table class="roster-table" id="rosterTable">
    <thead>
        <tr>
            <th>Time Slot</th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Saturday</th>
            <th>Sunday</th>
        </tr>
    </thead>
    <tbody id="rosterTableBody">
        <tr>
            <td>Morning</td>
            <td class="slot" data-day="monday" data-shift="morning"></td>
            <td class="slot" data-day="tuesday" data-shift="morning"></td>
            <td class="slot" data-day="wednesday" data-shift="morning"></td>
            <td class="slot" data-day="thursday" data-shift="morning"></td>
            <td class="slot" data-day="friday" data-shift="morning"></td>
            <td class="slot" data-day="saturday" data-shift="morning"></td>
            <td class="slot" data-day="sunday" data-shift="morning"></td>
        </tr>
        <tr>
            <td>Afternoon</td>
            <td class="slot" data-day="monday" data-shift="afternoon"></td>
            <td class="slot" data-day="tuesday" data-shift="afternoon"></td>
            <td class="slot" data-day="wednesday" data-shift="afternoon"></td>
            <td class="slot" data-day="thursday" data-shift="afternoon"></td>
            <td class="slot" data-day="friday" data-shift="afternoon"></td>
            <td class="slot" data-day="saturday" data-shift="afternoon"></td>
            <td class="slot" data-day="sunday" data-shift="afternoon"></td>
        </tr>
        <tr>
            <td>Evening</td>
            <td class="slot" data-day="monday" data-shift="evening"></td>
            <td class="slot" data-day="tuesday" data-shift="evening"></td>
            <td class="slot" data-day="wednesday" data-shift="evening"></td>
            <td class="slot" data-day="thursday" data-shift="evening"></td>
            <td class="slot" data-day="friday" data-shift="evening"></td>
            <td class="slot" data-day="saturday" data-shift="evening"></td>
            <td class="slot" data-day="sunday" data-shift="evening"></td>
        </tr>
    </tbody>
</table>
        </div>
    </div>

    <div id="rosterResults">ROSTER RESULTS</div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function submitDate() {
            const selectedDate = $('#selectedDate').val();
            
            $.ajax({
                url: 'fetch_roster.php',
                type: 'POST',
                data: { date: selectedDate },
                dataType: 'json', // Expecting JSON response
                cache: false,
                success: function(response) {
                    console.log('PHP Response:', response); 
                    $('#selectedDateDisplay').text('Selected Date: ' + selectedDate); // Update selected date display
                    populateTable(response);
                    renderScheduleTable(response);
                    response = null;
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#rosterResults').html('<p>Error fetching data. Please try again.</p>');
                }
            });
        }


        async function populateTable(data) {
            const rosterData = data; // Renamed to rosterData for clarity
            const table = document.getElementById('rosterTable');
            clearTable(table);
            
            rosterData.forEach(entry => {
            const entryDate = new Date(entry.Date); // Renamed to entryDate
            const dayIndex = entryDate.getDay(); // Renamed to dayIndex
            const shiftID = parseInt(entry.ShiftID);
            const userID = parseInt(entry.users_id); // Renamed to userID
            const FirstName = entry.FirstName;
            const LastName = entry.LastName;

            const cell = table.querySelector(`.slot[data-day="${getDayName(dayIndex)}"][data-shift="${getShiftName(shiftID)}"]`);
            if (cell) {
                cell.textContent = `${FirstName} ${LastName} (${userID})`;
            }
    });

}

function clearTable(table) {
    // Clear all cells in the table
    const cells = table.querySelectorAll('.slot');
    cells.forEach(cell => {
        cell.textContent = '';
    });
}
        function getDayName(dayIndex) {
            const days = ['sunday','monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
            return days[dayIndex];
        }

        function getShiftName(shiftID) {
            switch (shiftID) {
                case 1:
                    return 'morning';
                case 2:
                    return 'afternoon';
                case 3:
                    return 'evening';
                default:
                    return '';
            }
        }
        function addSchedule() {
    var formData = new FormData();
    formData.append('employee', document.getElementById('employee').value);
    formData.append('selectedDate', document.getElementById('selectedDate').value);
    formData.append('shift', document.getElementById('shift').value);

    fetch('addSchedule.php', {
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
        if (data.trim() === 'Schedule added successfully') {
            console.log(data); // Log response from PHP script
            alert('Schedule added successfully!');
            submitDate();
        } else {
            console.log(data); // Log response from PHP script
            alert('Error: ' + data); // Display PHP error message
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('There was an error adding the schedule.');
    });
    
}

function renderScheduleTable(data) {
    const rosterData = data; // Assuming rosterData is an array of objects
    const tableBody = document.querySelector('#scheduleTable tbody');
    tableBody.innerHTML = ''; // Clear existing table rows if any

    rosterData.forEach(entry => {
        const entryDate = new Date(entry.Date); // Assuming entry.Date is a valid date string
        const RosterID = parseInt(entry.RosterID);
        const dayIndex = entryDate.getDay(); // Assuming you need the day index for some purpose
        const shiftID = parseInt(entry.ShiftID); // Assuming ShiftID is a string representation of an integer
        if (shiftID == 1){
            displayshiftID = 'morning'
        }else if (shiftID == 2){
            displayshiftID = 'afternoon'
        }else {
            displayshiftID = 'evening'
        }
        const userID = parseInt(entry.users_id); // Assuming users_id is a string representation of an integer
        const firstName = entry.FirstName; // Renamed to use camelCase convention
        const lastName = entry.LastName; // Renamed to use camelCase convention
        
        // Create a new row
        const row = document.createElement('tr');
        row.dataset.rosterId = RosterID;

        // Populate row HTML content
        row.innerHTML = `
            <td>${firstName} ${lastName} (${userID})</td>
            <td>${entry.Date}</td>
            <td>${displayshiftID}</td>
            <td><button class="delete-btn" onclick="deleteEntry('${entry.RosterID}')">Delete ('${entry.RosterID}')</button></td>
        `;

        // Append row to table body
        tableBody.appendChild(row);
            });
        }


        function deleteEntry(rosterID) {
            rosterID = parseInt(rosterID);
            $.ajax({
                url: 'removeSchedule.php',
                method: 'POST',
                dataType: 'json',
                data: { RosterID: rosterID },
                success: function(response) {
                    if (response.success) {
                        // Assuming successful deletion, remove the row from the table
                        const tableRow = $(`tr[data-roster-id="${rosterID}"]`);
                        if (tableRow.length > 0) {
                            tableRow.remove();
                            console.log('Entry deleted successfully');
                            submitDate();
                        } else {
                            console.error('Table row not found');
                        }
                    } else {
                        console.error('Failed to delete entry:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting entry:', error);
                }
            });
        }

    </script>
