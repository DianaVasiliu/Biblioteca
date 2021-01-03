<!DOCTYPE html>
<html>
  <head>
      <style>
        h2, .content-container {
          text-align: center;
        }
      </style>
  </head>
  <body>
      <h2>RECOMANDĂRI <a href="https://www.elefant.ro" style="color: black;"> elefant.ro</a></h2>
      <br>
      <hr>
      <br>
<?php
    $url = file_get_contents('https://www.elefant.ro/hp-carte');

    $content = explode('RECOMANDARI</h2></div>', $url);

    $contentbun = explode('<div id="Pagelet_MQoKKgAHZJIAAAFmwa8Nuosl"', $content[1]);

    $elemente = explode('href="', $contentbun[0]);


    for ($i = 0; $i < count($elemente); $i++) {
      echo $elemente[$i];

      if ($i != 3) {
        echo 'href="https://www.elefant.ro';
      }
      else {
        echo 'href="';
      }
    }
?>
  </body>
</html>