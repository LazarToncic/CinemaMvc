<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\DbConnection;
use app\models\ActorModel;
use app\models\CategoryModel;
use app\models\DirectorModel;
use app\models\ListMovieModel;
use app\models\ListUserModel;
use app\models\MovieCategoryModel;
use app\models\MovieDirectorModel;
use app\models\MovieModel;
use app\models\ReservationModel;
use app\models\UserModel;
use app\models\UserRoleModel;

class AdministrationController extends Controller
{
    public function users() {
        $this->view("users", "dashboard", null);
    }

    public function adminPage() {
        $this->view("admin", "dashboard", null);
    }

    public function moviesAdmin() {
        $this->view("moviesAdmin", "dashboard", null);
    }

    public function adminDirections() {
        $this->view("adminDirections", "empty", null);
    }

    public function managerDirections() {
        $this->view("managerDirections", "empty", null);
    }

    public function getMovieRowsAdmin() {
        $listMovieModel = new ListMovieModel();
        $listMovieModel->mapData($this->router->request->all());

        echo $listMovieModel->search();
    }

    public function createMovie() {
        $movieModel = new MovieModel();
        $categoryModel = new CategoryModel();

        $categories = $categoryModel->all();
        $movieModel->categories = $categories;

        $this->view("createMovie", "dashboard", $movieModel);
    }

    public function createMovieProcess() {
        $movieModel = new MovieModel();
        $categoryModel = new CategoryModel();
        $directorModel = new DirectorModel();

        $categories = $categoryModel->all();
        $movieModel->categories = $categories;

        $movieModel->mapData($this->router->request->all());
        $directorModel->mapData($this->router->request->all());

        $movieModel->validate();

        if ($movieModel->errors) {
            return $this->view("createMovie", "dashboard", $movieModel);
        }

        $movieModel->create();

        // INSERTING DIRECTORS
        $directorModel->insertDirectors($directorModel);

        // INSERTING ACTORS
        $actorModel = new ActorModel();
        $actorModel->mapData($this->router->request->all());
        $actorModel->insertActors($actorModel);

        //FOR CATEGORY
        $dbData = $movieModel->one("name = '$movieModel->name'");

        foreach ($movieModel->selected_category_ids as $singleMovieCategory) {
            $movieCategoryModel = new MovieCategoryModel();
            $movieCategoryModel->movie_id = $dbData["movie_id"];
            $movieCategoryModel->category_id = $singleMovieCategory;
            $movieCategoryModel->create();
        }

        return $this->view("createMovie", "dashboard", $movieModel);
    }

    public function getAllUsers() {
        $listUserModel = new ListUserModel();
        $listUserModel->mapData($this->router->request->all());

        echo $listUserModel->searchUsers();
    }

    public function editUser() {
        $userModel = new UserModel();
        $userModel->mapData($this->router->request->all());

        $this->view("userEdit", "dashboard", $userModel);
    }

    //ADDING PRIVILEGES

    public function userUpdate() {
        $userModel = new UserModel();
        $userModel->mapData($this->router->request->all());

        $this->view("updateUser", "dashboard", $userModel);
    }

    public function giveUserAdminPrivileges() {
        $userModel = new UserModel();
        $userModel->mapData($this->router->request->all());

        $dbResult = $this->getSingleUserRoles($userModel->user_id);

        foreach ($dbResult as $singleRole) {
            if ($singleRole == 4) {
                Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_ERROR, "Korisnik je vec admin!");
                return $this->view("users", "dashboard", null);
            }
        }

        $userRoleModel = new UserRoleModel();
        $userRoleModel->user_id = $userModel->user_id;
        $userRoleModel->role_id = 4;

