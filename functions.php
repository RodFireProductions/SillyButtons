<?php

function importCSV($filepath) {
    $button = [];
    $csv = fopen($filepath, "r");
    while ($values = fgetcsv($csv)) {
        $button[] = $values;
    }
    fclose($csv);

    $keys = array_shift($button);
    $buttons = [];
    foreach ($button as $values) {
        $buttons[] = array_combine($keys, $values);
    }

    return $buttons;
}

function showButtons($buttons) {
    echo "<section>";
    foreach ($buttons as $button) {
        echo '<button type="button">'.$button["name"].": ".$button["number"]."</button>";
    }
    echo "</section>";
}


?>