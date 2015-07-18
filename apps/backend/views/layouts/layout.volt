<!DOCTYPE html>
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="description" content="DigitalKrikits"/>
    {{ this.assets.outputCss() }}
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    {{ get_title() }}
</head>
<body>
<div class="container">
    {{ partial('partials/header') }}
    <div class="container-fluid content">
        {{ this.flashSession.output() }}
        {{ content() }}
    </div>
</div>
{{ this.assets.outputJs() }}
{% block scripts %} {% endblock %}
</body>
</html>