<?php
    // Load file
    require_once('embed.php');

    // Create new embed object
    $embed = new Embed('templates/pages/index.tpl');

    if ($embed) {
        // Call file with data
        $embed->callFile([
            'login' => false,
            'title' => 'Hello World',
            'brand' => 'My Website',
            'content' => 'This is a test',
            'items' => [
                [
                    'name' => 'Item 1',
                    'img' => "https://picsum.photos/1000/750?1"
                ],
                [
                    'name' => 'Item 2',
                    'img' => "https://picsum.photos/1000/750?2"
                ],
                [
                    'name' => 'Item 3',
                    'img' => "https://picsum.photos/1000/750?3"
                ],
                [
                    'name' => 'Item 4',
                    'img' => "https://picsum.photos/1000/750?4"
                ],
                [
                    'name' => 'Item 5',
                    'img' => "https://picsum.photos/1000/750?5"
                ],
                [
                    'name' => 'Item 6',
                    'img' => "https://picsum.photos/1000/750?6"
                ]
            ]
        ]);
    }