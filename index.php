<?php
require_once __DIR__ . '/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        $db->query($query);
        echo "<div class='alert alert-success text-center'>Inscription réussie !</div>";
    }

    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = $db->query($query);
        $user = $result->fetch(PDO::FETCH_ASSOC);

        if ($user && $_POST['password'] === $user['password']) {
            $_SESSION['user'] = $user['username'];
            echo "<div class='alert alert-success text-center'>Connexion réussie !</div>";
        } else {
            echo "<div class='alert alert-danger text-center'>Identifiants invalides !</div>";
        }
    }

    if (isset($_POST['comment']) && isset($_SESSION['user'])) {
        $comment = $_POST['comment'];
        $query = "INSERT INTO comments (user, comment) VALUES ('{$_SESSION['user']}', '$comment')";
        $db->query($query);
        echo "<div class='alert alert-success text-center'>Commentaire posté !</div>";
    }
}

// Récupération des commentaires
$comments = $db->query("SELECT * FROM comments ORDER BY created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Commentaires</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<main class="container">
    <div class="border-bottom pb-4 mb-4 text-center pt-5">
        <?php if (!isset($_SESSION['user'])): ?>
            <h2 class="mb-4">Se connecter</h2>
            <form method="POST">
                <div class="mb-3">
                    <input class="form-control" type="email" name="username" placeholder="Nom d'utilisateur" required>
                </div>
                <div class="mb-3">
                    <input  class="form-control" type="password" name="password" placeholder="Mot de passe" required>
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary me-2" type="submit" name="login">Connexion</button>
                    <button class="btn btn-secondary" type="submit" name="register">Inscription</button>
                </div>
            </form>
        <?php else: ?>
            <h2 class="mb-4">Ajouter un commentaire</h2>
            <p>Connecté en tant que <b><?= $_SESSION['user'] ?></b></p>
            <form method="POST">
                <div class="mb-3">
                    <label class="small text-secondary">Nouveau commentaire</label>
                    <textarea class="form-control" name="comment" required></textarea>
                </div>
                <button class="btn btn-primary me-2" type="submit">Poster le commentaire</button>
                <a class="btn btn-secondary" href="/logout.php">Déconnexion</a>
            </form>
        <?php endif; ?>
    </div>
    <h3>Derniers commentaires</h3>
    <ul>
        <?php foreach ($comments as $comment): ?>
            <li><strong><?= $comment['user'] ?>:</strong> <?= $comment['comment'] ?> (<?= $comment['created_at'] ?>)
            </li>
        <?php endforeach; ?>
    </ul>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
