const express = require('express');
const bodyParser = require('body-parser');
const fs = require('fs');
const mysql = require('mysql');
const cors = require('cors');
const path = require('path');

const app = express();
const port = 3002; // Change this to your preferred port if needed

// Enable CORS for all routes
app.use(cors());

app.use(bodyParser.json());

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

const readData = () => {
  const data = fs.readFileSync('employeeData.json');
  return JSON.parse(data);
};

const writeData = (data) => {
  fs.writeFileSync('employeeData.json', JSON.stringify(data, null, 2));
};

// Get all employees
app.get('/api/employees', (req, res) => {
  const data = readData();
  res.json(data.employees);
});

// Add a new schedule
app.post('/api/employees/:id/schedule', (req, res) => {
  const data = readData();
  const employee = data.employees.find(emp => emp.id === parseInt(req.params.id));
  if (employee) {
    employee.schedule.push(req.body);
    writeData(data);
    res.status(201).send(req.body);
  } else {
    res.status(404).send({ message: 'Employee not found' });
  }
});

// Delete a schedule
app.delete('/api/employees/:id/schedule', (req, res) => {
  const data = readData();
  const employee = data.employees.find(emp => emp.id === parseInt(req.params.id));
  if (employee) {
    const index = employee.schedule.findIndex(s => s.date === req.body.date && s.shift === req.body.shift);
    if (index !== -1) {
      employee.schedule.splice(index, 1);
      writeData(data);
      res.status(200).send({ message: 'Schedule deleted' });
    } else {
      res.status(404).send({ message: 'Schedule not found' });
    }
  } else {
    res.status(404).send({ message: 'Employee not found' });
  }
});

// Function to read customer feedback data
const readFeedbackData = () => {
  const data = fs.readFileSync(path.join(__dirname, 'customerFeedback.json'));
  return JSON.parse(data);
};

const writeFeedbackData = (data) => {
  fs.writeFileSync(path.join(__dirname, 'customerFeedback.json'), JSON.stringify(data, null, 2));
};

// Get all feedback
app.get('/api/feedback', (req, res) => {
  const data = readFeedbackData();
  res.json(data.feedback);
});

// Respond to feedback
app.post('/api/feedback/:id/response', (req, res) => {
  const data = readFeedbackData();
  const feedback = data.feedback.find(fb => fb.id === parseInt(req.params.id));
  if (feedback) {
    feedback.response = req.body.response;
    feedback.status = 'Responded';
    writeFeedbackData(data);
    res.status(201).send(feedback);
  } else {
    res.status(404).send({ message: 'Feedback not found' });
  }
});

app.listen(port, () => {
  console.log(`Server running at http://localhost:${port}`);
});
