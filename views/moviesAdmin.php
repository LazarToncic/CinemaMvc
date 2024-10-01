<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-md-6"><h6>Movies</h6></div>
                    <div class="col-md-6 d-flex justify-content-end"><a href="/createMovie" class="btn btn-sm btn-primary">Create new product</a></div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Time and place of play</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Price</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Category name</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Options</th>
                        </tr>
                        </thead>
                        <tbody id="table-body">


                        </tbody>
                    </table>
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

    $(document).on('click', '.delete-btn-action', function() {
        $.get($(this/* je .delete-btn-action */).data("route"), function(result) {
            getRows();
        });
    });

    function getRows() {
        $("#table-body").empty();

        var data = {"search":$("#search-input-field").val()};
        $.getJSON("/api/moviesAdmin/rows/json", data, function(result) {
            $.each(result.movies, function(i, item) {
                $("#table-body").append(
                    "<tr>" +
                    "<td>" +
                        "<div class='d-flex px-2 py-1'>" +
                        "<div>" +
                        "<img src='"+ item.image_url +"' class='avatar avatar-sm me-3' alt='user1'>" +
                        "</div>" +
                        "<div class='d-flex flex-column justify-content-center'>" +
                        "<h6 class='mb-0 text-sm'>" + item.name + "</h6>" +
                        "</div>" +
                        "</div>" +
                    " </td>" +
                    "<td>" +
                        "<a href='/movie/updateTandP?movie_id="+item.movie_id+"' class='btn btn-sm btn-primary'>MORE</a>" +
                    "</td>" +
                    "<td>" +
                        "<p class='mb-0 text-sm'>" + item.price + "</p>" +
                    "</td>" +
                    "<td>" +
                        "<p class='mb-0 text-sm'>" + item.category + "</p>" +
                    "</td>" +
                    "<td class='align-middle'>" +
                        "<a href='/movie/update?movie_id="+item.movie_id+"' class='text-secondary font-weight-bold text-xs' data-toggle='tooltip' data-original-title='Edit user'>Edit</a>" +
                        " | <a href='javascript:;' data-route='/movie/delete?movie_id="+item.movie_id+"' class='text-secondary font-weight-bold text-xs delete-btn-action' data-toggle='tooltip' data-original-title='Edit user'>Delete</a>" +
                    "</td>" +
                    "</tr>"
                );
            });
        });
    }
</script>