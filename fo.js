document.addEventListener("DOMContentLoaded", function () {
    const userIcon = document.getElementById("user-icon");
    const menuContainer = document.createElement("div");
    menuContainer.id = "user-menu"; 
    menuContainer.style.display = "none"; 
    document.body.appendChild(menuContainer);

    const style = document.createElement('style');
    style.innerHTML = `
        #password-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 300px;
            margin: 20px auto;
            padding: 20px;
            background-color:black;
            border-radius: 10px;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.4);
        }

        #password-form label {
            font-size: 16px;
            color: red;
            font-weight: 600;
            margin-bottom: 5px;
        }

        #password-form input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            color: #8f0000;
            background: transparent;
            border: 1px solid #8f0000;
            border-radius: 5px;
            outline: none;
            margin-bottom: 15px;
        }

        #password-form input::placeholder {
            color: #aaa;
        }

        #password-form #passbutton {
            padding: 10px 20px;
            font-size: 18px;
            color: #fff;
            background-color: #8f0000;
            border: none;
            width:250px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        #password-form #passbutton:hover {
            background-color: #b00000;
        }

        #current-password-label,
        #new-password-label,
        #confirm-new-password-label {
            font-size: 18px;
            color: #fff;
            margin-bottom: 10px;
        }

        #current-password,
        #new-password,
        #confirm-new-password {
            padding: 12px;
            font-size: 18px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #8f0000;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            max-width: 500px;
            width: 90%;
            position: relative;
            height: 500px;
        }

        .contact-form, .password-form {
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
        
        .contact-form label, .password-form label {
            font-size: 16px;
            color: #8f0000;
            font-weight: 600;
            margin-bottom: 10px;
            display: block;
        }

        .contact-form input,
        .contact-form textarea,
        .password-form input {
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
        .contact-form textarea::placeholder,
        .password-form input::placeholder {
            color: #ffffff;
        }
        
        .contact-form textarea {
            resize: none;
            min-height: 100px;
        }
        
        .contact-form button,
        .password-form button {
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
        
        .contact-form button::before,
        .password-form button::before {
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
        
        .contact-form button:hover::before,
        .password-form button:hover::before {
            scale: 3;
        }
        
        .contact-form button:hover,
        .password-form button:hover {
            color: #212121;
            scale: 1.1;
            box-shadow: 0 0px 20px rgba(193, 163, 98, 0.4);
        }

        .contact-form button:active,
        .password-form button:active {
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
            .contact-form, .password-form {
                width: 300px;
                height: 550px;
                padding: 30px;
            }
        }

        @media (min-width: 1024px) {
            .contact-form, .password-form {
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
            window.location.href = "login.html";
        }
    }

    function setupMenu() {
        fetch("check_admin.php")
            .then(response => response.json())
            .then(data => {
                const isAdmin = data.is_admin === 1;
                const menuContainer = document.getElementById("user-menu"); 
    
                if (!menuContainer) {
                    console.error("Hiba: A 'user-menu' nem található.");
                    return;
                }
    
                let menuItems = ` <ul>
                    <li id="account-info">Fiókinformáció</li>
                    <li id="settings">Jelszó változtatás</li>
                    <li id="contact">Kapcsolat</li>
                    <li id="logout">Kijelentkezés</li>
                `;
    
                if (isAdmin) {
                    menuItems += `<li id="admin-menu">Rendelések</li>`;
                    menuItems += `<li id="admin-menu1">Felhasználók</li>`;
                }
    
                menuItems += `</ul>`;
                menuContainer.innerHTML = menuItems;
    
                document.getElementById("logout").addEventListener("click", () => {
                    if (confirm("Biztosan ki szeretnél jelentkezni?")) {
                        fetch("logout.php", { method: "POST" })
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
                });
    
                if (isAdmin) {
                    document.getElementById("admin-menu").addEventListener("click", () => {
                        window.location.href = "rendelesek.html";
                    });
    
                    document.getElementById("admin-menu1").addEventListener("click", () => {
                        window.location.href = "users.html";
                    });
                }
    
                document.getElementById("settings").addEventListener("click", () => {
                    createModal(`
                        <h3>Jelszó megváltoztatás</h3>
                        <form id="password-form" class="password-form">
                            <label for="current-password" id="current-password-label">Jelenlegi jelszó:</label>
                            <input type="password" id="current-password" name="current-password" placeholder="Adja meg a jelenlegi jelszót" required>

                            <label for="new-password" id="new-password-label">Új jelszó:</label>
                            <input type="password" id="new-password" name="new-password" placeholder="Adja meg az új jelszót" required>

                            <label for="confirm-new-password" id="confirm-new-password-label">Új jelszó megerősítése:</label>
                            <input type="password" id="confirm-new-password" name="confirm-new-password" placeholder="Erősítse meg az új jelszót" required>

                            <button type="submit" id="passbutton">Jelszó módosítása</button>
                        </form>

                    `);
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
                                    <p id="info">Felhasználónév: ${localStorage.getItem("username") || "N/A"}</p>
                                    <p id="info">Email: ${data.email || "N/A"}</p>
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
            })
            .catch(error => console.error("Hiba történt az admin ellenőrzésekor:", error));
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

    document.body.addEventListener("submit", function (e) {
        if (e.target.id === "password-form") {
            e.preventDefault();

            const currentPassword = document.getElementById("current-password").value;
            const newPassword = document.getElementById("new-password").value;
            const confirmNewPassword = document.getElementById("confirm-new-password").value;

            if (newPassword !== confirmNewPassword) {
                alert("Az új jelszavak nem egyeznek!");
                return;
            }

            fetch("change-password.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `currentPassword=${encodeURIComponent(currentPassword)}&newPassword=${encodeURIComponent(newPassword)}`
            })
            .then(response => response.text())
            .then(data => {
                if (data === 'success') {
                    alert("A jelszó sikeresen megváltozott!");
                    closeModal();
                } else {
                    alert("Hiba történt a jelszó módosításakor: " + data);
                }
            })
            .catch(error => {
                console.error("Hiba történt:", error);
                alert("Nem sikerült kapcsolatot létesíteni a szerverrel.");
            });
        }
    });

    
});
