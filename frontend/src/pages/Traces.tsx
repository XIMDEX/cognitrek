import { useEffect, useState } from "react"
import { getAdaptationsResource, getAllResourcesCognitrek, getAllResourcesXDam } from "../services/resourceService"
import { ResourceGroup } from "../interfaces/resources"
import TraceLLM from "../components/TraceLLM"
import LibraryIcon from "../components/icons/LibraryIcon"
import { Select } from "../components/ui/Select"
import { useLocation, useNavigate } from "react-router-dom"
import Button from "../components/ui/Button"

export default function Traces() {
    const location = useLocation();
    const { state } = location.state || {};
    const [resources, setResources] = useState<ResourceGroup[]>([])

    useEffect(() => {
        if (resources.length > 0 || state) return
        
        const getResources = async () => {
            const promises = [
                getAllResourcesXDam().then(e => ({type: 'xdam', resources: e})).catch(() => ({type: 'xdam', resources: []})),
                getAllResourcesCognitrek().then(e => ({type: 'cognitrek', resources: e})).catch(() => ({type: 'cognitrek', resources: []}))
            ]
            const output = []
            let cognitrek = []
            let xdam = []
            const responses = await Promise.allSettled(promises)    
            responses.forEach((response) => {
                if (response.status === 'fulfilled') {
                    if (response.value.type === 'xdam') {
                        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
                        // @ts-expect-error
                        xdam = response.value.resources.data
                    } else {
                        cognitrek = response.value.resources
                    }
                }
            })

            cognitrek.forEach((resource: {xdam_id: string}) => {
                const xdam_r = xdam.find((r: {id: string}) => r.id === resource.xdam_id)
                if (xdam_r) {
                    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
                    // @ts-expect-error
                    output.push({
                        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
                        // @ts-expect-error
                        ...xdam_r,
                        ...resource, 
                    })
                }
            })

            setResources(output)
        }

        getResources()
    }, [resources.length, state])
    

    return (
        <section className="h-full flex flex-col p-6 gap-8">
            <h1 className="text-3xl font-bold text-gray-900">Trace for resources</h1>
            
            <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                {state && (
                    <TraceLLM title={state.title} id={state.id} label={state.label} />)}
                {!state && resources.map((resource: {id: string, name: string}) => (
                    <TraceCardResource key={resource.id} resource={resource} />
                ))}
            </div>
        </section>
    )
}

const TraceCardResource = ({ resource }) => {
    const [adaptations, setAdaptations] = useState([])
    const navigate = useNavigate()

    useEffect(() => {
        if (adaptations.length > 0) return
        getAdaptationsResource(resource.xdam_id)
            .then((data) => {
                setAdaptations(data)
            })
            .catch((err) => {
                console.error(err)
            })
    }, [adaptations.length, resource.xdam_id])

    const handleSelect = (e) => {
        navigate(`/traces/${resource.id}`, {
            state: {
                label: e.target.value,
                id: resource.id,
                title: resource.name
            }
        })
    }

    const handleClick = () => {
        navigate(`/trace/${resource.id}`, {
            state: {
                label: adaptations[0],
                id: resource.id,
                title: resource.name
            }
        })
    }

    return (
        <div className="rounded-lg border bg-white p-6 shadow-sm flex flex-col gap-4">
            <h3 className="flex flex-row gap-2">
                <LibraryIcon  className="" />
                <span>{resource.name}</span>
            </h3>
            <Select 
                selectId={resource.id} 
                options={adaptations}
                onChange={handleSelect}
                placeholder="Select a trace"
                className="" 
            />
            <div className="flex justify-end">
               <Button size="sm" onClick={handleClick}>View Trace</Button>
            </div>
        </div>
    )
}