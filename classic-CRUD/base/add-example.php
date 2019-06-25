<?php


// IMPORT DE PDO ! Pour ne pas retapper à chaque fois new PDO(....)
require 'pdo.php';

if (!empty($_POST)) {

    /**
     * 1. Validations
     */

    if (!isset($_POST['field1'])) {
        throw new Exception('Le champ field1 n\'a pas été renseigné.');
    }

    if (strlen($_POST['field2']) < 3) {
        throw new Exception('Le champ field2 est trop court.');
    }

    if (strlen($_POST['field3']) > 150) {
        throw new Exception('La champ field3 est trop long.');
    }

    // Validation de la date : si j'arrive à créer une date ainsi ($d n'est pas false donc), c'est que c'est bon
    $dateFormat = DateTime::createFromFormat('Y-m-d', $_POST['field4']);

    if (!$dateFormat) {
        throw new Exception('La date a un format incorrect.');
    }


    /**
     * 2. Si aucune exception n'a été levée...
     * Enregistrement en base de données
     */

    $request = 'INSERT INTO exampleTable (field1, field2, field3, field4)
                VALUES (:field1, :field2, :field3, :field4)';

    $response = $bdd->prepare($request);

    $response->execute([
        'field1'        => $_POST['field1'],
        'field2'        => $_POST['field2'],
        'field3'        => $_POST['field3'],
        'field4'        => $_POST['field4']
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
                    < Retour à la page d'accueil</a> <h1>Ajouter un nouvel élément</h1>

                        <form action="add-example.php" method="post" class="form">

                            <div class="form-group">
                                <label for="#formField1">Field1</label>
                                <input type="text" name="field1">
                            </div>

                            <div class="form-group">
                                <label for="#formField1">Field2</label>
                                <input type="text" name="field2">
                            </div>

                            <div class="form-group">
                                <label for="#formField1">Field3</label>
                                <input type="text" name="field3">
                            </div>

                            <div class="form-group">
                                <label for="#formField1">field4</label>
                                <input type="text" name="field4">
                            </div>

                            <button class="btn btn-success float-right" type="submit">Créer l'élément</button>

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