<?php
/** @var $params \app\models\SeatModel
 */

use app\core\Application;

/*
echo "<pre>";
var_dump($params->allSeats);
echo "</pre>";

echo "<pre>";
var_dump($params->reservedSeats);
echo "</pre>";
exit;
*/
?>

<div class="container m-0">
    <h3 class="font-weight-bolder text-dark text-gradient fs-2">Choose your seats</h3>
    <div class="row">
        <div class="col">
            <p class="text-danger">
                <?php
                if (Application::$app->session->get(Application::$app->session->USER_SESSION) === false) {
                    echo 'Morate da budete ulogovane da bi ste izvrsili rezervaciju!';
                }
                ?>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-sm w-auto">
                <?php

                $reservedSeatsInOrder = [];

                foreach ($params->reservedSeats as $reservedSeat) {
                    $reservedSeatsInOrder[] = intval($reservedSeat);
                }

                asort($reservedSeatsInOrder);

                foreach ($params->allSeats as $allSeat) {

                    $seatsNotInOrder = explode(",", $allSeat["number"]);

                    $seatsInOrder = [];

                    foreach ($seatsNotInOrder as $seatNotInOrder) {
                        $seatsInOrder[] = intval($seatNotInOrder);
                    }

                    asort($seatsInOrder);

                    echo '<tr class="rows">';
                    echo '<td class="text-danger pe-4">'. $allSeat["row"] .'</td>';

                    $helper = false;

                    foreach ($seatsInOrder as $seatInOrder) {
                        foreach ($reservedSeatsInOrder as $reservedSeat) {
                            if ($seatInOrder === $reservedSeat) {

                                $helper = true;
                                break;
                            }

                            $helper = false;
                        }

                        if ($helper) {
                            echo '<td class="text-center"><div class="p-2 border border-dark bg-dark" data-set="' . $seatInOrder . '"></div></td>';
                        } else {
                            echo '<td class="text-center"><div class="p-2 border border-dark seat-number" data-set="' . $seatInOrder . '"></div></td>';
                        }
                    }

                    echo '</tr>';

                }
                ?>
            </table>
        </div>
        <div class="col">
            <p id="price">Ticket price: <b><?php echo $params->price ?></b></p>
            <p id="total_price" class="fs-5"></p>
            <p id="reserved_seats_ui"></p>
        </div>
    </div>

    <form action="/reservationProcess" method="post" role="form">
        <input type="hidden" id="reserved_seats" name="reserved_seats">
        <input type="hidden" name="screening_id" value="<?php echo $params->screening_id ?>">
        <input type="hidden" id="total_price_form" name="total_price">
        <div class="row">
            <div class="col">
                <a href="/movies" class="btn btn-dark">Go back to all movies</a>
            </div>
            <div class="col">
                <button type="submit" class="btn bg-gradient-info">Make reservation</button>
            </div>
        </div>
    </form>
</div>




<script>

    const redovi = document.querySelectorAll('.rows');
    let allChosenSeats = [];

    console.log(redovi);

    redovi.forEach(red => {
        red.addEventListener('click', (e) => {
            const seat = e.target;
            const formReservedSeats = document.getElementById('reserved_seats');
            let totalPrice = document.getElementById('total_price');

            let priceString = document.getElementById('price').innerText;
            let priceArray = priceString.match(/\d+/);
            let price = priceArray[0];

            let reservedSeatsUI = document.getElementById('reserved_seats_ui');

            let totalPriceForm = document.getElementById('total_price_form');

            if (seat.classList.contains('seat-number')) {
                if (seat.style.backgroundColor !== 'rgb(255, 0, 0)') {

                    // brisanje sedista
                    let chosenSeat = seat.dataset;
                    allChosenSeats.push(chosenSeat.set);
                    formReservedSeats.value = allChosenSeats;

                    //total_price
                    totalPrice.innerText = 'Cena: RSD ' + price * allChosenSeats.length;

                    if (totalPrice.innerText === 'Cena: RSD 0') {
                        totalPrice.innerText = '';
                    }

                    totalPriceForm.value = price * allChosenSeats.length;

                    //rezervisana sedista
                    let reservisanaSedista = 'Sedista: ';
                    allChosenSeats.forEach(function (sediste) {
                        reservisanaSedista += sediste + ', ';
                    });
                    reservedSeatsUI.innerText = reservisanaSedista;

                    if (reservedSeatsUI.innerText === 'Sedista: ') {
                        reservedSeatsUI.innerText = '';
                    }

                    seat.style.backgroundColor = 'rgb(255, 0, 0)';
                } else {
                    let chosenSeat = seat.dataset;

                    // brisanje sedista
                    let removeSeat = allChosenSeats.indexOf(chosenSeat.set);
                    allChosenSeats.splice(removeSeat, 1);
                    formReservedSeats.value = allChosenSeats;

                    //total_price
                    totalPrice.innerText = 'Cena: RSD ' + price * allChosenSeats.length;

                    if (totalPrice.innerText === 'Cena: RSD 0') {
                        totalPrice.innerText = '';
                    }

                    totalPriceForm.value = price * allChosenSeats.length;

                    //rezervisana sedista
                    let reservisanaSedista = 'Sedista: ';
                    allChosenSeats.forEach(function (sediste) {
                        reservisanaSedista += sediste + ', ';
                    });
                    reservedSeatsUI.innerText = reservisanaSedista;

                    if (reservedSeatsUI.innerText === 'Sedista:') {
                        reservedSeatsUI.innerText = '';
                    }

                    seat.style.backgroundColor = 'rgb(255, 255, 255)';
                }

            }
        });
    });
</script>