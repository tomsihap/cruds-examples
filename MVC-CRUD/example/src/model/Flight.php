<?php

class Flight extends Db {

    const TABLE_NAME = "flight";

    protected $id;
    protected $departure_code;
    protected $arrival_code;
    protected $company;
    protected $departure_date;
    protected $duration;
    protected $photo;


    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setDepartureCode($departure_code) {

        if (strlen($departure_code) < 3) {
            throw new Exception ('code départ trop court');
        }

        if (strlen($departure_code) > 5) {
            throw new Exception('code départ trop long');
        }

        $this->departure_code = $departure_code;
        return $this;
    }

    public function setArrivalCode($arrival_code) {

        if (strlen($arrival_code) < 3) {
            throw new Exception('code arrivée trop court');
        }

        if (strlen($arrival_code) > 5) {
            throw new Exception('code arrivée trop long');
        }

        $this->arrival_code = $arrival_code;
        return $this;
    }

    public function setCompany($company) {

        if (strlen($company) > 150) {
            throw new Exception('champ company trop long');
        }

        $this->company = $company;
        return $this;
    }

    public function setDepartureDate($departure_date, $departure_time) {

        $dateFormat = DateTime::createFromFormat('Y-m-d', $departure_date);

        if (!$dateFormat) {
            throw new Exception('La date a un format incorrect.');
        }

        $this->departure_date = $departure_date . ' ' . $departure_time;
        return $this;
    }

    public function setDuration($duration) {
        $this->duration = $duration;
        return $this;
    }

    public function setPhoto($photo) {

        if (isset($photo) and $photo['error'] == 0) {
            // Testons si le fichier n'est pas trop gros
            if ($photo['size'] <= 10000000) {
                // Testons si l'extension est autorisée
                $infosfichier = pathinfo($photo['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                if (in_array($extension_upload, $extensions_autorisees)) {

                    // On stocke le NOM de la photo (pas la photo elle même, on le fera après le save afin de
                    // modifier le nom de la photo)
                    $this->photo = $photo;
                    return $this;
                }
            }
            else {
                throw new Exception ('photo trop grande');
            }
        }
        else {
            throw new Exception ('une erreur est survenue à l\'upload du fichier');
        }

    }

    public function getId() {
        return $this->id;
    }

    public function getDepartureCode() {
        return $this->departure_code;
    }

    public function getArrivalCode() {
        return $this->arrival_code;
    }

    public function getCompany() {
        return $this->company ;
    }

    public function getDepartureDate() {
        return $this->departure_date;
    }

    public function getDuration() {
        return $this->duration ;
    }

    public function getPhoto() {
        return $this->photo;
    }


    public function save()
    {

        // On ne met pas la photo tout de suite
        $data = [
            "departure_code"    => $this->getDepartureCode(),
            "arrival_code"      => $this->getArrivalCode(),
            "company"           => $this->getCompany(),
            "departure_date"    => $this->getDepartureDate(),
            "duration"          => $this->getDuration(),
        ];
        //if ($this->id > 0) return $this->update();
        $nouvelId = Db::dbCreate(self::TABLE_NAME, $data);
        $this->setId($nouvelId);

        // Une fois l'élément enregistré, on renomme la photo et on update l'élément.
        // On utilise une nouvelle méthode pour séparer le code proprement

        $this->savePhoto();
        $this->createMiniature();

        return $this;
    }

    private function savePhoto() {

        $photo = $this->getPhoto();

        $extension = pathinfo($photo['name'])['extension'];

        $newName = "flight_" . $this->getId();

        $newNameWithExtension = $newName . "." . $extension;

        move_uploaded_file($photo['tmp_name'], './public/uploads/'  .  $newNameWithExtension);

        $data = [
            'id' => $this->getId(),
            'photo' => $newNameWithExtension
        ];

        Db::dbUpdate( self::TABLE_NAME, $data );

        return $this;
    }

    private function createMiniature() {
        /**
         * Gestion de la miniature :
         * Je traite mes variables afin de remplir les arguments de ma fonction createMinature,
         * qui crééera par exemple l'image suivante : "logement_38_300x300.png"
         */


        $photo = $this->getPhoto();


        // 1. On récupère le nom de l'ancienne image
        $extension = pathinfo($photo['name'])['extension'];
        $oldName = "flight_" . $this->getId();
        $oldNameWithExtension = $oldName . "." . $extension;


        $titreAncienneImage = $oldNameWithExtension;                    // Le nom de l'image de départ AVEC extension
        $extension = $extension;                                        // L'extension de départ
        $dossierEnregistrement = './public/uploads';                    // Le dossier de stockage des images, sans "/" !!!
        $titreNouvelleImage = $titreAncienneImage . '_300x300.' . $extension;      // Le nom de la nouvelle image AVEC extension
        $resultMiniature = createMiniature($titreAncienneImage, $extension, $dossierEnregistrement, $titreNouvelleImage);
        if (!$resultMiniature) {
            echo "Il y a eu un problème lors de la création de la miniature.";
            return;
        }
    }

    public static function findAll() {
        $data = Db::dbFind(self::TABLE_NAME);
        return $data;
    }
}