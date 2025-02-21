import { UserLogged } from "./user";

export interface AuthState {
    user: UserLogged | null;
    loading: boolean;
    error: string | null;
    setUser: (user: UserLogged | null) => void;
    setLoading: (loading: boolean) => void;
    setError: (error: string | null) => void;
}

export interface Credentials {
    email: string;
    password: string;
}


export interface LoginResponse {
    user: UserLogged | null;
    error?: string;
}