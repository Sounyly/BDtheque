<?php
require_once '../func/functions.php';
 require_once '../admin/database.php';
$user_id = $_GET['id'];
$token = $_GET['token'];
$db = Database::connect();
$req = $db->prepare('SELECT * FROM membres WHERE id = ?');
$req->execute([$user_id]);
$user = $req->fetch();
session_start();
if($user && $user->confirmation_token == $token ){
    $db->prepare('UPDATE membres SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?')->execute([$user_id]);
    
    $_SESSION['flash']['success'] = 'Votre compte a bien été validé';
    //authentification de l'utilisateur
    $_SESSION['auth'] = $user;
    Database::disconnect();
    header('Location: account.php');
}else{
    $_SESSION['flash']['danger'] = "Ce token n'est plus valide";
    Database::disconnect();
    header('Location: login.php');
}
