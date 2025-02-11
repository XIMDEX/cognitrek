import { useEffect, useState } from "react";
import VisorContent from "../components/Visors/VisorContent";
import VisorMarkmap from "../components/Visors/VisorMarkmap";
import VisorSummary from "../components/Visors/VisorSummary";
import { COGNITREK_BACKEND_URL } from "../config/constants";

const VISOR_TYPE = {
    CONTENT: 'content',
    SUMMARY: 'summary',
    MARKMAP: 'conceptual_map'
}

const demo = "9e196695-825b-4265-8ecb-b0073146f7f4"

export default function Visor() {
    const [type, setType] = useState(VISOR_TYPE.MARKMAP)
    const [value, setValues] = useState({[VISOR_TYPE.CONTENT]: false, [VISOR_TYPE.SUMMARY]: false, [VISOR_TYPE.MARKMAP]: false})

    useEffect(() => {
        if (!value[type]) {
            fetch(COGNITREK_BACKEND_URL + '/resources/' + demo + '/' + type)
                .then(e => e.json())
                .then(e => {
                    console.log(e)
                    setValues({...value, [type]: e[type] })
                })
        }

    }, [value, type])

    return (
        <div className="flex flex-row h-full">
            <div className="grow">
                {!value[type] && (
                    <p>Loading...</p>
                )}
                {type === VISOR_TYPE.SUMMARY && value[type] && (
                    <VisorSummary content={value[type]} />
                )}
                {type === VISOR_TYPE.MARKMAP && value[type] && (
                    <VisorMarkmap content={value[type]} />
                )}
                {type === VISOR_TYPE.CONTENT && value[type] && (
                    <VisorContent content={""} />
                )}
            </div>
            <div className="w-[400px] bg-secondary">
ds
            </div>
        </div>
    )
}