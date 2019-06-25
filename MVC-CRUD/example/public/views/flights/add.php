<?php ob_start(); ?>

<a href="<?= url('/') ?>">< Retour à la page d'accueil</a>

<h1>Ajouter un nouveau vol</h1>

        <form action="<?= url('add-flight') ?>" method="post" class="form" enctype="multipart/form-data">

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

        <?php $content = ob_get_clean() ?>
        <?php view('template', compact('content')); ?>