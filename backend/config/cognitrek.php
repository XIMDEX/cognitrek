<?php

return [
    'html_template' =>  <<<HTML

<!DOCTYPE html>
<html lang="###_XIMDEX_LANG_###">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>###XIMDEX_TITLE###</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            border: 0;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100dvh;
            width: 100dvw;
            overflow-x: hidden;
            background-color: #f0f0f0;

        }
        section {
            width: ###XIMDEX_WIDTH###;
            height: ###XIMDEX_HEIGHT###;
            position: relative;
            background-color: white;
        }
    </style>
</head>
<body>
    <section>
        ###XIMDEX_CONTENT###
    </section>
</body>
</html>
HTML,
   'name' => 'CogniTrek',
   'version' => '1.0.0',
];
