import { useEffect, useState } from "react"
import LibraryIcon from "../icons/LibraryIcon"
import { Select } from "./Select"
import { getAdaptationsResource, getAdaptationUserResource } from "../../services/resourceService"

export default function CardResourceAssign({resource, userId, onChange}) {
    const [data, setData] = useState([])
    const [error, setError] = useState<Error|null>(null)

    useEffect(() => {
        const handleAdaptations = async () => {
            try {
                const adaptations = await getAdaptationsResource(resource.id)
                const userAdaptation = await getAdaptationUserResource(resource.id, userId)
    
                // TODO: Adaptations should be merged with userAdaptation
                setData([...adaptations, ...userAdaptation])

            } catch (error) {
                setError((error as Error))
            }
        }
        

        handleAdaptations()
    }, [resource, userId])

    if (error) {
        console.error(error?.message)
        throw error
    }

    return (
        <div className="flex flex-row  justify-between py-2 odd:bg-gray-50 even:bg-white items-center px-5">
            <div className="flex flex-row gap-2">
                <LibraryIcon  className="" />
                <span>{resource.name}</span>
            </div>
            <Select 
                options={[
                    {value: "0", label: "Original", selected: !data.some((e: {id: string, label:string, selected?: boolean}) => e.selected)},
                    ...data.map((variant: {id: string, label:string, selected?: boolean}) => ({value: variant.id, label: variant.label, selected: variant?.selected ?? false}))
                ]}
                selectId={resource.id}
                onChange={onChange}
                className="w-1/2"
            />
        </div>
    )
}