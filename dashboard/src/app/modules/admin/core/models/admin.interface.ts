export interface IAdminResponseP {
    name: string;
    surname: string;
    email: string;
    phone?: string;
    phone_code?: string;
    created_at: string;
    id: number;
}

export interface IAdminCreateRequest {
    name: string;
    surname: string;
    email: string;
    phone?: string;
    phone_code?: string;
    password: string;
    password_confirmation: string;
}

export interface IAdminUpdateRequest {
    name?: string;
    email?: string;
    password: string;
    password_confirmation: string;
}

export interface IAdminUpdatePasswordRequest {
    password: string;
    password_confirm: string;
}

export interface IAdminRole {
    id: number;
    name: string;
    description: string;
}
