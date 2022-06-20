<?php


session_start();
if (isset($_SESSION['user'])) {
    header('Location: index.php'); //yhezk ll dashboard

}

include('connectdbb.php');


if (isset($_POST['connect'])) {
    $name = $_POST['adr'];
    $password = $_POST['pass'];
    //nchofoo mawjod fel base dd wala le 

    $stmt = $bdd->prepare("SELECT email,password FROM usercompte WHERE email = ?  AND password = ?");
    $stmt->execute(array($name, $password));
    $count = $stmt->rowCount();

    $k = $bdd->prepare("SELECT email,password FROM livreur WHERE email = ?  AND password = ?");
    $k->execute(array($name, $password));
    $c = $k->rowCount();

    if ($c > 0) {
        echo "welcome livreur";
        $_SESSION['name_livreur'] = $name; // sajalna name  
        $_SESSION['id_livreur'] = $password;
        header('Location: indexlivreur.php');
        exit(); //ya9ef mach ye5dem hta code wala ytala3lk 4alta 

    }
    //echo $count;
    // if count > 0 mrgl il user mawjood fel  base de donnes 
    //group id 1 == admin si group id = 0  client s
    if ($count > 0) {
        echo "welcome";
        $_SESSION['Username'] = $name; // sajalna name  
        $_SESSION['userid'] = $password;
        header('Location: index.php');
        exit(); //ya9ef mach ye5dem hta code wala ytala3lk 4alta 

    }
}

if (isset($_POST['submit'])) {
    $nom = $_POST['nom'];
    $email = $_POST['addemail'];
    $phone = $_POST['tlf'];
    $password1 = $_POST['pass1'];
    $password2 = $_POST['pass2'];
    $requete1 = $bdd->query("SELECT * FROM usercompte WHERE email='$email'");
    $resultat1 = $requete1->fetch();
    $requete2 = $bdd->query("SELECT * FROM livreur WHERE email='$email'");
    $resultat2 = $requete2->fetch();
    $requete3 = $bdd->query("SELECT * FROM inscrire WHERE adremail='$email'");
    $resultat3 = $requete3->fetch();
    if (($password1 == $password2) and ($resultat1 == null) and ($resultat2 == null) and ($resultat3 == null)) {
        $q = $bdd->prepare("INSERT INTO inscrire (id_cmpt, adremail, phone, mtdps1,`name`)
 VALUES (NULL,?,?,?,?);");

        $q->execute([$email, $phone, $password1, $nom]);
    }

    // echo "<div class='alert alert-success></div>";

    header('Location:loginfoodbizerte.php');
    exit;
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>FoodBizerte</title>

    <link rel="stylesheet" href="css/vertical-layout-light/logintransparent.css">
</head>

<body>

    <div class="container">
        <nav>
            <a href="#" class="logo">FoodBizerte</a>
            <ul>
                <!-- <li> <a href=""> Lien 1 </a></li>
                <li> <a href=""> Lien 2 </a></li>
                <li> <a href=""> Lien 3 </a></li>
                <li> <a href=""> Lien 4 </a></li> -->


                <li> <button class="btn" id="displayForm">Se connecter</button> </li>
            </ul>
        </nav>
        <section>
            <div class="sec-container">
                <div class="form-wrapper">
                    <div class="card">
                        <div class="card-header">
                            <div id="forLogin" class="form-header active"> Se connecter</div>
                            <div id="forRegister" class="form-header "> S'inscrire</div>
                        </div>


                        <div class="card-body" id="formContainer">
                            <form id="loginForm" method="POST">
                                <input type="text" class="form-control" name="adr" placeholder="@utilisaeur" />
                                <input type="password" class="form-control" name="pass" placeholder="@Mot de passe" />
                                <button class="formButton" type="submit" name="connect"> Connexion</button>
                            </form>

                            <form id="registerForm" class="toggleForm" method="POST">
                                <input type="text" class="form-control" name="nom" placeholder="@name" />
                                <input type="text" class="form-control" name="addemail" placeholder="@utilisaeur" />
                                <input type="text" class="form-control" name="tlf" placeholder="+216 phone" />
                                <input type="password" class="form-control" name="pass1" placeholder="@Mot de passe" />
                                <input type="password" class="form-control" name="pass2" placeholder="@Confirmer mot de passe" />
                                <button class="formButton" type="submit" name="submit"> Inscription</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        const displayForm = _('displayForm');
        const forLogin = _('forLogin');
        const loginForm = _('loginForm');
        const forRegister = _('forRegister');
        const registerForm = _('registerForm');
        const formContainer = _('formContainer');

        displayForm.addEventListener('click', showForm);

        forLogin.addEventListener('click', () => {
            forLogin.classList.add('active')
            forRegister.classList.remove('active')
            if (loginForm.classList.contains('toggleForm')) {
                formContainer.style.transform = 'translate(0%)';
                formContainer.style.transition = 'transform .5s'
                registerForm.classList.add('toggleForm');
                loginForm.classList.remove('toggleForm');

            }
        })


        forRegister.addEventListener('click', () => {
            forLogin.classList.remove('active')
            forRegister.classList.add('active')
            if (registerForm.classList.contains('toggleForm')) {
                formContainer.style.transform = 'translate(-100%)';
                formContainer.style.transition = 'transform .5s'
                registerForm.classList.remove('toggleForm');
                loginForm.classList.add('toggleForm');

            }
        })

        function _(e) {
            return document.getElementById(e);
        }


        function showForm() {
            document.querySelector('.form-wrapper .card').classList.toggle('show');
        }
    </script>

    <!-- fin login-->

</body>

</html>