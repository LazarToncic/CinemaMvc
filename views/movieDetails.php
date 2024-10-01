<?php
  /** @var $params \app\models\MovieModel
 */
/*
echo "<pre>";
var_dump($params);
echo "</pre>";
exit;
*/
?>
<div class="container">
    <div class="row">
        <div class="col-6 d-flex">
            <div class="movie-image-side ">
                <img class="card-img-top" src="<?php echo $params->image_url ?>">
            </div>
        </div>
        <div class="col-6 d-flex">
            <div class="movie-inf-side text-dark">
                <p class="fs-3 mb-0">Title: <?php echo $params->name ?></p>
                <p class="fs-3 mb-0">In cinema: <?php echo $params->pocetak_prikazivanja ?></p>
                <p class="fs-3 mb-0">Movie length: <?php echo $params->movie_length ?></p>
                <p class="fs-3 mb-0">Genre: <?php echo $params->category ?></p>
                <p class="fs-4 mb-0">Director: <?php echo $params->director_name ?></p>
                <p class="fs-5 mb-0">Actors: <?php echo $params->actor_name_role ?></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h3 class="text-center pt-6">Summary</h3>
            <p class="fs-3 fst-italic text-dark"><?php echo $params->description ?></p>
        </div>
    </div>
    <div class="text-center mt-4 mb-7">
        <p class="fs-2 text-success">Vremenski raspored svih projekcija</p>
    </div>

    <div class="d-flex">
        <?php
            $allTimesAndAuditoriums = explode(",",$params->time_auditorium);

            $screeningIds = explode(",", $params->screening_id);

        foreach ($allTimesAndAuditoriums as $allTimesAndAuditorium) {
                $singleTimeAndAuditorium = explode("/",$allTimesAndAuditorium);

                $screeningTimeWithSeconds = explode(":", $singleTimeAndAuditorium[0]);
                $screeningTimeWithoutSeconds = $screeningTimeWithSeconds[0]. ":".$screeningTimeWithSeconds[1];

                echo '<div class="border border-2 border-success m-2 p-2">';
                    echo '<a href="/movieReservationCustomer?screening_id='. $screeningIds[0] .'&price='. $params->price .'">';
                        echo '<p class="text-dark">'.$screeningTimeWithoutSeconds.'<span><i class="fa fa-ticket opacity-6 text-success me-1 ms-2"></i></span></p>';
                        echo '<p>'.$singleTimeAndAuditorium[1].'</p>';
                    echo '</a>';
                echo '</div>';

                $screeningIds = array_splice($screeningIds,1);
            }
        ?>
    </div>
</div>
