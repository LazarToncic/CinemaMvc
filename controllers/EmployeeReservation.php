<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\models\EmployeeReservationModel;
use app\models\ListMovieModel;
use app\models\ListReservationModel;
use app\models\MovieModel;
use app\models\ScreeningModel;
use app\models\SeatModel;
use app\models\SeatReservedModel;

class EmployeeReservation extends Controller
{
    public function makeReservation() {
        $listMovieModel = new ListMovieModel();

        $listMovieModel->getAllMovieNamesForReservation();

        return $this->view("EmployeeReservation", "dashboard", $listMovieModel);
    }

    public function employeeReservationProcess() {
        $employeeReservationModel = new EmployeeReservationModel();
        $employeeReservationModel->mapData($this->router->request->all());

        $seatReservedModel = new SeatReservedModel;
        $seatReservedModel->mapData($this->router->request->all());

        $listMovieModel = new ListMovieModel();
        $listMovieModel->getAllMovieNamesForReservation();

        if ($seatReservedModel->reserved_seats === "") {
            Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_ERROR, "No seats chosen!");
            return $this->view("EmployeeReservation", "dashboard", $listMovieModel);
        }

        $employeeReservationModel->getUserId($employeeReservationModel->user_email);

        if ($employeeReservationModel->user_id === "") {
            Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_ERROR, "Korisnik ne postoji");
            return $this->view("EmployeeReservation", "dashboard", $listMovieModel);
        }

        $employeeReservationModel->getEmployeeFullName($employeeReservationModel->employee_reserved, $employeeReservationModel->employee_paid);

        if ($employeeReservationModel->employee_reserved === "" || $employeeReservationModel->employee_paid === "") {
            Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_ERROR, "Ovaj zaposleni ne postoji");
            return $this->view("EmployeeReservation", "dashboard", $listMovieModel);
        }

        $employeeReservationModel->validate();

        if ($employeeReservationModel->errors) {
            Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_ERROR, "Rezervacija nije dobra");
            return $this->view("EmployeeReservation", "dashboard", $employeeReservationModel);
        }

        $employeeReservationModel->reservation_type_id = 2;
        $employeeReservationModel->reserved = true;
        $employeeReservationModel->active = true;

        $employeeReservationModel->create();
        $seatReservedModel->creatingSeatReserved();

        Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_SUCCESS, "Rezervacija zavrsena");
        return $this->view("EmployeeReservation", "dashboard", $listMovieModel);
    }

    public function getSeats() {
        $screeningModel = new ScreeningModel();
        $screeningModel->mapData($this->router->request->all());

        $seatModel = new SeatModel();
        $seatModel->screening_id = $screeningModel->screening_id;
        $seatModel->allSeats = $seatModel->getSeats($screeningModel->screening_id);

        $seatReservedModel = new SeatReservedModel;
        $seatModel->reservedSeats = $seatReservedModel->getReservedSeats($screeningModel->screening_id);

        echo json_encode($seatModel);
    }

    public function allReservations() {
        return $this->view("allReservations", "dashboard", null);
    }

    public function getAllReservations() {
        $listReservationModel = new ListReservationModel();
        $listReservationModel->mapData($this->router->request->all());

        echo $listReservationModel->searchReservations();
    }

    public function changePaidStatus() {
        $employeeReservationModel = new EmployeeReservationModel();
        $employeeReservationModel->mapData($this->router->request->all());

        echo $employeeReservationModel->changePaidStatus();
    }

    public function changeActiveStatus() {
        $employeeReservationModel = new EmployeeReservationModel();
        $employeeReservationModel->mapData($this->router->request->all());

//        echo "<pre>";
//        var_dump($employeeReservationModel);
//        echo "</pre>";
//        exit;

        echo $employeeReservationModel->changeActiveStatus();
    }

    public function changeMovieReservation() {
        $movieModel = new MovieModel();
        $movieModel->mapData($this->router->request->all());

        $allInf = $movieModel->getInfForSingleMovieEmployeeRes($movieModel->movie_id);

        echo json_encode($allInf);
    }

    public function authorize(): array
    {
        return [
            'Employee',
            'Manager',
            'Admin',
            'SuperAdmin'
        ];
    }
}