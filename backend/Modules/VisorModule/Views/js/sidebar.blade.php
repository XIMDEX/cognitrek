
<script>
    
    function toggleHistoryAccordion() {
        const header = document.querySelector('.history-header');
        const historyList = document.querySelector('.history-list');

        header.classList.toggle('collapsed');
        historyList.classList.toggle('collapsed');
    }

    function toggleConditionsAccordion() {
        const header = document.querySelector('.conditions-header');
        const historyList = document.querySelector('.variant-conditions');

        header.classList.toggle('collapsed');
        historyList.classList.toggle('collapsed');
    }

    
    function toggleEditMode(is_edit) {
        let url = new URL(window.location.href);
        if (url.searchParams.has('edit_mode')) {
            url.searchParams.delete('edit_mode'); 
        } else {
            url.searchParams.set('edit_mode', '1');
        }

        window.location.href = url.toString();

        return;
        let editor = tinymce.get('editor1') ?? tinymce.activeEditor; 
        if (typeof is_edit == 'undefined') {
            is_edit = !editor.hasEditableRoot();
        }
        if (is_edit) {
            editor.setEditableRoot(true); 
            editor.getContainer().querySelector('.tox-toolbar').style.display = 'block'; 
            
            // setTimeout(() => editor.dom.select('.xmodified').forEach(el => el.classList.remove('view')), 100)
            
        } else {
            editor.setEditableRoot(false);
            editor.getContainer().querySelector('.tox-toolbar').style.display = 'none'; 
            // editor.getContainer().querySelector('.tox-menubar').style.display = 'none'; 
            setTimeout(() => editor.dom.select('.xmodified').forEach(el => el.classList.add('view')), 100)
        }
    }

    let editor = tinymce.get('editor1') ?? tinymce.activeEditor; 
    
    function handleEditMode(editor, edit_mode) {
        $switch_edit_mode = document.querySelector('#editModeToggle')
        if (!edit_mode) {
            editor.getContainer().querySelector('.tox-toolbar').style.display = 'none'; 
            // editor.getContainer().querySelector('.tox-menubar').style.display = 'none'; 
            $switch_edit_mode.checked = false
        } else {
            $switch_edit_mode.checked = true
    
        }
    }

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

    function changeVariant(value) {
        let url = new URL(window.location.href);
        if (value !== 'Original') {
            url.searchParams.set('variant', encodeURIComponent(value)); 
        } else {
            url.searchParams.delete('variant');
        }
        window.location.href = url.toString();
    }

    const checkboxes = document.querySelectorAll('.variant-conditions input[type=checkbox]');
    const tagsContainer = document.getElementById('selected-tags');

    function updateTags({currentTarget: checkbox}) {
        const id_checkbox = checkbox.id
        const is_checked = checkbox.checked
        const $tags = tagsContainer.querySelectorAll('li');
        const index_tag = [...$tags].findIndex(tag => { 
            return tag.id == id_checkbox
        });

        if (is_checked && index_tag < 0) {
            const tag = document.createElement('li');
            tag.id = checkbox.id
            tag.textContent = `${checkbox.name}`;
            tag.style.padding = '4px 8px';
            tag.style.margin = '4px';
            tag.style.border = '1px solid #ccc';
            tag.style.borderRadius = '4px';
            tag.style.backgroundColor = '#f0f0f0';
            tag.style.fontSize = '14px';
            tagsContainer.appendChild(tag);
        }
        if (!is_checked && index_tag >= 0) {
            $tags[index_tag].parentElement.removeChild($tags[index_tag])
        }
         
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateTags);
    });


    let conditions_checked = []

    document.querySelector('button#save-new').addEventListener('click', () => saveNewAdaptation())
    document.querySelector('button#create-new').addEventListener('click', () => createNewAdaptation())
    document.querySelector('button#cancel-new').addEventListener('click', () => cancelNewAdaptation())
    document.querySelector('button#save-adapt').addEventListener('click', () => saveAdaptation())
    

    function createNewAdaptation() {
        $conditions = document.querySelector('.variant-conditions')
        $new_adaptation = document.querySelector('#new-adaptation')

        $new_adaptation.style.display = 'block'
        $checked = $conditions.querySelectorAll('input[type=checkbox]:checked')

        $checked.forEach(c => {
            conditions_checked.push(c.id)
            c.checked = false
        })
        $checkboxes = $conditions.querySelectorAll('input[type=checkbox]')
        $checkboxes.forEach(c => c.disabled = false)
    }

    function cancelNewAdaptation() {
        $conditions = document.querySelector('.variant-conditions')
        $new_adaptation = document.querySelector('#new-adaptation')
        $new_adaptation.style.display = 'none'

        $checkboxes = $conditions.querySelectorAll('input[type=checkbox]')
        $checkboxes.forEach(c => {
            console.log(c.id)
            if (conditions_checked.some(cc => cc == c.id)) c.checked = true
            c.disabled = true
        })
        conditions_checked = []

        document.querySelector('#label-new').value = ""
        document.querySelector('#selected-tags').innerHTML = ""
    }

    function handleMessageNewVariant(type, message) {
        const $message = document.querySelector('#new-message')
        $message.textContent = message
        if (type == 'error') {
            $message.classList.add('error-message')
            $message.classList.remove('success-message')
        } else {
            $message.classList.remove('error-message')
            $message.classList.add('success-message')
        }
        $message.style.display = 'block'
        setTimeout(() => {

        }, 2000)
    }

    function saveAdaptation() {
        if (window.is_changed) {
            
            const data = {
                resource_id: "{{ $resource['id'] }}",
                conditions: [user_condition],
                content: 'content',
                user_data: window.user_data,
                label: ''
            }
        } 
    }
    function saveNewAdaptation() {
        const $button_save = document.querySelector('#save-new')
        const $button_cancel = document.querySelector('#cancel-new')
        const $checkboxes = document.querySelectorAll('.variant-conditions input[type=checkbox]');
        const $selected_tags = document.querySelectorAll('#selected-tags li')

        $checkboxes.forEach(c => c.disabled= true)
        
        $button_cancel.disabled = true
        $button_save.disabled = true

        const label = document.querySelector('#label-new').value.trim()

        if (label == "") {
            return handleMessageNewVariant('error', 'Label is required')
        }

        const content = 'content'

        const data = {
            resource_id: "{{ $resource['id'] }}",
            conditions: [...$selected_tags].map(t => t.id),
            content: 'content',
            label
        }

        let user_data =  Array.from({ 
            length: window.user_data.length}, 
            () => []
        );

        window.user_data.forEach((ud, idx) => {
            if (ud.length > 0) {
                user_data[idx] = ud.map(data => data.change )
            }
        })

        if (window.is_changed) {
            data['user_data'] = window.user_data;
            data['conditions'] = [user_condition, ...data['conditions']]
        }
        fetch("{{ route('v.variant.store') }}", {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(data)
        }).then(e => {
            handleMessageNewVariant('success', 'Adaptation in progress.')
            cancelNewAdaptation()
            setTimeout(function(){
                location.reload();
            }, 2000);
        }).catch(error => {
            handleMessageNewVariant('error', 'Error on create new adaptation. Contact with your supplier')
            cancelNewAdaptation()
        }).finally(() => {
            $button_cancel.disabled = false
            $button_save.disabled = false
        })
    }

</script>