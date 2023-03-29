<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />
    <title>{{ title }}</title>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection" />
</head>

<body>
    <nav class="light-blue lighten-1" role="navigation">
        <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">{{ brand }}</a>
            <ul class="right hide-on-med-and-down">
                {% if login == true %}
                    <li><a href="#">Logout</a></li>
                {% else %}
                    <li><a href="#">Login</a></li>
                {% endif %}
            </ul>

            <ul id="nav-mobile" class="sidenav">
                {% if login == true %}
                <li><a href="#">Logout</a></li>
                {% else %}
                <li><a href="#">Login</a></li>
                {% endif %}
            </ul>
            <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        </div>
    </nav>

    <div class="container section">
<div class="row">