<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Users</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Function</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Employed</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                        </thead>
                        <tbody id="users">


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        getUserRows();

        $("#search-input-field").change(function () {
            getUserRows();
        });
    });

    function getUserRows() {
        $("#users").empty();

        var data = {"search":$("#search-input-field").val()};

        $.getJSON("/api/administration/users", data, function(result) {
            $.each(result.users, function(i, item) {
                $("#users").append(
                    "<tr>" +
                    "<td>" +
                    "<div class='d-flex px-2 py-1'>" +
                    "<div>" +
                    "<img src='../assets/img/team-2.jpg' class='avatar avatar-sm me-3' alt='user1'>" +
                    "</div>" +
                    "<div class='d-flex flex-column justify-content-center'>" +
                    "<h6 class='mb-0 text-sm'>" + item.name + "</h6>" +
                    "<p class='text-xs text-secondary mb-0'>"+ item.email +"</p>" +
                    "</div>" +
                    "</div>" +
                    " </td>" +
                    "<td>" +
                    "<p class='text-xs font-weight-bold mb-0'>User Roles</p>" +
                    "<p class='text-xs text-secondary mb-0'>"+item.user_roles+"</p>" +
                    "</td>" +
                    "<td class='align-middle text-center text-sm'>" +
                    "<span class='badge badge-sm bg-gradient-success'>Online</span>" +
                    "</td>" +
                    "<td class='align-middle text-center'>" +
                    "<span class='text-secondary text-xs font-weight-bold'>"+item.created_at+"</span>" +
                    "</td>" +
                    "<td class='align-middle'>" +
                    "<a href='/user/edit?user_id="+ item.user_id +"' class='text-secondary font-weight-bold text-xs' data-toggle='tooltip' data-original-title='Edit user'>Edit</a>" +
                    "</td>" +
                    "</tr>"
                );
            });
        });
    }
</script>
