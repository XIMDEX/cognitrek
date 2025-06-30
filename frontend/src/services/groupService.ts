import { XDAM_BACKEND_URL } from "../config/constants";
import { Group, GroupUsers } from "../interfaces/groups";
import { User } from "../interfaces/user";
import { useAuthStore } from "../store/authStore";

const {user} = useAuthStore.getState();

export const getGroups = async (): Promise<GroupUsers[]> => {
    let output: GroupUsers[] = [];
    if ((user?.groups?.length ?? 0) == 0) {
        return output
    }
    
    const promisesUsers = user?.groups?.map(async (group) => {
        return getUsersGroup(group)
    })

    const promisesResources = user?.groups?.map(async (group) => {
        return getResourcesGroup(group)
    })


    if (promisesUsers) {
        const results = await Promise.allSettled(promisesUsers)
        output = results
            .filter(result => result.status === 'fulfilled' && result.value !== null)
            .map(result => (result as unknown as PromiseFulfilledResult<GroupUsers>).value);
    }

    if (promisesResources) {
        const resources_results = await Promise.allSettled(promisesResources)
        resources_results
            .filter(result => result.status === 'fulfilled' && result.value !== null)
            .forEach(result => {
                const {data} = (result as unknown as PromiseFulfilledResult<ResourceGroupResponse>).value
                Object.keys(data).forEach(id => {
                    const idxGroup = output.findIndex((g: GroupUsers) => g.id == id)
                    if (idxGroup >= 0) {
                        output[idxGroup].resources = data[id].filter(resource => resource.type === 'document')
                    }
                })
            });
    }

    return output
}

export const getUsersGroup = async (group): Promise<GroupUsers> => {
    const response = await fetch(`${XDAM_BACKEND_URL}/workspace/${group.id}/users`,{
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${user?.token}`
        }
    })
    if (response.ok) {
        const {data} = await response.json()
        return {
            id: group.id,
            name: group.name,
            type: group.type,
            users: data.map((user): User => {
                return {
                    id: user.id,
                    name: user.name,
                    email: user.email,
                }
            })
        }
    } else {
        return Promise.reject('Error fetching data')
    }
}

interface ResourceGroupResponse {
    data: { name: string; id: string; type: string }[];
    error?: string;
}

export const getResourcesGroup = async (group: Group): Promise<ResourceGroupResponse> => {
    const output: ResourceGroupResponse  = {data: []} 
    const response = await fetch(`${XDAM_BACKEND_URL}/user/workspaces/${group.id}/resources`,{
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${user?.token}`
        } 
    })
    if (response.ok) {
        const {data} = await response.json()
        data.forEach(resource => {
            if (!output.data[group.id]) output.data[group.id] = []
            output.data[group.id].push({
                name: resource.name,
                id: resource.id,
                type: resource.type
            })
            
        });
    } else {
        output.error = 'Error fetching data'
    }
    return output
}
