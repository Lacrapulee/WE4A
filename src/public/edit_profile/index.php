

<div class="edit-container">
    <h2>Modifier mon profil</h2>

    <?php if ($success): ?>
        <p class="alert success">Profil mis à jour avec succès ! <a href="index.php?action=user&id=<?= $_SESSION['user_id'] ?>">Voir mon profil</a></p>
    <?php endif; ?>

    <?php if ($error): ?>
        <p class="alert error"><?= $error ?></p>
    <?php endif; ?>

    <form action="routeur.php?action=edit_profile" method="POST" class="edit-form">
        <div class="form-group">
            <label>Prénom</label>
            <input type="text" name="prenom" value="<?= htmlspecialchars($user['prenom'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" value="<?= htmlspecialchars($user['nom'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Ma Bio</label>
            <textarea name="bio" placeholder="Parlez-nous de vous..."><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label>Email (Non modifiable)</label>
            <input type="email" value="<?= htmlspecialchars($user['email']) ?>" disabled>
        </div>

        <button type="submit" class="btn-save">Enregistrer les modifications</button>
    </form>
</div>