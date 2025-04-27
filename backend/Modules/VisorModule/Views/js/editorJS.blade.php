
<script>
    tinymce.init({
        selector: 'textarea',
        content_css: false,
        license_key: 'gpl',
        height: '100%',
        content_style: `
            .view.modified, .view.modified.noedit { padding-left: 2px; background-color: #FFF9C4; }
            .view.deleted { padding-left: 2px; background-color: #FFCDD2; text-decoration: line-through; }
            .view.added { background-color: #C8E6C9; }
            button.view { background-color: #dcdcdc; border: 1px solid #444444; border-radius: 5px; transitions: all .2s ease; cursor: pointe   r; }
            button.view:hover { background-color: #dcdcdc !important;}
            .xhidden { display: none;}
            button.button-condition, button.button-gear { cursor: pointer; }
        `,
        noneditable_class: 'nonedit',
        editable_class: 'editcontent',
        contextmenu: 'cut copy paste autolink link image',
        plugins: 'advlist autolink link image lists media table charmap codesample',
        toolbar: [
            `undo redo | bold italic forecolor backcolor fontsizeselect fontfamily | alignrigth alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat link list table charmap `],
        fontsize_formats: "8pt 10pt 12pt 14pt 18pt",
        font_formats: "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Cursive=cursive; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva;",
        statusbar: false,
        menubar: false,
        disabled: !edit_mode,
        htmlAllowedTags:  ['.*'],
        htmlAllowedAttrs: ['.*'],
        extended_valid_elements: '*[.*]',
        init_instance_callback: function (editor) {
            // var promotion = document.querySelector('div.tox-promotion')
            // promotion.style.display = 'none';
            handleEditMode(editor, edit_mode)
            // toggleEditMode(false)

            const editor_body = editor.getBody()
            const gear_button = editor_body.querySelectorAll('.show-config')
            const undo_button = editor_body.querySelectorAll('.button-undo')
            const redo_button = editor_body.querySelectorAll('.button-redo')
            const accept_button = editor_body.querySelectorAll('.button-accept')

            gear_button.forEach(button => button.addEventListener('click', evt => handleSetting(evt, editor)))
            undo_button.forEach(button => button.addEventListener('click', evt => handleUndo(evt, editor)))
            redo_button.forEach(button => button.addEventListener('click', evt => handleRedo(evt, editor)))
            accept_button.forEach(button => button.addEventListener('click', evt => handleAccept(evt, editor)))
        },
        setup: function(editor) {
            editor.on('NodeChange', (event) => {
                handleEdit(event, editor)
            })
        }
    });

    function handleUndo(evt, editor) {
        const {blockid, conditionid} = evt.currentTarget.dataset
        
        const mod = blocks_modified.find(e => e.id == blockid)

        console.log(mod, blocks_modified)
        // if (idx_block > 0) {
        //     mod[idx_block-1]
        // }
    }

    function handleRedo(evt, editor) {
        const {blockid, conditionid} = evt.currentTarget.dataset
        
        const mod = blocks_modified.find(e => e.id == blockid)

        
        // if (idx_block > mod.blocks) {
        //     blocks_modified[idx_block+1]
        // }
    }


    function handleAccept(evt, editor) {
        const {blockid, conditionid} = evt.currentTarget.dataset
        
        const mod = blocks_modified.find(e => e.id == blockid)

    }

    function handleSetting({currentTarget}, editor) {
        const parent = currentTarget.parentElement.parentElement
        const is_showing = parent.getAttribute('data-show') == 'true'
        parent.setAttribute('data-show', is_showing ? 'false' : 'true')
        if (!is_showing) {
            parent.querySelector('.actions').style.display = 'flex';
            parent.querySelector('.original').style.display = 'flex';
            const $content = parent.querySelector('.xcontent')
            editor.dom.removeClass($content, 'nonedit')
            editor.dom.addClass($content, 'editcontent')
            $content.classList.remove('noeditcontent')
            $content.classList.add('editcontent')
            if (editor.hasEditableRoot()) {
                editor.dom.setAttrib($content, 'contenteditable', 'true');
            }
        } else {
            parent.querySelector('.actions').style.display = 'none';
            parent.querySelector('.original').style.display = 'none';
            const $content = parent.querySelector('.xcontent')
            editor.dom.addClass($content, 'nonedit')
            editor.dom.removeClass($content, 'editcontent')
            $content.classList.add('noeditcontent')
            $content.classList.remove('editcontent')
            if (editor.hasEditableRoot()) {
                $content.removeAttribute('contenteditable')
            }
        }
    }

    window.user_data = []

    function handleEdit(evt, editor) {
        let element = evt.element
        if (element.nodeName == 'SECTION' || element.nodeName == 'BODY') return;
        if (window.user_data.length == 0) {
            window.user_data = Array.from({ 
                length:  editor.getBody().querySelectorAll('section.book-container').length}, 
                () => []
            );
        }
        let section = evt.parents.find(p => p.nodeName === 'SECTION' )
        let section_id = section.dataset.sectionid
        let idx = window.user_data[section_id].findIndex(ud => ud.id == element.id)
        if (idx >= 0) {
            let inside = window.user_data[section_id][idx]
            if (window.user_data[section_id][idx].outerHTML !== element.outerHTML) {
                window.user_data[section_id][idx].outerHTML = element.outerHTML
                window.user_data[section_id][idx].change = parseHTML(element)
            }
        } else {
            window.user_data[section_id].push({
                outerHTML: element.outerHTML,
                block_id: element.id,
                change: parseHTML(element, section.dataset.sectionid)
            })
            window.is_changed = true

        }
    }

    function parseHTML(html, section_id) {
        let json = {
            id: html.id,
            type: 'modfied',
            modified_text: html.textContent,
            start_position_modification: 0,
            end_position_modification: html.textContent.length - 1
        }

        return json
    }

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
        console.log({jsonResult})
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

</script>
