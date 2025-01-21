document.addEventListener("DOMContentLoaded", function () {
    const userIcon = document.getElementById("user-icon");

    // Ellenőrizzük, hogy be van-e jelentkezve
    function isLoggedIn() {
        return localStorage.getItem("loggedIn") === "true";
    }

    function updateIcon() {
        if (isLoggedIn()) {
            userIcon.title = "Kijelentkezés";
        } else {
            userIcon.title = "Bejelentkezés";
        }
    }

    // Frissítjük az ikont
    updateIcon();

    // Kattintás esemény kezelése
    userIcon.addEventListener("click", () => {
        if (isLoggedIn()) {
            // Kijelentkezés megerősítése
            const confirmLogout = confirm("Biztosan ki szeretnél jelentkezni?");
            if (confirmLogout) {
                localStorage.removeItem("loggedIn");
                alert("Sikeresen kijelentkeztél!");
                updateIcon(); // Frissítjük az ikont kijelentkezés után
                location.reload();  // Az oldal frissítése
            }
        } else {
            // Ha nem vagy bejelentkezve, irányítsuk a bejelentkezési oldalra
            window.location.href = "index.html";
        }
    });
});
