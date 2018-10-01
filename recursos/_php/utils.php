<?php
function dump($data){
    echo "<PRE>";
    var_dump($data);
    echo "</PRE>";
    }         
    function refresh(){
        $self = $_SERVER['PHP_SELF']; //Obtenemos la página en la que nos encontramos
        header("url=$self"); //Refrescamos
        }
         
