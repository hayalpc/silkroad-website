<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Helper::$TITLE ?></title>
    <link href="/panel/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/panel/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- Toastr style -->
    <link href="/panel/assets/css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <!-- Gritter -->
    <link href="/panel/assets/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
    <link href="/panel/assets/css/plugins/cropper/cropper.min.css" rel="stylesheet">
    <link href="/panel/assets/css/plugins/switchery/switchery.css" rel="stylesheet">
    <link href="/panel/assets/css/animate.css" rel="stylesheet">
    <link href="/panel/assets/css/style.css" rel="stylesheet">
    <link href="/panel/assets/css/custom.css" rel="stylesheet">
    <script src="/panel/assets/js/jquery-2.1.1.js"></script>
    <script src="/panel/assets/js/bootstrap.min.js"></script>
</head>
<body>

<?= $content ?>

<!-- Mainly scripts -->
<script src="/panel/assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/panel/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<!-- Flot -->
<script src="/panel/assets/js/plugins/flot/jquery.flot.js"></script>
<script src="/panel/assets/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="/panel/assets/js/plugins/flot/jquery.flot.spline.js"></script>
<script src="/panel/assets/js/plugins/flot/jquery.flot.resize.js"></script>
<script src="/panel/assets/js/plugins/flot/jquery.flot.pie.js"></script>
<!-- Peity -->
<script src="/panel/assets/js/plugins/peity/jquery.peity.min.js"></script>
<script src="/panel/assets/js/demo/peity-demo.js"></script>
<!-- Custom and plugin javascript -->
<script src="/panel/assets/js/inspinia.js"></script>
<script src="/panel/assets/js/plugins/pace/pace.min.js"></script>
<!-- jQuery UI -->
<script src="/panel/assets/js/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- GITTER -->
<script src="/panel/assets/js/plugins/gritter/jquery.gritter.min.js"></script>
<!-- Sparkline -->
<script src="/panel/assets/js/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- Sparkline demo data  -->
<script src="/panel/assets/js/demo/sparkline-demo.js"></script>
<!-- ChartJS-->
<script src="/panel/assets/js/plugins/chartJs/Chart.min.js"></script>
<script src="/panel/assets/js/plugins/toastr/toastr.min.js"></script>
<script src="/panel/assets/js/plugins/cropper/cropper.min.js"></script>
<script src="/panel/assets/js/plugins/switchery/switchery.js"></script>
<? renderPartial("/layouts/_flash", null, false, true) ?>
</body>
</html>