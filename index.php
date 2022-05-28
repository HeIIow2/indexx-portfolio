<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>All my Projects</title>

    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<body>
<header>
    <h1>Hellow2</h1>

    <button onclick="toggle()" class="push">Theme</button>
</header>

<div class="container">
    <?php
    function write_to_console($data)
    {
        $console = $data;
        if (is_array($console))
            $console = implode(',', $console);

        echo "<script>console.log('Console: " . $console . "' );</script>";
    }

    function add_file($echo_string, $path, $name)
    {
        $echo_string = $echo_string . "<hr>";
        $echo_string = $echo_string . "<div class=\"row\">";
        $echo_string = $echo_string . "<a href=\"" . $path . "\">" . $name . "</a>";
        // $echo_string = $echo_string . "<br>";
        $echo_string = $echo_string . "<p class=\"secondary\">" . date("d F Y", filemtime($path)) . "</p>";
        $echo_string = $echo_string . "</div>";


        return $echo_string;
    }

    function add_folder($echo_str, $path, $name, $pre_name = "")
    {
        $iframe = false;

        if ($name == "." or $name == "..") {
            return $echo_str;
        }

        $child_files = scandir($path);

        if (in_array("keywords.txt", $child_files)) {
            $keywords_str = file_get_contents($path . "/keywords.txt");
            $keywords = explode(",", $keywords_str);
            if (in_array("hidden", $keywords)) {
                return $echo_str;
            }
            if (in_array("project", $keywords)) {
                if (!(in_array("index.html", $child_files) || in_array("index.php", $child_files))) {
                    foreach ($child_files as $child_file) {
                        if (is_dir($path . "/" . $child_file)) {
                            $echo_str = add_folder($echo_str, $path . "/" . $child_file, $child_file, $pre_name = $name . " - ");
                        }
                    }
                    return $echo_str;
                }
            }
            if (in_array("iframe", $keywords)) {
                $iframe = true;
            }
        }

        if (!(in_array("index.html", $child_files) || in_array("index.php", $child_files))) {
            return $echo_str;
        }

        $echo_str = $echo_str . "
			<div class=\"textbox\">
				<h1><a target='_blank' href=" . $path . ">" . $pre_name . str_replace("_", " ", $name) . "</a></h1>
			";

        if ($iframe) {
            $echo_str = $echo_str . "
            <div class='iframe-wrapper'><iframe src='" . $path . "'></iframe></div>
            ";
        }

        if (in_array("readme.html", $child_files)) {
            $echo_str = $echo_str . "
			<hr>
			<div class='description'>
			";

            $description_html = file_get_contents($path . "/readme.html");
            write_to_console($description_html);

            $echo_str = $echo_str . $description_html;

            $echo_str = $echo_str . "
			</div>
			";
        }

        $echo_str = $echo_str . "
			</div>
			";


        return $echo_str;
    }

    function add_thing($echo_str, $path, $name)
    {
        if (is_dir($path . "/" . $name)) {
            $echo_str = add_folder($echo_str, $path . "/" . $name, $name);
        } else {
            $echo_str = add_file($echo_str, $path, $name);
        }

        return $echo_str;
    }

    $root_dir = "../";

    $files = scandir($root_dir);
    $echo_str = "";
    $mist_echo_str = "";

    foreach ($files as $file) {
        if (is_dir($root_dir . "/" . $file)) {
            $echo_str = add_thing($echo_str, $root_dir, $file);
        } else {
            //$mist_echo_str = add_file($mist_echo_str, $root_dir, $file);
        }
    }
    /*
        $echo_str = $echo_str . "
                <div class=\"textbox\">
                    <h1>Misc-Files</h1>
                ";

        $echo_str = $echo_str . $mist_echo_str;

        $echo_str = $echo_str . "
                </div>
                ";
    */
    echo $echo_str;
    ?>
</div>

<div id="popup-container">
    <img src="assets/img/among-us.png" class="hide" id="popup">
</div>

<span id="copyright">
© Lars Noack
</span>

<script src="js/app.js"></script>
<script src="js/popup.js"></script>
</body>
</html>
