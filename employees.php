


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


$sql = "SELECT * FROM Person WHERE RoleID = 2";
$result = $conn->query($sql);
$categories = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['category_Type'];
    }
} else {
    echo "0 results";
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="mainstyles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Manager</title>
    <title>Add new employee</title>
    
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
    <h1>Employee Manager</h1>
    <h1>Add new Employee</h1>
    <div class="container">
    <div class="form-group">
        <label for="empfname">Employee First Name:</label>
        <input type="text" id="empfname" name="empfname">
    </div>
    <div class="form-group">
        <label for="emplname">Employee Last Name:</label>
        <input type="text" id="emplname" name="emplname">
    </div>
    <div class="form-group">
        <label for="roleID">Role PersonID (1-3):</label>
        <input type="text" id="roleID" name="roleID">
    </div>
    
        <div class="form-group">
            <button onclick="addNewPerson()">Add User</button>
        </div>
        <div class="form-group">
            <button onclick="fetchStock()">refresh</button>
        </div>

        <table id="EmployeeTable">
            <thead>
                <tr>
                    <th>PersonID</th>
                    <th>FirstName</th>
                    <th>LastName</th>
                    <th>StoreID</th>
                    <th>RoleID</th>
                    <th>UsersID</th>
                    <th>UserName</th>
                </tr>
            </thead>
            <tbody>
                <!-- Inventory data will be inserted here -->
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let inventory = [];

    function fetchEmployee() {
            $.ajax({
                url: 'fetchEmployees.php',
                dataType: 'json', // Expecting JSON response
                cache: false,
                success: function(response) {
                    console.log('PHP Response:', response); 
                    renderEmployeeTable(response);
                    response = null;
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#rosterResults').html('<p>Error fetching data. Please try again.</p>');
                }
            });
        }

        function updateEmployee(UserID) {
    const PersonID = document.querySelector(`#PersonID_${UserID}`).value;
    const FirstName = document.querySelector(`#FirstName_${UserID}`).value;
    const LastName = document.querySelector(`#LastName_${UserID}`).value;
    const StoreID = parseInt(document.querySelector(`#StoreID_${UserID}`).value);
    const RoleID = parseInt(document.querySelector(`#RoleID_${UserID}`).value);
    const Username = document.querySelector(`#Username_${UserID}`).value;
    
    const formData = new FormData();
    formData.append('PersonID', PersonID);
    formData.append('empfname', FirstName);
    formData.append('emplname', LastName);
    formData.append('StoreID', StoreID);
    formData.append('RoleID', RoleID);
    formData.append('UserID', UserID);
    formData.append('Username', Username);

    fetch('updatePerson.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(result => {
        console.log(result);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function renderEmployeeTable(data) {
    const tableBody = document.querySelector('#EmployeeTable tbody');
    tableBody.innerHTML = '';

    data.forEach(entry => {
        const PersonID = entry.PersonID;
        const FirstName = entry.FirstName;
        const LastName = entry.LastName;
        const StoreID = entry.StoreID;
        const RoleID = entry.RoleID;
        const UserID = entry.users_id;
        const Username = entry.username;

        const row = document.createElement('tr');
        row.setAttribute('data-employee-id', UserID);

        row.innerHTML = `
            <td><input type="text" id="PersonID_${UserID}" value="${PersonID}" disabled></td>
            <td><input type="text" id="FirstName_${UserID}" value="${FirstName}"></td>
            <td><input type="text" id="LastName_${UserID}" value="${LastName}"></td>
            <td><input type="text" id="StoreID_${UserID}" value="${StoreID}"></td>
            <td><input type="text" id="RoleID_${UserID}" value="${RoleID}"></td>
            <td><input type="text" id="UserID_${UserID}" value="${UserID}" disabled></td>
            <td><input type="text" id="Username_${UserID}" value="${Username}"></td>
            <td>
                <button class="update-btn" onclick="updateEmployee(${UserID})">Update</button>
                <button class="delete-btn" onclick="deleteEntry(${UserID})">Delete</button>
            </td>
        `;

        tableBody.appendChild(row);
    });
}

    function addNewPerson() {
        var formData = new FormData();
        formData.append('empfname', document.getElementById('empfname').value);
        formData.append('emplname', document.getElementById('emplname').value);
        formData.append('roleID', document.getElementById('roleID').value);

        fetch('addNewPerson.php', {
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
            if (data.trim() === 'user added successfully') {
                console.log(data); // Log response from PHP script
                alert('User added successfully!');
                fetchEmployee();
            } else {
                console.log(data); // Log response from PHP script
                alert('Error: ' + data); // Display PHP error message
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('There was an error adding the user.');
        });
    
    }           

    function deleteEntry(UserID) {
        $.ajax({
            url: 'deleteUser.php',
            method: 'POST',
            dataType: 'json',
            data: { UserID: UserID },
            success: function(response) { 
                if (response.success) {
                    // Assuming successful deletion, remove the row from the table
                    const tableRow = document.querySelector(`tr[data-employee-id="${UserID}"]`);
                    console.log(`Selector used: tr[data-employee-id="${UserID}"]`); // Debugging output
                    console.log('Selected row:', tableRow); // Debugging output
                    if (tableRow) {
                        tableRow.remove();
                        console.log('Entry deleted successfully');
                        fetchEmployee();
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
            fetchEmployee();
        });
    </script>
</body>
</html>




