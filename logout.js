document.addEventListener("DOMContentLoaded", function () {
    const userIcon = document.getElementById("user-icon");
  
    // Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
    const isLoggedIn = sessionStorage.getItem("loggedIn") === "true";
  
    // Beállítjuk az ikon címét (opcionális, ha szeretnéd vizuálisan jelezni az állapotot)
    userIcon.title = isLoggedIn ? "Kijelentkezés" : "Bejelentkezés";
  
    // Ikon kattintás eseménykezelő
    userIcon.addEventListener("click", () => {
      if (isLoggedIn) {
        // Ha be van jelentkezve, megerősítés kijelentkezéshez
        const confirmLogout = confirm("Biztosan ki szeretnél jelentkezni?");
        if (confirmLogout) {
          sessionStorage.removeItem("loggedIn"); // Kijelentkezési állapot törlése
          alert("Sikeresen kijelentkeztél!");
          window.location.reload(); // Oldal frissítése
        }
      } else {
        alert("Nem vagy bejelentkezve!");
      }
    });
  });
  