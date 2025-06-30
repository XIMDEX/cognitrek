
export const XDAM_FRONTEND_URL = import.meta.env.VITE_XDAM_FRONTEND_URL;
export const COGNITREK_BACKEND_URL = import.meta.env.VITE_COGNITREK_BACKEND_URL;
export const XDAM_BACKEND_URL = import.meta.env.VITE_XDAM_BACKEND_URL;

export const LOGIN_PATH = COGNITREK_BACKEND_URL + '/xauth/login';
export const LOGOUT_PATH = COGNITREK_BACKEND_URL + '/xauth/logout';
export const WHOAMI_PATH = COGNITREK_BACKEND_URL + '/xauth/me';

export const ROLES = {
    ADMIN: 'admin',
    SUPERADMIN: 'super-admin',
    USER: 'user',
    EDITOR: 'editor',
    VIEWER: 'viewer',
}

export const DOCUMENT_CORE_ID = import.meta.env.VITE_DOCUMENT_CORE_ID;