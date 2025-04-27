import { useEffect, useMemo, useState } from "react";
import VisorContent from "../components/Visors/VisorContent";
import VisorMarkmap from "../components/Visors/VisorMarkmap";
import VisorSummary from "../components/Visors/VisorSummary";
import { COGNITREK_BACKEND_URL } from "../config/constants";
import { useLocation } from "react-router-dom";

const VISOR_TYPE = {
    CONTENT: 'content',
    SUMMARY: 'summary',
    MARKMAP: 'conceptual_map'
}

export default function Visor({resourceId=''}) {
    const location = useLocation()
    const resource_id = useMemo(() =>  resourceId !== '' || location.state?.resourceId, [resourceId, location.state])
    const [type, setType] = useState(VISOR_TYPE.SUMMARY)
    const [value, setValues] = useState({[VISOR_TYPE.CONTENT]: false, [VISOR_TYPE.SUMMARY]: false, [VISOR_TYPE.MARKMAP]: false})
    
    //!! to delete when usee it
    console.log(setType)
    
    useEffect(() => {
        if (!value[type]) {
            fetch(COGNITREK_BACKEND_URL + '/resources/' + resource_id + '/' + type)
                .then(e => e.json())
                .then(e => {
                    setValues({...value, [type]: e[type] })
                })
        }

    }, [value, type, resource_id])

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