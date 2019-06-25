<?php


// IMPORT DE PDO ! Pour ne pas retapper à chaque fois new PDO(....)
require 'pdo.php';

if (!empty($_POST)) {

    /**
     * 1. Validations
     */

    if (!isset($_POST['departure_code'])) {
        throw new Exception('Le code de départ n\'a pas été renseigné.');
    }

    if (strlen($_POST['departure_code']) < 3) {
        throw new Exception('Le code de départ est trop court.');
    }

    if (strlen($_POST['departure_code']) > 5) {
        throw new Exception('Le code de départ est trop long.');
    }

    if (!isset($_POST['arrival_code'])) {
        throw new Exception('Le code de d\'arrivée n\'a pas été renseigné.');
    }

    if (strlen($_POST['arrival_code']) < 3) {
        throw new Exception('Le code d\'arrivée est trop court.');
    }

    if (strlen($_POST['arrival_code']) > 5) {
        throw new Exception('Le code d\'arrivée est trop long.');
    }

    if (!isset($_POST['company'])) {
        throw new Exception('La compagnie n\'a pas été renseignée.');
    }

    if (strlen($_POST['company']) > 150) {
        throw new Exception('La compagnie a un nom trop long.');
    }

    if (!isset($_POST['departure_date'])) {
        throw new Exception('Le date de départ n\'a pas été renseignée.');
    }

    // Validation de la date : si j'arrive à créer une date ainsi ($d n'est pas false donc), c'est que c'est bon
    $dateFormat = DateTime::createFromFormat('Y-m-d', $_POST['departure_date']);

    if (!$dateFormat) {
        throw new Exception('La date a un format incorrect.');
    }

    if (!isset($_POST['duration'])) {
        throw new Exception('La durée de vol n\'a pas été renseignée.');
    }

    if (isset($_FILES['photo']) and $_FILES['photo']['error'] == 0) {
        // Testons si le fichier n'est pas trop gros
        if ($_FILES['photo']['size'] <= 10000000) {
            // Testons si l'extension est autorisée
            $infosfichier = pathinfo($_FILES['photo']['name']);
            $extension_upload = $infosfichier['extension'];
            $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
            if (in_array($extension_upload, $extensions_autorisees)) {
                // On peut valider le fichier et le stocker définitivement
                move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/' . basename($_FILES['photo']['name']));
                echo "L'envoi a bien été effectué !";
            }
        }
    }


    /**
     * 2. Si aucune exception n'a été levée...
     * Enregistrement en base de données
     */

    $request = 'INSERT INTO flight (departure_code, arrival_code, company, departure_date, duration, photo)
                VALUES (:departure_code, :arrival_code, :company, :departure_date, :duration, :photo)';

    $response = $bdd->prepare($request);

    $response->execute([
        'departure_code'    => $_POST['departure_code'],
        'arrival_code'      => $_POST['arrival_code'],
        'company'           => $_POST['company'],
        'departure_date'    => $_POST['departure_date'] . " " . $_POST['departure_time'], // date + " " + time
        'duration'          => $_POST['duration'],
        'photo'             => basename($_FILES['photo']['name']),
    ]);
}

?>


<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row mt-3">
            <div class="col-12">

                <a href="index.php">
                    < Retour à la page d'accueil</a> <h1>Ajouter un nouveau vol</h1>

                        <form action="add-flight.php" method="post" class="form" enctype="multipart/form-data">

                            <div class="form-group">
                                <label for="#formDepartureCode">Code IATA de l'aéroport de départ</label>
                                <input type="text" name="departure_code">
                            </div>

                            <div class="form-group">
                                <label for="#formDepartureCode">Code IATA de l'aéroport d'arrivée</label>
                                <input type="text" name="arrival_code">
                            </div>

                            <div class="form-group">
                                <label for="#formDepartureCode">Compagnie aérienne en charge du vol</label>
                                <input type="text" name="company">
                            </div>

                            <div class="form-group">
                                <label for="#formDepartureCode">Date de départ</label>
                                <input type="date" name="departure_date">
                            </div>

                            <div class="form-group">
                                <label for="#formDepartureCode">Heure de départ</label>
                                <input type="time" name="departure_time">
                            </div>

                            <div class="form-group">
                                <label for="#formDepartureCode">Durée du vol en minutes</label>
                                <input type="number" name="duration">
                            </div>

                            <div class="form-group">
                                <label for="#formDepartureCode">Image du vol</label>
                                <input type="file" name="photo">
                            </div>

                            <button class="btn btn-success float-right" type="submit">Créer le vol</button>

                        </form>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>