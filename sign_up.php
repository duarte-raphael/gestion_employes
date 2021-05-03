    <?php

    $isThereError = false;
    $messages = [];
    if (isset($_POST) && !empty($_POST)) {
        $nextId = nextId();

        $hash = password_hash($_POST["hash_password"], PASSWORD_DEFAULT);

        if (isset($_POST["nom"]) && empty($_POST["nom"])) {
            $isThereError = true;
            $messages[] = "veuillez saisir un pseudo. ";
        } else {
            $tabNom = listeNomUser();

            foreach ($tabNom as $nom) {
                if ($_POST["nom"] == $nom) {
                    $isThereError = true;
                    $messages[] = "Ce pseudo est deja utilisé. ";
                }
            }
        }
        if (isset($_POST["hash_password"]) && empty($_POST["hash_password"])) {
            $isThereError = true;
            $messages[] = "veuillez saisir un mot de passe. ";
        }

        if (!$isThereError && !empty($_POST["nom"]) && !empty($_POST["hash_password"])) {
            insererUser($nextId, $_POST["nom"], $hash);
            header("location: sign_in.php");
        }
    }

    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>inscription</title>
    </head>

    <body>
        <?php
        if ($isThereError) {
            echo $messages[0];
        }
        ?>
        <div class="container">
            <form action="" method="POST" class="formulaire">
                <h1>Inscription</h1>
                <div class="form-group row">
                    <label for="pseudo" class="col-sm-5 col-form-label">choisir un pseudo</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="pseudo" name="nom" placeholder="ex : rafael59100p" style="width: 80%;">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-5 col-form-label">choisir un mot de passe</label>
                    <div class="col-sm-7">
                        <input type="password" class="form-control" id="inputPassword" name="hash_password" placeholder="Password" style="width: 80%;">
                    </div>
                </div>
                <input type="submit" class="btn btn-success" value="Soumettre">
            </form>
        </div>


    </body>

    </html>

    <?php
    function nextId()
    {
        $bdd = mysqli_init();
        mysqli_real_connect($bdd, "127.0.0.1", "rafael", "rafael", "entreprise");
        $findNextId = "SELECT max(id) FROM utilisateur;";
        $max = mysqli_query($bdd, $findNextId);
        $data = mysqli_fetch_array($max, MYSQLI_NUM);
        mysqli_free_result($max);
        $nextId = $data[0] + 1;
        mysqli_close($bdd);
        return $nextId;
    }

    function listeNomUser()
    {
        $bdd = mysqli_init();
        mysqli_real_connect($bdd, "127.0.0.1", "rafael", "rafael", "entreprise");
        $nomUnique = "SELECT DISTINCT nom FROM utilisateur;";
        $requeteNomUnique = mysqli_query($bdd, $nomUnique);
        $tabNom = mysqli_fetch_array($requeteNomUnique, MYSQLI_ASSOC);
        mysqli_free_result($requeteNomUnique);
        mysqli_close($bdd);
        return $tabNom;
    }
    function insererUser($id, $nom, $mdpHash)
    {
        $bdd = mysqli_init();
        mysqli_real_connect($bdd, "127.0.0.1", "rafael", "rafael", "entreprise");
        $inserer = "INSERT INTO utilisateur (id, nom, hash_password) 
        VALUES (" . $id . ", '" . $nom . "', '" . $mdpHash . "');";
        mysqli_query($bdd, $inserer);
        mysqli_close($bdd);
    }
