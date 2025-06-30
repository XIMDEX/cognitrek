import { Editor } from "@tinymce/tinymce-react";
import { useRef } from "react";
import { COGNITREK_BACKEND_URL } from "../../config/constants";

export default function XEditor({ data = "" }) {

    const editorRef = useRef(null);

    const handleOnInit = (_, editor) => {
        editorRef.current = editor
    }
    
    return (
        <>
            <Editor
                tinymceScriptSrc={COGNITREK_BACKEND_URL.replace('api/v1', 'lib/tinymce/tinymce.min.js')}
                onInit={handleOnInit}
                initialValue={data}
                licenseKey="gpl"
                init={{
                    height: 500,
                    menubar: false,
                    contextmenu: 'cut copy paste autolink link image',
                    plugins: 'advlist autolink link image lists media table charmap codesample',
                    toolbar: [`undo redo bold italic forecolor backcolor fontsizeselect fontselect alignleft aligncenter alignright alignjustify bullist numlist outdent indent removeformat link list table charmap  `],
                    content_style: `
                        .view.modified, .view.modified.noedit { padding-left: 2px; background-color: #FFF9C4; }
                        .view.deleted { padding-left: 2px; background-color: #FFCDD2; text-decoration: line-through; } 
                        .view.added { background-color: #C8E6C9; }
                        button.view { background-color: #dcdcdc; border: 1px solid #444444; border-radius: 5px; transitions: all .2s ease; cursor: pointe   r; }
                        button.view:hover { background-color: #dcdcdc !important;}
                        .xhidden { display: none;}
                        button.button-condition, button.button-gear { cursor: pointer; } 
                    `,
                    font_family_formats: "8pt 10pt 12pt 14pt 18pt",
                    default_font_stack: ["Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Cursive=cursive; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new     roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva;"],
                    statusbar: false,
                    disabled: true,
                    htmlAllowedTags:  ['.*'],
                    htmlAllowedAttrs: ['.*'],
                    extended_valid_elements: '*[.*]',
                }}
            />
        </>
    )
}