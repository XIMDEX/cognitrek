
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