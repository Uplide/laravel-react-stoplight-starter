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
        id: number;
        name: string;
        email: string;
        created_at: string;
    };
}

export type ILogoutOptions = {
    alert?: boolean;
};
