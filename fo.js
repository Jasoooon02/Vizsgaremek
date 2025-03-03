document.addEventListener("DOMContentLoaded", function () {
    const userIcon = document.getElementById("user-icon");
    const menuContainer = document.createElement("div");
    menuContainer.id = "user-menu";
    menuContainer.style.display = "none";
    document.body.appendChild(menuContainer);

    const style = document.createElement('style');
    style.innerHTML = `
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            max-width: 500px;
            width: 90%;
            position: relative;
            height: 500px;
        }
        
        .contact-form {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 90%; 
            max-width: 400px; 
            height: 400px; 
            max-height: 400px; 
            padding: 20px;
            transform: translate(-50%, -50%);
            background: rgba(24, 20, 20, 0.987); 
            box-sizing: border-box;
            box-shadow: 0 15px 25px rgba(0, 0, 0, .6);
            border-radius: 10px;
            overflow-y: auto; 
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .contact-form label {
            font-size: 16px;
            color: #8f0000;
            font-weight: 600;
            margin-bottom: 10px;
            display: block;
        }
        
        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 10px 0;
            font-size: 16px;
            color: #8f0000;
            margin-bottom: 20px;
            border: none;
            border-bottom: 1px solid #8f0000;
            outline: none;
            background: transparent;
        }
        
        .contact-form input::placeholder,
        .contact-form textarea::placeholder {
            color: #ffffff;
        }
        
        .contact-form textarea {
            resize: none;
            min-height: 100px;
        }
        
        .contact-form button {
            cursor: pointer;
            position: relative;
            padding: 10px 24px;
            font-size: 18px;
            color: #8f0000;
            border: 2px solid #8f0000;
            border-radius: 34px;
            background-color: transparent;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
            overflow: hidden;
            display: block;
            margin: 0 auto;
            height:40px;
        }
        
        .contact-form button::before {
            content: '';
            position: absolute;
            inset: 0;
            margin: auto;
            width: 70px;
            height: 50px;
            border-radius: inherit;
            scale: 0;
            z-index: -1;
            background-color: #8f0000;
            transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1);
        }
        
        .contact-form button:hover::before {
            scale: 3;
        }
        
        .contact-form button:hover {
            color: #212121;
            scale: 1.1;
            box-shadow: 0 0px 20px rgba(193, 163, 98, 0.4);
        }
        
        .contact-form button:active {
            scale: 1;
        }
        
        .success {
            color: #ffffff;
            margin-bottom: 20px;
        }
        
        .error {
            color: red;
            font-weight: bold;
            margin: 10px 0;
        }
        
        ::placeholder {
            color: #ffffff;
        }

        @media (min-width: 768px) {
            .contact-form {
                width: 300px;
                height: 550px;
                padding: 30px;
            }
        }

        @media (min-width: 1024px) {
            .contact-form {
                width: 450px;
                height: 600px;
            }
        }
    `;
    document.head.appendChild(style);

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

    function toggleMenu() {
        if (isLoggedIn()) {
            menuContainer.style.display =
                menuContainer.style.display === "block" ? "none" : "block";
        } else {
            window.location.href = "index.html";
        }
    }

    function setupMenu() {
        const isAdmin = localStorage.getItem("username") === "admin"; 

        let menuItems = `
            <ul>
                <li id="account-info">Fiókinformáció</li>
                <li id="settings">Beállítások</li>
                <li id="contact">Kapcsolat</li>
                <li id="logout">Kijelentkezés</li>
        `;

        if (isAdmin) {
            menuItems += `
                <li id="admin-menu">Rendelések</li>
            `;
        }

        menuItems += `</ul>`;

        menuContainer.innerHTML = menuItems;

        document.getElementById("logout").addEventListener("click", () => {
            if (confirm("Biztosan ki szeretnél jelentkezni?")) {
                fetch("logout.php", { method: "POST" })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            localStorage.removeItem("isLoggedIn");
                            localStorage.removeItem("username");
                            alert(data.message);
                            window.location.href = "index.html";
                        } else {
                            alert("Hiba történt a kijelentkezés során!");
                        }
                    })
                    .catch((error) => {
                        console.error("Hiba a kijelentkezés során:", error);
                        alert("Nem sikerült kapcsolatot létesíteni a szerverrel.");
                    });
            }
        });

        if (isAdmin) {
            document.getElementById("admin-menu").addEventListener("click", () => {
                window.location.href = "rendelesek.html";
            });
        }

        document.getElementById("settings").addEventListener("click", () => {
            createModal(
                `<h3>Beállítások</h3><p>Jelenleg nincs elérhető beállítás!</p>`
            );
        });

        document.getElementById("contact").addEventListener("click", () => {
            createModal(
                `<h3>Kapcsolat</h3>
                <form id="contact-form" class="contact-form">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Például: email@example.com" required>
                    <label for="message">Üzenet:</label>
                    <textarea id="message" name="message" placeholder="Írja ide üzenetét..." required></textarea>
                    <button type="submit">Küldés</button>
                </form>`
            );
        });

        document.getElementById("account-info").addEventListener("click", () => {
            fetch('account-info.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        createModal(`
                            <h3>Fiókinformáció</h3>
                            <p>Felhasználónév: ${localStorage.getItem("username") || "N/A"}</p>
                            <p>Email: ${data.email || "N/A"}</p>
                        `);
                    } else {
                        alert("Hiba történt a fiók információinak lekérése során.");
                    }
                })
                .catch(error => {
                    console.error('Hiba a fiók információk lekérése során:', error);
                    alert("Nem sikerült kapcsolatot létesíteni a szerverrel.");
                });
        });
    }

    function createModal(content, onLoad = null) {
        const modal = document.createElement("div");
        modal.id = "modal";
        modal.innerHTML = `
            <div class="modal-content">
                <button id="close-modal" class="close-btn">✖</button>
                ${content}
            </div>
        `;
        document.body.appendChild(modal);

        document.getElementById("close-modal").addEventListener("click", closeModal);

        if (onLoad) {
            onLoad();
        }
    }

    function closeModal() {
        const modal = document.getElementById("modal");
        if (modal) {
            modal.remove();
        }
    }

    // Handle contact form submission
    document.body.addEventListener("submit", function (e) {
        if (e.target.id === "contact-form") {
            e.preventDefault();

            const email = document.getElementById("email").value;
            const message = document.getElementById("message").value;

            // Send form data to send-email.php
            fetch("send-email.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `email=${encodeURIComponent(email)}&message=${encodeURIComponent(message)}`
            })
            .then(response => response.text())
            .then(data => {
                if (data === 'success') {
                    alert("Az üzenet sikeresen elküldve!");
                    closeModal(); // Close modal after success
                } else {
                    alert("Hiba történt az üzenet küldésekor: " + data);
                }
            })
            .catch(error => {
                console.error("Hiba történt:", error);
                alert("Nem sikerült kapcsolatot létesíteni a szerverrel.");
            });
        }
    });

    userIcon.addEventListener("click", toggleMenu);
    setupMenu();
    updateIcon();
});
