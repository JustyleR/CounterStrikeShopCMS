<?php

if (!defined('file_access')) {
    header('Location: home');
}

function main_info() {
    return array('pagination', 'cPage', '{NUMBER}');
}

function main() {
    $stuff = pagination('SELECT * FROM stuff');

    foreach ($stuff[1] as $item) {
        echo '[' . $item['stuff_id'] . '] &nbsp; &nbsp; &nbsp;' . $item['text'] . '<br />';
    }

    echo '<hr />';
    echo '<a href="'. url .'test/cPage/'. $stuff[0]['prev'] .'">Prev</a> | <a href="'. url .'test/cPage/'. $stuff[0]['next'] .'">Next</a>';
}