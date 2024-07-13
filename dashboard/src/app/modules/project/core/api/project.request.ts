import { FetchListParams } from "@base/enums/api.interface";
import api from "@base/helpers/enhencers/Interceptor";
import {
    IProjectCreateRequest,
    IProjectResponseP,
    IProjectUpdateRequest,
} from "../models/project.interface";
import { PageableResponseModel } from "@app/core/models/app.interfaces";

const API_URL = import.meta.env.VITE_API_URL;
const PREFIX = "project";

// Get Pageable Projects
export function fetchProjects({
    skip,
    take,
    sort,
    filter,
}: FetchListParams): Promise<PageableResponseModel<IProjectResponseP>> {
    return api.get(`${API_URL}/api/backoffice/${PREFIX}`, {
        params: {
            skip,
            take,
            sort,
            filter,
        },
    });
}

// Add Project
// eslint-disable-next-line @typescript-eslint/no-explicit-any
export function addProject(data: IProjectCreateRequest): Promise<any> {
    return api.post(`${API_URL}/api/backoffice/${PREFIX}`, data);
}

// Get Single Project
export function getProject(id: number): Promise<IProjectResponseP> {
    return api.get(`${API_URL}/api/backoffice/${PREFIX}/${id}`);
}

// Update Project
export function updateProject({
    id,
    data,
}: {
    id: number;
    data: IProjectUpdateRequest;
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
}): Promise<any> {
    return api.put(`${API_URL}/api/backoffice/${PREFIX}/${id}`, data);
}

// Delete Project
export function deleteProject(
    id: number
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
): Promise<any> {
    return api.delete(`${API_URL}/api/backoffice/${PREFIX}/${id}`);
}
