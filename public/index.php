<?php
require_once __DIR__ . "/../vendor/autoload.php";

use app\controllers\AdministrationController;
use app\controllers\AuthController;
use app\controllers\EmployeeReservation;
use app\controllers\HomeController;
use app\controllers\MovieController;
use app\controllers\ReservationController;
use app\controllers\ProfileController;
use app\controllers\StatisticsController;
use app\core\Application;

$app = new Application();

//treba da zavrsis za active ali moraces da napravis bolju gunkciju koja apenduje sve i onda provera
// sta je true a sta false i na osnovu toga da menjas info ili danger boje

$app->router->get("/", [HomeController::class, "index"]);
$app->router->get("/home", [HomeController::class, "index"]);
$app->router->get("/login", [AuthController::class, "login"]);
$app->router->get("/logout", [AuthController::class, "logout"]);
$app->router->get("/registration", [AuthController::class, "registration"]);
$app->router->get("/users", [AdministrationController::class, "users"]);
$app->router->get("/api/administration/users", [AdministrationController::class, "getAllUsers"]);
$app->router->get("/user/edit", [AdministrationController::class, "editUser"]);
$app->router->get("/user/update", [AdministrationController::class, "userUpdate"]);
$app->router->get("/user/delete", [AdministrationController::class, "userDelete"]);
$app->router->get("/user/giveUserAdminPrivileges", [AdministrationController::class, "giveUserAdminPrivileges"]);
$app->router->get("/user/giveUserEmployeePrivileges", [AdministrationController::class, "giveUserEmployeePrivileges"]);
$app->router->get("/user/giveUserManagerPrivileges", [AdministrationController::class, "giveUserManagerPrivileges"]);
$app->router->get("/user/deleteUserAdminPrivileges", [AdministrationController::class, "deleteUserAdminPrivileges"]);
$app->router->get("/user/deleteUserEmployeePrivileges", [AdministrationController::class, "deleteUserEmployeePrivileges"]);
$app->router->get("/user/deleteUserManagerPrivileges", [AdministrationController::class, "deleteUserManagerPrivileges"]);
$app->router->get("/createMovie", [AdministrationController::class, "createMovie"]);
$app->router->get("/admin", [AdministrationController::class, "adminPage"]);
$app->router->get("/api/orders", [StatisticsController::class, "orders"]);
$app->router->get("/api/orders/top10", [StatisticsController::class, "ordersTop10"]);
$app->router->get("/api/orders/movieTopQuantity", [StatisticsController::class, "movieTopQuantity"]);
$app->router->get("/movie/delete", [AdministrationController::class, "deleteMovie"]);
$app->router->get("/movie/update", [AdministrationController::class, "updateMovie"]);
$app->router->get("/moviesAdmin", [AdministrationController::class, "moviesAdmin"]);
$app->router->get("/api/moviesAdmin/rows/json", [AdministrationController::class, "getMovieRowsAdmin"]);
$app->router->get("/adminDirections", [AdministrationController::class, "adminDirections"]);
$app->router->get("/managerDirections", [AdministrationController::class, "managerDirections"]);
$app->router->get("/api/movies/rows/json", [MovieController::class, "getMovieRows"]);
$app->router->get("/movies", [MovieController::class, "movies"]);
$app->router->get("/movie/details", [MovieController::class, "movieDetails"]);
$app->router->get("/api/product/rows/html", [MovieController::class, "getMovieRowsHome"]);
$app->router->get("/userProfile", [ProfileController::class, "userProfile"]);
$app->router->get("/movieReservationCustomer", [ReservationController::class, "movieReservationCustomer"]);
$app->router->get("/api/reservation/quantity/remove", [ReservationController::class, "removeMovieQuantity"]);
$app->router->get("/api/reservation/quantity/add", [ReservationController::class, "addMovieQuantity"]);
$app->router->get("/cart/check", [ReservationController::class, "checkCart"]);
$app->router->get("/cart/delete", [ReservationController::class, "deleteCart"]);
$app->router->get("/makeReservation", [EmployeeReservation::class, "makeReservation"]);
$app->router->get("/api/changeMovieReservation", [EmployeeReservation::class, "changeMovieReservation"]);
$app->router->get("/allReservations", [EmployeeReservation::class, "allReservations"]);
$app->router->get("/api/allReservations", [EmployeeReservation::class, "getAllReservations"]);
$app->router->get("/api/getSeatsEmployeeRes", [EmployeeReservation::class, "getSeats"]);
$app->router->get("/api/changePaidStatus", [EmployeeReservation::class, "changePaidStatus"]);
$app->router->get("/api/changeActiveStatus", [EmployeeReservation::class, "changeActiveStatus"]);
$app->router->post("/createMovieProcess", [AdministrationController::class, "createMovieProcess"]);
$app->router->post("/editMovieProcess", [AdministrationController::class, "editMovieProcess"]);
$app->router->post("/loginProcess", [AuthController::class, "loginProcess"]);
$app->router->post("/registrationProcess", [AuthController::class, "registrationProcess"]);
$app->router->post("/reservationProcess", [ReservationController::class, "reservationProcess"]);
$app->router->post("/employeeReservationProcess", [EmployeeReservation::class, "employeeReservationProcess"]);

$app->run();
