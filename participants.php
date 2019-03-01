<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script type="text/javascript" src="./assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="./assets/js/qrcode.js"></script>
    <script>
        function makeCode(text, qrId) {
            var qrcode = new QRCode(document.getElementById(qrId), {
                width: 100,
                height: 100,
                useSVG: true
            });
            qrcode.makeCode(text);
            return true;
        }

        function download(vsvg, vcan, vpng, id) {
            var svgString = new XMLSerializer().serializeToString(document.querySelector('#' + vsvg));
            console.log(svgString);
            var canvas = document.getElementById(vcan);
            var ctx = canvas.getContext("2d");
            console.log(ctx);
            var DOMURL = self.URL || self.webkitURL || self;
            var img = new Image();
            var svg = new Blob([svgString], {
                type: "image/svg+xml;charset=utf-8"
            });
            console.log(svg);
            var url = DOMURL.createObjectURL(svg);
            img.onload = function() {
                ctx.drawImage(img, 0, 0);
                var png = canvas.toDataURL("image/png");
                console.log(png);
                document.querySelector('#' + vpng).innerHTML = '<img src="' + png + '"/><a href="' + png + '" download="' + id + '.png" >Download</a>';
                DOMURL.revokeObjectURL(png);
            };
            img.src = url;
        }
    </script>
</head>

<body>
    <?php 
    require "config/config.php";
    $ptSql = "SELECT * FROM `participant`";
    $ptquery = mysqli_query($conn, $ptSql);
    while ($ptres = mysqli_fetch_array($ptquery)) {
        ?>
    <div>
        <div>
            <div>Participant ID :
                <?php echo $ptres['participantId']; ?>
            </div>
            <div>Name :
                <?php echo $ptres['firstName']; ?>
                <?php echo $ptres['lastName']; ?>
            </div>
            <div>Branch :
                <?php echo $ptres['branchId']; ?>
            </div>
        </div>
        <div>
            <div>QR code : </div>
            <div>
                <svg id="svg<?php echo $ptres['participantId']; ?>" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g id="qr<?php echo $ptres['participantId']; ?>" />
                </svg>
            </div>
            <div>
                <canvas style="display:none;" id="canvas<?php echo $ptres['participantId']; ?>" width="170" height="170"></canvas>
            </div>
            <div id="png-container<?php echo $ptres['participantId']; ?>"></div>
        </div>
    </div>
    <?php 
    echo "<script>makeCode('" . $ptres['qr'] . "','qr" . $ptres['participantId'] . "');</script>";
    echo "<script>download('svg" . $ptres['participantId'] . "','canvas" . $ptres['participantId'] . "','png-container" . $ptres['participantId'] . "','" . $ptres['participantId'] . "');</script>";
}
?>
</body>

</html> 