<?php
    class Vista{
        static public function render($rutaVista, $datos=array()){
            include($rutaVista);
        }
    }
    
    
?>