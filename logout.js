document.addEventListener("DOMContentLoaded", function () {
    const userIcon = document.getElementById("user-icon");

 
    function isLoggedIn() {
        return localStorage.getItem("loggedIn") === "true";
    }

    

   
    updateIcon();


    userIcon.addEventListener("click", () => {
        if (isLoggedIn()) {
            
            const confirmLogout = confirm("Biztosan ki szeretnél jelentkezni?");
            if (confirmLogout) {
                localStorage.removeItem("loggedIn");
                alert("Sikeresen kijelentkeztél!");
                updateIcon(); 
                location.reload();  
            }
        } else {
            
            window.location.href = "index.html";
        }
    });
});
