import { COGNITREK_BACKEND_URL } from "../config/constants"
import { useAuthStore } from "../store/authStore"

export const getFeedbacksResource = async (resourceId: string) => {
    const {user} = useAuthStore.getState()
    const response = await fetch(`${COGNITREK_BACKEND_URL}/resources/${resourceId}/feedbacks`, {
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

    throw new Error(`Error getting feedbacks for resource ${resourceId}`)
}

export const getFeebacksResourceByUser = async (resourceId: string, userId: string) => {
    const {user} = useAuthStore.getState()
    const response = await fetch(`${COGNITREK_BACKEND_URL}/resources/${resourceId}/users/${userId}/feedbacks`, {
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

    throw new Error(`Error getting feedbacks for user ${userId} on resource ${resourceId}`)
}