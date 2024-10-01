<div class='row g-4 p-3 mt-5 d-flex justify-content-center align-items-center' id='movies-panel'></div>

<script>
    $(document).ready(function() {
        $.get("/api/product/rows/html", function(result) {
            $("#movies-panel").append(result);
        });
    });

    $(document).on('click', '.add-to-cart-helper', function() {
        var url = $(this).data("route");
        var movie_id = $(this).data("movie_id");
        var data = {"movie_id": movie_id};
        $.post(url, data, function(result) {
            var jsonResult = JSON.parse(result);

            console.log(jsonResult);
            if (jsonResult.success === true) {
                toastr.success(jsonResult.message);
            }

            if (jsonResult.success === false) {
                toastr.error(jsonResult.message);
            }
        });
    });
</script>