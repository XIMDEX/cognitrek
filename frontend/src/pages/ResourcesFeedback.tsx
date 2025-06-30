import { useEffect, useState } from "react"
import { ResourceGroup } from "../interfaces/resources"
import ResourceFeedbackCard from "../components/ResourceFeedbackCard"
import { getAllResourcesCognitrek, getAllResourcesXDam } from "../services/resourceService"

export default function ResourcesFeedback() {
    const [resources, setResources] = useState<ResourceGroup[]>([])

    useEffect(() => {
        if (resources.length > 0) return
        
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
    }, [resources.length])

    return (
        <section className="h-full flex flex-col p-6 gap-8">
            <h1 className="text-3xl font-bold text-gray-900">Feedback of resources </h1>
            
            <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                {resources.map((resource: {id: string, name: string}) => (
                    <ResourceFeedbackCard key={resource.id} resource={resource} />
                ))}
            </div>
        </section>
    )
}

