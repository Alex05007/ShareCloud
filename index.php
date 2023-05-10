<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no, minimum-scale=1" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<?php if (isset($_GET['id'])) { ?>

    <?php
        if (!is_dir($_GET['id'])) {
            header("Location: ../share/?error=id_not_exists");
            die();
        }
    ?>

    <?php
        function compress($source, $destination, $quality) {
            $info = getimagesize($source);
            if ($info['mime'] == 'image/jpeg') 
                $image = imagecreatefromjpeg($source);
            elseif ($info['mime'] == 'image/gif') 
                $image = imagecreatefromgif($source);
            elseif ($info['mime'] == 'image/png') 
                $image = imagecreatefrompng($source);
            imagejpeg($image, $destination, $quality);
            return $destination;
        }

        $filesRaw = scandir($_GET['id']);
        $files = array();
        foreach ($filesRaw as $i) {
            if (@is_array(getimagesize($_GET['id'] . '/' . $i)))
                $files[] = $i;
        }
        $f = "";
        for ($i = 0; $i < count($files) - 1; $i++)
            $f .= '"' . $files[$i] . '",';
        $f .= '"' . $files[count($files) - 1] . '"';

        if (!is_dir($_GET['id'] . "/thub")) {
            mkdir($_GET['id'] . "/thub", 0777);
            for ($i = 0; $i < count($files); $i++)
                imagejpeg(imagecreatefromjpeg($_GET['id'] . '/' . $files[$i]), $_GET['id'] . "/thub/" . $files[$i], 75);
        }
    ?>

    <script>
        const files = [<?php echo $f; ?>];
        const id = "<?php echo $_GET['id']; ?>";
        var maxFiles = <?php echo count($files) - 1; ?>;
    </script>

    <script src="script.js"></script>

    <body onload="firstFile();">

        <div class="top-bar">
            <h4 id="name"></h4>
        </div>

        <div class="content">
            <a href="javascript:next()" class="control" id="next">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M52.5 440.6c-9.5 7.9-22.8 9.7-34.1 4.4S0 428.4 0 416V96C0 83.6 7.2 72.3 18.4 67s24.5-3.6 34.1 4.4L224 214.3V256v41.7L52.5 440.6zM256 352V256 128 96c0-12.4 7.2-23.7 18.4-29s24.5-3.6 34.1 4.4l192 160c7.3 6.1 11.5 15.1 11.5 24.6s-4.2 18.5-11.5 24.6l-192 160c-9.5 7.9-22.8 9.7-34.1 4.4s-18.4-16.6-18.4-29V352z"/></svg>
            </a>
            <a href="javascript:prev()" class="control" id="prev">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M459.5 440.6c9.5 7.9 22.8 9.7 34.1 4.4s18.4-16.6 18.4-29V96c0-12.4-7.2-23.7-18.4-29s-24.5-3.6-34.1 4.4L288 214.3V256v41.7L459.5 440.6zM256 352V256 128 96c0-12.4-7.2-23.7-18.4-29s-24.5-3.6-34.1 4.4l-192 160C4.2 237.5 0 246.5 0 256s4.2 18.5 11.5 24.6l192 160c9.5 7.9 22.8 9.7 34.1 4.4s18.4-16.6 18.4-29V352z"/></svg>
            </a>
        </div>
        <div class="menu-bar">
            <a id="download" download>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32V274.7l-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7V32zM64 352c-35.3 0-64 28.7-64 64v32c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V416c0-35.3-28.7-64-64-64H346.5l-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352H64zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg>
            </a>
            <a href="<?php echo $_GET['id'] . "/" . $_GET['id'] . ".zip"; ?>" download>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM96 48c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16zm-6.3 71.8c3.7-14 16.4-23.8 30.9-23.8h14.8c14.5 0 27.2 9.7 30.9 23.8l23.5 88.2c1.4 5.4 2.1 10.9 2.1 16.4c0 35.2-28.8 63.7-64 63.7s-64-28.5-64-63.7c0-5.5 .7-11.1 2.1-16.4l23.5-88.2zM112 336c-8.8 0-16 7.2-16 16s7.2 16 16 16h32c8.8 0 16-7.2 16-16s-7.2-16-16-16H112z"/></svg>
            </a>
        </div>

        <div class="bottom-bar">
            <?php
                for ($i = 0; $i < count($files); $i++)
                    echo '<div class="thub" onClick="loadFile(' . $i . ');" style="background-image: url(\'' . $_GET['id'] . '/thub/' . $files[$i] . '\'); opacity: 1;"></div>';;
            ?>
        </div>

    </body>

<?php } else { ?>

    <link rel="stylesheet" href="https://gnets.myds.me/account/style.css">

    <style>
        input {
            background-color: transparent;
        }
        .sb {
            margin-bottom: -7px;
        }
    </style>

    <body>
        <div class="login-box">
            <div class="user-box" <?php if(isset($_GET['error'])) { echo "style='border: #ef233c 1px solid !important;'"; } ?>>
                <form id="form" action="../share" method="get">
                    <div class="input">
                        <input type='text' name="id" required placeholder = " "/>
                        <p>Enter Share ID</p>
                    </div>
                    <a class="sb" href="javascript:document.getElementById('form').submit();"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z"/></svg></a>
                </form>
            </div>
        </div>
    </body>

<?php } ?>
</html>