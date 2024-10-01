<?php
/** @var $params \app\models\MovieModel
 */
/*var_dump($params);
exit;*/
?>
<div class="card">
    <div class="card-header pb-0 text-left bg-transparent">
        <h3 class="font-weight-bolder text-info text-gradient">Insert movie</h3>
    </div>
    <div class="card-body">
        <form action="/createMovieProcess" method="post" role="form">
            <label>Name</label>
            <div class="mb-3">
                <input type="text" class="form-control" name="name" value="<?php echo $params->name;?>"  placeholder="Name" aria-label="Name" aria-describedby="name-addon">
                <?php
                if ($params !== null && $params->errors !== null) {
                    foreach ($params->errors as $objectNum => $item) {
                        if ($objectNum == "name") {
                            echo "<span class='text-danger'>$item[0]</span>";
                        }
                    }
                }
                ?>
            </div>
            <label>Image url</label>
            <div class="mb-3">
                <input type="text" class="form-control" name="image_url" value="<?php echo $params->image_url;?>"  placeholder="Image_url" aria-label="Image_url" aria-describedby="image_url-addon">
                <?php
                if ($params !== null && $params->errors !== null) {
                    foreach ($params->errors as $objectNum => $item) {
                        if ($objectNum == "image_url") {
                            echo "<span class='text-danger'>$item[0]</span>";
                        }
                    }
                }
                ?>
            </div>
            <label>Price</label>
            <div class="mb-3">
                <input type="text" class="form-control" name="price" value="<?php echo $params->price;?>"  placeholder="Price" aria-label="Price" aria-describedby="price-addon">
                <?php
                if ($params !== null && $params->errors !== null) {
                    foreach ($params->errors as $objectNum => $item) {
                        if ($objectNum == "price") {
                            echo "<span class='text-danger'>$item[0]</span>";
                        }
                    }
                }
                ?>
            </div>
            <label>Categories</label>
            <div class="mb-3">
                <?php
                if ($params !== null && $params->categories !== null) {
                    foreach ($params->categories as $category) {
                        echo "<input type='checkbox' id='category_$category[category_id]' value='$category[category_id]' name='singleMovieCategories[]'>";
                        echo "<label class='me-4' for='category_$category[category_id]'>$category[name]</label>";
                    }
                }
                ?>
                <?php
                    if ($params !== null && $params->errors !== null) {
                        foreach ($params->errors as $objectNum => $item) {
                            if ($objectNum == "singleMovieCategories") {
                                echo "<span class='text-danger d-block'>$item[0]<span>";
                            }
                        }
                    }
                ?>
            </div>

            <label>Movie length</label>
            <div class="mb-3">
                <input type="text" class="form-control" name="movie_length" value="<?php echo $params->movie_length;?>"  placeholder="movie length" aria-label="Movie_length" aria-describedby="movie_length-addon">
                <?php
                if ($params !== null && $params->errors !== null) {
                    foreach ($params->errors as $objectNum => $item) {
                        if ($objectNum == "movie_length") {
                            echo "<span class='text-danger'>$item[0]</span>";
                        }
                    }
                }
                ?>
            </div>

            <label>Movie Directors</label>
            <div class="mb-3">
                <input type="text" class="form-control" name="directors_full_name" value="<?php echo $params->movie_length;?>"  placeholder="Directors" aria-label="directors_full_name" aria-describedby="directors_full_name-addon">
                <?php
                if ($params !== null && $params->errors !== null) {
                    foreach ($params->errors as $objectNum => $item) {
                        if ($objectNum == "directors_full_name") {
                            echo "<span class='text-danger'>$item[0]</span>";
                        }
                    }
                }
                ?>
            </div>

            <label>Actors</label>
            <div class="mb-3">
                <input type="text" class="form-control" name="actors_full_name" value=""  placeholder="Actors" aria-label="actors_full_name" aria-describedby="actors_full_name-addon">
                <?php
                if ($params !== null && $params->errors !== null) {
                    foreach ($params->errors as $objectNum => $item) {
                        if ($objectNum == "actors_full_name") {
                            echo "<span class='text-danger'>$item[0]</span>";
                        }
                    }
                }
                ?>
            </div>

            <label>Most popular</label>
            <div class="mb-0">
                <input type="radio" class="" id="popular" name="most_popular" value="1" aria-label="Company name" aria-describedby="company-name-addon" checked="checked">
                <label for="popular">Yes</label>
            </div>
            <div class="mb-3">
                <input type="radio" class="" id="not-popular" name="most_popular" value="0" aria-label="Company name" aria-describedby="company-name-addon">
                <label for="not-popular">No</label>
            </div>

            <label>Description</label>
            <div class="mb-3">
                <textarea class="form-control" name="description" placeholder="Description" aria-label="Description" aria-describedby="description-addon"><?php echo $params->description;?></textarea>
                <?php
                if ($params !== null && $params->errors !== null) {
                    foreach ($params->errors as $objectNum => $item) {
                        if ($objectNum == "description") {
                            echo "<span class='text-danger'>$item[0]</span>";
                        }
                    }
                }
                ?>
            </div>
            <div class="text-center">
                <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Create Movie</button>
            </div>
        </form>
    </div>

</div>


