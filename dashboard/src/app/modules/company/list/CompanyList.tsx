import React from "react";
import { FetchStatus } from "@base/enums/api.enum";
import { deleteCompany, fetchCompanys } from "../core/api/company.request";
import { ICompanyResponseP } from "../core/models/company.interface";
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
import { Avatar, Button, Tooltip } from "@nextui-org/react";
import { swal } from "@base/components/common/swal/SwalAlert";
import toast from "react-hot-toast";
import {
    hasPermission,
    hasPermissionMany,
} from "@base/helpers/permissions/permission.helper";

const CompanyList = () => {
    const [companyListResponse, setCompanyListResponse] = React.useState<
        PageableResponseModel<ICompanyResponseP> | undefined
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
        fetchCompanys({ skip, take, sort, filter })
            .then((res) => {
                setFetchStatus(FetchStatus.SUCCEEDED);
                setCompanyListResponse(res);
            })
            .catch(() => {
                setFetchStatus(FetchStatus.FAILED);
            });
    }, [skip, take, sort, filter, tableAction]);

    const columns: IColumn[] = [
        {
            key: "logo",
            label: "Logo",
            customCell: (row) => (
                <Avatar
                    as="div"
                    color="default"
                    showFallback
                    src={row?.logo}
                    size="sm"
                    isBordered
                />
            ),
        },
        {
            key: "name",
            label: "Ad",
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

    if (hasPermissionMany(`${ERole.COMPANY_UPDATE},${ERole.COMPANY_DELETE}`)) {
        columns.push({
            type: EColumnType.OPERATIONS,
            label: "İşlemler",
            operations: [
                {
                    name: "edit",
                    icon: <Icon icon="fluent:edit-48-filled" />,
                    text: "Düzenle",
                    handle: (id: number) => {
                        navigate(`/sirketler/duzenle/${id}`);
                    },
                    role: ERole.COMPANY_UPDATE,
                },
                {
                    name: "delete",
                    icon: <Icon icon="ic:round-delete" />,
                    text: "Sil",
                    handle: (id) => {
                        swal.fire({
                            title: "Şirketyı silmek istediğinize emin misiniz?",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Evet",
                            cancelButtonText: "Hayır",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                deleteCompany(id).then(() => {
                                    toast.success("Şirket başarıyla silindi");
                                    setTableAction(`delete_${id}`);
                                });
                            }
                        });
                    },
                    role: ERole.COMPANY_DELETE,
                },
            ],
        });
    }

    if (fetchStatus === FetchStatus.IDLE) return <Loader />;

    return (
        companyListResponse && (
            <DynamoTable
                filterPath="company"
                title="Şirketler"
                meta={companyListResponse?.meta}
                columns={columns}
                rows={companyListResponse.items}
                loadStatus={fetchStatus}
                headerContent={
                    <React.Fragment>
                        {hasPermission(ERole.ADMIN_CREATE) ? (
                            <Tooltip content="Şirket Ekle">
                                <Button
                                    size="sm"
                                    color="default"
                                    isIconOnly
                                    onClick={() => {
                                        navigate("/sirketler/ekle");
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

export default CompanyList;
