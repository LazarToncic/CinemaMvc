<?php
/** @var $params \app\models\MovieModel
 */
/*
    echo "<pre>";
    var_dump($params);
    echo "</pre>";
    exit;*/
?>
<div class="card">
    <div class="card-header pb-0 text-left bg-transparent">
        <h3 class="font-weight-bolder text-info text-gradient">Change existing movie</h3>
    </div>
     <div class="col-md-3">
         <div class="card">
             <img src="<?php echo $params->image_url ?>" class="card-img-top">
             <div class="card-body">
                 <h5 class="card-title"><?php echo $params->name ?></h5>
                 <p class="card-text"><?php echo $params->price ?> Din.</p>
             </div>
         </div>
     </div>
    <div class="card-body">
        <form action="/editMovieProcess" method="post" role="form">
            <input type="hidden" name="movie_id" value="<?php echo $params->movie_id; ?>">
            <label>Name</label>
            <div class="mb-3">
                <input type="text" class="form-control" name="name" value="<?php echo $params->name; ?>" placeholder="Name" aria-label="Name" aria-describedby="name-addon">
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
                <input type="text" class="form-control" name="image_url" value="<?php echo $params->image_url; ?>"  placeholder="Image_url" aria-label="Image_url" aria-describedby="image_url-addon">
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
                <input type="text" class="form-control" name="price" value="<?php echo $params->price; ?>"  placeholder="Price" aria-label="Price" aria-describedby="price-addon">
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
            <label>Most popular</label>
            <?php
                if ($params->most_popular = "0") {
                    echo '<div class="mb-0">';
                        echo '<input type="radio" class="" id="popular" name="most_popular" value="1" aria-label="Most popular" aria-describedby="most-popular-addon">';
                        echo '<label for="popular">Popular</label>';
                    echo '</div>';
                    echo '<div class="mb-0">';
                        echo '<input type="radio" class="" id="not-popular" name="most_popular" value="0" aria-label="Most popular" aria-describedby="most-popular-addon" checked="checked">';
                        echo '<label for="not-popular">Not popular</label>';
                    echo '</div>';
                }

                if ($params->most_popular = "1") {
                    echo '<div class="mb-0">';
                    echo '<input type="radio" class="" id="popular" name="most_popular" value="1" aria-label="Most popular" aria-describedby="most-popular-addon" checked="checked">';
                    echo '<label for="popular">Popular</label>';
                    echo '</div>';
                    echo '<div class="mb-0">';
                    echo '<input type="radio" class="" id="not-popular" name="most_popular" value="0" aria-label="Most popular" aria-describedby="most-popular-addon">';
                    echo '<label for="not-popular">Not popular</label>';
                    echo '</div>';
                }
            ?>
            <label>Categories</label>
            <div class="mb-3">
                <?php
                    $helper = false;

                    foreach ($params->categories as $category) {
                        foreach ($params->selected_category_ids as $selected_category_id) {
                            if ($category->category_id === $selected_category_id) {
                                $helper = true;
                                break;
                            }
                        }

                        if ($helper) {
                            echo '<input class="ms-3" type="checkbox" id="' . $category->category_id . '" value="' . $category->category_id . '" name="selected_category_ids[]" checked="checked">';

                        } else {
                            echo '<input class="ms-3" type="checkbox" id="' . $category->category_id . '" value="' . $category->category_id . '" name="selected_category_ids[]">';
                        }

                        echo '<label for="' . $category->category_id . '">' . $category->name . '</label>';
                        $helper = false;
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
            <label>Description</label>
            <div class="mb-3">
                <textarea class="form-control" name="description" placeholder="Description" aria-label="Description" aria-describedby="description-addon"><?php echo $params->description; ?></textarea>
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
                <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Edit Movie</button>
            </div>
        </form>
    </div>

</div>



