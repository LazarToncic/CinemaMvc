<?php
/** @var $params \app\models\ListMovieModel
 */

use app\models\ListMovieModel;
?>

<form action="/employeeReservationProcess" method="post" role="form">
    <label>Movie</label>
    <div class="mb-3">
        <select id="movie_select">
            <option disabled selected>-- choose movie --</option>
            <?php
            foreach ($params->movies as $movie) {
                    echo '<option value="'.$movie->movie_id.'">'.$movie->name.'</option>';
                }
            ?>
        </select>
    </div>
    <div id="price_auditoriums">
        <div id="prices">
            <p class="d-inline">price:</p>
            <p id="price"></p>
            <button type="button" id="button_inc" class="btn btn-info">+</button>
            <button type="button" id="ticket_quantity" class="btn btn-info">1</button>
            <button type="button" id="button_dec" class="btn btn-info">-</button>
            <p class="text-bold mb-0">Ukupna cena: </p>
            <p id="user_price"></p>
        </div>
        <div id="auditoriums" class="d-flex">

        </div>
    </div>

    <div class="row">
        <div class="col">
            <table id="seats_table" class="table table-sm w-auto">

            </table>
        </div>
        <div class="col">
            <p id="resSeats_text" class="mb-0"></p>
            <p id="reserved_seats_ui"></p>
        </div>
    </div>

    <label for="employee_reserved">Employee_reserved</label>
    <div class="mb-3">
        <input type="text" class="form-control" name="employee_reserved" id="employee_reserved" value="<?php echo \app\core\Application::$app->session->get(\app\core\Application::$app->session->USER_SESSION) ?>">
        <?php
        if ($params !== null && $params->errors !== null) {
            foreach ($params->errors as $objectNum => $item) {
                if ($objectNum == "employee_reserved") {
                    echo "<span class='text-danger'>$item[0]</span>";
                }
            }
        }
        ?>
    </div>

    <label for="user_email">Customer Email</label>
    <div class="mb-3">
        <input type="text" class="form-control" name="user_email" id="user_email">
    </div>

    <label for="employee_paid">Employee_paid</label>
    <div class="mb-3">
        <input type="text" class="form-control" name="employee_paid" id="employee_paid" value="<?php echo \app\core\Application::$app->session->get(\app\core\Application::$app->session->USER_SESSION) ?>">
        <?php
        if ($params !== null && $params->errors !== null) {
            foreach ($params->errors as $objectNum => $item) {
                if ($objectNum == "employee_paid") {
                    echo "<span class='text-danger'>$item[0]</span>";
                }
            }
        }
        ?>
    </div>

    <label for="user_paid">Customer Paid</label>
    <div class="mb-3">
        <div class="mb-0">
            <input type="radio" class="" id="user_paid-y" name="paid" value="true">
            <label for="user_paid-y">Yes</label>
        </div>
        <div class="mb-3">
            <input type="radio" class="" id="user_paid-n" name="paid" value="false" checked="checked">
            <label for="user_paid-n">No</label>
        </div>
    </div>

    <input type="hidden" name="reserved_seats" id="reserved_seats">
    <input type="hidden" name="total_price" id="total_price" value="620">
    <?php
    if ($params !== null && $params->errors !== null) {
        foreach ($params->errors as $objectNum => $item) {
            if ($objectNum == "total_price") {
                echo "<span class='text-danger'>$item[0]</span>";
            }
        }
    }
    ?>

    <div class="text-center">
        <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign up</button>
    </div>
</form>

