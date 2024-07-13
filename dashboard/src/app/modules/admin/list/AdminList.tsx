import React from "react";
import { FetchStatus } from "@base/enums/api.enum";
import { deleteAdmin, fetchAdmins } from "../core/api/admin.request";
import { IAdminResponseP } from "../core/models/admin.interface";
import Loader from "@base/layout/components/loader/Loader";
import { PageableResponseModel } from "@app/core/models/app.interfaces";

import DynamoTable from "@base/components/common/dynamo-table/DynamoTable";
import { useNavigate, useSearchParams } from "react-router-dom";
import {
    EColumnType,
    EFilterType,
    IColumn,
} from "@base/components/common/dynamo-table/types/dynamo-table.types";
import { ERole } from "@base/enums/role.enum";
import { Icon } from "@iconify/react/dist/iconify.js";
import { Button, Tooltip } from "@nextui-org/react";
import { swal } from "@base/components/common/swal/SwalAlert";
import toast from "react-hot-toast";
import {
    hasPermission,
    hasPermissionMany,
} from "@base/helpers/permissions/permission.helper";

const AdminList = () => {
    const [adminListResponse, setAdminListResponse] = React.useState<
        PageableResponseModel<IAdminResponseP> | undefined
    >();
    const navigate = useNavigate();
    const [fetchStatus, setFetchStatus] = React.useState<FetchStatus>(
        FetchStatus.IDLE
    );

    const [searchParams] = useSearchParams();
    const skip = parseInt(searchParams.get("skip") ?? "1");
    const take = parseInt(searchParams.get("take") ?? "10");
    const sort = searchParams.get("sort") ?? undefined;
    const filter = searchParams.get("filter") ?? "[]";
    const [tableAction, setTableAction] = React.useState<string>("");

    React.useEffect(() => {
        setFetchStatus(FetchStatus.LOADING);
        fetchAdmins({ skip, take, sort, filter })
            .then((res) => {
                setFetchStatus(FetchStatus.SUCCEEDED);
                setAdminListResponse(res);
            })
            .catch(() => {
                setFetchStatus(FetchStatus.FAILED);
            });
    }, [skip, take, sort, filter, tableAction]);

    const columns: IColumn[] = [
        {
            key: "name",
            label: "Ad",
            filterType: EFilterType.SELECT,
        },
        {
            key: "surname",
            label: "Soyad",
            filterType: EFilterType.SELECT,
        },
        {
            key: "email",
            label: "E-posta",
            filterType: EFilterType.SELECT,
            customCell: (row) => (
                <div>
                    {row.name}
                    <br />
                    {row.email}
                </div>
            ),
        },
        {
            key: "created_at",
            label: "Oluşturma Tarihi",
            filterType: EFilterType.DATE,
            config: {
                date: {
                    format: "DD MMM YYYY, HH:mm",
                },
            },
            type: EColumnType.DATE,
        },
    ];

    if (
        hasPermissionMany(
            `${ERole.ADMIN_UPDATE},${ERole.ADMIN_DELETE},${ERole.ADMIN_ROLE}`
        )
    ) {
        columns.push({
            type: EColumnType.OPERATIONS,
            label: "İşlemler",
            operations: [
                {
                    name: "edit",
                    icon: <Icon icon="fluent:edit-48-filled" />,
                    text: "Düzenle",
                    handle: (id: number) => {
                        navigate(`/yoneticiler/duzenle/${id}`);
                    },
                    role: ERole.ADMIN_UPDATE,
                },
                {
                    name: "delete",
                    icon: <Icon icon="ic:round-delete" />,
                    text: "Sil",
                    handle: (id) => {
                        swal.fire({
                            title: "Yöneticiyı silmek istediğinize emin misiniz?",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Evet",
                            cancelButtonText: "Hayır",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                deleteAdmin(id).then(() => {
                                    toast.success("Yönetici başarıyla silindi");
                                    setTableAction(`delete_${id}`);
                                });
                            }
                        });
                    },
                    role: ERole.ADMIN_DELETE,
                },
                {
                    name: "roles",
                    icon: <Icon icon="bx:bxs-lock-alt" />,
                    text: "Yetkiler",
                    handle: (id) => {
                        navigate(`/yoneticiler/yetki/${id}`);
                    },
                    role: ERole.ADMIN_ROLE,
                },
            ],
        });
    }

    if (fetchStatus === FetchStatus.IDLE) return <Loader />;

    return (
        adminListResponse && (
            <DynamoTable
                filterPath="admin"
                title="Yöneticiler"
                meta={adminListResponse?.meta}
                columns={columns}
                rows={adminListResponse.items}
                loadStatus={fetchStatus}
                headerContent={
                    <React.Fragment>
                        {hasPermission(ERole.ADMIN_CREATE) ? (
                            <Tooltip content="Yönetici Ekle">
                                <Button
                                    size="sm"
                                    color="default"
                                    isIconOnly
                                    onClick={() => {
                                        navigate("/yoneticiler/ekle");
                                    }}
                                >
                                    <Icon
                                        icon="lets-icons:add-round"
                                        width="1.2rem"
                                        height="1.2rem"
                                    />
                                </Button>
                            </Tooltip>
                        ) : null}
                    </React.Fragment>
                }
                searchColumns={[
                    { id: "name", type: "string" },
                    { id: "email", type: "string" },
                ]}
            />
        )
    );
};

export default AdminList;
