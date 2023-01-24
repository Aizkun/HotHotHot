<?php
require('db.php');

final class Users
{
    private array $options = [
        'cost' => 10,
    ];

    private function addUser($nom, $prenom, $email, $password)
    {
        $db = new DB();
        return $db->execDB("INSERT INTO user (nom,prenom,email,password,role,current_connexion) 
                               VALUES ('$nom','$prenom','$email','$password','U',NOW())");
    }

    private function exist() : bool
    {
        $not_exist = false;

        $db = new DB();
        $email = $_POST['email'];

        $infoEmail = $db->queryDB("SELECT * FROM user WHERE email='$email'");
        $emailDB = $infoEmail->fetch();

        if ( isset($emailDB) && $emailDB->email !== $email ) {
            $not_exist = true;
        }
        return $not_exist;
    }

    public function registerUser()
    {
        $bool = $this->exist(); // $bool true quand pas de user du même type false quand un user existe déja avec les mêmes email et username
        if (!$bool) {
            return header('location: /Users/error');
        }
        $nom = $_POST['lastname'];
        $prenom = $_POST['firstname'];
        $email = $_POST['email'];
        $password = password_hash($_POST['mdp'], PASSWORD_BCRYPT, $this->options);
        $this->addUser($nom, $prenom, $email, $password);
        return header('location: /Pages/login');
    }

    private function resetTentatives($db, $resultRequest, $email) : bool
    {
        $bloquer =$resultRequest->bloquer;
        $current_connexion = $resultRequest->current_connexion;
        if($bloquer == 1){
            return false;
        }
        $db->queryDB("UPDATE user SET nb_connexion = '$resultRequest->nb_connexion' + 1, tentatives = 0 WHERE email = '$email';");
        $db->queryDB("UPDATE user SET last_connexion = '$current_connexion', current_connexion = NOW() WHERE email = '$email';");
        return true;
    }

    private function increaseTentative($db, $resultRequest, $email) : bool
    {
        $tentatives = $resultRequest->tentatives;
        $db->queryDB("UPDATE user SET tentatives = '$tentatives' + 1 WHERE email = '$email';");
        if($tentatives >= 2){
            $db->queryDB("UPDATE user SET bloquer = 1 WHERE email = '$email';");
        }
        return false;
    }

    private function verifierTentatives($email,$emailDB, $password) : bool
    {
        $db = new DB();
        $result_db = $db->queryDB("SELECT * FROM user WHERE email='$email'");
        $resultRequest = $result_db->fetch();

        return match (TRUE) {
            ( $email == $emailDB && $password == true ) => $this->resetTentatives($db,$resultRequest,$email),
            ($email == $emailDB && $password != true) => $this->increaseTentative($db,$resultRequest,$email),
            default => false,
        };
    }

    public function connect()
    {
        session_start();
        $email = $_POST['email'];
        $db = new DB();
        $request = $db->queryDB("SELECT * FROM user WHERE email='$email'");
        $requestToken = $db->queryDB("SELECT * FROM token WHERE email_user='$email'");

        $resultToken = $requestToken->fetch();
        $resultRequest = $request->fetch();

        $mdp = $resultRequest->password;
        $emailDB = $resultRequest->email;
        $time = date("H:i:s",strtotime( +3600));

        if(isset($resultToken->time_expiration) && $time > $resultToken->time_expiration){
            $db->execDB("DELETE FROM token WHERE email_user = '$email'");
            return "Token incorrect ou expiré";
        }
        if($resultRequest->token == 1){
            $mdp = $resultToken->token_mdp;
        }
        $password = password_verify($_POST['mdp'], $mdp);

        if (!$this->verifierTentatives($email, $emailDB, $password)) { //$bool true user est bien vérifié et false ne reconnait pas l'user
            $_SESSION['tentatives'] += 1;
            $requestUpdate = $db->queryDB("SELECT * FROM user WHERE email='$email'");
            $resultUpdate = $requestUpdate->fetch();
            $bloquer = $resultUpdate->bloquer;

            if($bloquer != 1){
                return header('Location: /Pages/login');
            }
            return header('Location: /Users/bloquer');
        }
        $_SESSION['log'] = $resultRequest->role;
        $_SESSION['email'] = $email;
        return header('Location: /Pages/home');
    }

    public function otherConnect() : void
    {
        session_start();
        $_SESSION['otherLogin'] = true;
        $_SESSION['log'] = 'U';
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['name'] = $_POST['nom'];
        $_SESSION['firstname'] = $_POST['prenom'];
    }

    public function disconnect() : void
    {
        session_start();
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header('Location: /Pages');
    }

    public function getUserInfo() : array
    {
        session_start();
        $db = new DB();
        $email = $_SESSION['email'];
        $request = $db->queryDB("SELECT * FROM user WHERE email='$email'");
        $resultRequest = $request->fetch();
        $infoUser = [$resultRequest->nom,$resultRequest->prenom,$resultRequest->email];
        if(isset($_SESSION['otherLogin']) && $_SESSION['otherLogin'] == true){
            $infoUser = [$_SESSION['name'],$_SESSION['firstname'],$_SESSION['email']];
        }
        return $infoUser;

    }

    private function randMDP() : string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function mdpForget()
    {
        session_start();
        $time = date("H:i:s");
        $time_creation= date("H:i:s", strtotime($time) + 3600);
        $time_expi= date("H:i:s", strtotime($time_creation) + 3600);

        $email = $_POST['email'];

        $db = new DB();

        $request = $db->queryDB("SELECT * FROM user WHERE email='$email'");
        $resultRequest = $request->fetch();
        $mailDB = $resultRequest->email;

        if ( $mailDB !== $email ) {
            return header("Location: /Users/error");
        }
        $mdp = $this->randMDP();
        $_SESSION['mdp'] = $mdp;
        $mdpHash = password_hash($mdp, PASSWORD_BCRYPT, $this->options);
        $content = "Voici votre nouveau mot de passe : " . $mdp . "" . PHP_EOL .
            "Il est vivement conseillé de modifier ce mot de passe en cliquant sur l'onglet \"Account\" puis sur \"Changer mon mot de passe\".";

        if($resultRequest->token == 1){
            $db->execDB("DELETE FROM token WHERE email_user = '$email'");
        }
        $db->execDB("INSERT INTO token (email_user,token_mdp,time_creation,time_expiration) 
                               VALUES ('$email','$mdpHash','$time_creation','$time_expi')");
        $db->queryDB("UPDATE user SET bloquer = 0, token = 1 WHERE email = '$email';");
        mail($email, "Réinitialisation de mot de passe", $content);
        return header("Location: /Users/success");
    }

    public function modifierMDP()
    {
        session_start();

        if (!$_SESSION['log'] == 'U') {
            return header('Location: /Users/error');
        }
        $mail = $_SESSION['email'];
        $db = new DB();
        $oldRequest = $db->queryDB("SELECT * FROM user WHERE email='$mail'");
        $oldResult = $oldRequest->fetch();
        $mdp = $oldResult->password;

        $requestToken = $db->queryDB("SELECT * FROM token WHERE email_user='$mail'");
        $resultToken = $requestToken->fetch();

        if($oldResult->token == 1){
            $mdp = $resultToken->token_mdp;
        }
        $oldMDP = password_verify($_POST['oldMdp'], $mdp);
        if(!$oldMDP){
            return header('Location: /Users/error');
        }
        $password = password_hash($_POST['mdp2'], PASSWORD_BCRYPT, $this->options);
        $db->execDB("UPDATE user SET password = '$password', token = 0 WHERE email = '$mail'");
        $db->execDB("DELETE FROM token WHERE email_user = '$mail'");
        return header('Location: /Pages');
    }

    public function adminPanel() : array
    {
        $db = new DB();
        $requestUser = $db->queryDB("SELECT Count(*) as nbUser FROM user");
        $nbUser = $requestUser->fetch();

        $requestToken = $db->queryDB("SELECT Count(*) as nbToken FROM token");
        $nbToken = $requestToken->fetch();

        $requestListUser = $db->queryDB("SELECT nom,prenom,role FROM user");
        $listUser = $requestListUser->fetchAll();

        return [$nbUser->nbUser, $nbToken->nbToken, $listUser];
    }

    public function cache() : string
    {
        return date('Y-m-d H:i:s');
    }

}
