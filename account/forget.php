<?php
if(!empty($_POST) && !empty($_POST['email'])){
    require_once '../func/functions.php';
  require_once '../admin/database.php';
    $req = $db->prepare('SELECT * FROM membres WHERE email = ? AND confirmed_at IS NOT NULL');
    $req->execute([$_POST['email']]);
    $user = $req->fetch();
    if($user){
        session_start();
        $db = Database::connect();
        $reset_token = str_random(60);
        $db->prepare('UPDATE membres SET reset_token = ?, reset_at = NOW() WHERE id = ?')->execute([$reset_token, $user->id]);
        $_SESSION['flash']['success'] = 'Les instructions du rappel de mot de passe vous ont été envoyées par email';
        mail($_POST['email'], 'Réinitiatilisation de votre mot de passe', "Afin de réinitialiser votre mot de passe merci de cliquer sur ce lien\n\nhttp://localhost:8888/bdthek/account/reset.php?id={$user->id}&token=$reset_token");
        Database::disconnect();
        header('Location: login.php');
        exit();
    }else{
        $_SESSION['flash']['danger'] = 'Aucun compte ne correspond à cet adresse';
    }
}
?>
<?php require 'inc/header.php'; ?>

    <h1>Mot de passe oublié</h1>

    <form action="" method="POST">

        <div class="form-group">
            <label for="">Email</label>
            <input type="email" name="email" class="form-control"/>
        </div>

        <button type="submit" class="btn btn-primary">Se connecter</button>

    </form>

<?php require '../inc/footer.php'; ?>