<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $title ?></title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link href="<?= $style ?>" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
  </head>
  <body>
  <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
          <div class="navbar-header">
              <a class="navbar-brand" href="/">Bbc MVC</a>
          </div>
          <div id="navbar" class="collapse navbar-collapse">
              <ul class="nav navbar-nav">
                  <li><a href="/">Home</a></li>
                  <li><a href="/user">Benutzer</a></li>
                  <li><a href="/gallery">Gallery</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                  <li><a href="/user/create"><span class="glyphicon glyphicon-user"></span> Registrieren</a></li>
                  <li><a href="/user/login"><span class="glyphicon glyphicon-log-in"></span> Anmelden</a></li>
              </ul>
          </div>
      </div>
  </nav>
  <div class="container">