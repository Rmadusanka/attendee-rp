<!DOCTYPE html>
<html>

<head>
    <title>JQuery HTML5 QR Code Scanner using Instascan JS Example - ItSolutionStuff.com</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
</head>

<body>

    <h1>JQuery HTML5 QR Code Scanner using Instascan JS Example - ItSolutionStuff.com</h1>

    <video id="preview"></video>
    <script type="text/javascript">
        let scanner = new Instascan.Scanner({
            video: document.getElementById('preview')
        });
        scanner.addListener('scan', function(content) {
            alert(content);
            console.log(content);
            $.ajax({
                type: "POST",
                data: {
                    data: content
                },
                url: "./scripts/attendance.php",
                success: function(data) {
                    //data will contain the vote count echoed by the controller i.e.  
                    console.log(data);
                    //then append the result where ever you want like
                    $("span#votes_number").html(data); //data will be containing the vote count which you have echoed from the controller

                }
            });
        });
        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function(e) {
            console.error(e);
        });
    </script>

</body>

</html> 