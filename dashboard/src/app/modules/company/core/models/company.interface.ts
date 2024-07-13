export interface ICompanyResponseP {
    name: string;
    address: string;
    description: string;
    logo: string;
    email: string;
    phone?: string;
    phone_code?: string;
    id: number;
}

export interface ICompanyCreateRequest {
    name: string;
    address: string;
    description: string;
    logo: string;
    email: string;
    phone?: string;
    phone_code?: string;
}

export interface ICompanyUpdateRequest {
    name: string;
    address: string;
    description: string;
    logo: string;
    email: string;
    phone?: string;
    phone_code?: string;
}
