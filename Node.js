app.get('/api/products/:category', (req, res) => {
    const categoryName = req.params.category;

    connection.query("CALL getProductsByCategory(?)", [categoryName], (err, results) => {
        if (err) {
            res.status(500).json({ error: err.message });
        } else {
            res.json(results[0]);
        }
    });
});

//ez a tárolt eljáráshóz kell majd