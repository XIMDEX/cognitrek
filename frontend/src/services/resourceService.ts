import { COGNITREK_BACKEND_URL, DOCUMENT_CORE_ID, XDAM_BACKEND_URL } from "../config/constants"
import { useAuthStore } from "../store/authStore"

export const getAdaptationsResource = async (resourceId) => {

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

export const getAdaptationUserResource = async (resourceId, userId) => {
    
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

    throw new Error(`Error getting variants for user ${userId} on resource ${resourceId}`)
}


export const assingAdaptationResource = async (resourceId:string, userId: string, adaptationId: string) => {
    const {user} = useAuthStore.getState()
    const response = await fetch(`${COGNITREK_BACKEND_URL}/resources/${resourceId}/users/${userId}/adaptations`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Auhorization': `Bearer ${user?.token}`
        },
        body: JSON.stringify({
            'adaptation_id': adaptationId
        })
    })
    if (response.ok) {
        return await response.json()
    }

    throw new Error(`Error assigning adaptation ${adaptationId} to user ${userId} on resource ${resourceId}`)
}

export const getAllResourcesCognitrek = async () => {
    const {user} = useAuthStore.getState()
    const response = await fetch(`${COGNITREK_BACKEND_URL}/resources`, {
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

    throw new Error(`Error getting all resources`)
}

export const getAllResourcesXDam = async () => {
    const {user} = useAuthStore.getState()
    const response = await fetch(`${XDAM_BACKEND_URL}/catalogue/${DOCUMENT_CORE_ID}?page=1&search=&limit=48`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${user?.token}`
        }
    })
    let data = []
    if (response.ok) {
        data = await response.json()
        return data
    }

    throw new Error(`Error getting all resources`)
}
