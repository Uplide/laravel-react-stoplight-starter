import React from "react";
import { FetchStatus } from "@base/enums/api.enum";
import { deleteProject, fetchProjects } from "../core/api/project.request";
import { IProjectResponseP } from "../core/models/project.interface";
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

const ProjectList = () => {
    const [projectListResponse, setProjectListResponse] = React.useState<
        PageableResponseModel<IProjectResponseP> | undefined
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
        fetchProjects({ skip, take, sort, filter })
            .then((res) => {
                setFetchStatus(FetchStatus.SUCCEEDED);
                setProjectListResponse(res);
            })
            .catch(() => {
                setFetchStatus(FetchStatus.FAILED);
            });
    }, [skip, take, sort, filter, tableAction]);

    const columns: IColumn[] = [
        {
            key: "cover",
            label: "Kapak",
            customCell: (row) => (
                <Avatar
                    as="div"
                    color="default"
                    showFallback
                    src={row?.cover}
                    size="sm"
                    isBordered
                />
            ),
        },
        {
            key: "title",
            label: "Başlık",
            filterType: EFilterType.SELECT,
        },
        {
            key: "start_date",
            label: "Başlangıç Tarihi",
            filterType: EFilterType.DATE,
            config: {
                date: {
                    format: "DD MMM YYYY, HH:mm",
                },
            },
            type: EColumnType.DATE,
        },
        {
            key: "end_date",
            label: "Bitiş Tarihi",
            filterType: EFilterType.DATE,
            config: {
                date: {
                    format: "DD MMM YYYY, HH:mm",
                },
            },
            type: EColumnType.DATE,
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

    if (hasPermissionMany(`${ERole.PROJECT_UPDATE},${ERole.PROJECT_DELETE}`)) {
        columns.push({
            type: EColumnType.OPERATIONS,
            label: "İşlemler",
            operations: [
                {
                    name: "edit",
                    icon: <Icon icon="fluent:edit-48-filled" />,
                    text: "Düzenle",
                    handle: (id: number) => {
                        navigate(`/projeler/duzenle/${id}`);
                    },
                    role: ERole.PROJECT_UPDATE,
                },
                {
                    name: "delete",
                    icon: <Icon icon="ic:round-delete" />,
                    text: "Sil",
                    handle: (id) => {
                        swal.fire({
                            title: "Projeyı silmek istediğinize emin misiniz?",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Evet",
                            cancelButtonText: "Hayır",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                deleteProject(id).then(() => {
                                    toast.success("Proje başarıyla silindi");
                                    setTableAction(`delete_${id}`);
                                });
                            }
                        });
                    },
                    role: ERole.PROJECT_DELETE,
                },
            ],
        });
    }

    if (fetchStatus === FetchStatus.IDLE) return <Loader />;

    return (
        projectListResponse && (
            <DynamoTable
                filterPath="project"
                title="Projeler"
                meta={projectListResponse?.meta}
                columns={columns}
                rows={projectListResponse.items}
                loadStatus={fetchStatus}
                headerContent={
                    <React.Fragment>
                        {hasPermission(ERole.ADMIN_CREATE) ? (
                            <Tooltip content="Proje Ekle">
                                <Button
                                    size="sm"
                                    color="default"
                                    isIconOnly
                                    onClick={() => {
                                        navigate("/projeler/ekle");
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

export default ProjectList;
