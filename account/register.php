<?php
require_once '../func/functions.php';
session_start();
if(!empty($_POST)){
    $errors = array();
    require_once '../admin/database.php';
    if(empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])){
        $errors['username'] = "Votre pseudo n'est pas valide (alphanumérique)";
    } else {//si le pseudo est déja prit
        $db = Database::connect();
        $req = $db->prepare('SELECT id FROM membres WHERE username = ?');
        $req->execute([$_POST['username']]);
        $user = $req->fetch();
        Database::disconnect();
        if($user){
            $errors['username'] = 'Ce pseudo est déjà pris';
        }
    }
        //filter_var controler le format de l'email , filtre email à utiliser    
    if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Votre email n'est pas valide";
    } else {
        $db = Database::connect();
        $req = $db->prepare('SELECT id FROM membres WHERE email = ?');
        $req->execute([$_POST['email']]);
        $user = $req->fetch();
        Database::disconnect();
        if($user){
            $errors['email'] = 'Cet email est déjà utilisé pour un autre compte';
        }
    }
    if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
        $errors['password'] = "Vous devez rentrer un mot de passe valide";
    }
if(empty($errors)){
    $db = Database::connect();
    $req = $db->prepare("INSERT INTO membres SET username = ?, password = ?, email = ?, confirmation_token = ?");
    //cryptage mdp
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    //
    $token = str_random(60);
    $req->execute([$_POST['username'], $password, $_POST['email'], $token]);
    //lastInsertId renvoie le dernier id générer par pdo
    $user_id = $db->lastInsertId();
    mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien\n\nhttp://localhost:8888/bdthek/account/confirm.php?id=$user_id&token=$token");
    $_SESSION['flash']['success'] = 'Un email de confirmation vous a été envoyé pour valider votre compte';
    Database::disconnect();
    header('Location: login.php');
    exit();
}
debug($errors);
}
?>

<?php require 'header_account.php'; ?>

<h1>S'inscrire</h1>

<?php if(!empty($errors)): ?>
<div class="alert alert-danger">
    <p>Vous n'avez pas rempli le formulaire correctement</p>
    <ul>
        <?php foreach($errors as $error): ?>
           <li><?= $error; ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form action="" method="POST">

    <div class="form-group">
        <label for="">Pseudo</label>
        <input type="text" name="username" class="form-control"/>
    </div>

    <div class="form-group">
        <label for="">Email</label>
        <input type="text" name="email" class="form-control"/>
    </div>

    <div class="form-group">
        <label for="">Mot de passe</label>
        <input type="password" name="password" class="form-control"/>
    </div>

    <div class="form-group">
        <label for="">Confirmez votre mot de passe</label>
        <input type="password" name="password_confirm" class="form-control"/>
    </div>

    <button type="submit" class="btn btn-primary">M'inscrire</button>

</form>

<?php require '../inc/footer.php'; ?>
