
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
            .xontainer {

        `, 
        noneditable_class: 'nonedit',
        editable_class: 'editcontent',
        contextmenu: 'cut copy paste autolink link image',
        plugins: 'advlist autolink link image lists media table charmap codesample',
        toolbar: [`undo redo bold italic forecolor backcolor fontsizeselect alignleft aligncenter alignright alignjustify bullist numlist outdent indent removeformat link list table charmap `],
        fontsize_formats: "8pt 10pt 12pt 14pt 18pt",
        font_formats: "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Cursive=cursive; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva;",
        statusbar: false,
        readonly: false,
        htmlAllowedTags:  ['.*'],
        htmlAllowedAttrs: ['.*'],
        extended_valid_elements: '*[.*]',
        init_instance_callback: function (editor) {
            var promotion = document.querySelector('div.tox-promotion')
            promotion.style.display = 'none';
            toggleEditMode(false)   
        },
        setup: function(editor) {
            editor.on('input SetContent', (event) => {
                trackChanges(editor);
            })

            editor.on('KeyDown',  (event) => {
                trackChanges(editor);
                var content = editor?.getContent({ format: 'text' });
                var maxChars = editor.getParam('max_num_characters');
                if(content.length >= maxChars && event.keyCode !== 8){
                    event.preventDefault();
                    event.stopPropagation();
                }
            });
            editor.on('NodeChange', (event) => {
                trackChanges(editor)
            })
        }
    });
</script>