<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Reservations</h6>
            </div>
            <div id="res_options">
                <input type="radio" id="allRes" class="res_type" checked="checked" name="res_type">
                <label for="allRes" class="ms-0">All</label>
                <input type="radio" id="active" class="ms-2 res_type" name="res_type">
                <label for="active" class="ms-0">Active</label>
                <input type="radio" id="not_active" class="ms-2 res_type" name="res_type">
                <label for="not_active" class="ms-0">not active</label>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User email</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Reserved at</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Paid</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Active</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Details</th>
                        </tr>
                        </thead>
                        <tbody id="reservations">


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

        $(".res_type").change(function () {
            getRows();
        });

        $(document).on('click', '.btn_paid', function() {
            let reservationId = $(this).data("reservation_id");
            let isPaid = $(this).data("is_paid");

            let data = {"reservation_id":reservationId, "paidStatus":isPaid};

            if (isPaid === 'paid') {
                $(this).data('is_paid', 'not_paid');
                $(this).text('not_paid');
                $(this).css('background-color', '#dc3545');
            }

            if (isPaid === 'not_paid') {
                $(this).data('is_paid', 'paid');
                $(this).text('paid');
                $(this).css('background-color', '#17a2b8');
            }

            $.getJSON("/api/changePaidStatus", data, function(result) {



            });
        });

        $(document).on('click', '.btn_active', function() {
            let reservationId = $(this).data("reservation_id");
            let isActive = $(this).data("is_active");

            let data = {"reservation_id":reservationId, "activeStatus":isActive};

            if (isActive === 'active') {
                $(this).data('is_paid', 'not_active');
                $(this).text('not_active');
                $(this).css('background-color', '#dc3545');
            }

            if (isActive === 'not_active') {
                $(this).data('is_paid', 'active');
                $(this).text('active');
                $(this).css('background-color', '#17a2b8');
            }

            $.getJSON("/api/changeActiveStatus", data, function(result) {



            });
        });
    });

    function getRows() {
        $("#reservations").empty();

        let checkedRes;

        if (document.getElementById('allRes').checked) {
            checkedRes = '';
        }

        if (document.getElementById('active').checked) {
            checkedRes = true;
        }

        if (document.getElementById('not_active').checked) {
            checkedRes = false;
        }

        var data = {"search":$("#search-input-field").val(), "resType":checkedRes};

        $.getJSON("/api/allReservations", data, function(result) {
            $.each(result.reservations, function(i, item) {

                let status;

                if (item.paid === true) {
                    status = "paid";
                }

                if (item.paid === false) {
                    status = "not_paid";
                }

                let activeStatus;

                if (item.active === true) {
                    activeStatus = 'active';
                }

                if (item.active === false) {
                    activeStatus = 'not_active';
                }

                if (status === 'not_paid') {
                    $("#reservations").append(
                        "<tr>" +
                        "<td>" +
                        "<div class='d-flex px-2 py-1'>" +
                        "<div class='d-flex flex-column justify-content-center'>" +
                        "<h6 class='mb-0 text-sm'>" + item.email + "</h6>" +
                        "<p class='text-xs text-secondary mb-0'>"+ item.type_name +"</p>" +
                        "</div>" +
                        "</div>" +
                        " </td>" +
                        "<td>" +
                        "<p class='text-xs text-secondary mb-0'>"+item.created_at+"</p>" +
                        "</td>" +
                        "<td class='align-middle text-center'>" +
                        "<btn data-reservation_id='"+ item.reservation_id +"' data-is_paid='"+ status +"' class='btn btn-danger btn_paid'>"+status+"</btn>" +
                        "</td>" +
                        "<td class='align-middle text-center'>" +
                        "<btn data-reservation_id='"+ item.reservation_id +"' data-is_active='"+ activeStatus +"' class='btn btn-info btn_active'>"+activeStatus+"</btn>" +
                        "</td>" +
                        "<td class='align-middle'>" +
                        "<a href='/reservationDetails?reservation_id="+ item.reservation_id +"' class='btn btn-info'>Details</a>" +
                        "</td>" +
                        "</tr>"
                    );
                }

                if (status === 'paid') {
                    $("#reservations").append(
                        "<tr>" +
                        "<td>" +
                        "<div class='d-flex px-2 py-1'>" +
                        "<div class='d-flex flex-column justify-content-center'>" +
                        "<h6 class='mb-0 text-sm'>" + item.email + "</h6>" +
                        "<p class='text-xs text-secondary mb-0'>"+ item.type_name +"</p>" +
                        "</div>" +
                        "</div>" +
                        " </td>" +
                        "<td>" +
                        "<p class='text-xs text-secondary mb-0'>"+item.created_at+"</p>" +
                        "</td>" +
                        "<td class='align-middle text-center'>" +
                        "<btn data-reservation_id='"+ item.reservation_id +"' data-is_paid='"+ status +"' class='btn btn-info btn_paid'>"+status+"</btn>" +
                        "</td>" +
                        "<td class='align-middle text-center'>" +
                        "<btn data-reservation_id='"+ item.reservation_id +"' data-is_active='"+ activeStatus +"' class='btn btn-info btn_active'>"+activeStatus+"</btn>" +
                        "</td>" +
                        "<td class='align-middle'>" +
                        "<a href='/reservationDetails?reservation_id="+ item.reservation_id +"' class='btn btn-info'>Details</a>" +
                        "</td>" +
                        "</tr>"
                    );
                }

            });
        });
    }

</script>