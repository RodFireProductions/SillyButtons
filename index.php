<?php
    include "functions.php";

    foreach (importCSV("buttons.csv") as $button) {
        if (isset($_POST[$button["id"]])) {
            updateCount($button, "buttons.csv");
        }
    }

    showButtons(importCSV("buttons.csv"));
?>
