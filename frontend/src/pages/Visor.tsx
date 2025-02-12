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

export default function Visor({resourceId}) {
    const [type, setType] = useState(VISOR_TYPE.SUMMARY)
    const [value, setValues] = useState({[VISOR_TYPE.CONTENT]: false, [VISOR_TYPE.SUMMARY]: false, [VISOR_TYPE.MARKMAP]: false})

    useEffect(() => {
        if (!value[type]) {
            fetch(COGNITREK_BACKEND_URL + '/resources/' + resourceId + '/' + type)
                .then(e => e.json())
                .then(e => {
                    setValues({...value, [type]: e[type] })
                })
        }

    }, [value, type])

    return (
        <div className="flex flex-row h-full">
            <div>Demo</div>
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
            <div className="w-[400px] bg-secondary" style={{minWidth: 400}}>
            </div>
        </div>
    )
}