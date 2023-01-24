<?php

if(!isset($_SESSION)){
    session_start();
}
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
    $currentpage = 'Login';

if(isset($_SESSION['log']) && $_SESSION['log'] == 'A') {
    $Pages = array(
        "Home" => "Home",
        "Parametrage" => "Parametrage",
        "History" => "History",
        "Account" => "Account",
        "Documentation" => "Documentation",
        "Admin" => "Admin",
        "Logout" => "Logout");
} else if(isset($_SESSION['log']) && $_SESSION['log'] == 'U' && !isset($_SESSION['otherLogin'])) {
    $Pages = array(
        "Home" => "Home",
        "Parametrage" => "Parametrage",
        "History" => "History",
        "Account" => "Account",
        "Documentation" => "Documentation",
        "Logout" => "Logout");
} else if(isset($_SESSION['log']) && $_SESSION['log'] == 'U' && $_SESSION['otherLogin'] == true) {
    $Pages = array(
        "Home" => "Home",
        "Parametrage" => "Parametrage",
        "History" => "History",
        "Account" => "Account",
        "Documentation" => "Documentation",
        "Sign-out" => "Sign out");
}
else {
    $Pages = array(
        "Login" => "Login",
        "Documentation" => "Documentation");
}
echo '

<body>
    <header class="tete">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">HotHothot</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample05"
                aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
            <i class="navbar-toggler-icon"></i>
        </button>
        <nav class="navbar-collapse collapse show" id="navbarsExample05">';

foreach ($Pages as $key => $value){
    if($ctrl  = "Pages"){
        $var = "/Pages/".lcfirst($key);
    };
    if($ctrl == "Documentation"){
        $currentpage = "Documentation";
    };
    if($key == "admin"){
        $ctrl = "/Users/".lcfirst($key);
    };
    if($key == "History" || $value == "History"){
        echo '<a href="'. $var .'/1">'.$value.'</a>';
        continue;
    }
    if($key == "Sign-out"){
        echo '<a href="#" id="google" onclick="signOut();deleteCache();" >Sign out</a>';
        continue;
    }
    if($key == "Logout"){
        echo '<a href="'. $var .'" onclick="deleteCache()">'.$value.'</a>';
        continue;
    }
    echo '<a href="'. $var .'">'.$value.'</a>';
}

echo '</nav>
    </nav>
    <h1 id="nomPage">' . ucfirst($currentpage) . '</h1>
   </header>';

    if( $currentpage !== "Login" && $currentpage !== "Pages") {
        echo '<div id="signinButton" style="display: none" class="g-signin2" data-onsuccess="onSignIn"></div>';
    }
    else{
        echo '<div id="signinButton" class="g-signin2" data-onsuccess="onSignIn" onclick="redirect()"></div>';
    }

