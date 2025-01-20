<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>DemonCars</title>
</head>
<body>
<?php
session_start();
?>

<header>
    <p class="sz">DEMONCARS</p>
    <div class="user-icon" id="user-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path d="M256 0C114.39 0 0 114.61 0 256s114.39 256 256 256 256-114.61 256-256S397.61 0 256 0zm0 96a80 80 0 1 1-80 80 80 80 0 0 1 80-80zm0 352c-66.77 0-125.07-36.41-156.68-90.66a158.48 158.48 0 0 1 313.36 0C381.07 411.59 322.77 448 256 448z"/>
        </svg>
    </div>
</header>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const userIcon = document.getElementById('user-icon');
        const loggedIn = <?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>;

        userIcon.addEventListener('click', () => {
            if (loggedIn) {
                if (confirm('Biztosan ki szeretnél jelentkezni?')) {
                    window.location.href = 'logout.php';
                }
            } else {
                window.location.href = 'index.php';
            }
        });
    });
</script>

<div class="frame">
    <div class="category">
        <ul class="category-menu">
            <li data-category="all">Minden termék</li>
            <li data-category="sport">Sportautók</li>
            <li data-category="super">Szuperautók</li>
            <li data-category="muscle">Izomautók</li>
            <li data-category="street">Utcai autók</li>
        </ul>
    </div>
    <p class="kat">Kategóriák</p>
    <div class="cars">
        <!-- Autók listája -->
        <div class="car-item" data-category="street">
            <a href="golf.html">
                <img src="golf_black.jpg" alt="Golf MK4">
            </a>
            <p class="name">Golf MK4</p>
            <p class="price">1 895 000 Ft-tól</p>
        </div>
        <div class="car-item" data-category="sport">
            <a href="audir8.html">
                <img src="r8_black.jpg" alt="Audi R8">
            </a>
            <p class="name">Audi R8</p>
            <p class="price">10 890 000 Ft-tól</p>
        </div>
        <div class="car-item" data-category="super">
            <a href="bugattic.html">
                <img src="bugatti_black.jpg" alt="Bugatti Chiron">
            </a>
            <p class="name">Bugatti Chiron</p>
            <p class="price">20 290 000 Ft-tól</p>
        </div>
        <div class="car-item" data-category="muscle">
            <a href="dodgech.html">
                <img src="dodge_fekete.jpg" alt="Dodge Charger">
            </a>
            <p class="name">Dodge Charger</p>
            <p class="price">5 980 000 Ft-tól</p>
        </div>
        <div class="car-item" data-category="street">
            <a href="golf6.html">
                <img src="golf6_black.png" alt="Golf MK6">
            </a>
            <p class="name">Golf MK6</p>
            <p class="price">17 210 000 Ft-tól</p>
        </div>
        <div class="car-item" data-category="street">
            <a href="e39.html">
                <img src="e39_black.jpeg" alt="BMW E39">
            </a>
            <p class="name">BMW E39</p>
            <p class="price">20 780 000 Ft-tól</p>
        </div>
        <div class="car-item" data-category="street">
            <a href="e46.html">
                <img src="e46_black.jpg" alt="BMW E46">
            </a>
            <p class="name">BMW E46</p>
            <p class="price">29 610 000 Ft-tól</p>
        </div>
    </div>
</div>

<section class="team-section">
    <h1>Egy összetartó csapat vagyunk</h1>
    <p class="subtitle">Egy menő csapat, rengeteg energiával!</p>

    <div class="team-container">
        <div class="team-member">
            <img src="jani.jpg" alt="Kelemen János" class="team-photo">
            <h3>Kelemen János</h3>
            <p class="position">Ceo</p>
            <p class="description">Kattints ide, és kezdheted is az írást.</p>
        </div>
        <div class="team-member">
            <img src="balazs.jpg" alt="Gáspár Balázs" class="team-photo">
            <h3>Gáspár Balázs</h3>
            <p class="position">Ceo</p>
            <p class="description">Kattints ide, és kezdheted is az írást.</p>
        </div>
        <div class="team-member">
            <img src="bence.jpg" alt="Kollár Bence" class="team-photo">
            <h3>Kollár Bence</h3>
            <p class="position">Ceo</p>
            <p class="description">Kattints ide, és kezdheted is az írást.</p>
        </div>
    </div>
</section>

<script>
    const cars = document.querySelectorAll('.car-item');
    const categoryLinks = document.querySelectorAll('.category-menu li');

    categoryLinks.forEach(link => {
        link.addEventListener('click', () => {
            const category = link.getAttribute('data-category');

            cars.forEach(car => {
                car.classList.remove('active');
                if (category === 'all' || car.getAttribute('data-category') === category) {
                    car.classList.add('active');
                }
            });
        });
    });

    document.querySelector('[data-category="all"]').click();

    document.addEventListener("DOMContentLoaded", function() {
        const carsDiv = document.querySelector('.cars');
        carsDiv.style.maxHeight = '400px';
        carsDiv.style.overflowY = 'auto';
    });
</script>

<footer>
    <button onclick="window.open('https://www.facebook.com/profile.php?id=100007516684232', '_blank')">
        <span class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 512 512">
                <!-- Facebook ikon SVG -->
            </svg>
        </span>
        <span class="text1">Kövess be</span>
        <span class="text2">Jani</span>
    </button>
    <div class="jobbra">
        <button onclick="window.open('https://www.instagram.com/kelemen.jani.39/', '_blank')"> 
            <span class="iconn">
                <svg height="33" width="33" viewBox="0 0 128 128">
                    <!-- Instagram ikon SVG -->
                </svg>
            </span>
            <span class="text1">Kövess be</span>
            <span class="text2">Jani</span> 
        </button>
    </div>
</footer>

</body>
</html>
