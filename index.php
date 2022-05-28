<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>All my Projects</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://ln.topdf.de/web_framework/css/styles.css">
    <script src="https://ln.topdf.de/web_framework/js/marked.min.js"></script>
    <script type="module" src="https://ln.topdf.de/web_framework/js/index.js"></script>
</head>

<body>
<header>
    <h1>Hellow2</h1>

    <button class="push theme-button">Theme</button>
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

    function add_folder($echo_str, $path, $name, $pre_name = "")
    {
        if ($name == "." or $name == "..") {
            return $echo_str;
        }

        $child_files = scandir($path);

        if (!in_array("readme.html", $child_files)) {
            return $echo_str;
        }

        if (!(in_array("index.html", $child_files) || in_array("index.php", $child_files))) {
            return $echo_str;
        }

        $description_html = file_get_contents($path . "/readme.html");

        $echo_str = $echo_str . "
			<div class=\"textbox\">
				<h1><a href=" . $path . ">" . $pre_name . str_replace("_", " ", $name) . "</a></h1>
			    <hr>" .$description_html . "
			</div>
			";

        return $echo_str;
    }

    function add_thing($echo_str, $path, $name)
    {
        if (is_dir($path . "/" . $name)) {
            $echo_str = add_folder($echo_str, $path . "/" . $name, $name);
        }

        return $echo_str;
    }


    $root_dir = "../";

    // $files = scandir($root_dir, $sorting_order = SCANDIR_SORT_NONE);

    // https://gist.github.com/gourneau/1415698
    $files = array();
    $dir = new DirectoryIterator($root_dir);

    foreach ($dir as $fileinfo) {
        $files[$fileinfo->getMTime()] = $fileinfo->getFilename();
    }

    //krsort will sort in reverse order
    krsort($files);

    $echo_str = "";
    $mist_echo_str = "";

    foreach ($files as $file) {
        if (is_dir($root_dir . "/" . $file)) {
            $echo_str = add_thing($echo_str, $root_dir, $file);
        }
    }

    echo $echo_str;
    ?>
</div>

<span id="copyright">
© Lars Noack
</span>

</body>
</html>
