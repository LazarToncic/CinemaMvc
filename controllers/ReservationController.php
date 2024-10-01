<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\DbConnection;
use app\models\CartItemModel;
use app\models\ReservationModel;
use app\models\MovieModel;
use app\models\ReservationItemModel;
use app\models\ResponseMessageModel;
use app\models\ScreeningModel;
use app\models\SeatModel;
use app\models\SeatReservedModel;
use app\models\UserModel;

class ReservationController extends Controller
{
    public function movieReservationCustomer() {
        $screeningModel = new ScreeningModel();
        $screeningModel->mapData($this->router->request->all());

        $seatModel = new SeatModel();
        $seatModel->mapData($this->router->request->all());
        $seatModel->screening_id = $screeningModel->screening_id;
        $seatModel->allSeats = $seatModel->getSeats($screeningModel->screening_id);

        $seatReservedModel = new SeatReservedModel;
        $seatModel->reservedSeats = $seatReservedModel->getReservedSeats($screeningModel->screening_id);

        $this->view("movieReservationCustomer", "dashboard", $seatModel);
    }

    public function reservationProcess() {
        $reservationModel = new ReservationModel();
        $reservationModel->mapData($this->router->request->all());
        $seatReservedModel = new SeatReservedModel();
        $seatReservedModel->mapData($this->router->request->all());

        $userEmail = Application::$app->session->get(Application::$app->session->USER_SESSION);

        if ($userEmail === false) {
            Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_ERROR, "Niste ulogovani!");
            return $this->view("login", "auth", null);
        }

        if ($seatReservedModel->reserved_seats == '') {
            Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_ERROR, "Niste izabrali nijedno sediste!");
            return $this->view("movies", "dashboard", null);
        }

        if ($reservationModel->total_price == '0') {
            Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_ERROR, "Cena ne moze da bude 0!");
            return $this->view("movies", "dashboard", null);
        }

        $reservationModel->creatingReservation($userEmail);

        $seatReservedModel->creatingSeatReserved();

        Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_SUCCESS, "Rezervacija uspesno napravljena");
        return $this->view("movies", "dashboard", null);
    }

    public function authorize(): array
    {
        return [];
    }
}