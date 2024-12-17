const express = require('express');
const mysql = require('mysql2');

const app = express();
const port = 3000;

// MySQL kapcsolat
const connection = mysql.createConnection({
    host: 'localhost',
    port: '3306',
    user: 'Bence',
    password: 'ASDasd123',
    database: 'vizsgaremek'
});

// API meghivas
app.get('/api/products/:category', (req, res) => {
    const categoryName = req.params.category;

    connection.query("CALL getProductsByCategory(?)", [categoryName], (err, results) => {
        if (err) {
            res.status(500).json({ error: err.message });
        } else {
            res.json(results[0]); // Tárolt eljárás első eredményhalmaza
        }
    });
});

// ez kell majd az elinditashot Szerver inditasa
app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});
connection.connect((err) => {
    if (err) {
        console.error('Error connecting to MySQL:', err.message);
    } else {
        console.log('Connected to MySQL database.');
    }
});

