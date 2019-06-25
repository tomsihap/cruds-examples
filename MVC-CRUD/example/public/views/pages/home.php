<?php ob_start(); ?>


<h1>Bienvenue sur l'application de gestion de trajets aériens.</h1>

<ul>
    <li><a href="<?= url('add-flight')?>">Ajouter un nouveau vol</a></li>
    <li><a href="<?= url('list-flights')?>">Voir les vols enregistrés</a></li>
</ul>

<?php $content = ob_get_clean() ?> <?php view('template', compact('content')); ?>