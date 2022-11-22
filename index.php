<?php
require_once "bdd.php";

if (!empty($_POST['pseudo'])) {

    $pseudo = htmlspecialchars($_POST["pseudo"]);
    $pseudolength  = strlen($pseudo);
    if (($pseudolength  <= 50)) {
        $reqpseudo = $bdd->prepare("SELECT  * FROM membres WHERE pseudo = ?");
        $reqpseudo->execute(array($pseudo));
        $pseudoexist = $reqpseudo->rowCount();

        if ($pseudoexist == 0) {
            $insertmbr = $bdd->prepare("INSERT INTO membres(pseudo) VALUES (?)");
            $insertmbr->execute(array($pseudo));
        } else {
            $erreur = "Le pseudo est déja utilisé";
        }
    } else {
        $erreur = "Le pseudo doit être inférieur à 50 caractères";
    }
}

?>






<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Aider Jason à retrouver son équipage!!">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Argonautes</title>
    <link rel="stylesheet" href="style.css">
</head>



<body>
    <!-- Header section -->
    <header>
        <h1>
            <img src="https://www.wildcodeschool.com/assets/logo_main-e4f3f744c8e717f1b7df3858dce55a86c63d4766d5d9a7f454250145f097c2fe.png" alt="Wild Code School logo" />
            Les Argonautes
        </h1>
    </header>

    <!-- Main section -->
    <main>

        <!-- New member form -->
        <h2>Ajouter un(e) Argonaute</h2>
        <form method="POST" class="new-member-form">
            <label for="name">Nom de l&apos;Argonaute</label>
            <input id="pseudo" name="pseudo" type="text" size="21" placeholder="Entrer un membre d'équipage " />
            <?php
        if (isset($erreur)) {
        ?>
            <div class="er-msg"><?= $erreur ?></div>
        <?php
        }
        ?>
            <div class="requete"><button class="button " type="submit">Envoyer</button></div>
        </form>
        
        <section>
        <h2>Membres de l'équipage</h2>

        <h3>Équipage</h3>


        <?php
        $i = 0;
        echo '<table <tr><td>';
        $recup_pseudo = $bdd->query("SELECT pseudo FROM  membres");

        while ($pseudoJason = $recup_pseudo->fetch()) {

            $i++;
            echo $pseudoJason['pseudo'] . '<br>';
            if ($i == 17) {
                echo '<td>';
                $i = 0;
            }
        }
        echo '</td></tr></table>';
        ?>
        </section>
    </main>

    <footer>
        <p>Réalisé par Rayane en Anthestérion de l'an 515 avant JC</p>
    </footer>
</body>