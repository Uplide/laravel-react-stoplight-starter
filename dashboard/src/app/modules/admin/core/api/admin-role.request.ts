import { IAdminRole } from "@app/modules/admin/core/models/admin.interface";
import { ERole } from "@base/enums/role.enum";
import api from "@base/helpers/enhencers/Interceptor";

const API_URL = import.meta.env.VITE_API_URL;

export function getAllAdminRoles({
    search,
}: {
    search: string | undefined;
}): Promise<IAdminRole[]> {
    return api.get(`${API_URL}/api/backoffice/role`, {
        params: {
            search,
        },
    });
}

// Get Single Admin Roles
export function getAdminRoles(id: number): Promise<IAdminRole[]> {
    return api.get(`${API_URL}/api/backoffice/role/${id}`);
}

// Update Single Admin Roles
export function updateAdminRoles({
    id,
    data,
}: {
    id: number;
    data: {
        roles: ERole[];
    };
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
}): Promise<any> {
    return api.put(`${API_URL}/api/backoffice/role/${id}`, data);
}
