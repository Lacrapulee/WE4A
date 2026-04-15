<?php
include '../../templates/header.php';
?>

    <main>

        <h2>Connexion</h2>

        <form method="POST" action="login.php">

            <div>
                <label for="email">Email :</label><br>
                <input type="email" id="email" name="email" required>
            </div>

            <br>

            <div>
                <label for="password">Mot de passe :</label><br>
                <input type="password" id="password" name="password" required>
            </div>

            <br>

            <button type="submit">Se connecter</button>

        </form>

    </main>

<?php
include '../../templates/footer.php';
?>