<?php
/** @var $params \app\models\UserModel
 */

use app\core\Application;

?>
<div class="container">
    <div class="row g-4 p-3 mt-9 mb-9">
        <div class="col-12">
            <a href="/user/update?user_id=<?php echo $params->user_id ?>" class="btn btn-info w-100">Update User privileges</a>
        </div>
        <div class="col-12">
            <a href="/user/delete?user_id=<?php echo $params->user_id ?>" class="btn btn-danger w-100">Delete user privileges</a>
        </div>

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

        if ($strongestRole === "Admin" || $strongestRole === "SuperAdmin") {
            echo '<div class="col-12">';
            echo '<a href="/user/deleteUserEntirely?user_id='. $params->user_id .'" class="btn btn-danger w-100">Delete user Entirely</a>';
            echo '</div>';
        }


        ?>
    </div>
</div>


