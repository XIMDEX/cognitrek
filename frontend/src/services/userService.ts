import { WHOAMI_PATH } from '../config/constants';
import { UserLogged } from '../interfaces/user';
import { parseUser } from './authService';

export const whoamiService = async (token): Promise<UserLogged | null> => {
    const {user} = (await import('../store/authStore')).useAuthStore.getState();
    const response = await fetch(WHOAMI_PATH, {
        method: 'GET',
        headers: { 
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token ?? user?.token}`
        },
    })
    if (response.ok) {
        const json = await response.json();
        return parseUser(json, token);
    }
    return null;
}