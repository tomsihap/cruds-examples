<?php


class FlightsController {


    public function index() {

        $flights = Flight::findAll();

        view('flights.index', compact('flights'));
    }

    public function add() {

        view('flights.add');
    }

    public function save() {

        $flight = new Flight;
        $flight->setDepartureCode($_POST['departure_code']);
        $flight->setArrivalCode($_POST['departure_code']);
        $flight->setDepartureDate($_POST['departure_date'], $_POST['departure_time']);
        $flight->setCompany($_POST['company']);
        $flight->setDuration($_POST['duration']);
        $flight->setPhoto($_FILES['photo']);

        $flight->save();
    }

}