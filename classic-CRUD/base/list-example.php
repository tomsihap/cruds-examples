<?php

require 'pdo.php';

$request = 'SELECT * FROM exampleTable';

$response = $bdd->query($request);

$flights = $response->fetchAll();

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
        <div class="row mt-3 div col-12">

            <a href="index.php">
                < Retour à la page d'accueil</a> <table class="table">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Field1</th>
                            <th>Field2</th>
                            <th>Field3</th>
                            <th>Field4</th>
                        </tr>
                    </thead>


                    <?php foreach ($flights as $flight) : ?>

                        <tr>
                            <td><?= $flight['id'] ?></td>
                            <td><?= $flight['field1'] ?></td>
                            <td><?= $flight['field2'] ?></td>
                            <td><?= $flight['field3'] ?></td>
                            <td><?= $flight['field4'] ?></td>
                        </tr>

                    <?php endforeach; ?>

                    </table>

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