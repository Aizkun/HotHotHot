<?php

if (isset($_GET['url'])) {
    $url = $_GET['url'];
    $urlAction = explode('/', $url);
    if(isset($urlAction[1])) {
        $currentpage = ucfirst($urlAction[1]);
    } else {
        $currentpage = ucfirst($urlAction[0]);
    }
}
else
    $currentpage = 'Home';


echo '
<!doctype html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>' . ucfirst($currentpage) . '</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="google-signin-client_id" content="48486305668-7e3t98e2smfcbqs7dl1k3cu5i1ejttvj.apps.googleusercontent.com">
    <link rel="apple-touch-icon" sizes="180x180" href="' . Constantes::repertoireIMG() . 'assets/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="' . Constantes::repertoireIMG() . 'assets/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="' . Constantes::repertoireIMG() . 'assets/favicon-16x16.png">
    <link rel="manifest" href="' . Constantes::repertoireConfig() . 'site.webmanifest">
    <link rel="mask-icon" href="' . Constantes::repertoireIMG() . 'assets/safari-pinned-tab.svg" color="#152cff">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link rel="shortcut icon" href="' . Constantes::repertoireIMG() . 'icon.png" type="image/x-ico">
    <link href="' . Constantes::repertoireCSS() . 'style.css" rel="stylesheet" type="text/css" media="all" />
</head>';
       Vue::montrer('standard/entete'); 
       echo $A_vue['body'];
       Vue::montrer('standard/pied');
