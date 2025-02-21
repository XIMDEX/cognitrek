import { useEffect, useState } from "react"
import { COGNITREK_BACKEND_URL } from "../../config/constants"
import { useAuthStore } from "../../store/authStore"
import LibraryIcon from "../icons/LibraryIcon"
import { Select } from "./Select"

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
        console.log(error?.message)
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
                    {value: "0", label: "Original", selected: true},
                    ...data.map((variant: {id: string, label:string}) => ({value: variant.id, label: variant.label, selected: false}))
                ]}
                selectId={resource.id}
                onChange={onChange}
                className="w-1/2"
            />
        </div>
    )
}

// const getVariantsResource = async (resourceId, userId) => {
//     const {user} = useAuthStore.getState()
//     const response = await fetch(`${COGNITREK_BACKEND_URL}/resources/${resourceId}/variants`, {
//         method: 'GET',
//         headers: {
//             'Content-Type': 'application/json',
//             'Auhorization': `Bearer ${user?.token}`
//         }
//     })
//     let data = []
//     if (response.ok) {
//         data = await response.json()
//         return data
//     }

//     return []

//     throw new Error(`Error getting variants for user ${userId} on resource ${resourceId}`)
// }

const getAdaptationsResource = async (resourceId) => {

    const {user} = useAuthStore.getState()
    const response = await fetch(`${COGNITREK_BACKEND_URL}/resources/${resourceId}/adaptations`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Auhorization': `Bearer ${user?.token}`
        }
    })
    let data = []
    if (response.ok) {
        data = await response.json()
        return data
    }

    //! Handle resources not found on cognitrek
    return []

    throw new Error(`Error getting variants for user ${user?.id} on resource ${resourceId}`)
}


const getAdaptationUserResource = async (resourceId, userId) => {
    
    const {user} = useAuthStore.getState()
    const response = await fetch(`${COGNITREK_BACKEND_URL}/resources/${resourceId}/users/${userId}/adaptations`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Auhorization': `Bearer ${user?.token}`
        }
    })
    let data = []
    if (response.ok) {
        data = await response.json()
        return data
    }

    //! Handle resources not found on cognitrek
    return []

    throw new Error(`Error getting variants for user ${userId} on resource ${resourceId}`)
}