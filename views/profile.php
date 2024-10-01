<?php
/** @var $params \app\models\ProfileModel
 */

?>

<div class="row">
    <div class="col-12">
        <h2 class="fst-italic text-dark">Welcome back <?php echo $params->user_name ?></h2>
    </div>
    <div class="col-12">
        <?php
            if ($params->total_price >= 10000) {
                echo '<div class="fs-3">Congratulations you are a gold member!</div>';
                echo '<div class="fs-3">expect many sales on food and drinks, even some bonuses :)</div>';
            } else {
                echo '<div class="fs-3">OH! look like you are not a gold member still, but you are getting there!</div>';
                echo '<div class="fs-3">Keep it up!</div>';
            }
        ?>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6 class="fs-2">Movies you watched</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                            <?php
                            foreach ($params->movies as $movie) {
                                echo '<div class="d-flex my-4">';
                                    echo '<div class="flex-grow-1">';
                                        echo '<a href="movie/details?movie_id='. $movie->movie_id .'"><img src="'. $movie->image_url .'" class="avatar" alt="movieImage"></a>';
                                    echo '</div>';
                                    echo '<div class="flex-grow-1">';
                                        echo '<p class="">'. $movie->name .'</p>';
                                    echo '</div>';
                                    echo '<div class="flex-grow-2">';
                                        echo '<a href="movie/details?movie_id='. $movie->movie_id .'" class="btn btn-primary">About a movie</a>';
                                    echo '</div>';
                                echo '</div>';
                            }
                            ?>
            </div>
        </div>
    </div>
</div>
