<?php
    // Load file
    require_once('embed.php');

    // Call class
    $embed = new Embed('html/index.html');

    // Data given to parser
    $data = [
        "title" => "test",
        "test" => [
            2 => "test",
            3 => [
                "test" => "MMMMM butter"
            ],
            4 => "item"
        ]
    ];

    // Run parser
    $embed->callFile($data);
?>