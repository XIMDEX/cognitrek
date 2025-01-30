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

        <script src="{{url('lib/ckeditor')}}/ckeditor.js"></script>
        <!-- <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script> -->

        <!-- Styles Tailwindcss -->
        <style>
            /* ! tailwindcss v3.2.4 | MIT License | https://tailwindcss.com */*,::after,::before{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}::after,::before{--tw-content:''}html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;font-family:Figtree, sans-serif;font-feature-settings:normal}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,pre,samp{font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-size:100%;font-weight:inherit;line-height:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}[type=button],[type=reset],[type=submit],button{-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dd,dl,figure,h1,h2,h3,h4,h5,h6,hr,p,pre{margin:0}fieldset{margin:0;padding:0}legend{padding:0}menu,ol,ul{list-style:none;margin:0;padding:0}textarea{resize:vertical}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}[role=button],button{cursor:pointer}:disabled{cursor:default}audio,canvas,embed,iframe,img,object,svg,video{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]{display:none}*, ::before, ::after{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }::-webkit-backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }::backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }.relative{position:relative}.mx-auto{margin-left:auto;margin-right:auto}.mx-6{margin-left:1.5rem;margin-right:1.5rem}.ml-4{margin-left:1rem}.mt-16{margin-top:4rem}.mt-6{margin-top:1.5rem}.mt-4{margin-top:1rem}.-mt-px{margin-top:-1px}.mr-1{margin-right:0.25rem}.flex{display:flex}.inline-flex{display:inline-flex}.grid{display:grid}.h-16{height:4rem}.h-7{height:1.75rem}.h-6{height:1.5rem}.h-5{height:1.25rem}.min-h-screen{min-height:100vh}.w-auto{width:auto}.w-16{width:4rem}.w-7{width:1.75rem}.w-6{width:1.5rem}.w-5{width:1.25rem}.max-w-7xl{max-width:80rem}.shrink-0{flex-shrink:0}.scale-100{--tw-scale-x:1;--tw-scale-y:1;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}.grid-cols-1{grid-template-columns:repeat(1, minmax(0, 1fr))}.items-center{align-items:center}.justify-center{justify-content:center}.gap-6{gap:1.5rem}.gap-4{gap:1rem}.self-center{align-self:center}.rounded-lg{border-radius:0.5rem}.rounded-full{border-radius:9999px}.bg-gray-100{--tw-bg-opacity:1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}.bg-white{--tw-bg-opacity:1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-red-50{--tw-bg-opacity:1;background-color:rgb(254 242 242 / var(--tw-bg-opacity))}.bg-dots-darker{background-image:url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E")}.from-gray-700\/50{--tw-gradient-from:rgb(55 65 81 / 0.5);--tw-gradient-to:rgb(55 65 81 / 0);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.via-transparent{--tw-gradient-to:rgb(0 0 0 / 0);--tw-gradient-stops:var(--tw-gradient-from), transparent, var(--tw-gradient-to)}.bg-center{background-position:center}.stroke-red-500{stroke:#ef4444}.stroke-gray-400{stroke:#9ca3af}.p-6{padding:1.5rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.text-center{text-align:center}.text-right{text-align:right}.text-xl{font-size:1.25rem;line-height:1.75rem}.text-sm{font-size:0.875rem;line-height:1.25rem}.font-semibold{font-weight:600}.leading-relaxed{line-height:1.625}.text-gray-600{--tw-text-opacity:1;color:rgb(75 85 99 / var(--tw-text-opacity))}.text-gray-900{--tw-text-opacity:1;color:rgb(17 24 39 / var(--tw-text-opacity))}.text-gray-500{--tw-text-opacity:1;color:rgb(107 114 128 / var(--tw-text-opacity))}.underline{-webkit-text-decoration-line:underline;text-decoration-line:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.shadow-2xl{--tw-shadow:0 25px 50px -12px rgb(0 0 0 / 0.25);--tw-shadow-colored:0 25px 50px -12px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.shadow-gray-500\/20{--tw-shadow-color:rgb(107 114 128 / 0.2);--tw-shadow:var(--tw-shadow-colored)}.transition-all{transition-property:all;transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);transition-duration:150ms}.selection\:bg-red-500 *::selection{--tw-bg-opacity:1;background-color:rgb(239 68 68 / var(--tw-bg-opacity))}.selection\:text-white *::selection{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.selection\:bg-red-500::selection{--tw-bg-opacity:1;background-color:rgb(239 68 68 / var(--tw-bg-opacity))}.selection\:text-white::selection{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.hover\:text-gray-900:hover{--tw-text-opacity:1;color:rgb(17 24 39 / var(--tw-text-opacity))}.hover\:text-gray-700:hover{--tw-text-opacity:1;color:rgb(55 65 81 / var(--tw-text-opacity))}.focus\:rounded-sm:focus{border-radius:0.125rem}.focus\:outline:focus{outline-style:solid}.focus\:outline-2:focus{outline-width:2px}.focus\:outline-red-500:focus{outline-color:#ef4444}.group:hover .group-hover\:stroke-gray-600{stroke:#4b5563}.z-10{z-index: 10}@media (prefers-reduced-motion: no-preference){.motion-safe\:hover\:scale-\[1\.01\]:hover{--tw-scale-x:1.01;--tw-scale-y:1.01;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}}@media (prefers-color-scheme: dark){.dark\:bg-gray-900{--tw-bg-opacity:1;background-color:rgb(17 24 39 / var(--tw-bg-opacity))}.dark\:bg-gray-800\/50{background-color:rgb(31 41 55 / 0.5)}.dark\:bg-red-800\/20{background-color:rgb(153 27 27 / 0.2)}.dark\:bg-dots-lighter{background-image:url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E")}.dark\:bg-gradient-to-bl{background-image:linear-gradient(to bottom left, var(--tw-gradient-stops))}.dark\:stroke-gray-600{stroke:#4b5563}.dark\:text-gray-400{--tw-text-opacity:1;color:rgb(156 163 175 / var(--tw-text-opacity))}.dark\:text-white{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.dark\:shadow-none{--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.dark\:ring-1{--tw-ring-offset-shadow:var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow:var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow:var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)}.dark\:ring-inset{--tw-ring-inset:inset}.dark\:ring-white\/5{--tw-ring-color:rgb(255 255 255 / 0.05)}.dark\:hover\:text-white:hover{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.group:hover .dark\:group-hover\:stroke-gray-400{stroke:#9ca3af}}@media (min-width: 640px){.sm\:fixed{position:fixed}.sm\:top-0{top:0px}.sm\:right-0{right:0px}.sm\:ml-0{margin-left:0px}.sm\:flex{display:flex}.sm\:items-center{align-items:center}.sm\:justify-center{justify-content:center}.sm\:justify-between{justify-content:space-between}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width: 768px){.md\:grid-cols-2{grid-template-columns:repeat(2, minmax(0, 1fr))}}@media (min-width: 1024px){.lg\:gap-8{gap:2rem}.lg\:p-8{padding:2rem}}
        </style>

        <style>
            :root {
                font-size: 16px;
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


        <style>
            body {
                font-family: 'Georgia', serif;
                margin: 0;
                padding: 0;
                background-color: #f5f5f5;
                display: flex;
                height: 100dvh; 
                overflow: hidden; 
            }

            /* Update sidebar styles */
            .sidebar {
                min-width: 500px; 
                max-width: 700px;
                background: #FFF; 
                color: #333; 
                padding: 30px;
                border-right: 1px solid #eaeaea;
                box-shadow: 2px 0 10px rgba(0,0,0,0.03);
                display: flex;
                flex-direction: column;
                gap: 30px; 
                flex-shrink: 0;
                height: 100dvh;
                overflow-y: auto;
                box-sizing: border-box;
            }

            .sidebar-section {
                display: flex;
                flex-direction: column;
                gap: 15px;
                margin-bottom: 0; /* Removed margin */
                border-bottom: none; /* Removed border */
                padding-bottom: 0; /* Removed padding */
            }

            .sidebar-section h3 {
                color: #333;
                font-size: 0.85rem;
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 1.5px;
            }

            .sidebar .title {
                font-size: 1.2rem; /* Smaller title */
                color: #333;
                margin-bottom: 5px;
            }

            .sidebar .last-edit {
                font-size: 0.8rem;
                color: #666;
            }

            .theme-picker {
                width: 100%;
                padding: 12px;
                border: 1px solid #eaeaea;
                border-radius: 8px;
                background: #f8f8f8;
                font-size: 0.9rem;
                color: #333;
                transition: border-color 0.2s;
            }

            .theme-picker:hover {
                border-color: #ddd;
            }

            .edit-mode-switch {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 12px;
                background: #f8f8f8;
                border: 1px solid #eaeaea;
                border-radius: 8px;
                font-size: 0.9rem;
            }

            .main-content {
                flex: 1;
                display: flex;
                flex-direction: column;
                min-width: 0;
                overflow-y: hidden; 
                height: 100dvh; 
            }

            .format-toolbar {
                position: sticky; 
                top: 0;
                background: rgba(240, 240, 240, 0.95);
                padding: 10px;
                z-index: 9999999;
                width: 100%;
                box-sizing: border-box;
                display: flex;
                align-items: center; 
                justify-content: center; 
                gap: 2px; 
                font-size: 0.75rem;
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            .book-container {
                line-height: 1.6;
                max-width: 800px;
                margin: 20px auto;
                padding: 60px 80px; 
                background: #fff;
                color: #2c3e50;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
                width: 100%;
                box-sizing: border-box;
                min-height: 100dvh; 
            }

            .book-container:not([class*="-theme"]) {
                font-size: 16px;
                line-height: 1.8;
                letter-spacing: 0.01em;
                
                /* Margins and spacing */
                --paragraph-margin: 1.8em;
                --title-margin: 2.5em;
                --subtitle-margin: 2em;
            }

            .book-container:not([class*="-theme"]) .title {
                font-family: 'Georgia', serif;
                font-size: 2.8em;
                line-height: 1.2;
                color: #2c3e50;
                margin-bottom: var(--title-margin);
                text-align: center;
                font-weight: 700;
            }

            .book-container:not([class*="-theme"]) .subtitle {
                font-family: 'Georgia', serif;
                font-size: 1.8em;
                line-height: 1.4;
                color: #34495e;
                margin-bottom: var(--subtitle-margin);
                text-align: center;
                font-weight: 400;
                font-style: italic;
            }

            .book-container:not([class*="-theme"]) .paragraph {
                margin-bottom: var(--paragraph-margin);
                text-align: justify;
                text-indent: 2em; /* First line indent */
                hyphens: auto;
            }

            /* Add margin to first paragraph after titles/subtitles */
            .book-container:not([class*="-theme"]) .title + .paragraph,
            .book-container:not([class*="-theme"]) .subtitle + .paragraph {
                margin-top: 2em;
            }

            /* Style quotes and blockquotes */
            .book-container:not([class*="-theme"]) blockquote {
                margin: 2em 4em;
                padding-left: 2em;
                border-left: 3px solid #7f8c8d;
                font-style: italic;
                color: #34495e;
            }

            /* Lists styling */
            .book-container:not([class*="-theme"]) ul,
            .book-container:not([class*="-theme"]) ol {
                margin: 1.5em 0;
                padding-left: 2em;
            }

            .book-container:not([class*="-theme"]) li {
                margin-bottom: 0.5em;
            }

            /* Tables styling */
            .book-container:not([class*="-theme"]) table {
                margin: 2em 0;
                width: 100%;
                border-collapse: collapse;
                border: 1px solid #e0e0e0;
            }

            .book-container:not([class*="-theme"]) th,
            .book-container:not([class*="-theme"]) td {
                padding: 1em;
                border: 1px solid #e0e0e0;
                text-align: left;
            }

            .book-container:not([class*="-theme"]) th {
                background-color: #f8f9fa;
                font-weight: 600;
            }

            /* Images styling */
            .book-container:not([class*="-theme"]) .resizable-image {
                margin: 2em 0;
            }

            .book-container:not([class*="-theme"]) .image-caption {
                font-size: 0.9em;
                color: #666;
                text-align: center;
                margin-top: 1em;
                font-style: italic;
            }

            .book-container img {
                max-width: 100%;
                height: auto;
                cursor: pointer;
            }

            .resizable-image {
                position: relative;
                display: inline-block;
                margin-bottom: 20px; /* Space for caption */
                max-width: 100%;
            }

            .resizable-image img {
                max-width: 100%;
                height: auto;
            }

            .resize-handle {
                position: absolute;
                width: 10px;
                height: 10px;
                background-color: #fff;
                border: 1px solid #3498db;
                border-radius: 50%;
            }

            .resize-handle.nw { top: -5px; left: -5px; cursor: nw-resize; }
            .resize-handle.ne { top: -5px; right: -5px; cursor: ne-resize; }
            .resize-handle.sw { bottom: -5px; left: -5px; cursor: sw-resize; }
            .resize-handle.se { bottom: -5px; right: -5px; cursor: se-resize; }

            .resize-handle.n { top: -5px; left: 50%; margin-left: -5px; cursor: n-resize; }
            .resize-handle.s { bottom: -5px; left: 50%; margin-left: -5px; cursor: s-resize; }
            .resize-handle.e { right: -5px; top: 50%; margin-top: -5px; cursor: e-resize; }
            .resize-handle.w { left: -5px; top: 50%; margin-top: -5px; cursor: w-resize; }

            .resizable-image .resize-handle,
            .resizable-image .image-alt-text {
                display: none; /* Hide by default */
            }

            .resizable-image.active .resize-handle,
            .resizable-image.active .image-alt-text {
                display: block; /* Show when parent has active class */
            }

            .image-controls {
                position: absolute;
                left: 0;
                right: 0;
                bottom: -30px;
                display: none;
                gap: 10px;
                align-items: center;
                justify-content: center;
                background: rgba(245, 245, 245, 0.95);
                padding: 4px;
                border-radius: 4px;
                font-size: 0.8rem;
            }

            .image-alt-text {
                font-size: 0.8rem;
                color: #666;
                padding: 2px 6px;
                border: 1px solid #ddd;
                border-radius: 4px;
                min-width: 200px;
                background: white;
            }

            .caption-toggle {
                display: flex;
                align-items: center;
                gap: 4px;
                font-size: 0.8rem;
                color: #666;
            }

            .image-caption {
                font-size: 0.9rem;
                color: #666;
                text-align: center;
                margin-top: 8px;
                font-style: italic;
                display: none;
            }

            .resizable-image.active .image-controls {
                display: flex;
            }

            .resizable-image.show-caption .image-caption {
                display: block;
            }

            [contenteditable="true"] {
                outline: none;
                padding: 5px;
                border-radius: 4px;
                transition: all 0.3s ease;
            }

            [contenteditable="true"]:focus {
                background-color: #f0f7ff;
                box-shadow: 0 0 5px rgba(0,123,255,0.3);
            }

            .title {
                font-size: 2.5rem;
                margin-bottom: 10px;
                color: #2c3e50;
            }

            .subtitle {
                font-size: 1.5rem;
                color: #7f8c8d;
                margin-bottom: 30px;
            }

            .paragraph {
                font-size: 1.1rem;
                line-height: 1.6;
                margin-bottom: 20px;
                color: #34495e;
            }

            .format-toolbar.readonly {
                padding: 5px;
                justify-content: flex-end;
                background: transparent;
                box-shadow: none;
                border: none;
            }

            .format-toolbar.readonly .format-button,
            .format-toolbar.readonly .separator,
            .format-toolbar.readonly .color-picker,
            .format-toolbar.readonly .font-size-picker,
            .format-toolbar.readonly .font-family-picker,
            .format-toolbar.readonly .theme-picker {
                display: none;
            }

            .edit-mode-switch {
                display: flex;
                align-items: center;
                gap: 8px;
                margin-left: auto;
                padding: 5px 10px;
                background: rgba(255, 255, 255, 0.9);
                border-radius: 20px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }

            .switch {
                position: relative;
                display: inline-block;
                width: 44px; /* Updated width */
                height: 24px; /* Updated height */
            }

            .switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }

            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #eaeaea; /* Updated background color */
                transition: .4s;
                border-radius: 20px;
            }

            .slider:before {
                position: absolute;
                content: "";
                height: 20px; /* Updated height */
                width: 20px; /* Updated width */
                left: 2px;
                bottom: 2px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* Updated shadow */
                background-color: white;
                transition: .4s;
                border-radius: 50%;
            }

            input:checked + .slider {
                background-color: #3498db;
            }

            input:checked + .slider:before {
                transform: translateX(20px);
            }

            .book-container[contenteditable="false"] {
                cursor: default;
            }

            .book-container[contenteditable="false"] .add-block-button {
                display: none;
            }

            .image-upload {
                display: none;
            }

            .add-block-button {
                display: block;
                width: 100%;
                padding: 8px;
                margin: 5px 0;
                background: transparent;
                color: #95a5a6;
                border: 2px dashed #e0e0e0;
                border-radius: 6px;
                cursor: pointer;
                transition: all 0.3s ease;
                font-size: 0.9rem;
                opacity: 0.6;
                position: relative;
                min-height: 40px;
            }

            .block-type-icons {
                display: none;
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                background: white;
                padding: 5px;
                border-radius: 4px;
                gap: 5px;
                flex-wrap: wrap;
                justify-content: center;
            }

            .add-block-button:hover .block-type-icons {
                display: flex;
            }

            .block-type-icon {
                width: 30px;
                height: 30px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 4px;
                cursor: pointer;
                background: #f0f0f0;
                font-size: 16px;
                transition: all 0.2s ease;
            }

            .block-type-icon:hover {
                background: #e0e0e0;
                transform: scale(1.1);
            }

            /* Add these styles to the existing CSS */
            .resizable-image[style*="float: left"] {
                margin-right: 20px;
                margin-bottom: 10px;
            }

            .resizable-image[style*="float: right"] {
                margin-left: 20px;
                margin-bottom: 10px;
            }

            /* Clear floats after images */
            .resizable-image::after {
                content: "";
                clear: both;
                display: table;
            }

            /* Make toolbar responsive */
            @media (max-width: 768px) {
                .format-toolbar {
                    padding: 5px;
                }
                
                .format-button,
                .color-picker,
                .font-size-picker,
                .font-family-picker {
                    width: 32px; 
                    height: 32px;
                    margin: 0 1px; 
                    font-size: 0.85rem; 
                }
                
                .separator {
                    height: 20px; /* Adjust separator height */
                    margin: 0 4px; /* Adjust separator margin */
                }
            }

            @media (max-width: 480px) {
                body {
                    padding-top: 100px; /* More padding for wrapped toolbar */
                }
            }

            /* Add to existing CSS */
            .format-button.delete-button {
                width: 32px; /* Keep delete button width */
                height: 32px; /* Keep delete button height */
                margin: 0 1px; /* Match button margin */
                background: linear-gradient(to right, #ff6b6b, #ff8e8e);
                color: white;
                border: none;
                border-radius: 6px;
                box-shadow: 0 2px 4px rgba(255, 107, 107, 0.2);
                transition: all 0.3s ease;
            }

            .format-button.delete-button:hover {
                background: linear-gradient(to right, #ff8e8e, #ffa5a5);
                transform: translateY(-1px);
            }

            /* Preserve active state styling */
            .format-button.active {
                background-color: #e3f2fd !important;
                border-color: #2196f3;
                color: #2196f3;
                box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
            }

            /* Adjust hover states */
            .format-button:hover {
                background-color: #f0f0f0 !important;
                transform: translateY(-1px);
            }

            /* History section styles */
            .history-list {
                max-height: 300px; /* Updated max-height */
                overflow-y: auto;
                padding-right: 15px; /* Updated padding */
            }

            .history-item {
                padding: 12px 0; /* Updated padding */
                border-bottom: 1px solid #f0f0f0; /* Updated border color */
                font-size: 0.9rem; /* Updated font size */
                cursor: pointer;
                transition: background-color 0.2s;
            }

            .history-item:hover {
                background-color: rgba(52, 152, 219, 0.1);
            }

            .history-item .timestamp {
                color: #999;
                font-size: 0.8rem; /* Updated font size */
                display: block;
                margin-bottom: 4px;
            }

            .history-item .change {
                color: #333;
            }

            /* Scrollbar styling for history */
            .history-list::-webkit-scrollbar {
                width: 4px; /* Updated width */
            }

            .history-list::-webkit-scrollbar-track {
                background: #f8f8f8; /* Updated background */
                border-radius: 2px;
            }

            .history-list::-webkit-scrollbar-thumb {
                background: #ddd; /* Updated background */
                border-radius: 2px;
            }

            .history-list::-webkit-scrollbar-thumb:hover {
                background: #ccc;
            }

            /* Modern theme */
            .modern-theme {
                font-family: 'Helvetica Neue', Arial, sans-serif;
                line-height: 1.5;
                letter-spacing: -0.02em;
                color: #333;
                background: #fff;
                padding: 50px 80px;
                box-shadow: 0 0 30px rgba(0,0,0,0.1);
            }

            .modern-theme .title {
                font-family: 'Helvetica Neue', Arial, sans-serif;
                font-weight: 700;
                letter-spacing: -0.03em;
                color: #2c3e50;
            }

            .modern-theme .subtitle {
                font-weight: 400;
                color: #7f8c8d;
                margin-top: 0.5em;
            }

            .modern-theme .paragraph {
                font-size: 1.1em;
                margin-bottom: 1.5em;
            }

            /* Pride theme */
            .pride-theme {
                font-family: 'Avenir Next', 'Segoe UI', system-ui, sans-serif;
                line-height: 1.6;
                background: linear-gradient(135deg, #fff8f8, #f8fff8);
                padding: 45px 70px;
                border-radius: 12px;
                color: #2c3e50;
            }

            .pride-theme .title {
                font-weight: 800;
                background: linear-gradient(45deg, #ff0000, #ff8d00, #ffee00, #008000, #0000ff, #6a0dad);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            .pride-theme .subtitle {
                color: #666;
                font-weight: 600;
            }

            /* Kids theme */
            .kids-theme {
                font-family: 'Comic Sans MS', 'Chalkboard SE', cursive;
                line-height: 1.6;
                background: #fffdf7;
                padding: 35px 55px;
                border-radius: 20px;
                color: #4a4a4a;
            }

            .kids-theme .title {
                color: #ff6b6b;
                font-size: 2.8em;
                text-shadow: 2px 2px 0px #ffe066;
            }

            .kids-theme .subtitle {
                color: #20b2aa;
                font-size: 1.8em;
            }

            /* University theme */
            .university-theme {
                font-family: 'Georgia', serif;
                line-height: 1.7;
                background: #fff;
                padding: 60px 90px;
                color: #222;
            }

            .university-theme .title {
                font-family: 'Georgia', serif;
                font-weight: 700;
                color: #1a237e;
                font-size: 2.6em;
                margin-bottom: 1em;
            }

            .university-theme .subtitle {
                font-family: 'Georgia', serif;
                color: #283593;
                font-size: 1.7em;
                margin-bottom: 1.5em;
            }

            .university-theme .paragraph {
                font-size: 1.15em;
                text-align: justify;
                margin-bottom: 1.8em;
                padding-right: 1em;
            }

            /* Vintage theme */
            .vintage-theme {
                font-family: 'Old Standard TT', 'Bodoni MT', serif;
                line-height: 1.65;
                background: #f9f7f1;
                padding: 55px 85px;
                color: #2f1810;
            }

            .vintage-theme .title {
                font-family: 'UnifrakturMaguntia', 'Old Standard TT', serif;
                color: #582f0e;
                font-size: 2.7em;
                margin-bottom: 1.2em;
                text-align: center;
            }

            .vintage-theme .subtitle {
                font-family: 'Playfair Display', serif;
                color: #7f4f24;
                font-size: 1.6em;
                font-style: italic;
                text-align: center;
                margin-bottom: 2em;
            }

            .vintage-theme .paragraph {
                font-size: 1.12em;
                text-align: justify;
                margin-bottom: 2em;
                padding: 0 1em;
                text-indent: 2em;
            }

            /* Download button styles */
            .download-button {
                width: 100%;
                padding: 12px;
                background: #3498db;
                color: white;
                border: none;
                border-radius: 8px;
                font-size: 0.9rem;
                cursor: pointer;
                transition: all 0.2s ease;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            .download-button:hover {
                background: #2980b9;
                transform: translateY(-1px);
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }

            /* Modern theme tables */
            .modern-theme table {
                border-collapse: collapse;
                width: 100%;
                margin: 2em 0;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }

            .modern-theme th,
            .modern-theme td {
                border: 1px solid #eaeaea;
                padding: 1em;
                background: white;
            }

            .modern-theme th {
                background: #f8f9fa;
                font-weight: 500;
                color: #2c3e50;
            }

            /* Pride theme tables */
            .pride-theme table {
                border-collapse: collapse;
                width: 100%;
                margin: 2em 0;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }

            .pride-theme th,
            .pride-theme td {
                border: 1px solid #eee;
                padding: 1em;
                background: white;
            }

            .pride-theme th {
                background: linear-gradient(45deg, rgba(255,0,0,0.1), rgba(255,141,0,0.1), rgba(255,238,0,0.1), rgba(0,128,0,0.1), rgba(0,0,255,0.1), rgba(106,13,173,0.1));
                font-weight: 600;
                color: #333;
            }

            /* Kids theme tables */
            .kids-theme table {
                border-collapse: collapse;
                width: 100%;
                margin: 2em 0;
                border: 3px solid #ff6b6b;
                border-radius: 12px;
                overflow: hidden;
            }

            .kids-theme th,
            .kids-theme td {
                border: 2px dashed #20b2aa;
                padding: 1em;
                background: #fffdf7;
            }

            .kids-theme th {
                background: #ffe066;
                color: #ff6b6b;
                font-weight: bold;
                font-size: 1.1em;
            }

            /* University theme tables */
            .university-theme table {
                border-collapse: collapse;
                width: 100%;
                margin: 2em 0;
                border: 1px solid #1a237e;
            }

            .university-theme th,
            .university-theme td {
                border: 1px solid #1a237e;
                padding: 1.2em;
            }

            .university-theme th {
                background: #1a237e;
                color: white;
                font-weight: 700;
                text-align: left;
            }

            /* Vintage theme tables */
            .vintage-theme table {
                border-collapse: collapse;
                width: 100%;
                margin: 2em 0;
                border: 2px solid #582f0e;
            }

            .vintage-theme th,
            .vintage-theme td {
                border: 1px solid #7f4f24;
                padding: 1.2em;
                color: #2f1810;
            }

            .vintage-theme th {
                background: #f9f7f1;
                border-bottom: 2px solid #582f0e;
                font-family: 'Playfair Display', serif;
                font-weight: 700;
                font-style: italic;
            }

            /* Table toolbar styles */
            .table-toolbar {
                position: sticky;
                top: 52px;
                background: rgba(240, 240, 240, 0.95);
                padding: 5px;
                z-index: 999;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 2px;
                border-top: 1px solid #ddd;
            }

            .table-toolbar button {
                padding: 4px 8px;
                border: 1px solid #ddd;
                border-radius: 4px;
                background: white;
                cursor: pointer;
                font-size: 0.9rem;
                height: 32px;
                transition: all 0.2s ease;
            }

            .table-toolbar button:hover {
                background-color: #f0f0f0;
                transform: translateY(-1px);
            }

            .table-toolbar button:active {
                transform: translateY(0);
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

        <style>
        </style>
    </head>
    <body class="antialiased">

        <main class="flex-1 flex flex-col overflow-y-hidden main-content">

            <input type="file" id="imageUpload" class="image-upload" accept="image/*">
            <!-- <div class="format-toolbar" id="formatToolbar">
                <button class="format-button" onclick="toggleFormat('bold')" title="Negrita"
                    style="width: 32px; height: 32px; margin: 0 1px; background: white;">B</button>
                <button class="format-button" onclick="toggleFormat('italic')" title="Cursiva"
                    style="width: 32px; height: 32px; margin: 0 1px; background: white;">I</button>
                <button class="format-button" onclick="toggleFormat('underline')" title="Subrayado"
                    style="width: 32px; height: 32px; margin: 0 1px; background: white;">U</button>
                <div class="separator"></div>
                <button class="format-button" onclick="toggleFormat('strikeThrough')" title="Tachado"
                    style="width: 32px; height: 32px; margin: 0 1px; background: white;">S</button>
                <button class="format-button" onclick="toggleFormat('subscript')" title="Subíndice"
                    style="width: 32px; height: 32px; margin: 0 1px; background: white;">X₂</button>
                <button class="format-button" onclick="toggleFormat('superscript')" title="Superíndice"
                    style="width: 32px; height: 32px; margin: 0 1px; background: white;">X²</button>
                <div class="separator"></div>
                <button class="format-button" onclick="toggleAlign('justifyLeft')" title="Alinear a la izquierda"
                    style="width: 32px; height: 32px; margin: 0 1px; background: white;">⫷</button>
                <button class="format-button" onclick="toggleAlign('justifyCenter')" title="Centrar"
                    style="width: 32px; height: 32px; margin: 0 1px; background: white;">≣</button>
                <button class="format-button" onclick="toggleAlign('justifyRight')" title="Alinear a la derecha"
                    style="width: 32px; height: 32px; margin: 0 1px; background: white;">⫸</button>
                <button class="format-button" onclick="toggleAlign('justifyFull')" title="Justificar"
                    style="width: 32px; height: 32px; margin: 0 1px; background: white;">☰</button>
                <div class="separator"></div>
                <button class="format-button" onclick="insertList('insertOrderedList')" title="Lista numerada"
                    style="width: 32px; height: 32px; margin: 0 1px; background: white;">1.</button>
                <button class="format-button" onclick="insertList('insertUnorderedList')" title="Lista con viñetas"
                    style="width: 32px; height: 32px; margin: 0 1px; background: white;">•</button>
                <button class="format-button" onclick="insertTable()" title="Insertar tabla"
                    style="width: 32px; height: 32px; margin: 0 1px; background: white;">⊞</button>
                <button class="format-button" onclick="triggerImageUpload()" title="Insertar imagen"
                    style="width: 32px; height: 32px; margin: 0 1px; background: white;">🖼</button>
                <div class="separator"></div>
                <input type="color" class="color-picker" oninput="changeColor(this.value)"
                    onchange="changeColor(this.value)" title="Color de texto"
                    style="width: 32px; height: 32px; padding: 2px; margin: 0 1px;">
                <select class="font-size-picker" onchange="changeFontSize(this.value)" title="Tamaño de fuente"
                    style="height: 32px; margin: 0 1px;">
                    <option value="1">8pt</option>
                    <option value="2">10pt</option>
                    <option value="3">12pt</option>
                    <option value="4">14pt</option>
                    <option value="5">18pt</option>
                    <option value="6">24pt</option>
                    <option value="7">36pt</option>
                </select>
                <select class="font-family-picker" onchange="changeFont(this.value)" title="Tipo de fuente"
                    style="height: 32px; margin: 0 1px;">
                    <option value="Georgia">Georgia</option>
                    <option value="Arial">Arial</option>
                    <option value="Times New Roman">Times New Roman</option>
                    <option value="Courier New">Courier New</option>
                    <option value="Verdana">Verdana</option>
                </select>
                <div class="separator"></div>
                <div class="separator"></div>
                <button class="format-button delete-button" onclick="deleteCurrentBlock()" title="Eliminar bloque"
                    style="width: 32px; height: 32px; margin: 0 1px; background: linear-gradient(to right, #ff6b6b, #ff8e8e); color: white; border: none; border-radius: 6px; box-shadow: 0 2px 4px rgba(255, 107, 107, 0.2); transition: all 0.3s ease;">🗑️</button>
    
                <style>
                    .format-button {
                        border: 1px solid #ddd;
                        border-radius: 4px;
                        cursor: pointer;
                        transition: all 0.2s ease;
                    }
    
                    .format-button:hover {
                        background-color: #f0f0f0 !important;
                        transform: translateY(-1px);
                    }
    
                    .format-button.active {
                        background-color: #e3f2fd !important;
                        border-color: #2196f3;
                        color: #2196f3;
                        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
                    }
    
                    .separator {
                        height: 20px;
                        margin: 0 4px;
                    }
    
                    select.font-size-picker,
                    select.font-family-picker {
                        border: 1px solid #ddd;
                        border-radius: 4px;
                        /* padding: 4px 8px; */
                        background-color: white;
                        height: 32px;
                        margin: 0 1px;
                    }
    
                    input.color-picker {
                        border: 1px solid #ddd;
                        border-radius: 4px;
                        padding: 2px;
                        background-color: white;
                        height: 32px;
                        /* Match button height */
                        margin: 0 1px;
                        /* Match button margin */
                    }
                </style>
            </div> -->

            <div id="toolbar"></div>

            <textarea name="editor1"  class="" style="padding: 200px; background: tomato;">
                 @foreach($resource['sections'] as $section)
                    <section class="book-container {{ $dyslexic_level ? 'level-' . $dyslexic_level  : '' }}" >
                        @foreach($section['blocks'] as $block)
                            @if($block['type'] == 'p' || $block['type'] == 'text')
                            <p @if($is_edit) contenteditable @endif style="{{ $block['styles'] }}" id="{{ $block['id'] }}">
                                @foreach($block['blocks'] as $item)
                                    @if($item['type'] == 'text')
                                        {{ $item['content'] }}
                                    @else
                                        <{{ $item['type'] }} id="{{ $item['id'] }}" style="{{ $item['styles'] }}"> {{ $item['content'] }}</{{ $item['type'] }}>
                                    @endif
                                @endforeach
                            </p>
                            @elseif($block['type'] == 'image')
                            <img src="{{ asset('storage/'.$block['path']) }}" alt="{{ $block['alt'] }}" style="max-width: 100%; {{ $block['styles'] }}" />
                            @endif
                        @endforeach
                    </section>
                @endforeach
            </textarea>

        </main>
        <!-- Sidebar -->
         
        <div class="sidebar">
            
            
            <div class="sidebar-section">
                <div class="doc-info">
                    <h3 class="title">{{ $resource['title'] }}</h3>
                </div>
            </div>

            <div class="sidebar-section pb-4 border-b hidden flex" style="flex-direction: row;">
                <div id="back-list" class="">
                    <div class="flex items-center justify-between">
                        <button class="border border-1 border-blue px-2 py-1 bg-gray-300" >Back to list</button>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <button class="border border-1 border-blue px-2 py-1 bg-gray-300" >Create new Adaptation</button>
                </div>
            </div>

            <div class="sidebar-section p-4" style="border: 1px solid gray;">
                <h3>New Adaptation</h3>
                <div>

                </div>
            </div>
            <div class="sidebar-section">
            </div>

            <div class="sidebar-section">
                <h3>Adaptations</h3>
                <select class="theme-picker" onchange="changeTheme(this.value)" title="Cambiar tema">
                    @foreach ($adaptations as $adaptation)
                        <option value="{{$adaptation['label']}}" @if(isset($adaptation["selected"]) && $adaptation["selected"]) selected @endif>{{$adaptation['label']}}</option>
                    @endforeach
                </select>
                <h4 class="conditions-header" onclick="toggleConditionsAccordion()" style="cursor: pointer; user-select: none;">
                    Conditions on Adaptation
                    <span class="accordion-icon" style="float: right; transition: transform 0.3s;">▼</span>
                    <style>
                        .conditions-header {
                            position: relative;
                            padding: 10px 0;
                            margin: 0;
                            transition: background-color 0.2s;
                        }

                        .conditions-header:hover {
                            background-color: #f5f5f5;
                        }

                        .accordion-icon {
                            transition: transform 0.3s ease;
                        }

                        .conditions-header.collapsed .accordion-icon {
                            transform: rotate(-90deg);
                        }

                        .variant-conditions {
                            font-size: 0.75rem;
                            padding-inline: 20px;
                            max-height: 300px;
                            transition: max-height 0.3s ease-out, opacity 0.3s ease-out;
                            overflow: hidden;
                            opacity: .7;
                            display: flex;
                            flex-direction: row;
                            flex-wrap: wrap;
                            row-gap: 10px;
                            column-gap: 30px;

                        }

                        .variant-conditions.collapsed {
                            max-height: 0;
                            opacity: 0;
                        }
                    </style>
                    <script>
                        function toggleConditionsAccordion() {
                            const header = document.querySelector('.conditions-header');
                            const historyList = document.querySelector('.variant-conditions');

                            header.classList.toggle('collapsed');
                            historyList.classList.toggle('collapsed');
                        }
                    </script>
                </h4>
                <div class="variant-conditions">
                    @foreach ($conditions as $condition)
                        <label for="{{$condition['name']}}" style="display: flex; flex-direction: row; align-items:center; gap: 5px;">
                            <input type="checkbox" name="{{$condition['name']}}" id="{{ $condition['id'] }}" disabled @if($condition["selected"]) checked @endif >
                            {{$condition['name']}}
                        </label>
                    @endforeach
                </div>
                <div class="edit-mode-switch"
                    style="display: flex;justify-content: space-between;align-items: center;gap: 32px;width: 100%;background: #f8f8f8;padding: 10px;border-radius: 8px;box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 0.9rem; color: #666;">Edit Mode</h3>

                    <label class="switch" style="margin: 0 5px;">
                        <input type="checkbox" id="editModeToggle"  onchange="toggleEditMode()">
                        <span class="slider"></span>
                    </label>
                    <script>
                        function toggleEditMode(is_edit) {
                            let toolbar_container = document.querySelector('#toolbar')
                            if (typeof is_edit != 'boolean') {
                                is_edit = toolbar_container.style.visibility == 'hidden'
                            }
                            if (window.xeditor) {
                                window.xeditor.setReadOnly(!is_edit)
                            } else {
                                setTimeout(function(){
                                    window.xeditor.setReadOnly(!is_edit)
                                }, 200)
                            }
                            toolbar_container.style.visibility = is_edit ? '' : 'hidden'
                            toolbar_container.style.display = is_edit ? '' : 'none'
                            return;
                            
                            const editMode = document.getElementById('editModeToggle').checked;
                            const bookContainer = document.querySelector('.book-container');
                            const formatToolbar = document.querySelector('.format-toolbar');
                            const addBlockButtons = document.querySelectorAll('.add-block-button');

                            // Toggle contenteditable on all editable elements
                            bookContainer.querySelectorAll('[contenteditable]').forEach(element => {
                                element.contentEditable = editMode;
                            });

                            // Toggle toolbar visibility
                            formatToolbar.classList.toggle('readonly', !editMode);

                            // Toggle add block buttons visibility
                            addBlockButtons.forEach(button => {
                                button.style.display = editMode ? 'block' : 'none';
                            });

                            // Add history entry
                            addHistoryEntry(`Modo edición ${editMode ? 'activado' : 'desactivado'}`);
                        }

                        document.addEventListener('DOMContentLoaded', () => {
                            toggleEditMode(false);
                        });
                    </script>
                </div>
            </div>

            <div class="sidebar-section">
                <h3 class="history-header" onclick="toggleHistoryAccordion()" style="cursor: pointer; user-select: none;">
                    History
                    <span class="accordion-icon" style="float: right; transition: transform 0.3s;">▼</span>
                    <style>
                        .history-header {
                            position: relative;
                            padding: 10px 0;
                            margin: 0;
                            transition: background-color 0.2s;
                        }

                        .history-header:hover {
                            background-color: #f5f5f5;
                        }

                        .accordion-icon {
                            transition: transform 0.3s ease;
                        }

                        .history-header.collapsed .accordion-icon {
                            transform: rotate(-90deg);
                        }

                        .history-list {
                            max-height: 300px;
                            transition: max-height 0.3s ease-out, opacity 0.3s ease-out;
                            overflow: hidden;
                            opacity: 1;
                        }

                        .history-list.collapsed {
                            max-height: 0;
                            opacity: 0;
                        }
                    </style>
                    <script>
                        function toggleHistoryAccordion() {
                            const header = document.querySelector('.history-header');
                            const historyList = document.querySelector('.history-list');

                            header.classList.toggle('collapsed');
                            historyList.classList.toggle('collapsed');
                        }
                    </script>
                </h3>
                <div class="history-list">
                    <div class="history-item">
                        <div class="change">No Changes</div>
                    </div>
                    <!-- <div class="history-item">
                        <span class="timestamp">Hace 2 minutos</span>
                        <div class="change">Modificación del párrafo principal</div>
                    </div> -->
                </div>
            </div>

        </div>
        

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
    
            <script>

        // Primero, necesitamos cargar el plugin sharedspace


                         CKEDITOR.replace( 'editor1', {
                            height: 'calc(100vh - ' + document.querySelector('#toolbar').clientHeight + 'px)',
                            sharedSpaces: {
                                top: 'toolbar'
                            },
                            autoParagraph: false,
                            extraAllowedContent: 'section(*)[id,style]; p(*)[id,style]; div(*)[id,style];',
                            allowedContent: true, 
                            on: {
                                instanceReady: function({editor}) {
                                    window.xeditor = editor
                                    let raw_showNotifications = editor.showNotification
                                    editor.showNotification = function (...args) {
                                        if (args[0].includes('This CKEditor 4.22.1 version') && args[1] == 'warning') 
                                            return
                                        return raw_showNotifications(...args)
                                    } 
                                    editor.document.$.querySelectorAll('.editor-page').forEach(page => {
                                        page.setAttribute('contenteditable', 'true');
                                    });
                                }
                            },
                            contentsCss: [
                                'data:text/css;charset=utf-8,' + encodeURIComponent(`
                                                            
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


                                    <style>
                                        body {
                                            font-family: 'Georgia', serif;
                                            margin: 0;
                                            padding: 0;
                                            background-color: #f5f5f5;
                                            display: flex;
                                            height: 100dvh; 
                                            overflow: hidden; 
                                        }

                                        /* Update sidebar styles */
                                        .sidebar {
                                            min-width: 400px; 
                                            max-width: 700px;
                                            background: #FFF; 
                                            color: #333; 
                                            padding: 30px;
                                            border-right: 1px solid #eaeaea;
                                            box-shadow: 2px 0 10px rgba(0,0,0,0.03);
                                            display: flex;
                                            flex-direction: column;
                                            gap: 30px; 
                                            flex-shrink: 0;
                                            height: 100dvh;
                                            overflow-y: auto;
                                            box-sizing: border-box;
                                        }

                                        .sidebar-section {
                                            display: flex;
                                            flex-direction: column;
                                            gap: 15px;
                                            margin-bottom: 0; /* Removed margin */
                                            border-bottom: none; /* Removed border */
                                            padding-bottom: 0; /* Removed padding */
                                        }

                                        .sidebar-section h3 {
                                            color: #333;
                                            font-size: 0.85rem;
                                            margin-bottom: 10px;
                                            font-weight: 500;
                                            text-transform: uppercase;
                                            letter-spacing: 1.5px;
                                        }

                                        .sidebar .title {
                                            font-size: 1.2rem; /* Smaller title */
                                            color: #333;
                                            margin-bottom: 5px;
                                        }

                                        .sidebar .last-edit {
                                            font-size: 0.8rem;
                                            color: #666;
                                        }

                                        .theme-picker {
                                            width: 100%;
                                            padding: 12px;
                                            border: 1px solid #eaeaea;
                                            border-radius: 8px;
                                            background: #f8f8f8;
                                            font-size: 0.9rem;
                                            color: #333;
                                            transition: border-color 0.2s;
                                        }

                                        .theme-picker:hover {
                                            border-color: #ddd;
                                        }

                                        .edit-mode-switch {
                                            display: flex;
                                            align-items: center;
                                            justify-content: space-between;
                                            padding: 12px;
                                            background: #f8f8f8;
                                            border: 1px solid #eaeaea;
                                            border-radius: 8px;
                                            font-size: 0.9rem;
                                        }

                                        .main-content {
                                            flex: 1;
                                            display: flex;
                                            flex-direction: column;
                                            min-width: 0;
                                            overflow-y: hidden; 
                                            height: 100dvh; 
                                        }

                                        .format-toolbar {
                                            position: sticky; 
                                            top: 0;
                                            background: rgba(240, 240, 240, 0.95);
                                            padding: 10px;
                                            z-index: 9999999;
                                            width: 100%;
                                            box-sizing: border-box;
                                            display: flex;
                                            align-items: center; 
                                            justify-content: center; 
                                            gap: 2px; 
                                            font-size: 0.75rem;
                                            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
                                            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                                        }

                                        .book-container {
                                            line-height: 1.6;
                                            max-width: 800px;
                                            margin: 20px auto;
                                            padding: 60px 80px; 
                                            background: #fff;
                                            color: #2c3e50;
                                            box-shadow: 0 0 20px rgba(0,0,0,0.1);
                                            width: 100%;
                                            box-sizing: border-box;
                                            min-height: 100dvh; 
                                        }

                                        .book-container:not([class*="-theme"]) {
                                            font-size: 16px;
                                            line-height: 1.8;
                                            letter-spacing: 0.01em;
                                            
                                            /* Margins and spacing */
                                            --paragraph-margin: 1.8em;
                                            --title-margin: 2.5em;
                                            --subtitle-margin: 2em;
                                        }

                                        .book-container:not([class*="-theme"]) .title {
                                            font-family: 'Georgia', serif;
                                            font-size: 2.8em;
                                            line-height: 1.2;
                                            color: #2c3e50;
                                            margin-bottom: var(--title-margin);
                                            text-align: center;
                                            font-weight: 700;
                                        }

                                        .book-container:not([class*="-theme"]) .subtitle {
                                            font-family: 'Georgia', serif;
                                            font-size: 1.8em;
                                            line-height: 1.4;
                                            color: #34495e;
                                            margin-bottom: var(--subtitle-margin);
                                            text-align: center;
                                            font-weight: 400;
                                            font-style: italic;
                                        }

                                        .book-container:not([class*="-theme"]) .paragraph {
                                            margin-bottom: var(--paragraph-margin);
                                            text-align: justify;
                                            text-indent: 2em; /* First line indent */
                                            hyphens: auto;
                                        }

                                        /* Add margin to first paragraph after titles/subtitles */
                                        .book-container:not([class*="-theme"]) .title + .paragraph,
                                        .book-container:not([class*="-theme"]) .subtitle + .paragraph {
                                            margin-top: 2em;
                                        }

                                        /* Style quotes and blockquotes */
                                        .book-container:not([class*="-theme"]) blockquote {
                                            margin: 2em 4em;
                                            padding-left: 2em;
                                            border-left: 3px solid #7f8c8d;
                                            font-style: italic;
                                            color: #34495e;
                                        }

                                        /* Lists styling */
                                        .book-container:not([class*="-theme"]) ul,
                                        .book-container:not([class*="-theme"]) ol {
                                            margin: 1.5em 0;
                                            padding-left: 2em;
                                        }

                                        .book-container:not([class*="-theme"]) li {
                                            margin-bottom: 0.5em;
                                        }

                                        /* Tables styling */
                                        .book-container:not([class*="-theme"]) table {
                                            margin: 2em 0;
                                            width: 100%;
                                            border-collapse: collapse;
                                            border: 1px solid #e0e0e0;
                                        }

                                        .book-container:not([class*="-theme"]) th,
                                        .book-container:not([class*="-theme"]) td {
                                            padding: 1em;
                                            border: 1px solid #e0e0e0;
                                            text-align: left;
                                        }

                                        .book-container:not([class*="-theme"]) th {
                                            background-color: #f8f9fa;
                                            font-weight: 600;
                                        }

                                        /* Images styling */
                                        .book-container:not([class*="-theme"]) .resizable-image {
                                            margin: 2em 0;
                                        }

                                        .book-container:not([class*="-theme"]) .image-caption {
                                            font-size: 0.9em;
                                            color: #666;
                                            text-align: center;
                                            margin-top: 1em;
                                            font-style: italic;
                                        }

                                        .book-container img {
                                            max-width: 100%;
                                            height: auto;
                                            cursor: pointer;
                                        }

                                        .resizable-image {
                                            position: relative;
                                            display: inline-block;
                                            margin-bottom: 20px; /* Space for caption */
                                            max-width: 100%;
                                        }

                                        .resizable-image img {
                                            max-width: 100%;
                                            height: auto;
                                        }

                                        .resize-handle {
                                            position: absolute;
                                            width: 10px;
                                            height: 10px;
                                            background-color: #fff;
                                            border: 1px solid #3498db;
                                            border-radius: 50%;
                                        }

                                        .resize-handle.nw { top: -5px; left: -5px; cursor: nw-resize; }
                                        .resize-handle.ne { top: -5px; right: -5px; cursor: ne-resize; }
                                        .resize-handle.sw { bottom: -5px; left: -5px; cursor: sw-resize; }
                                        .resize-handle.se { bottom: -5px; right: -5px; cursor: se-resize; }

                                        .resize-handle.n { top: -5px; left: 50%; margin-left: -5px; cursor: n-resize; }
                                        .resize-handle.s { bottom: -5px; left: 50%; margin-left: -5px; cursor: s-resize; }
                                        .resize-handle.e { right: -5px; top: 50%; margin-top: -5px; cursor: e-resize; }
                                        .resize-handle.w { left: -5px; top: 50%; margin-top: -5px; cursor: w-resize; }

                                        .resizable-image .resize-handle,
                                        .resizable-image .image-alt-text {
                                            display: none; /* Hide by default */
                                        }

                                        .resizable-image.active .resize-handle,
                                        .resizable-image.active .image-alt-text {
                                            display: block; /* Show when parent has active class */
                                        }

                                        .image-controls {
                                            position: absolute;
                                            left: 0;
                                            right: 0;
                                            bottom: -30px;
                                            display: none;
                                            gap: 10px;
                                            align-items: center;
                                            justify-content: center;
                                            background: rgba(245, 245, 245, 0.95);
                                            padding: 4px;
                                            border-radius: 4px;
                                            font-size: 0.8rem;
                                        }

                                        .image-alt-text {
                                            font-size: 0.8rem;
                                            color: #666;
                                            padding: 2px 6px;
                                            border: 1px solid #ddd;
                                            border-radius: 4px;
                                            min-width: 200px;
                                            background: white;
                                        }

                                        .caption-toggle {
                                            display: flex;
                                            align-items: center;
                                            gap: 4px;
                                            font-size: 0.8rem;
                                            color: #666;
                                        }

                                        .image-caption {
                                            font-size: 0.9rem;
                                            color: #666;
                                            text-align: center;
                                            margin-top: 8px;
                                            font-style: italic;
                                            display: none;
                                        }

                                        .resizable-image.active .image-controls {
                                            display: flex;
                                        }

                                        .resizable-image.show-caption .image-caption {
                                            display: block;
                                        }

                                        [contenteditable="true"] {
                                            outline: none;
                                            padding: 5px;
                                            border-radius: 4px;
                                            transition: all 0.3s ease;
                                        }

                                        [contenteditable="true"]:focus {
                                            background-color: #f0f7ff;
                                            box-shadow: 0 0 5px rgba(0,123,255,0.3);
                                        }

                                        .title {
                                            font-size: 2.5rem;
                                            margin-bottom: 10px;
                                            color: #2c3e50;
                                        }

                                        .subtitle {
                                            font-size: 1.5rem;
                                            color: #7f8c8d;
                                            margin-bottom: 30px;
                                        }

                                        .paragraph {
                                            font-size: 1.1rem;
                                            line-height: 1.6;
                                            margin-bottom: 20px;
                                            color: #34495e;
                                        }

                                        .format-toolbar.readonly {
                                            padding: 5px;
                                            justify-content: flex-end;
                                            background: transparent;
                                            box-shadow: none;
                                            border: none;
                                        }

                                        .format-toolbar.readonly .format-button,
                                        .format-toolbar.readonly .separator,
                                        .format-toolbar.readonly .color-picker,
                                        .format-toolbar.readonly .font-size-picker,
                                        .format-toolbar.readonly .font-family-picker,
                                        .format-toolbar.readonly .theme-picker {
                                            display: none;
                                        }

                                        .edit-mode-switch {
                                            display: flex;
                                            align-items: center;
                                            gap: 8px;
                                            margin-left: auto;
                                            padding: 5px 10px;
                                            background: rgba(255, 255, 255, 0.9);
                                            border-radius: 20px;
                                            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                                        }

                                        .switch {
                                            position: relative;
                                            display: inline-block;
                                            width: 44px; /* Updated width */
                                            height: 24px; /* Updated height */
                                        }

                                        .switch input {
                                            opacity: 0;
                                            width: 0;
                                            height: 0;
                                        }

                                        .slider {
                                            position: absolute;
                                            cursor: pointer;
                                            top: 0;
                                            left: 0;
                                            right: 0;
                                            bottom: 0;
                                            background-color: #eaeaea; /* Updated background color */
                                            transition: .4s;
                                            border-radius: 20px;
                                        }

                                        .slider:before {
                                            position: absolute;
                                            content: "";
                                            height: 20px; /* Updated height */
                                            width: 20px; /* Updated width */
                                            left: 2px;
                                            bottom: 2px;
                                            box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* Updated shadow */
                                            background-color: white;
                                            transition: .4s;
                                            border-radius: 50%;
                                        }

                                        input:checked + .slider {
                                            background-color: #3498db;
                                        }

                                        input:checked + .slider:before {
                                            transform: translateX(20px);
                                        }

                                        .book-container[contenteditable="false"] {
                                            cursor: default;
                                        }

                                        .book-container[contenteditable="false"] .add-block-button {
                                            display: none;
                                        }

                                        .image-upload {
                                            display: none;
                                        }

                                        .add-block-button {
                                            display: block;
                                            width: 100%;
                                            padding: 8px;
                                            margin: 5px 0;
                                            background: transparent;
                                            color: #95a5a6;
                                            border: 2px dashed #e0e0e0;
                                            border-radius: 6px;
                                            cursor: pointer;
                                            transition: all 0.3s ease;
                                            font-size: 0.9rem;
                                            opacity: 0.6;
                                            position: relative;
                                            min-height: 40px;
                                        }

                                        .block-type-icons {
                                            display: none;
                                            position: absolute;
                                            left: 50%;
                                            top: 50%;
                                            transform: translate(-50%, -50%);
                                            background: white;
                                            padding: 5px;
                                            border-radius: 4px;
                                            gap: 5px;
                                            flex-wrap: wrap;
                                            justify-content: center;
                                        }

                                        .add-block-button:hover .block-type-icons {
                                            display: flex;
                                        }

                                        .block-type-icon {
                                            width: 30px;
                                            height: 30px;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            border-radius: 4px;
                                            cursor: pointer;
                                            background: #f0f0f0;
                                            font-size: 16px;
                                            transition: all 0.2s ease;
                                        }

                                        .block-type-icon:hover {
                                            background: #e0e0e0;
                                            transform: scale(1.1);
                                        }

                                        /* Add these styles to the existing CSS */
                                        .resizable-image[style*="float: left"] {
                                            margin-right: 20px;
                                            margin-bottom: 10px;
                                        }

                                        .resizable-image[style*="float: right"] {
                                            margin-left: 20px;
                                            margin-bottom: 10px;
                                        }

                                        /* Clear floats after images */
                                        .resizable-image::after {
                                            content: "";
                                            clear: both;
                                            display: table;
                                        }

                                        /* Make toolbar responsive */
                                        @media (max-width: 768px) {
                                            .format-toolbar {
                                                padding: 5px;
                                            }
                                            
                                            .format-button,
                                            .color-picker,
                                            .font-size-picker,
                                            .font-family-picker {
                                                width: 32px; 
                                                height: 32px;
                                                margin: 0 1px; 
                                                font-size: 0.85rem; 
                                            }
                                            
                                            .separator {
                                                height: 20px; /* Adjust separator height */
                                                margin: 0 4px; /* Adjust separator margin */
                                            }
                                        }

                                        @media (max-width: 480px) {
                                            body {
                                                padding-top: 100px; /* More padding for wrapped toolbar */
                                            }
                                        }

                                        /* Add to existing CSS */
                                        .format-button.delete-button {
                                            width: 32px; /* Keep delete button width */
                                            height: 32px; /* Keep delete button height */
                                            margin: 0 1px; /* Match button margin */
                                            background: linear-gradient(to right, #ff6b6b, #ff8e8e);
                                            color: white;
                                            border: none;
                                            border-radius: 6px;
                                            box-shadow: 0 2px 4px rgba(255, 107, 107, 0.2);
                                            transition: all 0.3s ease;
                                        }

                                        .format-button.delete-button:hover {
                                            background: linear-gradient(to right, #ff8e8e, #ffa5a5);
                                            transform: translateY(-1px);
                                        }

                                        /* Preserve active state styling */
                                        .format-button.active {
                                            background-color: #e3f2fd !important;
                                            border-color: #2196f3;
                                            color: #2196f3;
                                            box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
                                        }

                                        /* Adjust hover states */
                                        .format-button:hover {
                                            background-color: #f0f0f0 !important;
                                            transform: translateY(-1px);
                                        }

                                        /* History section styles */
                                        .history-list {
                                            max-height: 300px; /* Updated max-height */
                                            overflow-y: auto;
                                            padding-right: 15px; /* Updated padding */
                                        }

                                        .history-item {
                                            padding: 12px 0; /* Updated padding */
                                            border-bottom: 1px solid #f0f0f0; /* Updated border color */
                                            font-size: 0.9rem; /* Updated font size */
                                            cursor: pointer;
                                            transition: background-color 0.2s;
                                        }

                                        .history-item:hover {
                                            background-color: rgba(52, 152, 219, 0.1);
                                        }

                                        .history-item .timestamp {
                                            color: #999;
                                            font-size: 0.8rem; /* Updated font size */
                                            display: block;
                                            margin-bottom: 4px;
                                        }

                                        .history-item .change {
                                            color: #333;
                                        }

                                        /* Scrollbar styling for history */
                                        .history-list::-webkit-scrollbar {
                                            width: 4px; /* Updated width */
                                        }

                                        .history-list::-webkit-scrollbar-track {
                                            background: #f8f8f8; /* Updated background */
                                            border-radius: 2px;
                                        }

                                        .history-list::-webkit-scrollbar-thumb {
                                            background: #ddd; /* Updated background */
                                            border-radius: 2px;
                                        }

                                        .history-list::-webkit-scrollbar-thumb:hover {
                                            background: #ccc;
                                        }

                                        /* Modern theme */
                                        .modern-theme {
                                            font-family: 'Helvetica Neue', Arial, sans-serif;
                                            line-height: 1.5;
                                            letter-spacing: -0.02em;
                                            color: #333;
                                            background: #fff;
                                            padding: 50px 80px;
                                            box-shadow: 0 0 30px rgba(0,0,0,0.1);
                                        }

                                        .modern-theme .title {
                                            font-family: 'Helvetica Neue', Arial, sans-serif;
                                            font-weight: 700;
                                            letter-spacing: -0.03em;
                                            color: #2c3e50;
                                        }

                                        .modern-theme .subtitle {
                                            font-weight: 400;
                                            color: #7f8c8d;
                                            margin-top: 0.5em;
                                        }

                                        .modern-theme .paragraph {
                                            font-size: 1.1em;
                                            margin-bottom: 1.5em;
                                        }

                                        /* Pride theme */
                                        .pride-theme {
                                            font-family: 'Avenir Next', 'Segoe UI', system-ui, sans-serif;
                                            line-height: 1.6;
                                            background: linear-gradient(135deg, #fff8f8, #f8fff8);
                                            padding: 45px 70px;
                                            border-radius: 12px;
                                            color: #2c3e50;
                                        }

                                        .pride-theme .title {
                                            font-weight: 800;
                                            background: linear-gradient(45deg, #ff0000, #ff8d00, #ffee00, #008000, #0000ff, #6a0dad);
                                            -webkit-background-clip: text;
                                            -webkit-text-fill-color: transparent;
                                        }

                                        .pride-theme .subtitle {
                                            color: #666;
                                            font-weight: 600;
                                        }

                                        /* Kids theme */
                                        .kids-theme {
                                            font-family: 'Comic Sans MS', 'Chalkboard SE', cursive;
                                            line-height: 1.6;
                                            background: #fffdf7;
                                            padding: 35px 55px;
                                            border-radius: 20px;
                                            color: #4a4a4a;
                                        }

                                        .kids-theme .title {
                                            color: #ff6b6b;
                                            font-size: 2.8em;
                                            text-shadow: 2px 2px 0px #ffe066;
                                        }

                                        .kids-theme .subtitle {
                                            color: #20b2aa;
                                            font-size: 1.8em;
                                        }

                                        /* University theme */
                                        .university-theme {
                                            font-family: 'Georgia', serif;
                                            line-height: 1.7;
                                            background: #fff;
                                            padding: 60px 90px;
                                            color: #222;
                                        }

                                        .university-theme .title {
                                            font-family: 'Georgia', serif;
                                            font-weight: 700;
                                            color: #1a237e;
                                            font-size: 2.6em;
                                            margin-bottom: 1em;
                                        }

                                        .university-theme .subtitle {
                                            font-family: 'Georgia', serif;
                                            color: #283593;
                                            font-size: 1.7em;
                                            margin-bottom: 1.5em;
                                        }

                                        .university-theme .paragraph {
                                            font-size: 1.15em;
                                            text-align: justify;
                                            margin-bottom: 1.8em;
                                            padding-right: 1em;
                                        }

                                        /* Vintage theme */
                                        .vintage-theme {
                                            font-family: 'Old Standard TT', 'Bodoni MT', serif;
                                            line-height: 1.65;
                                            background: #f9f7f1;
                                            padding: 55px 85px;
                                            color: #2f1810;
                                        }

                                        .vintage-theme .title {
                                            font-family: 'UnifrakturMaguntia', 'Old Standard TT', serif;
                                            color: #582f0e;
                                            font-size: 2.7em;
                                            margin-bottom: 1.2em;
                                            text-align: center;
                                        }

                                        .vintage-theme .subtitle {
                                            font-family: 'Playfair Display', serif;
                                            color: #7f4f24;
                                            font-size: 1.6em;
                                            font-style: italic;
                                            text-align: center;
                                            margin-bottom: 2em;
                                        }

                                        .vintage-theme .paragraph {
                                            font-size: 1.12em;
                                            text-align: justify;
                                            margin-bottom: 2em;
                                            padding: 0 1em;
                                            text-indent: 2em;
                                        }

                                        /* Download button styles */
                                        .download-button {
                                            width: 100%;
                                            padding: 12px;
                                            background: #3498db;
                                            color: white;
                                            border: none;
                                            border-radius: 8px;
                                            font-size: 0.9rem;
                                            cursor: pointer;
                                            transition: all 0.2s ease;
                                            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                                        }

                                        .download-button:hover {
                                            background: #2980b9;
                                            transform: translateY(-1px);
                                            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                                        }

                                        /* Modern theme tables */
                                        .modern-theme table {
                                            border-collapse: collapse;
                                            width: 100%;
                                            margin: 2em 0;
                                            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                                        }

                                        .modern-theme th,
                                        .modern-theme td {
                                            border: 1px solid #eaeaea;
                                            padding: 1em;
                                            background: white;
                                        }

                                        .modern-theme th {
                                            background: #f8f9fa;
                                            font-weight: 500;
                                            color: #2c3e50;
                                        }

                                        /* Pride theme tables */
                                        .pride-theme table {
                                            border-collapse: collapse;
                                            width: 100%;
                                            margin: 2em 0;
                                            border-radius: 8px;
                                            overflow: hidden;
                                            box-shadow: 0 0 20px rgba(0,0,0,0.1);
                                        }

                                        .pride-theme th,
                                        .pride-theme td {
                                            border: 1px solid #eee;
                                            padding: 1em;
                                            background: white;
                                        }

                                        .pride-theme th {
                                            background: linear-gradient(45deg, rgba(255,0,0,0.1), rgba(255,141,0,0.1), rgba(255,238,0,0.1), rgba(0,128,0,0.1), rgba(0,0,255,0.1), rgba(106,13,173,0.1));
                                            font-weight: 600;
                                            color: #333;
                                        }

                                        /* Kids theme tables */
                                        .kids-theme table {
                                            border-collapse: collapse;
                                            width: 100%;
                                            margin: 2em 0;
                                            border: 3px solid #ff6b6b;
                                            border-radius: 12px;
                                            overflow: hidden;
                                        }

                                        .kids-theme th,
                                        .kids-theme td {
                                            border: 2px dashed #20b2aa;
                                            padding: 1em;
                                            background: #fffdf7;
                                        }

                                        .kids-theme th {
                                            background: #ffe066;
                                            color: #ff6b6b;
                                            font-weight: bold;
                                            font-size: 1.1em;
                                        }

                                        /* University theme tables */
                                        .university-theme table {
                                            border-collapse: collapse;
                                            width: 100%;
                                            margin: 2em 0;
                                            border: 1px solid #1a237e;
                                        }

                                        .university-theme th,
                                        .university-theme td {
                                            border: 1px solid #1a237e;
                                            padding: 1.2em;
                                        }

                                        .university-theme th {
                                            background: #1a237e;
                                            color: white;
                                            font-weight: 700;
                                            text-align: left;
                                        }

                                        /* Vintage theme tables */
                                        .vintage-theme table {
                                            border-collapse: collapse;
                                            width: 100%;
                                            margin: 2em 0;
                                            border: 2px solid #582f0e;
                                        }

                                        .vintage-theme th,
                                        .vintage-theme td {
                                            border: 1px solid #7f4f24;
                                            padding: 1.2em;
                                            color: #2f1810;
                                        }

                                        .vintage-theme th {
                                            background: #f9f7f1;
                                            border-bottom: 2px solid #582f0e;
                                            font-family: 'Playfair Display', serif;
                                            font-weight: 700;
                                            font-style: italic;
                                        }

                                        /* Table toolbar styles */
                                        .table-toolbar {
                                            position: sticky;
                                            top: 52px;
                                            background: rgba(240, 240, 240, 0.95);
                                            padding: 5px;
                                            z-index: 999;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            gap: 2px;
                                            border-top: 1px solid #ddd;
                                        }

                                        .table-toolbar button {
                                            padding: 4px 8px;
                                            border: 1px solid #ddd;
                                            border-radius: 4px;
                                            background: white;
                                            cursor: pointer;
                                            font-size: 0.9rem;
                                            height: 32px;
                                            transition: all 0.2s ease;
                                        }

                                        .table-toolbar button:hover {
                                            background-color: #f0f0f0;
                                            transform: translateY(-1px);
                                        }

                                        .table-toolbar button:active {
                                            transform: translateY(0);
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

                                    <style>
                                    </style>
                                
                                `)
                            ],
                        });
                
            </script>
            
<script>
        function downloadBookHTML() {
            return ;
            // Get the book container content
            const bookContainer = document.querySelector('.book-container');

            // Create a clone of the content to modify
            const tempContainer = bookContainer.cloneNode(true);

            // Remove contenteditable attributes and add block buttons
            tempContainer.querySelectorAll('[contenteditable]').forEach(element => {
                element.removeAttribute('contenteditable');
            });

            tempContainer.querySelectorAll('.add-block-button').forEach(button => {
                button.remove();
            });

            // Create full HTML document
            const fullHTML = `
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Libro Exportado</title>
    <style>
        ${document.querySelector('style').textContent}
        
        /* Additional styles to ensure content is not editable */
        .book-container {
            pointer-events: auto !important;
            cursor: default !important;
        }
        
        .book-container * {
            pointer-events: auto !important;
            cursor: default !important;
            user-select: text !important;
        }
        
        .add-block-button {
            display: none !important;
        }
        
        [contenteditable] {
            outline: none !important;
            border: none !important;
            box-shadow: none !important;
        }
    </style>
    ${document.querySelector('link[rel="stylesheet"]').outerHTML}
</head>
<body>
    <div class="book-container${bookContainer.className.replace('book-container', '')}">
        ${tempContainer.innerHTML}
    </div>
</body>
</html>`;

            // Create blob and download link
            const blob = new Blob([fullHTML], { type: 'text/html' });
            const url = URL.createObjectURL(blob);
            const downloadLink = document.createElement('a');
            downloadLink.href = url;
            downloadLink.download = 'libro.html';

            // Trigger download
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);

            // Clean up
            URL.revokeObjectURL(url);

            // Add history entry
            if (typeof addHistoryEntry === 'function') {
                addHistoryEntry('Descarga del documento');
            }
        }

        // Add missing function if it doesn't exist
        if (typeof addHistoryEntry !== 'function') {
            function addHistoryEntry(change) {
                const historyList = document.querySelector('.history-list');
                if (!historyList) return;

                const historyItem = document.createElement('div');
                historyItem.className = 'history-item';
                historyItem.innerHTML = `
            <span class="timestamp">Ahora</span>
            <div class="change">${change}</div>
        `;

                historyList.insertBefore(historyItem, historyList.firstChild);
            }
        }

        function updateToolbarState() {
            // Get selection and range
            const selection = window.getSelection();
            if (!selection.rangeCount) return;

            const range = selection.getRangeAt(0);
            const container = range.commonAncestorContainer;
            const element = container.nodeType === 1 ? container : container.parentNode;

            // Update format buttons
            const formats = ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript'];
            formats.forEach(format => {
                const button = document.querySelector(`[onclick*="${format}"]`);
                if (button) {
                    button.classList.toggle('active', document.queryCommandState(format));
                }
            });

            // Update alignment buttons
            const alignments = ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'];
            alignments.forEach(align => {
                const button = document.querySelector(`[onclick*="${align}"]`);
                if (button) {
                    button.classList.toggle('active', document.queryCommandState(align));
                }
            });

            // Update font family
            const fontFamily = document.queryCommandValue('fontName');
            const fontSelect = document.querySelector('.font-family-picker');
            if (fontSelect) {
                const option = Array.from(fontSelect.options).find(opt =>
                    opt.value.toLowerCase() === fontFamily.toLowerCase());
                if (option) {
                    fontSelect.value = option.value;
                }
            }

            // Update font size
            const fontSize = document.queryCommandValue('fontSize');
            const sizeSelect = document.querySelector('.font-size-picker');
            if (sizeSelect && fontSize) {
                const option = Array.from(sizeSelect.options).find(opt =>
                    opt.value === fontSize);
                if (option) {
                    sizeSelect.value = option.value;
                }
            }

            // Update color picker
            const color = document.queryCommandValue('foreColor');
            const colorPicker = document.querySelector('.color-picker');
            if (colorPicker && color) {
                colorPicker.value = rgbToHex(color);
            }
        }

        function rgbToHex(rgb) {
            // Convert RGB color string to hex
            if (rgb.startsWith('rgb')) {
                const [r, g, b] = rgb.match(/\d+/g);
                return '#' + ((1 << 24) + (+r << 16) + (+g << 8) + +b).toString(16).slice(1);
            }
            return rgb;
        }

        function toggleFormat(command) {
            document.execCommand(command, false, null);
            updateToolbarState();
            addHistoryEntry(`Aplicado formato: ${command}`);
        }

        function toggleAlign(command) {
            document.execCommand(command, false, null);
            updateToolbarState();
            addHistoryEntry(`Aplicado alineación: ${command}`);
        }

        function insertList(command) {
            document.execCommand(command, false, null);
            updateToolbarState();
            addHistoryEntry(`Insertada lista: ${command}`);
        }

        // Add event listeners for text selection changes
        // document.querySelector('.book-container').addEventListener('mouseup', updateToolbarState);
        // document.querySelector('.book-container').addEventListener('keyup', updateToolbarState);

        // Update changeFontSize, changeFont, and changeColor functions
        function changeFontSize(size) {
            document.execCommand('fontSize', false, size);
            updateToolbarState();
        }

        function changeFont(fontFamily) {
            document.execCommand('fontName', false, fontFamily);
            updateToolbarState();
        }

        function changeColor(color) {
            document.execCommand('foreColor', false, color);
            updateToolbarState();

            // Only add history entry when the final color is selected (on change, not during input)
            if (event && event.type === 'change') {
                addHistoryEntry('Cambio de color de texto');
            }
        }

        // Add missing table function
        function insertTable() {
            const table = `
        <table border="1" style="width:100%;margin:10px 0;">
            <tr>
                <td>Celda 1</td>
                <td>Celda 2</td>
                <td>Celda 3</td>
            </tr>
            <tr>
                <td>Celda 4</td>
                <td>Celda 5</td>
                <td>Celda 6</td>
            </tr>
        </table>
    `;
            document.execCommand('insertHTML', false, table);
            addHistoryEntry('Insertada tabla');
        }

        // Add theme change function
        function changeTheme(themeName) {
            const bookContainer = document.querySelector('.book-container');

            // Remove all existing theme classes
            bookContainer.classList.remove(
                'modern-theme',
                'pride-theme',
                'kids-theme',
                'university-theme',
                'vintage-theme'
            );

            // If a theme other than default is selected, add the theme class
            if (themeName !== 'default') {
                bookContainer.classList.add(`${themeName}-theme`);
            }

            // Add history entry for theme change
            addHistoryEntry(`Cambio de tema a: ${themeName}`);
        }

        // Make sure to initialize the toolbar state when the page loads
        document.addEventListener('DOMContentLoaded', updateToolbarState);
        document.addEventListener('DOMContentLoaded', () => {
            updateColorPickerElement();
            updateToolbarState();
        });

        function updateColorPickerElement() {
            const colorPicker = document.querySelector('.color-picker');
            if (colorPicker) {
                colorPicker.setAttribute('oninput', 'changeColor(this.value)');
                colorPicker.setAttribute('onchange', 'changeColor(this.value)');
            }
        }
    </script>
</html>
