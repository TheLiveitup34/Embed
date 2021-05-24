<?php
    // Load file
    require_once('embed.php');

    // Call class
    $header = new Embed('html/header.html');

    // Data given to parser
    $data = [
        "title" => "example Site",
        "brand" => "Gallery Site"
    ];

    // Run parser
    $header->callFile($data);


    $card = new Embed('html/card.html');

    $data = [
        [
            "img" => "https://picsum.photos/1000/750",
            "name" => "Item 1"
        ],
        [
            "img" => "https://picsum.photos/1000/750",
            "name" => "Item 2"
        ],
        [
            "img" => "https://picsum.photos/1000/750",
            "name" => "Item 3"
        ],
        [
            "img" => "https://picsum.photos/1000/750",
            "name" => "Item 4"
        ],
        [
            "img" => "https://picsum.photos/1000/750",
            "name" => "Item 5"
        ],
        [
            "img" => "https://picsum.photos/1000/750",
            "name" => "Item 6"
        ]
        
    ];

    for($i = 0; $i < count($data); $i++) {
        $card->callFile($data[$i]);
    }

    $footer = new Embed('html/footer.html');

    $data = [];

    $footer->callFile($data);
