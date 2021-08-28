<?php 

if( !isset($_SESSION['active_routes']) || !isset($_SESSION['routes']) ){
    header('location: http://ministock.pt/');
    return;
}


function render_routes (){
    foreach ( $_SESSION['routes'] as $val){ 
        extract($val);
        $route_state =  $_SESSION['active_routes'] == $id ? 'ativo' : 'out';
    
        echo "
            <div  onclick='location.href=`$link`'  
                class='li-container ". $route_state ." '
            >
            <div>
                <label>
                <i class='$icon'></i>
                </label>
                <label>$text</label>
            </div>
            </div>
        ";
    } 
}

function get(){
    return $_SESSION['routes'][$_SESSION['active_routes']];
}

extract( get() );