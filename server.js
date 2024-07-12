const express = require('express');
const bodyParser = require('body-parser');
const fs = require('fs');
const mysql = require('mysql');
const cors = require('cors');
const multer = require('multer');
const path = require('path');

const app = express();
const port = 3000;

// Enable CORS for all routes
app.use(cors());

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

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

// File upload setup
const storage = multer.diskStorage({
    destination: (req, file, cb) => {
        cb(null, 'uploads/');
    },
    filename: (req, file, cb) => {
        cb(null, Date.now() + path.extname(file.originalname));
    }
});
const upload = multer({ storage });

// API endpoint to get promotions data from JSON file
app.get('/api/promotions', (req, res) => {
    fs.readFile('promotions.json', 'utf8', (err, data) => {
        if (err) {
            console.error('Error reading promotions.json:', err);
            res.status(500).send('Server error');
            return;
        }
        const promotions = JSON.parse(data);
        res.json(promotions);
    });
});

// API endpoint to create a new promotion
app.post('/api/promotions', upload.single('image'), (req, res) => {
    const { name, description, startDate, endDate } = req.body;
    const imageURL = `http://localhost:${port}/uploads/${req.file.filename}`;

    // Read current promotions from the JSON file
    fs.readFile('promotions.json', 'utf8', (err, data) => {
        if (err) {
            console.error('Error reading promotions.json:', err);
            res.status(500).send('Server error');
            return;
        }

        const promotions = JSON.parse(data);
        const newPromotion = {
            id: promotions.promotions.length + 1,
            name,
            description,
            startDate,
            endDate,
            imageURL
        };

        promotions.promotions.push(newPromotion);

        // Write the updated promotions to the JSON file
        fs.writeFile('promotions.json', JSON.stringify(promotions, null, 2), (err) => {
            if (err) {
                console.error('Error writing to promotions.json:', err);
                res.status(500).send('Server error');
                return;
            }
            res.json({ success: true, promotionId: newPromotion.id });
        });
    });
});

// API endpoint to delete a promotion
app.delete('/api/promotions/:id', (req, res) => {
    const { id } = req.params;

    // Read current promotions from the JSON file
    fs.readFile('promotions.json', 'utf8', (err, data) => {
        if (err) {
            console.error('Error reading promotions.json:', err);
            res.status(500).send('Server error');
            return;
        }

        let promotions = JSON.parse(data);
        const promotionIndex = promotions.promotions.findIndex(promo => promo.id === parseInt(id));

        if (promotionIndex === -1) {
            res.status(404).send('Promotion not found');
            return;
        }

        promotions.promotions.splice(promotionIndex, 1);

        // Write the updated promotions to the JSON file
        fs.writeFile('promotions.json', JSON.stringify(promotions, null, 2), (err) => {
            if (err) {
                console.error('Error writing to promotions.json:', err);
                res.status(500).send('Server error');
                return;
            }
            res.json({ success: true });
        });
    });
});

// Serve static files
app.use('/uploads', express.static(path.join(__dirname, 'uploads')));

app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});
