<!doctype html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<style>
			:root {
				--button-color			: #5065FF;
				--button-hover-color	: #3244c2;
				--font-color			: white;
				--background-color		: black;
				
				--font-size: calc(1rem);
			}
			
			html { height: 100% }
			body {
				margin: 0;
				background-color: var(--background-color);
				height: 100%;
			}
			
			main {
				display: flex;
				justify-content: center;
				align-items: center;
				
				height: 100%;
				width: 100%;
			}
			
			button {
				background-color: var(--button-color);
				border: none;
				border-radius: 50px;
				padding: .5em 1em;
				margin-bottom: .3em;
				
				font-weight: 700;
				color: var(--font-color);
				font-size: var(--font-size);
				
				float: right;
				
				cursor: pointer;
			}
			
			button:hover {
				background-color: var(--button-hover-color);
			}
			
			button span {
				background-color: var(--font-color);
				color: var(--button-color);
				
				padding: 0.1em .25em 0.1em .25em;
				border-radius: 5px;
			}
		</style>
	</head>
	<body>
		<main>
			<?php
			// -- Functions -- //

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
					echo '<button type="submit" name="'.$button["id"].'" value="'.$button["name"].'">'.$button["name"].' <span>'.$button["number"].'</span></button><br>';
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

			<?php
			// -- Buttons -- //
			
				foreach (importCSV("buttons.csv") as $button) {
					if (isset($_POST[$button["id"]])) {
						updateCount($button, "buttons.csv");
					}
				}

				showButtons(importCSV("buttons.csv"));
			?>
		</main>
	</body>
</html>