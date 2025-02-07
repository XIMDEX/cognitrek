
<script>

    function trackChanges(editor) {
        const content = editor.getContent();
        const jsonStructure = parseHtmlToJson(content);
        compareAndStoreChanges(jsonStructure);
    }

    function parseHtmlToJson(html) {
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = html;
        let jsonResult = [];

        tempDiv.childNodes.forEach((node, index) => {
            if (node.nodeType === Node.ELEMENT_NODE) {
                let jsonItem = {
                    id: index + 1,
                    styles: node.getAttribute('style') || "",
                    bbox: getBoundingBox(node),
                };

                if (node.tagName.toLowerCase() === 'img') {
                    jsonItem.type = 'image';
                    jsonItem.alt = node.getAttribute('alt') || "";
                    jsonItem.path = node.getAttribute('src');
                } else {
                    jsonItem.type = 'text';
                    jsonItem.tag = node.tagName.toLowerCase();
                    jsonItem.blocks = [{
                        type: 'span',
                        content: node.innerText.trim(),
                        styles: node.getAttribute('style') || "",
                        id: index + 1
                    }];
                }
                jsonResult.push(jsonItem);
            }
        });
        return jsonResult;
    }

    function compareAndStoreChanges(newJson) {
        if (!window.editorChanges) window.editorChanges = []
        const oldJson = (window?.editorChanges?.length ?? 0) > 0 ? window.editorChanges[window.editorChanges.length - 1] : [];
        const changes = [];
        
        newJson.forEach(newItem => {
            const existingItem = oldJson.find(item => item.id === newItem.id);
            
            if (!existingItem) {
                changes.push({ ...newItem, action: 'added', start: 0, end: newItem.blocks ? newItem.blocks[0].content.length : 0 });
            } else if (JSON.stringify(existingItem) !== JSON.stringify(newItem)) {
                changes.push({ ...newItem, action: 'modified' });
            }
        });
        
        oldJson.forEach(oldItem => {
            if (!newJson.find(newItem => newItem.id === oldItem.id)) {
                changes.push({ ...oldItem, action: 'deleted' });
            }
        });

        if (changes.length > 0) {
            window.editorChanges.push(newJson);
        }
    }

    function getBoundingBox(element) {
        const rect = element.getBoundingClientRect();
        return [rect.left, rect.top, rect.right, rect.bottom];
    }

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
        let editor = tinymce.get('editor1') ?? tinymce.activeEditor; 
        if (typeof is_edit == 'undefined') {
            is_edit = !editor.hasEditableRoot();
        }
        if (is_edit) {
            editor.setEditableRoot(true); 
            editor.getContainer().querySelector('.tox-toolbar').style.display = 'block'; 
            
            setTimeout(() => editor.dom.select('.xmodified').forEach(el => el.classList.remove('view')), 100)
            
        } else {
            editor.setEditableRoot(false);
            editor.getContainer().querySelector('.tox-toolbar').style.display = 'none'; 
            editor.getContainer().querySelector('.tox-menubar').style.display = 'none'; 
            setTimeout(() => editor.dom.select('.xmodified').forEach(el => el.classList.add('view')), 100)
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

    function updateTags() {
        tagsContainer.innerHTML = '';

        checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            const tag = document.createElement('span');
            tag.id = checkbox.id
            tag.textContent = checkbox.name;
            tag.style.display = 'inline-block';
            tag.style.padding = '4px 8px';
            tag.style.margin = '4px';
            tag.style.border = '1px solid #ccc';
            tag.style.borderRadius = '4px';
            tag.style.backgroundColor = '#f0f0f0';
            tag.style.fontSize = '14px';
            tagsContainer.appendChild(tag);
        }
        });
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateTags);
    });


    let conditions_checked = []
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

        conditions_checked.forEach(c => {

        })

        $checkboxes = $conditions.querySelectorAll('input[type=checkbox]')
        $checkboxes.forEach(c => {
            if (conditions_checked.some(c.id)) c.checked = true
            c.disabled = true
        })
        conditions_checked = []
    }

    document.querySelector('button#save-new').addEventListener('click', function() {
        saveNewAdaptation()
    })

    document.querySelector('button#create-new').addEventListener('click', function() {
        createNewAdaptation()
    })

    document.querySelector('button#cancel-new').addEventListener('click', function() {
        createNewAdaptation()
    })

    function saveNewAdaptation() {
        const $button_save = document.querySelector('#save-new')
        const $button_cancel = document.querySelector('#cancel-new')
        const $checkboxes = document.querySelectorAll('.variant-conditions input[type=checkbox]');

        $checkboxes.forEach(c => c.disabled= true)
        $button_cancel.disabled = true
        $button_save = true

        const data = {}
        fetch("{{ route('v.variant.store') }}", {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(data)
        }).then(e => {

        }).catch(error => {

        }).finally(() => {
            $button_cancel.disabled = false
            $button_save = false
        })
    }

</script>