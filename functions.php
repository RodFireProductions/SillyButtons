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
    echo '<form enctype="multipart/form-data" action="/" method="post">';
    foreach ($buttons as $button) {
        echo '<button type="submit" name="'.$button["id"].'" value="'.$button["name"].'">'.$button["name"].": ".$button["number"].'</button>';
    }
    echo "</form>";
}

function updateCount($button, $filepath) {
    $temp_file = fopen("temp.csv", "w");
    $file = fopen($filepath, "r");
    $buttons = importCSV($filepath);

    fputcsv($temp_file, array_keys($buttons[0]));
    try {
        foreach ($buttons as $b) {
            if ($button["id"] == $b["id"]) {
                $button["number"] += 1;
                fputcsv($temp_file, $button);
            } else {
                fputcsv($temp_file, $b);
            }
        }
    } catch (Exception $error) {
        echo $error->getMessage();
    }

    fclose($temp_file);
    fclose($file);
    rename("temp.csv", $filepath);
}

?>
