    <?php
    // création de l'objet PDO pour se connecter à la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=ep_test', 'balist', 'Aae86f2c');

    /*
        Vérification si l'utilisateur existe.
        Si oui, on vérifie que le password reçu par le formulaire est le bon
        */
    function connection($bdd, $login, $pass)
    {
        $req = $bdd->prepare('SELECT * FROM connexion WHERE login = ?');
        $req->execute(array($login));
        $user = $req->fetch(PDO::FETCH_OBJ);
        if ($user) {
            // on vérifie le mot de passe comme ça si tu utilises password_hash
            // pour crypter les mots de passe
            $pass = password_hash($pass, PASSWORD_DEFAULT);
            $verif = password_verify($pass, $user->password);
            if ($verif) {
                // si c'est bon on return les info de l'utilisateur récup dans la table connection juste avant
                return $user;
            }
        }
        return false;
    }
    function openSession($user)
    {
        // on rempli les sessions
        session_start();
        $_SESSION["id"]     = $user->id;
        $_SESSION["login"]  = $user->login;
    }




    // si le formulaire de connexion est soumis
    if (
        (isset($_POST['Email']) && !empty($_POST['Email'])) &&
        (isset($_POST['pwd']) && !empty($_POST['pwd']))

    ) {
        $login = $_POST['Email'];
        $pass = $_POST['pwd'];

        // on exécute la fonction connection
        $user = connection($bdd, $login, $pass);

        // si la fonction connection retourne quelques chose
        // ça veut dire que l'utilisateur existe et que le mot de
        // passe renseigné dans le formulaire de connexion est le bon
        if ($user) {
            openSession($user);
            header('Location: home.php');
        }
    }
    if (session_id()) {
        header('Location: home.php');
    }
    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>PHPJabbers.com | Free Blog Website Template</title>

        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/fontAwesome.css">
        <link rel="stylesheet" href="css/hero-slider.css">
        <link rel="stylesheet" href="css/owl-carousel.css">
        <link rel="stylesheet" href="css/style.css">

        <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>

    <body>

        <main>
            <section class="our-services">
                <div class="container">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="left-content">
                                <form action="index.php" method="post">
                                    <p>Votre email: <input type="email" name="Email" /></p>
                                    <label>Password</label> <input type="password" name="pwd" />
                                    <p><input type="submit" value="OK"></p>
                                </form>

                            </div>
                        </div>
                        <div class="col-md-5">
                            <img src="img/about-1-720x480.jpg" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <div class="about-veno">
                            <div class="logo">
                                <img src="img/footer_logo.png" alt="Venue Logo">
                            </div>
                            <p>Mauris sit amet quam congue, pulvinar urna et, congue diam. Suspendisse eu lorem massa. Integer sit amet posuere tellustea dictumst.</p>
                            <ul class="social-icons">
                                <li>
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-linkedin"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </footer>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript"></script>
        <script>
            window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')
        </script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/datepicker.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
    </body>

    </html>