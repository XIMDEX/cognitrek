
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
        background-color: rgb(255, 232, 232);
    }

    .added {
        display: inline-block;
        background-color: rgb(229, 240, 255);
        text-decoration: wavy underline rgb(136, 136, 255);
    }

    .modified {
        background-color: rgb(255, 244, 203);
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

    .bg-primary {
        background-color: hsl(222 88% 44%);
    }
    .bg-secondary {
        background-color: hsl(215.29, 54.84%, 93.92%);
    }

    .xbutton {

        background-color: hsl(222 88% 44%);
        color: white;
        border-radius: 5px;
        padding: 5px 15px;
    }

    .font-sans {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
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
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        width: 100%;
        box-sizing: border-box;
        min-height: 100dvh;
    }

    .book-container:not([class*="-theme"]) {
        font-size: 16px;
        line-height: 1.8;
        letter-spacing: 0.01em;

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
        text-indent: 2em;
        hyphens: auto;
    }

    .book-container:not([class*="-theme"]) .title+.paragraph,
    .book-container:not([class*="-theme"]) .subtitle+.paragraph {
        margin-top: 2em;
    }

    .book-container:not([class*="-theme"]) blockquote {
        margin: 2em 4em;
        padding-left: 2em;
        border-left: 3px solid #7f8c8d;
        font-style: italic;
        color: #34495e;
    }

    .book-container:not([class*="-theme"]) ul,
    .book-container:not([class*="-theme"]) ol {
        margin: 1.5em 0;
        padding-left: 2em;
    }

    .book-container:not([class*="-theme"]) li {
        margin-bottom: 0.5em;
    }

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
        margin-bottom: 20px;
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

    .resize-handle.nw {
        top: -5px;
        left: -5px;
        cursor: nw-resize;
    }

    .resize-handle.ne {
        top: -5px;
        right: -5px;
        cursor: ne-resize;
    }

    .resize-handle.sw {
        bottom: -5px;
        left: -5px;
        cursor: sw-resize;
    }

    .resize-handle.se {
        bottom: -5px;
        right: -5px;
        cursor: se-resize;
    }

    .resize-handle.n {
        top: -5px;
        left: 50%;
        margin-left: -5px;
        cursor: n-resize;
    }

    .resize-handle.s {
        bottom: -5px;
        left: 50%;
        margin-left: -5px;
        cursor: s-resize;
    }

    .resize-handle.e {
        right: -5px;
        top: 50%;
        margin-top: -5px;
        cursor: e-resize;
    }

    .resize-handle.w {
        left: -5px;
        top: 50%;
        margin-top: -5px;
        cursor: w-resize;
    }

    .resizable-image .resize-handle,
    .resizable-image .image-alt-text {
        display: none;
    }

    .resizable-image.active .resize-handle,
    .resizable-image.active .image-alt-text {
        display: block;
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
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
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

    .edit-mode-switch {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-left: auto;
        padding: 5px 10px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
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
        background-color: #eaeaea;
        transition: .4s;
        border-radius: 20px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 2px;
        bottom: 2px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #3498db;
    }

    input:checked+.slider:before {
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

    .resizable-image[style*="float: left"] {
        margin-right: 20px;
        margin-bottom: 10px;
    }

    .resizable-image[style*="float: right"] {
        margin-left: 20px;
        margin-bottom: 10px;
    }

    .resizable-image::after {
        content: "";
        clear: both;
        display: table;
    }

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
            height: 20px;
            margin: 0 4px;
        }
    }

    @media (max-width: 480px) {
        body {
            padding-top: 100px;
        }
    }

    .format-button.delete-button {
        width: 32px;
        height: 32px;
        margin: 0 1px;
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

    .format-button.active {
        background-color: #e3f2fd !important;
        border-color: #2196f3;
        color: #2196f3;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .format-button:hover {
        background-color: #f0f0f0 !important;
        transform: translateY(-1px);
    }

    .history-list {
        max-height: 300px;
        overflow-y: auto;
        padding-right: 15px;
    }

    .history-item {
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 0.9rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .history-item:hover {
        background-color: rgba(52, 152, 219, 0.1);
    }

    .history-item .timestamp {
        color: #999;
        font-size: 0.8rem;
        /* Updated font size */
        display: block;
        margin-bottom: 4px;
    }

    .history-item .change {
        color: #333;
    }

    /* Scrollbar styling for history */
    .history-list::-webkit-scrollbar {
        width: 4px;
        /* Updated width */
    }

    .history-list::-webkit-scrollbar-track {
        background: #f8f8f8;
        /* Updated background */
        border-radius: 2px;
    }

    .history-list::-webkit-scrollbar-thumb {
        background: #ddd;
        /* Updated background */
        border-radius: 2px;
    }

    .history-list::-webkit-scrollbar-thumb:hover {
        background: #ccc;
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
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .download-button:hover {
        background: #2980b9;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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

