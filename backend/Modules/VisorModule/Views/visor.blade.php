<!DOCTYPE html>
<html lang="{{ $resource['lang'] }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $resource['title'] }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />

        <!-- Styles Tailwindcss -->
        <style>
            /* ! tailwindcss v3.2.4 | MIT License | https://tailwindcss.com */*,::after,::before{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}::after,::before{--tw-content:''}html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;font-family:Figtree, sans-serif;font-feature-settings:normal}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,pre,samp{font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-size:100%;font-weight:inherit;line-height:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}[type=button],[type=reset],[type=submit],button{-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dd,dl,figure,h1,h2,h3,h4,h5,h6,hr,p,pre{margin:0}fieldset{margin:0;padding:0}legend{padding:0}menu,ol,ul{list-style:none;margin:0;padding:0}textarea{resize:vertical}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}[role=button],button{cursor:pointer}:disabled{cursor:default}audio,canvas,embed,iframe,img,object,svg,video{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]{display:none}*, ::before, ::after{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }::-webkit-backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }::backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }.relative{position:relative}.mx-auto{margin-left:auto;margin-right:auto}.mx-6{margin-left:1.5rem;margin-right:1.5rem}.ml-4{margin-left:1rem}.mt-16{margin-top:4rem}.mt-6{margin-top:1.5rem}.mt-4{margin-top:1rem}.-mt-px{margin-top:-1px}.mr-1{margin-right:0.25rem}.flex{display:flex}.inline-flex{display:inline-flex}.grid{display:grid}.h-16{height:4rem}.h-7{height:1.75rem}.h-6{height:1.5rem}.h-5{height:1.25rem}.min-h-screen{min-height:100vh}.w-auto{width:auto}.w-16{width:4rem}.w-7{width:1.75rem}.w-6{width:1.5rem}.w-5{width:1.25rem}.max-w-7xl{max-width:80rem}.shrink-0{flex-shrink:0}.scale-100{--tw-scale-x:1;--tw-scale-y:1;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}.grid-cols-1{grid-template-columns:repeat(1, minmax(0, 1fr))}.items-center{align-items:center}.justify-center{justify-content:center}.gap-6{gap:1.5rem}.gap-4{gap:1rem}.self-center{align-self:center}.rounded-lg{border-radius:0.5rem}.rounded-full{border-radius:9999px}.bg-gray-100{--tw-bg-opacity:1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}.bg-white{--tw-bg-opacity:1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-red-50{--tw-bg-opacity:1;background-color:rgb(254 242 242 / var(--tw-bg-opacity))}.bg-dots-darker{background-image:url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E")}.from-gray-700\/50{--tw-gradient-from:rgb(55 65 81 / 0.5);--tw-gradient-to:rgb(55 65 81 / 0);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.via-transparent{--tw-gradient-to:rgb(0 0 0 / 0);--tw-gradient-stops:var(--tw-gradient-from), transparent, var(--tw-gradient-to)}.bg-center{background-position:center}.stroke-red-500{stroke:#ef4444}.stroke-gray-400{stroke:#9ca3af}.p-6{padding:1.5rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.text-center{text-align:center}.text-right{text-align:right}.text-xl{font-size:1.25rem;line-height:1.75rem}.text-sm{font-size:0.875rem;line-height:1.25rem}.font-semibold{font-weight:600}.leading-relaxed{line-height:1.625}.text-gray-600{--tw-text-opacity:1;color:rgb(75 85 99 / var(--tw-text-opacity))}.text-gray-900{--tw-text-opacity:1;color:rgb(17 24 39 / var(--tw-text-opacity))}.text-gray-500{--tw-text-opacity:1;color:rgb(107 114 128 / var(--tw-text-opacity))}.underline{-webkit-text-decoration-line:underline;text-decoration-line:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.shadow-2xl{--tw-shadow:0 25px 50px -12px rgb(0 0 0 / 0.25);--tw-shadow-colored:0 25px 50px -12px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.shadow-gray-500\/20{--tw-shadow-color:rgb(107 114 128 / 0.2);--tw-shadow:var(--tw-shadow-colored)}.transition-all{transition-property:all;transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);transition-duration:150ms}.selection\:bg-red-500 *::selection{--tw-bg-opacity:1;background-color:rgb(239 68 68 / var(--tw-bg-opacity))}.selection\:text-white *::selection{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.selection\:bg-red-500::selection{--tw-bg-opacity:1;background-color:rgb(239 68 68 / var(--tw-bg-opacity))}.selection\:text-white::selection{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.hover\:text-gray-900:hover{--tw-text-opacity:1;color:rgb(17 24 39 / var(--tw-text-opacity))}.hover\:text-gray-700:hover{--tw-text-opacity:1;color:rgb(55 65 81 / var(--tw-text-opacity))}.focus\:rounded-sm:focus{border-radius:0.125rem}.focus\:outline:focus{outline-style:solid}.focus\:outline-2:focus{outline-width:2px}.focus\:outline-red-500:focus{outline-color:#ef4444}.group:hover .group-hover\:stroke-gray-600{stroke:#4b5563}.z-10{z-index: 10}@media (prefers-reduced-motion: no-preference){.motion-safe\:hover\:scale-\[1\.01\]:hover{--tw-scale-x:1.01;--tw-scale-y:1.01;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}}@media (prefers-color-scheme: dark){.dark\:bg-gray-900{--tw-bg-opacity:1;background-color:rgb(17 24 39 / var(--tw-bg-opacity))}.dark\:bg-gray-800\/50{background-color:rgb(31 41 55 / 0.5)}.dark\:bg-red-800\/20{background-color:rgb(153 27 27 / 0.2)}.dark\:bg-dots-lighter{background-image:url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E")}.dark\:bg-gradient-to-bl{background-image:linear-gradient(to bottom left, var(--tw-gradient-stops))}.dark\:stroke-gray-600{stroke:#4b5563}.dark\:text-gray-400{--tw-text-opacity:1;color:rgb(156 163 175 / var(--tw-text-opacity))}.dark\:text-white{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.dark\:shadow-none{--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.dark\:ring-1{--tw-ring-offset-shadow:var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow:var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow:var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)}.dark\:ring-inset{--tw-ring-inset:inset}.dark\:ring-white\/5{--tw-ring-color:rgb(255 255 255 / 0.05)}.dark\:hover\:text-white:hover{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.group:hover .dark\:group-hover\:stroke-gray-400{stroke:#9ca3af}}@media (min-width: 640px){.sm\:fixed{position:fixed}.sm\:top-0{top:0px}.sm\:right-0{right:0px}.sm\:ml-0{margin-left:0px}.sm\:flex{display:flex}.sm\:items-center{align-items:center}.sm\:justify-center{justify-content:center}.sm\:justify-between{justify-content:space-between}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width: 768px){.md\:grid-cols-2{grid-template-columns:repeat(2, minmax(0, 1fr))}}@media (min-width: 1024px){.lg\:gap-8{gap:2rem}.lg\:p-8{padding:2rem}}
        </style>

        <style>
            :root {
                font-size: 12px;
            }
            body {    
                font-size: 1rem;
            }
            p {
                margin-block-start: 1rem;
            }
            .deleted {
                background-color:rgb(255, 232, 232);
            }
            .added {
                display: inline-block;
                background-color:rgb(229, 240, 255);
                text-decoration: wavy underline rgb(136, 136, 255);
            }

            .modified {
                background-color:rgb(255, 244, 203);
                padding: 2px;
            }
            .modified-added {
                display: inline-block;
                text-decoration: wavy underline #ffae22;
                background-color: rgb(255, 244, 217);
            }
            .tooltip-modified {
                background-color: #fff6d7;
            }
        </style>

        @if($dyslexic_level)
        <style>
            @font-face {
                font-family: 'OpenDyslexic';
                font-weight: normal;
                font-style: normal;
                src: url("{{ asset('fonts/OpenDyslexic-Regular.otf') }}") format('opentype');
            }
            @font-face {
                font-family: 'OpenDyslexic';
                font-weight: bold;
                font-style: normal;
                src: url("{{ asset('fonts/OpenDyslexic-Bold.otf') }}") format('opentype');
            }
            @font-face {
                font-family: 'OpenDyslexic';
                font-weight: normal;
                font-style: italic;
                src: url("{{ asset('fonts/OpenDyslexic-Italic.otf') }}") format('opentype');
            }
            @font-face {
                font-family: 'OpenDyslexic';
                font-weight: bold;
                font-style: italic;
                src: url("{{ asset('fonts/OpenDyslexic-Bold-Italic.otf') }}") format('opentype');
            }

            :root {
                font-size: 18px;
            }

            body main section {
                font-family: 'OpenDyslexic', 'Lexend Deca', Arial, sans-serif;
                line-height: 1.75;
                letter-spacing: 0.08em;
                word-spacing: 0.2em;
                text-align: left;
                margin: 0;
                padding: 0;
            }

            .highlight {
                font-weight: bold;
                color: #0056B3;
            }

            a {
                text-decoration: none;
                color: #0056B3;
            }

            a:hover {
                text-decoration: underline;
                color: #003366;
            }

            .level-low {
                background-color: #F9F9E5;
                color: #333333;
            }

            .level-low-bold {
                color: #222222;
            }

            .level-low-alt1 {
                background-color: #EAEAEA;
                color: #2D2D2D;
            }

            .level-low-alt2 {
                background-color: #F4F9F9;
                color: #303030;
            }

            .level-low-alt3 {
                background-color: #FFFAE5;
                color: #292929;
            }

            .level-mid {
                background-color: #FFF5CC;
                color: #222222;
            }

            .level-mid-bold {
                color: #0056B3;
            }

            .level-mid-alt1 {
                background-color: #F2F2F2;
                color: #1C1C1C;
            }

            .level-mid-alt2 {
                background-color: #E8F5E9;
                color: #212121;
            }

            .level-mid-alt3 {
                background-color: #E0F7FA;
                color: #232323;
            }

            .level-high {
                background-color: #FFFFCC;
                color: #1A1A1A;
            }

            .level-high-bold {
                color: #2E7D32;
            }

            .level-high-alt1 {
                background-color: #F3E5F5;
                color: #121212;
            }

            .level-high-alt2 {
                background-color: #E0F7FA;
                color: #181818;
            }

            .level-high-alt3 {
                background-color: #E8F5E9;
                color: #141414;
            }

            .text-left {
                text-align: left;
            }

            .text-center {
                text-align: center;
            }

            .text-right {
                text-align: right;
            }

            .table {
                border-collapse: collapse;
                width: 100%;
                margin: 1em 0;
            }

            .table th,
            .table td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
                font-size: 16px;
            }

            .table th {
                background-color: #f4f4f4;
                color: #333333;
                font-weight: bold;
            }
        </style>
        @endif

    </head>
    <body class="antialiased flex h-screen bg-white overflow-hidden">
       
        <main class="flex-1 flex flex-col overflow-y-hidden">

            <!-- Toolbar -->
            <div class="border-b bg-white px-4 py-2 flex items-center space-x-2">
                <button @click="formatText('bold')" class="p-2 hover:bg-gray-100 rounded" :class="{'bg-gray-200': isActive('bold')}">
                    <span class="font-bold">B</span>
                </button>
                <button @click="formatText('italic')" class="p-2 hover:bg-gray-100 rounded" :class="{'bg-gray-200': isActive('italic')}">
                    <span class="italic">I</span>
                </button>
                <button @click="formatText('underline')" class="p-2 hover:bg-gray-100 rounded" :class="{'bg-gray-200': isActive('underline')}">
                    <span class="underline">U</span>
                </button>
                <button @click="formatText('strikeThrough')" class="p-2 hover:bg-gray-100 rounded" :class="{'bg-gray-200': isActive('strikeThrough')}">
                    <span class="line-through">S</span>
                </button>
                <button @click="formatText('superscript')" class="p-2 hover:bg-gray-100 rounded" :class="{'bg-gray-200': isActive('superscript')}">
                    <span>x²</span>
                </button>
                <div class="h-4 w-px bg-gray-300 mx-2"></div>
                <button @click="formatText('justifyLeft')" class="p-2 hover:bg-gray-100 rounded">
                    <span>←</span>
                </button>
                <button @click="formatText('justifyRight')" class="p-2 hover:bg-gray-100 rounded">
                    <span>→</span>
                </button>
                <button @click="formatText('justifyCenter')" class="p-2 hover:bg-gray-100 rounded">
                    <span>=</span>
                </button>
                <select x-model="fontSize" @change="changeFontSize()" class="rounded border-gray-300">
                    <option value="12">12pt</option>
                    <option value="14">14pt</option>
                    <option value="16">16pt</option>
                    <option value="18">18pt</option>
                </select>
                <select x-model="fontFamily" @change="changeFontFamily()" class="rounded border-gray-300">
                    <option value="Georgia, serif">Georgia</option>
                    <option value="Arial, sans-serif">Arial</option>
                    <option value="'Times New Roman', serif">Times New Roman</option>
                </select>
            </div>

            <div class="flex flex-col bg-gray-50  gap-4 p-4 overflow-auto flex-grow "  style="overflow: auto;">
                @foreach($resource['sections'] as $section)
                    <section class="flex-1 overflow-auto p-8 max-w-4xl mx-auto bg-white {{ $dyslexic_level ? 'level_' . $dyslexic_level  : '' }}" style="box-shadow: 0 0 20px rgba(0,0,0,0.1);">
                        @foreach($section['blocks'] as $block)
                            @if($block['type'] == 'p' || $block['type'] == 'text')
                            <p style="{{ $block['styles'] }}" id="{{ $block['id'] }}">
                                @foreach($block['blocks'] as $item)
                                    @if($item['type'] == 'text')
                                        {{ $item['content'] }}
                                    @else
                                        <{{ $item['type'] }} id="{{ $item['id'] }}" style="{{ $item['styles'] }}"> {{ $item['content'] }}</{{ $item['type'] }}>
                                    @endif
                                @endforeach
                            </p>
                            @elseif($block['type'] == 'image')
                            <img src="{{ asset('storage/'.$block['path']) }}" alt="{{ $block['alt'] }}" style="{{ $block['styles'] }}" />
                            @endif
                        @endforeach
                    </section>
                @endforeach
            </div>
        </main>
        <!-- Sidebar -->
        <sidebar class="w-64 border-r" style="background-color: hsl(215.29, 54.84%, 93.92%)">
            <div class="p-4">
                <h1 class="text-xl font-semibold text-gray-800">DOCUMENTO</h1>
                <p class="text-sm text-gray-600">Última edición: <span x-text="lastEdit"></span></p>
            </div>

            <!-- Modo Edición Toggle -->
            <div class="p-4 border-b">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">MODO EDICIÓN</span>
                    <button 
                        @click="editMode = !editMode"
                        :class="{'bg-blue-500': editMode, 'bg-gray-200': !editMode}"
                        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        <span 
                            :class="{'translate-x-5': editMode, 'translate-x-0': !editMode}"
                            class="inline-block h-5 w-5 transform rounded-full bg-white transition duration-200 ease-in-out"
                        ></span>
                    </button>
                </div>
            </div>


            <!-- Modo Edición Toggle -->
            <div id="back-list" class="p-4 border-b hidden">
                <div class="flex items-center justify-between">
                    <button class="border border-1 border-blue px-2 py-1 bg-gray-300" >Back to list</button>
                </div>
            </div>

            <!-- Tema Selector -->
            <div class="p-4 border-b">
                <h2 class="text-sm font-medium text-gray-700 mb-2">TEMA</h2>
                <select 
                    x-model="theme"
                    @change="changeTheme()"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="classic">Tema clásico</option>
                    <option value="modern">Tema moderno</option>
                    <option value="minimal">Tema minimalista</option>
                </select>
            </div>

            <!-- Historial de Cambios -->
            <div class="p-4">
                <h2 class="text-sm font-medium text-gray-700 mb-2">HISTORIAL DE CAMBIOS</h2>
                <div class="space-y-3">
                    <template x-for="change in changeHistory" :key="change.id">
                        <div class="text-sm">
                            <div class="text-gray-500" x-text="change.time"></div>
                            <div class="text-gray-700" x-text="change.description"></div>
                        </div>
                    </template>
                </div>
            </div>
        </sidebar>

    </body>
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
</html>
