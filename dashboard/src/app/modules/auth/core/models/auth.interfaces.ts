export interface ILoginRequest {
    email: string;
    password: string;
    rememberMe: boolean;
}

export interface ILoginResponse {
    accessToken: string;
    user: ICurrentUser;
}

export interface ICurrentUser {
    data: {
        id: string;
        name: string;
        surname: string;
        email: string;
        phone?: string;
        phone_code?: string;
        password: string;
        password_confirmation: string;
        created_at: string;
    };
}

export type ILogoutOptions = {
    alert?: boolean;
};
