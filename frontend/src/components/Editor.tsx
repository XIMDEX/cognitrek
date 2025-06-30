import { useEffect, useState } from "react";
import XEditor from "../components/XEditor";
import { COGNITREK_BACKEND_URL } from "../config/constants";

const handleData = (data) => {
    return data.resource.sections.map(section => {
        return `
            <section class="book-container ${data.dyslexic_level ? 'level-' + data.dyslexic_level  : '' }">
            ${ section.blocks.map(block => {
                if (block.type == 'p' || block.type == 'text') {
                    if(block.original) {
                        return `  
                            <div class="nonedit" style="display: flex; flex-direction: row; align-items: start;;margin-bottom: 10px; width: 100%; ">
                                <div>
                                    <button class="show-config button-gear"  style="aspect-ratio: 1">⚙️</button>
                                </div>
                                <div style=" border: 1px solid gray; flex-grow: 1; border-radius: 5px;">
                                    <div>
                                        <div class="actions" style="display: none; justify-content: end; border-bottom: 1px solid lightgray; align-items: center;"> 
                                            <span style="padding-inline: 10px; font-size: 0.75rem;"><em>Name condition change:</em></span>
                                            <span id="current-change-condition" style="flex-grow: 1; font-weight: bold; font-size: 0.75rem;">Dyslexia LOW</span>
                                            <button class="button-condition button-undo" style="aspect-ratio: 1">⬅️</button>
                                            <button class="button-condition button-redo" style="aspect-ratio: 1">➡️</button>
                                            <button class="button-condition button-accept" style="aspect-ratio: 1">✅ƒ</button>

                                        </div>
                                        <p class="xcontent" style="padding-inline: 15px; ${block.styles}" id="${block.id}">

                                            ${block.blocks.map(item => {
                                                if (item.modified && Array.isArray(item.modified) && item.modified.length > 0) {
                                                    const modification = item.modified[item.modified.length - 1]
                                                    let lastIndex = 0
                                                    let output = item.content.substring(lastIndex, modification.start - lastIndex)
                                                    let title = modification.original
                                                    if (modification.action == 'deleted') title = 'Deleted'
                                                    if (modification.action == 'added') title = 'Added'

                                                    output += `<span class="xmodified view ${modification.action}" title="${title}">`
                                                    output += modification.action == 'deleted'
                                                        ? item.content.substring(lastIndex, modification.end - modification.start)
                                                        : modification.content
                                                    output += '</span>'
                                                    output += item.content.substring(lastIndex, -1)
                                                    lastIndex = modification.end
                                                    return output
                                                } else {
                                                    return item.content
                                                }
                                            }).join("\n")}
                                        </p>
                                    </div>
                                    <div class="original" style=" background-color: #efefef; display: none; flex-direction: column; border-top: 1px solid gray;"> 
                                        <span style="font-size: 0.7rem; background-color: #cdcdcd; padding: 5px 10px;">
                                            Original Text
                                        </span>
                                        <p style="padding-inline: 15px;${block.styles}" id="${block.id}">
                                            ${block.blocks.map(item => {
                                                if (item.type === 'text') {
                                                    return item.content
                                                } else {
                                                    return `<${item.type} id="${item.id}" style="${item.styles}"> ${item.content}</${item.type}>`
                                                }
                                            }).join("\n")}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        `
                    } else {
                        return `
                            <p style="margin-left: 38px;${block.styles}" id="${block.id} >
                                ${ block.blocks.map(sub_block => {
                                    if (sub_block.type == 'text') {
                                        return sub_block
                                    } else {
                                        return `<${sub_block.type} id="${sub_block.id}" style="${sub_block.styles}"> ${sub_block.content}</${sub_block.type}>`
                                    }
                                }).join("\n") }
                            </p>
                        `
                    }

                } else if (block.type == 'image') {
                    return `<img  src="${COGNITREK_BACKEND_URL.replace('api/v1', '')}/storage/${block.path}" alt="${block.alt}" style="max-width: calc(100% - 36px); margin-left: 38px;${block.styles}" />`
                }
            }).join("n") }
            </section>
        `
    }).join("\n")
}

export default function Editor({resourceId}) {
    const [data, setData] = useState(false)

    useEffect(() => {
        fetch(COGNITREK_BACKEND_URL + '/visor/' + resourceId + '?json=true')
            .then(e => e.json())
            .then(json => setData(json))
            .catch(console.error)
    }, [resourceId])

    return (
        <XEditor data={data ? handleData(data) : ""}/> 
    )
}

