<?php
    // Load file
    require_once('embed.php');
    // Call class
    $embed = new Embed();
    // Data given to parser
    $data = [
        "title" => "test",
        "test" => [
            2 => "test",
            4 => "item"
        ]
    ];
    // Run parser
    $embed->callFile('html/index.html', $data);
?>