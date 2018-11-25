<!DOCTYPE html>
<html>
<head>
    {* Full base address *}
    <base href="{$request->getSchemeAndHttpHost()}/">

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>{$title|escape}</title>
    <meta name="description" content="{$description|escape}" />
    <meta name="keywords" content="{$keywords|escape}" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {* Favicon *}
    <link href="static/images/favicon.ico" type="image/x-icon" rel="icon">
    <link href="static/images/favicon.ico" type="image/x-icon" rel="shortcut icon">

    {* JQuery *}
    <script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="{$config->get('buildHash')}/scripts.js"></script>

    {* CSS *}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link href="{$config->get('buildHash')}/style.css" rel="stylesheet">
</head>

<body>
    <header class="header">
        <nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand">Final project</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="/">Home</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    {* Тело сайта *}
    <div class="container">
        <div id="fn_content">
            {$content}
        </div>
    </div>

    <div class="to_top"></div>

    <footer class="footer">

    </footer>
</body>
</html>

