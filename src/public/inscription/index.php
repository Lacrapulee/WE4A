<?php
include '../../templates/header.php';
?>

    <main>
        <h2>Inscription</h2>

        <form method="POST" action="../../includes/register.php">

            <input type="email" name="email" placeholder="Email" required><br><br>

            <input type="password" name="password" placeholder="Mot de passe" required><br><br>
            <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" required><br><br>

            <input type="text" name="nom" placeholder="Nom"><br><br>
            <input type="text" name="prenom" placeholder="Prénom"><br><br>

            <input type="text" name="telephone" placeholder="Téléphone"><br><br>

            <input type="date" name="date_naissance"><br><br>

            <textarea name="adresse_postale" placeholder="Adresse"></textarea><br><br>

            <button type="submit">S'inscrire</button>

        </form>
    </main>

<?php include '../../templates/footer.php'; ?>