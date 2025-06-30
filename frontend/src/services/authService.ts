import { LOGIN_PATH, LOGOUT_PATH, ROLES } from "../config/constants";
import { Credentials, LoginResponse } from "../interfaces/auth";
import { UserLogged } from "../interfaces/user";


export const loginService = async (credentials: Credentials): Promise<LoginResponse> => {
    try
    {
        const response = await fetch(LOGIN_PATH, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(credentials),
        });
        const data = await parseResponse(response);
        return data;
    }
    catch (e) {
        console.error(e);
        return { user: null, error: 'Error in login' };
    }
};

export const logoutService = async (user) => {

    try {
        const response = await fetch(LOGOUT_PATH, {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${user.token}`
            },
        })
        return response.ok;
    } catch (e) {
        console.error(e);
        return false;
    }
}



const parseResponse = async (response: Response) => {
    const data: LoginResponse = {
        user: null,
    }
    if (response.ok) {
        const json = await response.json();
        data.user = parseUser(json);
    } else {
        const error = await response.json();
        data.error = error.message ?? error.error;
    }
    return data;
}

// eslint-disable-next-line @typescript-eslint/no-explicit-any
export const parseUser = (data: any, token?: string): UserLogged => {
    const user: UserLogged = {
        id: data.id,
        name: data.name,
        token: data.access_token ?? token,
        email: data.email,
        isAuth: true
    }

    if (data.workspaces) {
        user.groups = data.workspaces;
    }

    if (data.role) {
        user.role = parseRol(data.role.name);
    }
    return user;
    
}

const parseRol = (role: string ): (typeof ROLES)[keyof typeof ROLES] => {
    switch (role) {
        case 'super-admin':
            return ROLES.SUPERADMIN;
        case 'admin':
            return ROLES.ADMIN;
        case 'editor':
            return ROLES.EDITOR;
        case 'user':
            return ROLES.USER;
        default:
            return ROLES.VIEWER;
    }
}