<script>

    $(document).ready(function() {

        $(document).on('change', '#movie_select', function() {
            let movie_id = $(this).val();
            let data = {'movie_id': movie_id};

            document.getElementById('resSeats_text').innerText = '';
            document.getElementById('reserved_seats_ui').innerText = '';
            document.getElementById('reserved_seats').value = '';

            $.getJSON('/api/changeMovieReservation', data, function(result) {
                let price = document.getElementById('price');
                price.innerText = result[0].price;

                let userPrice = document.getElementById('user_price');
                userPrice.innerText = result[0].price;

                $('#auditoriums').empty();
                $('#seats_table').empty();

                $.each(result, function(i, item) {

                    let screenings = item.screening_start.split(':');

                    let screeningWithoutSeconds = screenings[0] + ':' + screenings[1];

                    $('#auditoriums').append(
                        "<div class='border border-2 border-success m-2 p-2'>" +
                            "<p>"+ screeningWithoutSeconds +"<span><i class='fa fa-ticket opacity-6 text-success me-1 ms-2'></i></span></p>" +
                            "<p>"+ item.auditorium_name +"</p>" +
                            "<input type='radio' name='screening_id' class='single_auditorium' value='"+ item.screening_id +"'>" +
                        "</div>"
                    );
                });

            });
        });

        $(document).on('change', '.single_auditorium', function() {

            $('#seats_table').empty();
            document.getElementById('resSeats_text').innerText = '';
            document.getElementById('reserved_seats_ui').innerText = '';
            document.getElementById('reserved_seats').value = '';


            let data = {"screening_id":$(this).val()};

            $.getJSON('/api/getSeatsEmployeeRes', data, function(result) {
                let reservedSeatsInOrder = [];

                $.each(result.reservedSeats, function(i, reservedSeat) {
                    reservedSeatsInOrder.push(Number(reservedSeat));
                });

                reservedSeatsInOrder.sort(function(a, b){return a - b});
                let rowCount;

                $.each(result.allSeats, function(i, allSeat) {
                    let seatsNotInOrder = allSeat.number.split(',');

                    let seatsInOrder = [];

                    $.each(seatsNotInOrder, function(i, seatNotInOrder) {
                        seatsInOrder.push(Number(seatNotInOrder));
                    });

                    seatsInOrder.sort(function(a, b){return a - b});

                    if (rowCount === undefined) {
                        rowCount = 1;
                    }

                    $('#seats_table').append(
                        "<tr class='rows' id='row_number"+ rowCount +"'>" +
                        "<td class='text-danger pe-4'>"+ allSeat.row +"</td>"
                    );


                    let helper = false;

                    let appendHelper = '#row_number' + rowCount;

                    $.each(seatsInOrder, function(i, seatInOrder) {
                        $.each(reservedSeatsInOrder, function(i, reservedSeat) {
                            if (seatInOrder === reservedSeat) {
                                helper = true;
                                return false;
                            }

                            helper = false;
                        });

                        if (helper) {
                            $(appendHelper).append(
                                "<td class='text-center'><div class='p-2 border border-dark bg-dark' data-set='"+ seatInOrder +"'></div></td>"
                            );
                        } else {
                            $(appendHelper).append(
                                "<td class='text-center'><div class='p-2 border border-dark seat-number' data-set='"+ seatInOrder +"'></div></td>"
                            );
                        }

                    });

                    $('#seats_table').append(
                        "</tr>"
                    );

                    rowCount++;
                });
            });
        });

        $(document).on('click', '.rows', function(e) {
            const seat = e.target;
            const formReservedSeats = document.getElementById('reserved_seats');
            let reservedSeatsUI = document.getElementById('reserved_seats_ui');
            let reservedSeatsText = document.getElementById('resSeats_text');

            if (seat.classList.contains('seat-number')) {
                if (seat.style.backgroundColor !== 'rgb(255, 0, 0)') {

                    // dodavanje sedista
                    let chosenSeat = seat.dataset.set;
                    formReservedSeats.value += chosenSeat + ',';

                    //rezervisana sedista
                    reservedSeatsText.innerText = 'Reserved seats:';
                    reservedSeatsUI.innerText += chosenSeat + ',';

                    seat.style.backgroundColor = 'rgb(255, 0, 0)';
                } else {
                    let chosenSeat = seat.dataset.set;
                    let sedistaUFormiString = formReservedSeats.value;
                    let sedistaUFormiArray = sedistaUFormiString.split(',');

                    $.each(sedistaUFormiArray, function(i, item) {
                        if (item === '') {
                            let removeEmptySeat = sedistaUFormiArray.indexOf(item);
                            sedistaUFormiArray.splice(removeEmptySeat, 1);
                        }
                    });

                    // brisanje sedista
                    let removeSeat = sedistaUFormiArray.indexOf(chosenSeat);
                    sedistaUFormiArray.splice(removeSeat, 1);
                    formReservedSeats.value = sedistaUFormiArray;

                    // brisanje sedista UI
                    let sedistaUiString = reservedSeatsUI.innerText;
                    let sedistaUiArray = sedistaUiString.split(',');

                    $.each(sedistaUiArray, function(i, item) {
                        if (item === '') {
                            let removeEmptySeat = sedistaUiArray.indexOf(item);
                            sedistaUiArray.splice(removeEmptySeat, 1);
                        }
                    });

                    let removeUiSeat = sedistaUFormiArray.indexOf(chosenSeat);
                    sedistaUiArray.splice(removeUiSeat, 1);
                    reservedSeatsText.innerText = 'Reserved seats:';
                    reservedSeatsUI.innerText = sedistaUiArray;

                    seat.style.backgroundColor = 'rgb(255, 255, 255)';
                }
            }
        })



        $(document).on('click', '#button_inc', function() {
            let ticketQuantity = document.getElementById('ticket_quantity');
            let price = document.getElementById('price');
            let userPrice = document.getElementById('user_price');
            let total_price = document.getElementById('total_price');

            let currentAmount = Number(ticketQuantity.innerHTML);
            let currentPrice = Number(price.innerHTML);
            let currentUserPrice = Number(userPrice.innerHTML);

            ticketQuantity.innerHTML = currentAmount + 1;
            userPrice.innerHTML = currentUserPrice + currentPrice;
            total_price.value = currentUserPrice + currentPrice;
        });

        $(document).on('click', '#button_dec', function() {
            let ticketQuantity = document.getElementById('ticket_quantity');
            let price = document.getElementById('price');
            let userPrice = document.getElementById('user_price');
            let total_price = document.getElementById('total_price');

            let currentAmount = Number(ticketQuantity.innerHTML);
            let currentPrice = Number(price.innerHTML);
            let currentUserPrice = Number(userPrice.innerHTML);

            ticketQuantity.innerHTML = currentAmount - 1;

            if (ticketQuantity.innerHTML < 1) {
                ticketQuantity.innerHTML = 1;
            }

            userPrice.innerHTML = currentUserPrice - currentPrice;
            total_price.value = currentUserPrice - currentPrice;

            if (Number(userPrice.innerHTML) < currentPrice) {
                userPrice.innerHTML = currentPrice;
                total_price.value = currentPrice;
            }
        });

    });
</script>
