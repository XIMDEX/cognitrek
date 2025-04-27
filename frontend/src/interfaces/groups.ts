import { ResourceGroup } from "./resources";
import { User } from "./user";

export interface Group {
    id: string;
    name: string;
    type: string;
    organization_id: string;
} 

export interface GroupUserResonse {
    data: User[];
    error?: string;
}

export interface GroupUsers {
    users: User[];
    name: string;
    id: string;
    type: string;
    resources?: ResourceGroup[]
}