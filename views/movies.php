<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-md-6"><h6>Movies</h6></div>

                    <div class="container-fluid">
                        <div class='row row-cols-3 g-4 p-3 mt-5' id='movies-panel'>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        getRows();

        $("#search-input-field").change(function () {

            getRows();
        });
    });

    function getRows() {
        $("#movies-panel").empty();

        var data = {"search":$("#search-input-field").val()};

        $.getJSON('/api/movies/rows/json', data, function(result) {
            $.each(result.movies, function (i, item) {
                $("#movies-panel").append(
                    "<div class='col'>" +
                        "<a href='movie/details?movie_id="+ item.movie_id +"'><img src='"+ item.image_url +"'  class='card-img-top' alt='slika'></a>" +
                        "<div>" +
                            "<a href='movie/details?movie_id="+ item.movie_id +"' class='mb-0 fs-3 text-center'>" + item.name + "</a>" +
                        "</div>" +
                        "<div>" +
                            "<p class='mb-0 text-dark'>" + item.category + "</p>" +
                        "</div>" +
                        "<div>" +
                            "<p class='mb-0 text-sm'>Pocetak prikazivanja filma:</p>" +
                        "</div>" +
                        "<div>" +
                        "<p class='mb-0 text-dark'>" + item.pocetak_prikazivanja + "</p>" +
                        "</div>" +
                    "</div>"
                );
            });
        });
    }
</script>