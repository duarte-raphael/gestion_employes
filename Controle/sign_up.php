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
        $db = new mysqli("127.0.0.1", "rafael", "rafael", "entreprise");
        $stmt = $db->prepare("SELECT max(id) FROM utilisateur;");
        $stmt->execute();
        $rs = $stmt->get_result();
        $data = $rs->fetch_array(MYSQLI_NUM);
        $nextId = $data[0] + 1;
        $db->close();
        return $nextId;
    }

    function listeNomUser()
    {
        $db = new mysqli("127.0.0.1", "rafael", "rafael", "entreprise");
        $stmt = $db->prepare("SELECT DISTINCT nom FROM utilisateur;");
        $stmt->execute();
        $rs = $stmt->get_result();
        $tabNom = $rs->fetch_array(MYSQLI_ASSOC);
        $db->close();
        return $tabNom;
    }
    function insererUser($id, $nom, $mdpHash)
    {
        $db = new mysqli("127.0.0.1", "rafael", "rafael", "entreprise");
        $stmt = $db->prepare("INSERT INTO utilisateur (id, nom, hash_password) 
        VALUES (" . $id . ", '" . $nom . "', '" . $mdpHash . "');");
        $stmt->bind_param("iss", $id, $nom, $mdpHash);
        $stmt->execute();
        $db->close();
    }