<!DOCTYPE html>
<html lang=en>
<head>
    <meta charset=utf-8>
    <meta http-equiv=X-UA-Compatible content="IE=edge">
    <meta name=viewport content="width=device-width,initial-scale=1">
    <link rel=icon href=favicon.ico>
    <title>Суточный график</title>
    <link href=css/app.css rel=preload as=style>
    <link href=css/chunk-vendors.css rel=preload as=style>
    <link href=js/app.js rel=preload as=script>
    <link href=js/chunk-vendors.js rel=preload as=script>
    <link href=css/chunk-vendors.css rel=stylesheet>
    <link href=css/app.css rel=stylesheet>
</head>

<body><noscript><strong>We're sorry but vue-shipregs doesn't work properly without JavaScript enabled. Please enable it
            to continue.</strong></noscript>
    <div id=app></div>
    <script src=js/chunk-vendors.js> </script> <script src=js/app.js> </script>
    <script>
	window.onload = function name(params) {
		init_grafics ('../../db_grafics.php');
	}
	</script>
    </body> </html>