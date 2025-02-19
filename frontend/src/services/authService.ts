import { COGNITREK_BACKEND_URL } from "../config/constants";

export interface Credentials {
    email: string;
    password: string;
}

export interface User {
    id: string;
    name: string;
}

export interface LoginResponse {
    user: User | null;
    error?: string;
}

export const loginService = async (credentials: Credentials): Promise<LoginResponse> => {
    const response = await fetch(COGNITREK_BACKEND_URL + '/api/v1/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(credentials),
    });
    const data = await parseResponse(response);
    return data;
};

const parseResponse = async (response: Response) => {
    const data: LoginResponse = {
        user: null,
    }
    if (response.ok) {
        const json = await response.json();
        data.user = parseUser(json);
    } else {
        const error = await response.json();
        data.error = error.message;
    }
    return data;
}

// eslint-disable-next-line @typescript-eslint/no-explicit-any
const parseUser = (data: any): User => {
    return {
            id: data.id,
            name: data.name,
    }
    
}