<?php
/** @var $params \app\models\UserModel
 */

use app\core\Application;

?>
<div class="container">
    <div class="row g-4 p-3 mt-9 mb-9">

        <?php
        $sessionRoles = Application::$app->session->get(Application::$app->session->ROLE_SESSION);

        $strongestRole = "";

        if ($sessionRoles !== false) {
            foreach ($sessionRoles as $role) {
                if ($role === "Admin")
                    $strongestRole = "Admin";
                if ($role === "SuperAdmin")
                    $strongestRole = "SuperAdmin";
            }
        }

        if ($strongestRole === "Admin") {
            echo '<div class="col-12">';
            echo '<a href="/user/deleteUserManagerPrivileges?user_id='. $params->user_id .'" class="btn btn-danger w-100">Delete user Manager Privileges</a>';
            echo '</div>';
        }

        if ($strongestRole === "SuperAdmin") {
            echo '<div class="col-12">';
            echo '<a href="/user/deleteUserManagerPrivileges?user_id='. $params->user_id .'" class="btn btn-danger w-100">Delete user Manager Privileges</a>';
            echo '</div>';
            echo '<div class="col-12">';
            echo '<a href="/user/deleteUserAdminPrivileges?user_id='. $params->user_id .'" class="btn btn-danger w-100">Delete user Admin Privileges</a>';
            echo '</div>';
        }

        ?>
        <div class="col-12">
            <a href="/user/deleteUserEmployeePrivileges?user_id=<?php echo $params->user_id ?>" class="btn btn-danger w-100">Delete user Employee Privileges</a>
        </div>
    </div>
</div>

