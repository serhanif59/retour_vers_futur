<?php
$presentTime = new DateTime();
$strPresentTime =  $presentTime->format('M/d/Y A h:i');
$arrayPresTime = explode(" ", $strPresentTime);
$presentElts = array();
$presentElts =  array_merge(explode("/", $arrayPresTime[0]), [$arrayPresTime[1]], explode(":", $arrayPresTime[2]));
$destElts = ["???", "??", "????", "AM", "??", "??"];
$arrayDiffDate = ["?", "?", "?", "?", "?"];
$DiffDateMinutes = 0;
$fuel = 0;
$errors = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dateStr = $_POST['year'] . "-" . $_POST['month'] .
        "-" . $_POST['day'] . " " . $_POST['hour'] . ":" . $_POST['minutes'] .
        ($_POST['format'] == "AM" ? "AM" : "PM");

    try {
        $destinationTime = new DateTime($dateStr);
        $diffDate = $destinationTime->diff($presentTime);
        $strDiffDate = $diffDate->format("%y %m %d %h %i %s");
        $strDiffDateMinutes = $diffDate->format("%a %h %i");
        $arrayDiffDateMinutes = explode(" ", $strDiffDateMinutes);
        $DiffDateMinutes = (intval($arrayDiffDateMinutes[0]) * 24 + intval($arrayDiffDateMinutes[1])) * 60 + intval($arrayDiffDateMinutes[2]);
        $fuel =  intdiv($DiffDateMinutes, 10000) + 1;
        $arrayDiffDate = explode(" ", $strDiffDate);
        $strdestinationTime = $destinationTime->format('M/d/Y A h:i');
        $arrayDestTime = explode(" ", $strdestinationTime);
        $destElts = array();
        $destElts =  array_merge(explode("/", $arrayDestTime[0]), [$arrayDestTime[1]], explode(":", $arrayDestTime[2]));
    } catch (Exception $err) {
        $errors[] = "Error format date";
    }
}
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form action="" method="POST">
        <h3>Enter You Destination Time</h3>
        <table>
            <tr>
                <td>
                    Month
                </td>
                <td>
                    <select name="month">
                        <option value="JAN">Jannuary</option>
                        <option value="FEB">February</option>
                        <option value="MAR">March</option>
                        <option value="APR">April</option>
                        <option value="MAY">May</option>
                        <option value="JUN">June</option>
                        <option value="JUL">July</option>
                        <option value="AUG">August</option>
                        <option value="SEP">September</option>
                        <option value="OCT">October</option>
                        <option value="NOV">November</option>
                        <option value="DEC">December</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Day
                </td>
                <td>
                    <input type="text" name="day" placeholder="DD" minlength="2" maxlength="2" required>
                </td>
            </tr>
            <tr>
                <td>
                    Year
                </td>
                <td>
                    <input type="text" name="year" placeholder="YYYY" minlength="4" maxlength="4" required>
                </td>
            </tr>
            <tr>
                <td>
                    Fmt
                </td>
                <td>
                    <fieldset>
                        <label for="am">AM</label>
                        <input type="radio" id="AM" name="format" value="AM" checked required>
                        <label for="pm">PM</label>
                        <input type="radio" id="PM" name="format" value="PM" required>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <td>
                    Hour
                </td>
                <td>
                    <input type="text" name="hour" placeholder="hh" minlength="2" maxlength="2" required>
                </td>
            </tr>
            <tr>
                <td>
                    Minutes
                </td>
                <td>
                    <input type="text" name="minutes" placeholder="mm" minlength="2" maxlength="2" required>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" value="Confirm the destination hour">
                </td>
            </tr>
        </table>
        <p>
            <?php foreach ($errors as $err) : ?>
                <?= $err ?><br>
            <?php endforeach ?>
        </p>
    </form>
    <div id="result-bonus">
        <div id="countdown">
            <div id="nowMonth">
                <?= strtoupper($presentElts[0]); ?>
            </div>
            <div id="nowDay">
                <?= strtoupper($presentElts[1]); ?>
            </div>
            <div id="nowYear">
                <?= strtoupper($presentElts[2]); ?>
            </div>
            <div id="nowHour">
                <?= strtoupper($presentElts[4]); ?>
            </div>
            <div id="nowMin">
                <?= strtoupper($presentElts[5]); ?>
            </div>
            <div id="destMonth">
                <?= strtoupper($destElts[0]); ?>
            </div>
            <div id="destDay">
                <?= strtoupper($destElts[1]); ?>
            </div>
            <div id="destYear">
                <?= strtoupper($destElts[2]); ?>
            </div>

            <div id="destHour">
                <?= strtoupper($destElts[4]); ?>
            </div>
            <div id="destMin">
                <?= strtoupper($destElts[5]); ?>
            </div>

            <div class="destAM <?= $destElts[3]  === "AM" ? "on" : ""; ?>">
            </div>
            <div class="destPM <?= $destElts[3]  === "AM" ? "" : "on"; ?>">
            </div>
            <div class="nowAM <?= $presentElts[3]  === "AM" ? "on" : ""; ?>">
            </div>
            <div class="nowPM <?= $presentElts[3] === "AM" ? "" : "on"; ?>">
            </div>
        </div>

        <table id="table-result">
            <tr>
                <td>
                    Travel Time (Y M D h m)
                </td>
                <td>
                    Travel Time (in Minutes)
                </td>
                <td>
                    Fuel (in Liters)
                </td>
            </tr>
            <tr>
                <td>
                    <?= $arrayDiffDate[0] . " years " . $arrayDiffDate[1] . " months " . $arrayDiffDate[2] . " days " . $arrayDiffDate[3] . " hours " . $arrayDiffDate[4] . " minutes " ?>
                </td>
                <td>
                    <?= $DiffDateMinutes . " minutes" ?>
                </td>
                <td>
                    <?= $fuel . " liters" ?>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>