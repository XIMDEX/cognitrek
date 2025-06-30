import { ROLES } from "../config/constants";

export interface User {
    id: string;
    name: string;
    email: string;
    image?: string;
    role?: (typeof ROLES)[keyof typeof ROLES];
    groups?: Group[];
}

export interface Group {
    id: string;
    name: string;
    type: string;
    organization_id: string;
} 

export interface UserLogged extends User {
    token: string;
    isAuth: boolean;
} 