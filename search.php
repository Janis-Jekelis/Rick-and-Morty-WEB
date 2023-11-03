<?php
var_dump(var_dump($_POST['episodes']));
file_put_contents('search.json', json_encode($_POST['episodes']));
echo header('Location: http://' . $_SERVER["HTTP_HOST"] . "/search");

