
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