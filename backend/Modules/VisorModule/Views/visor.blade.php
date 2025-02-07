<!DOCTYPE html>
<html lang="{{ $resource['lang'] }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $resource['title'] }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        
        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
       
        @include('visor::styles.tailwindcss')
        @include('visor::styles.basic')
        @include('visor::styles.sidebar')

        @if(strpos($body_class, 'dyslexia') !== false) 
            @include('visor::styles.dyslexia')
        @endif
        @if (strpos($body_class, 'dyslexia') !== false)
            @include('visor::styles.dyslexia')
        @endif
        @if (strpos($body_class, 'attention_deficit') !== false)
            @include('visor::styles.attention_deficit')
        @endif
        @if (strpos($body_class, 'autism') !== false)
            @include('visor::styles.autism')
        @endif
        @if (strpos($body_class, 'visual_impairment') !== false)
            @include('visor::styles.visual_impairment')
        @endif
        @if (strpos($body_class, 'hearing_impairment') !== false)
            @include('visor::styles.hearing_impairment')
        @endif
        @if (strpos($body_class, 'language_disorder') !== false)
            @include('visor::styles.language_disorder')
        @endif

    </head>
    <body class="antialiased">

        <main class="flex-1 flex flex-col overflow-y-hidden main-content">

            <input type="file" id="imageUpload" class="image-upload" accept="image/*">
            
            @php
                ob_start();
            @endphp
            
            @include('visor::components.json2html')
            
            @php
                $editorContent = ob_get_clean()
            @endphp

            @include('visor::components.editor', ['content' => $editorContent] )

        </main>

        <!-- Sidebar -->
        @include('visor::components.sidebar')

    </body>
    
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

    <script>
        if (window.self !== window.top) {
            $back_list = document.getElementById('back-list');
            $back_list.classList.remove('hidden');
            $back_list_button = document.querySelector('#back-list button');
            $back_list_button.addEventListener('click', function() {
                window.parent.postMessage({type: 'cognitrek', content: 'list', data: {}}, '*');
            });
        }

    </script>

    {!! $blocks_modified !!} 

    @include('visor::js.basic')

</html>
