<?php ob_start(); ?>

<a href="<?= url('/') ?>">< Retour à la page d'accueil</a>

<table class="table">
<thead>
    <tr>
        <th>#</th>
        <th>Aéroport de départ</th>
        <th>Aéroport d'arrivée</th>
        <th>Compagnie</th>
        <th>Date de départ</th>
        <th>Durée du trajet</th>
        <th>Photo</th>
    </tr>
</thead>


<?php foreach ($flights as $flight) : ?>

    <tr>
        <td><?= $flight['id'] ?></td>
        <td><?= $flight['departure_code'] ?></td>
        <td><?= $flight['arrival_code'] ?></td>
        <td><?= $flight['company'] ?></td>
        <td><?= $flight['departure_date'] ?></td>
        <td><?= $flight['duration'] ?></td>
        <td><img src="<?= uploads_url( $flight['photo'] ) ?>" height="100"></td>
    </tr>

<?php endforeach; ?>

</table>

<?php $content = ob_get_clean() ?>
<?php view('template', compact('content')); ?>