        $userRoleModel->create();
        Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_SUCCESS, "Korisniku je dodata titula Admin!");
        return $this->view("users", "dashboard", null);
    }

    public function giveUserEmployeePrivileges() {
        $userModel = new UserModel();
        $userModel->mapData($this->router->request->all());

        $dbResult = $this->getSingleUserRoles($userModel->user_id);

        foreach ($dbResult as $singleRole) {
            if ($singleRole == 2) {
                Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_ERROR, "Korisnik je vec Employee!");
                return $this->view("users", "dashboard", null);
            }
        }

        $userRoleModel = new UserRoleModel();
        $userRoleModel->user_id = $userModel->user_id;
        $userRoleModel->role_id = 2;

        $userRoleModel->create();
        Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_SUCCESS, "Korisniku je dodata titula Employee!");
        return $this->view("users", "dashboard", null);
    }

    public function giveUserManagerPrivileges() {
        $userModel = new UserModel();
        $userModel->mapData($this->router->request->all());

        $dbResult = $this->getSingleUserRoles($userModel->user_id);

        foreach ($dbResult as $singleRole) {
            if ($singleRole == 3) {
                Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_ERROR, "Korisnik je vec Manager!");
                return $this->view("users", "dashboard", null);
            }
        }

        $userRoleModel = new UserRoleModel();
        $userRoleModel->user_id = $userModel->user_id;
        $userRoleModel->role_id = 3;

        $userRoleModel->create();
        Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_SUCCESS, "Korisniku je dodata titula Manager!");
        return $this->view("users", "dashboard", null);
    }

    //DELETING PRIVILEGES

    public function userDelete() {
        $userModel = new UserModel();
        $userModel->mapData($this->router->request->all());

        $this->view("deleteUser", "dashboard", $userModel);
    }

    public function deleteUserAdminPrivileges() {
        $userModel = new UserModel();
        $userModel->mapData($this->router->request->all());

        $dbResult = $this->getSingleUserRoles($userModel->user_id);

            if (!in_array("4", $dbResult)) {
                Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_ERROR, "Korisnik nikad nije ni bio admin!");
                return $this->view("users", "dashboard", null);
            }

        $userRoleModel = new UserRoleModel();
        $userRoleModel->user_id = $userModel->user_id;
        $userRoleModel->role_id = 4;

        $userRoleModel->delete("user_id = '$userRoleModel->user_id' AND role_is = '$userRoleModel->role_id'");
        Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_SUCCESS, "Korisniku je obrisana titula Admin!");
        return $this->view("users", "dashboard", null);
    }

    public function deleteUserEmployeePrivileges() {
        $userModel = new UserModel();
        $userModel->mapData($this->router->request->all());

        $dbResult = $this->getSingleUserRoles($userModel->user_id);


        if (!in_array("2", $dbResult)) {
            Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_ERROR, "Korisnik nikad nije ni bio Employee!");
            return $this->view("users", "dashboard", null);
        }


        $userRoleModel = new UserRoleModel();
        $userRoleModel->user_id = $userModel->user_id;
        $userRoleModel->role_id = 2;

        $userRoleModel->delete("user_id = '$userRoleModel->user_id' AND role_id = '$userRoleModel->role_id'");
        Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_SUCCESS, "Korisniku je izbrisana titula Employee!");
        return $this->view("users", "dashboard", null);
    }

    public function deleteUserManagerPrivileges() {
        $userModel = new UserModel();
        $userModel->mapData($this->router->request->all());

        $dbResult = $this->getSingleUserRoles($userModel->user_id);


        if (!in_array("3", $dbResult)) {
            Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_ERROR, "Korisnik nikad nije ni bio Employee!");
            return $this->view("users", "dashboard", null);
        }


        $userRoleModel = new UserRoleModel();
        $userRoleModel->user_id = $userModel->user_id;
        $userRoleModel->role_id = 3;

        $userRoleModel->delete("user_id = '$userRoleModel->user_id' AND role_id = '$userRoleModel->role_id'");
        Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_SUCCESS, "Korisniku je izbrisana titula Employee!");
        return $this->view("users", "dashboard", null);
    }

    public function getSingleUserRoles($user_id): array
    {
        $db = new DbConnection();
        $sqlCheckingDoesRoleExist = "
            SELECT role_id
            FROM user_role ur
            WHERE user_id = '$user_id';
        ";

        $dbData = $db->conn()->query($sqlCheckingDoesRoleExist);
        $dbResult = [];

        while($result = $dbData->fetch_assoc()) {
            $dbResult[] = $result["role_id"];
        }

        return $dbResult;
    }

    // UPDATING MOVIES, EDITING MOVIES AND DELETING MOVIES

    public function deleteMovie() {
        $movieModel = new MovieModel();
        $movieModel->mapData($this->router->request->all());

        $movieModel->delete("movie_id = '$movieModel->movie_id'");
    }

    public function updateMovie() {
        $movieModel = new MovieModel();
        $movieModel->mapData($this->router->request->all());

        $movieModel->mapData($movieModel->one("movie_id = '$movieModel->movie_id'"));

        $db = new DbConnection();

        $sqlString = "
            SELECT 
	            c.category_id
            FROM category c
            INNER JOIN movie_category mc ON c.category_id = mc.category_id
            INNER JOIN movie m ON mc.movie_id = m.movie_id
            WHERE
	            m.movie_id = '$movieModel->movie_id'
        ";

        $dbData = $db->conn()->query($sqlString);

        while($result = $dbData->fetch_assoc()) {
            $movieModel->selected_category_ids[] = $result["category_id"];
        }

        $categoryModel = new CategoryModel();

        $categories = $categoryModel->allCategoryModel();
        $movieModel->categories = $categories;

        $this->view("aboutSingleMovieAdmin", "dashboard", $movieModel);
    }

    public function editMovieProcess() {
        $movieModel = new MovieModel();
        $movieModel->mapData($this->router->request->all());

        /*
        echo "<pre>";
        var_dump($movieModel);
        echo "</pre>";
        exit;*/

        $sqlMovieUpdate = "UPDATE movie
                      SET
                        name = '$movieModel->name',
                        image_url = '$movieModel->image_url',
                        price = '$movieModel->price',
                        most_popular = '$movieModel->most_popular',
                        description = '$movieModel->description'
                      WHERE movie_id = $movieModel->movie_id;";

        $db = new DbConnection();

        $dbQueryMovie = $db->conn()->query($sqlMovieUpdate);

        if (!$dbQueryMovie) {
            Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_ERROR, "Podaci nisu promenjeni!");
            return $this->view("moviesAdmin", "dashboard", null);
        }


        $sqlMovieCategories = "SELECT category_id
                                FROM movie_category
                                WHERE movie_id = '$movieModel->movie_id'";

        $dbMovieCategories = $db->conn()->query($sqlMovieCategories);

        $resultArray = [];

        while ($result = $dbMovieCategories->fetch_assoc()) {
            $resultArray[] = $result;
        }

        $movieCategoryModelCreated = false;

        foreach ($resultArray as $item) {
            if ($movieCategoryModelCreated === true) {
                break;
            }

            foreach ($movieModel->selected_category_ids as $selected_category_id) {
                if ($movieCategoryModelCreated === true) {
                    break;
                }

                if ($item != $selected_category_id) {
                    $sqlString = "DELETE FROM movie_category 
                                  WHERE movie_id = '$movieModel->movie_id'";

                    $db->conn()->query($sqlString);

                    $movieCategoryModel = new MovieCategoryModel();

                    foreach ($movieModel->selected_category_ids as $selected_id) {
                        $movieCategoryModel->movie_id = $movieModel->movie_id;
                        $movieCategoryModel->category_id = $selected_id;
                        $movieCategoryModel->create();
                    }
                    $movieCategoryModelCreated = true;
                }
            }
        }

        Application::$app->session->setFlash(Application::$app->session->FLASH_MESSAGE_SUCCESS, "Podaci uspesno promenjeni!");
        return $this->view("moviesAdmin", "dashboard", null);
    }

    public function authorize(): array
    {
        return [
            "Admin",
            "Manager",
            "SuperAdmin"
        ];
    }
}