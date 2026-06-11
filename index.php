<?php 

	# Stop Hacking attempt
	define('__APP__', TRUE);
	
	# Start session
    session_start();
	
	# Database connection
	include ("dbconn.php");
	
	# Variables MUST BE INTEGERS
    if(isset($_GET['menu'])) { $menu   = (int)$_GET['menu']; }
	if(isset($_GET['action'])) { $action   = (int)$_GET['action']; }
	
	# Variables MUST BE STRINGS A-Z
    if(!isset($_POST['_action_']))  { $_POST['_action_'] = FALSE;  }
	
	if (!isset($menu)) { $menu = 1; }
	
	# Classes & Functions
    include_once("functions.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
        <!--CSS-->
        <link rel="stylesheet" href="style.css">
        <link rel="alternate" type="application/rss+xml" title="3D Printanje - Vijesti" href="rss.php">
        <!--End CSS--> 

        <!--meta elements-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="content-type" content="text/html, charset=utf-8">
        <meta name="description" content="some description">
        <meta name="keywords" content="keyword 1,keyword 2, keyword 3,keyword 4,...">
        <meta name="author" content="Marko Kušec">
        <!--favicon meta-->
        <link rel="icon" href="img/favicon2.ico" type="image/x-icon"/>
        <!--end favicon meta-->
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
		<!-- End Google Fonts -->

        <title>Projektni zadatak</title>
        
    </head>
    <body>
        <header>
            
            <?php include("menu.php");?>
            
        </header>
        <main>
        <?php
       if (isset($_SESSION['message'])) {
        // Provjeri tip poruke
        $messageType = isset($_SESSION['message_type']) ? $_SESSION['message_type'] : ''; // Ako nije postavljena, ostavi praznu
    
        // Ispis poruke s odgovarajućim CSS klasama
        echo '<div class="' . ($messageType == 'error' ? 'message-error' : 'message-success') . '">';
        echo $_SESSION['message'];
        echo '</div>';
    
        // Očisti poruku iz sesije
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }
        # Homepage
        if (!isset($menu) || $menu == 1) { include("home.php"); }
        
        # Galerija
        else if ($menu == 2) { 
            # Provjera postoji li podmeni
            if (isset($_GET['submenu'])) {
                # Učitaj sadržaj prema podmeniju
                switch ($_GET['submenu']) {
                    case 1:
                        include("galerija.php"); // Datoteka za FDM printere
                        break;
                    case 2:
                        include("galerija_smola_printeri.php"); // Datoteka za printere na bazi smole
                        break;
                    case 3:
                        include("galerija_modeli.php"); // Datoteka za 3D modele
                        break;
                    default:
                        include("galerija.php"); // Zadani sadržaj galerije
                }
    } else {
        # Ako podmeni nije odabran, učitaj osnovni sadržaj galerije
        include("galerija.php");
    }
}
        
        # Vijesti
        else if ($menu == 3) { include("vijesti.php"); }
        
        # O nama
        else if ($menu == 4) { include("o nama.php"); }

        # Kontakt
        else if ($menu == 5) { include("kontakt.php"); }

        # Registracija
        else if ($menu == 6) { include("register.php"); }

        # Prijava
        else if ($menu == 7) { include("signin.php"); }

        # Admin webpage
	    else if ($menu == 8) { include("admin.php"); }

        ?>
           
        </main>
        <footer>
            <p class="copyright">Copyright &copy; <?php print date("Y"); ?> Marko Kušec</p>
        </footer>
    </body>
</html>