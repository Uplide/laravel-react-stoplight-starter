import { FetchListParams } from "@base/enums/api.interface";
import api from "@base/helpers/enhencers/Interceptor";
import {
    ICompanyCreateRequest,
    ICompanyResponseP,
    ICompanyUpdateRequest,
} from "../models/company.interface";
import { PageableResponseModel } from "@app/core/models/app.interfaces";

const API_URL = import.meta.env.VITE_API_URL;
const PREFIX = "company";

// Get Pageable Companys
export function fetchCompanys({
    skip,
    take,
    sort,
    filter,
}: FetchListParams): Promise<PageableResponseModel<ICompanyResponseP>> {
    return api.get(`${API_URL}/api/backoffice/${PREFIX}`, {
        params: {
            skip,
            take,
            sort,
            filter,
        },
    });
}

// Add Company
// eslint-disable-next-line @typescript-eslint/no-explicit-any
export function addCompany(data: ICompanyCreateRequest): Promise<any> {
    return api.post(`${API_URL}/api/backoffice/${PREFIX}`, data);
}

// Get Single Company
export function getCompany(id: number): Promise<ICompanyResponseP> {
    return api.get(`${API_URL}/api/backoffice/${PREFIX}/${id}`);
}

// Update Company
export function updateCompany({
    id,
    data,
}: {
    id: number;
    data: ICompanyUpdateRequest;
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
}): Promise<any> {
    return api.put(`${API_URL}/api/backoffice/${PREFIX}/${id}`, data);
}

// Delete Company
export function deleteCompany(
    id: number
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
): Promise<any> {
    return api.delete(`${API_URL}/api/backoffice/${PREFIX}/${id}`);
}
