<?php
$json = file_get_contents('data.json');
$array = json_decode($json, true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="0">
    <title>Trinitiland</title>
    <link rel="stylesheet" href="./assets/css/main/app.css">
    <link rel="stylesheet" href="./assets/css/pages/auth.css">
    <link rel="icon" href="https://trinitiland.com/uploads/2022/10/cropped-7c4ce074ba092be0c80d3323b1041cda-32x32.png" sizes="32x32" />
    <link rel="icon" href="https://trinitiland.com/uploads/2022/10/cropped-7c4ce074ba092be0c80d3323b1041cda-192x192.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://trinitiland.com/uploads/2022/10/cropped-7c4ce074ba092be0c80d3323b1041cda-180x180.png" />
</head>

<body>
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">

                    <?php
                    $i = 0;
                    foreach ($array as $data) {
                    ?>
                        <a href="<?= $data['url'] ?>" class="btn btn-primary btn-block shadow-lg mt-2 btn-lg" style="color:black; font-weight: bold;" target="_blank"><?= $data['nama'] ?></a>
                    <?php
                        $i++;
                    }
                    ?>

                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">
                </div>
            </div>
        </div>

    </div>
</body>

</html>