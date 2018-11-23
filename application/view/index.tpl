<!DOCTYPE html>
<html>
<head>
    {* Full base address *}
    <base href="{$request->getSchemeAndHttpHost()}/">

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title></title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {* Favicon *}
    <link href="web/static/images/favicon.ico" type="image/x-icon" rel="icon">
    <link href="web/static/images/favicon.ico" type="image/x-icon" rel="shortcut icon">

    {* JQuery *}
    <script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="web/static/js/scripts.js"></script>

    {* CSS *}
    <link href="web/static/css/style.css" rel="stylesheet">
</head>

<body>
    <header class="header">

    </header>

    {* Тело сайта *}
    <div id="fn_content">
        {$content}
    </div>

    <div class="to_top"></div>

    <footer class="footer">

    </footer>
</body>
</html>

