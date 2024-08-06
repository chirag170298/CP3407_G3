<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="mainstyles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotions Management - TESTING</title>
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
    <div class="container">
        <h1>Promotions Management</h1>
        <div class="tabs">
            <div class="tab active" data-tab="current">Current Running</div>
            <div class="tab" data-tab="create">Create Promotion</div>
            <div class="tab" data-tab="delete">Delete Promotion</div>
        </div>
        

        <div id="current" class="tab-content active">
            <div class="promotion-list-section">
                <h2>Current Promotions</h2>
                <table id="promotion-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="promotion-table-body">
                        <!-- Promotion data will be injected here -->
                    </tbody>
                </table>
            </div>
        </div>
        <div id="create" class="tab-content">
            <div class="form-section">
                <h2>Create a Promotion</h2>
                <label for="promo-name">Promotion Name:</label>
                <input type="text" id="promo-name" name="promo-name">

                <label for="promo-description">Description:</label>
                <textarea id="promo-description" name="promo-description" rows="4"></textarea>

                <label for="promo-start-date">Start Date:</label>
                <input type="date" id="promo-start-date" name="promo-start-date">

                <label for="promo-end-date">End Date:</label>
                <input type="date" id="promo-end-date" name="promo-end-date">

                <label for="promo-image">Promotion Image:</label>
                <input type="file" id="promo-image" name="promo-image" accept="image/*">

                <button id="create-promotion">Create Promotion</button>\
            </div>
        </div>
        <div id="delete" class="tab-content">
            <div class="form-section">
                <h2>Delete a Promotion</h2>
                <label for="promo-id">Promotion ID:</label>
                <input type="number" id="promo-id" name="promo-id" min="1">

                <button id="delete-promotion">Delete Promotion</button>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const tabId = this.getAttribute('data-tab');
                    showTab(tabId);
                });
            });

            // fetchPromo();

            document.getElementById('create-promotion').addEventListener('click', createPromotion);
            document.getElementById('delete-promotion').addEventListener('click', deletePromotion);
        });

        function showTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });

            document.getElementById(tabId).classList.add('active');

            document.querySelectorAll('.tab').forEach(tab => {
                if (tab.getAttribute('data-tab') === tabId) {
                    tab.classList.add('active');
                } else {
                    tab.classList.remove('active');
                }
            });

            if (tabId === 'current') {
                fetchPromo();
            }
        }



        function displayPromotions(promotions) {
            const tbody = document.getElementById('promotion-table-body');
            tbody.innerHTML = '';

            promotions.forEach(promo => {
                const name = promo.PROMOTION_NAME;

                const row = document.createElement('tr');
                // <td><img src="${promo.imageURL}" alt="Promotion Image" class="promo-image"></td>

                row.innerHTML = `
                    <td>${name}</td>
                    <td>${promo.DESCRIPTION}</td>
                    <td>${promo.START_DATE}</td>
                    <td>${promo.END_DATE}</td>
                    <td><button class="delete-button" onclick="deletePromotion(${promo.id})">Delete</button></td>
                `;
                tbody.appendChild(row);
            });
        }


        function fetchPromo() {
            $.ajax({
                url: 'fetchPromo.php',
                dataType: 'json', // Expecting JSON response
                cache: false,
                success: function(response) {
                    console.log('PHP Response:', response); 
                    displayPromotions(response);
                    response = null;
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#promotion-table-body').html('<p>Error fetching data. Please try again.</p>');
                }
            });
        }

        function createPromotion() {
            const name = document.getElementById('promo-name').value;
            const description = document.getElementById('promo-description').value;
            const startDate = document.getElementById('promo-start-date').value;
            const endDate = document.getElementById('promo-end-date').value;
            // const imageFile = document.getElementById('promo-image').files[0];

            if (!name || !description || !startDate || !endDate) {
                alert('Please fill in all fields and select an image.');
                return;
            }

            fetch('addPromo.php', {
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
        if (data.trim() === 'Promo added successfully') {
            console.log(data); // Log response from PHP script
            alert('Promo added successfully!');
            fetchShifts();
        } else {
            console.log(data); // Log response from PHP script
            alert('Error: ' + data); // Display PHP error message
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('There was an error adding the Promo.');
    });



        }

        function deletePromotion(id) {
            fetch('promotions.json')
                .then(response => response.json())
                .then(data => {
                    const promotions = data.promotions || [];
                    const updatedPromotions = promotions.filter(promo => promo.id !== id);
                    savePromotions(updatedPromotions);
                    alert('Promotion deleted successfully!');
                    fetchPromo(); // Reload promotions after deletion
                })
                .catch(error => console.error('Error fetching promotions:', error));
        }

        function savePromotions(promotions) {
            fetch('promotions.json', {
                method: 'PUT', // Use PUT method for local file modification (not standard RESTful API)
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ promotions })
            })
            .catch(error => console.error('Error saving promotions:', error));
        }


        document.addEventListener('DOMContentLoaded', function() {
            console.log("DOM fully loaded and parsed.");
            fetchPromo();
        });


</script>
</body>
</html>