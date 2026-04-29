<?php
$page_css = "auth";
include '../../templates/header.php';
?>
    <link rel="stylesheet" href="../assets/css/inscription.css">

    <main class="auth-container">
        <div class="auth-card">
            <h1 class="auth-title">Créer un compte</h1>

            <form method="POST" action="../../includes/register.php" class="auth-form">

                <!-- Ligne 1 : Email (Pleine largeur) -->
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>

                <!-- Ligne 2 : Mots de passe (2 colonnes) -->
                <div class="form-row">
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Mot de passe" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="confirm_password" placeholder="Confirmer" required>
                    </div>
                </div>

                <!-- Ligne 3 : Identité (2 colonnes) -->
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" name="prenom" placeholder="Prénom">
                    </div>
                    <div class="form-group">
                        <input type="text" name="nom" placeholder="Nom">
                    </div>
                </div>

                <!-- Ligne 4 : Contact & Date (2 colonnes) -->
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" name="telephone" placeholder="Téléphone">
                    </div>
                    <div class="form-group">
                        <input type="date" name="date_naissance">
                    </div>
                </div>

                <!-- Ligne 5 : Adresse (Pleine largeur) -->
                <div class="form-group">
                    <textarea name="adresse_postale" placeholder="Adresse complète"></textarea>
                </div>

                <button type="submit" class="btn-auth">S'inscrire</button>

                <div style="margin-top: 1.5rem; text-align: center;">
                    <p class="form-help">Déjà membre ? <a href="../connexion/index.php" style="color: #005F83; text-decoration: none; font-weight: 600;">Connecte-toi</a></p>
                </div>
            </form>
        </div>
    </main>

    <script>

        const togglePassword = document.querySelector('#toggle-pw1');
        const passwordInput = document.querySelector('#password');
        const confirmInput = document.querySelector('#confirm_password');

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            confirmInput.setAttribute('type', type);
        });
    </script>

<?php
include '../../templates/footer.php';
?>