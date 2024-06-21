const express = require('express');
const mysql = require('mysql');
const cors = require('cors');

const app = express();
const port = 3002; // Change this to your preferred port if needed

// Enable CORS for all routes
app.use(cors());

// MySQL connection
const db = mysql.createConnection({
    host: 'cp3407-website-db.cfumcuommiak.ap-southeast-2.rds.amazonaws.com',
    user: 'CP3407admin',
    password: 'YFtG]?$4&+k}.WJ',
    database: 'EasyGrocer'
  });

db.connect(err => {
  if (err) {
    console.error('Error connecting to MySQL database:', err);
    return;
  }
  console.log('Connected to MySQL database.');
});

// API endpoint to get employee data
app.get('/api/employee', (req, res) => {
  const query = 'SELECT firstname, lastname, total_sales, attendance, feedback_percentage FROM employee';
  db.query(query, (err, results) => {
    if (err) {
      console.error('Error fetching employee data:', err);
      res.status(500).send('Server error');
      return;
    }
    res.json(results);
  });
});

app.listen(port, () => {
  console.log(`Server running at http://localhost:${port}`);
});
