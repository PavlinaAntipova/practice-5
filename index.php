<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Practice 5. PHP</title>
    <style>
        .double {
            font-weight: 700;
            color: red;
        }

        .table,
        .table tr,
        .table th,
        .table td {
            border: 1px solid black;
        }

        .chessboard {
            display: grid;
            grid-template-columns: auto auto;
            grid-template-rows: auto auto;
            width: fit-content;
            gap: 7px;
        }

        .tiles {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            grid-template-rows: repeat(8, 1fr);
            width: fit-content;
        }

        .tiles div {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 30px;
            height: 30px;
            background-color: wheat;
        }

        .tiles .dark {
            background-color: grey;
        }

        .cols {
            display: flex;
            grid-column: 2 / 3;
            justify-content: space-around;
        }

        .rows {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
        }
    </style>
</head>

<body>
    <header>
        <h1>Practice 5. PHP</h1>
        <p>Автор: Pavlina Antipova</p>
        <p>Варіант: 6</p>
    </header>

    <main>
        <section>
            <h2>Task 1</h2>
            <p>Номер квитка складається із 4 цифр, а у «щасливому квитку» різниця двох перших чисел номера
                дорівнює різниці двох інших.</p>
            <p>Щасливі номери квитків:</p>


            <?php
            define("MAX_TICKET_NUMBER", 9999);
            $countLuckyTickets = 0;

            for ($i = 0; $i <= MAX_TICKET_NUMBER; $i++) {
                if (isTicketLucky($i)) {
                    $countLuckyTickets++;
                    echo formatTicketNumber($i) . " ";
                }
            }
            ?>
            <p>Всього щасливих квитків: <?php echo $countLuckyTickets; ?></p>
            <p>Імовірність отримання щасливого квитка: <?php echo $countLuckyTickets / (MAX_TICKET_NUMBER + 1); ?></p>


        </section>
        <section>
            <h2>Task 2</h2>
            <p>У таблиці повинні бути комірки із даними для результатів множення для чисел від 1 до 9 усіх крім
                4. У кожному із стовпців повинен бути пропущений рядок множення на 2. Усі двозначні числа у
                таблиці множення повинні бути виділені жирним стилем шрифту та червоним кольором.</p>
            <?php
            $exeptionCol = 4;
            $exeptionRow = 2;
            $startColValue = 1;
            $endColValue = 9;
            $startRowValue = 1;
            $endRowValue = 9;
            ?>
            <table class="table">
                <thead>
                    <?php
                    echo getHeadingRow($startColValue, $endColValue, $exeptionCol);
                    ?>
                </thead>
                <tbody>
                    <?php
                    echo getBodyRow($startColValue, $endColValue, $exeptionCol, $startRowValue, $endRowValue, $exeptionRow);
                    ?>
                </tbody>
            </table>
        </section>
        <section>
            <?php
            define("BOARD_SIZE", 8);
            define("COLUMNS_NAMES", "abcdefgh");
            $currentPosition = getRandomPosition();
            $targetPosition = getRandomPosition();
            ?>
            <h2>Task 3</h2>
            <p>Хід тури.</p>
            <p>Теперішня позиція тури: <?php echo $currentPosition ?></p>
            <p>Бажана позиція тури: <?php echo $targetPosition ?></p>
            <p>Висновок. Запропонованний хід <?php echo isMovellowed($currentPosition, $targetPosition) ? 'можливий' : 'неможливий' ?>.</p>

            <div class="chessboard">
                <div class="rows"><?php echo getRowsTitles() ?></div>
                <div class="tiles"><?php echo getBoardTiles($currentPosition, $targetPosition) ?></div>
                <div class="cols"><?php echo getColsTitles() ?></div>
            </div>
        </section>
    </main>

    <?php

    function isMovellowed($currentPosition, $targetPosition)
    {
        if ($currentPosition == $targetPosition) {
            return false;
        }

        if (getPositionRowNumber($currentPosition) == getPositionRowNumber($targetPosition)) {
            return true;
        }

        if (getPositionColNumber($currentPosition) == getPositionColNumber($targetPosition)) {
            return true;
        }

        return false;
    }

    function getBoardTiles($currentPosition, $targetPosition)
    {
        $titles = "";
        $content = "";
        for ($row = BOARD_SIZE; $row >= 1; $row--) {
            for ($col = 1; $col <= strlen(COLUMNS_NAMES); $col++) {
                $content = "";
                if ($row == getPositionRowNumber($currentPosition) && $col == getPositionColNumber($currentPosition)) {
                    $content .= "R";
                }

                if ($row == getPositionRowNumber($targetPosition) && $col == getPositionColNumber($targetPosition)) {
                    $content .= "t";
                }

                if (($row + $col) % 2 == 0) {
                    $titles .= getTile(true, $content);
                } else {
                    $titles .= getTile(false, $content);
                }
            }
        }

        return $titles;
    }

    function getPositionRowNumber($position)
    {
        return intval(substr($position, 1, 1));
    }

    function getPositionColNumber($position)
    {
        return strpos(COLUMNS_NAMES, substr($position, 0, 1)) + 1;
    }

    function getColsTitles()
    {
        $titles = "";
        for ($col = 0; $col < strlen(COLUMNS_NAMES); $col++) {
            $titles .= "<div>" . substr(COLUMNS_NAMES, $col, 1) . "</div>";
        }

        return $titles;
    }

    function getRowsTitles()
    {
        $titles = "";
        for ($row = BOARD_SIZE; $row >= 1; $row--) {
            $titles .= "<div>$row</div>";
        }

        return $titles;
    }


    function getTile($dark, $piece)
    {
        if ($dark) {
            return "<div class='dark'>$piece</div>";
        } else {
            return "<div>$piece</div>";
        }
    }

    function getRandomPosition()
    {
        $col = substr(COLUMNS_NAMES, rand(0, strlen(COLUMNS_NAMES) - 1), 1);
        $row = rand(1, BOARD_SIZE);
        return $col . $row;
    }

    function getBodyRow($colStart, $colEnd, $colException, $rowStart, $rowEnd, $rowException)
    {
        $row = "<tr>";
        for ($col = $colStart; $col <= $colEnd; $col++) {
            if ($col == $colException) {
                continue;
            }
            $row .= getBodyCell($col, $rowStart, $rowEnd, $rowException);
        }
        return $row . "</tr>";
    }

    function getBodyCell($headingValue, $start, $end, $exception)
    {
        $cell = "<td>";
        for ($i = $start; $i <= $end; $i++) {
            if ($i == $exception) {
                continue;
            }
            $cell .= getCellLine($headingValue, $i) . "<br/>";
        }
        return $cell . "</td>";
    }


    function getHeadingRow($start, $end, $exception)
    {
        $row = "<tr>";

        for ($i = $start; $i <= $end; $i++) {
            if ($i == $exception) {
                continue;
            }
            $row .= "<th>" . formatDoubleNumber($i) . "</th>";
        }

        return $row . "</tr>";
    }
    function getCellLine($number1, $number2)
    {
        return formatDoubleNumber($number1) . " x " . formatDoubleNumber($number2) . " = " . formatDoubleNumber($number1 * $number2);
    }

    function formatDoubleNumber($number)
    {
        if (strlen($number) == 2) {
            return "<span class='double'>$number</span>";
        } else {
            return $number;
        }
    }
    function isTicketLucky($ticketNumber)
    {
        $ticketNumber = formatTicketNumber($ticketNumber);
        $diffLeft = substr($ticketNumber, 0, 1) - substr($ticketNumber, 1, 1);
        $diffRight = substr($ticketNumber, 2, 1) - substr($ticketNumber, 3, 1);
        if ($diffLeft == $diffRight) {
            return true;
        } else {
            return false;
        }
    }

    function formatTicketNumber($ticketNumber)
    {
        return str_pad(
            $ticketNumber,
            strlen(MAX_TICKET_NUMBER),
            0,
            STR_PAD_LEFT
        );
    }
    ?>
</body>

</html>