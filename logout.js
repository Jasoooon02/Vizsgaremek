document.addEventListener("DOMContentLoaded", function () {
    const userIcon = document.getElementById("user-icon");


    function isLoggedIn() {
        return localStorage.getItem("isLoggedIn") === "true";
    }

    function updateIcon() {
        if (isLoggedIn()) {
            userIcon.title = "Kijelentkezés";
        } else {
            userIcon.title = "Bejelentkezés";
        }
    }

    
    updateIcon();

    
    userIcon.addEventListener("click", () => {
        if (isLoggedIn()) {
            
            const confirmLogout = confirm("Biztosan ki szeretnél jelentkezni?");
            if (confirmLogout) {
                
                fetch('logout.php', { method: 'POST' })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            
                            localStorage.removeItem("isLoggedIn");
                            localStorage.removeItem("username");
                            alert(data.message);
                            
                            window.location.href = "index.html";
                        } else {
                            alert("Hiba történt a kijelentkezés során!");
                        }
                    })
                    .catch(error => {
                        console.error("Hiba a kijelentkezés során:", error);
                        alert("Nem sikerült kapcsolatot létesíteni a szerverrel.");
                    });
            }
        } else {
            
            window.location.href = "index.html";
        }
    });
});
