/* eslint-disable @typescript-eslint/no-explicit-any */
import React, { useState } from "react";
import { useNavigate, useParams } from "react-router";
import { IAdminResponseP, IAdminRole } from "../core/models/admin.interface";
import { getAdmin } from "../core/api/admin.request";
import Loader from "@base/layout/components/loader/Loader";
import toast from "react-hot-toast";
import { ERole } from "@base/enums/role.enum";

import { useDebounce } from "@uidotdev/usehooks";
import { FetchStatus } from "@base/enums/api.enum";
import {
    getAdminRoles,
    getAllAdminRoles,
    updateAdminRoles,
} from "@app/modules/admin/core/api/admin-role.request";
import {
    // Button,
    Input,
    Table,
    TableBody,
    TableCell,
    TableColumn,
    TableHeader,
    TableRow,
} from "@nextui-org/react";
import { Link } from "react-router-dom";
import { Icon } from "@iconify/react/dist/iconify.js";
import { useFormContext } from "@base/layout/contexts/FormContext";

const AdminRole = () => {
    const navigate = useNavigate();
    const { id: adminId } = useParams();
    const [roleSearch, setRoleSearch] = useState<string>("");
    const debouncedRoleSearch = useDebounce(roleSearch, 500);
    const [initialLoad, setInitialLoad] = useState<boolean>(true);
    const { setHandleSubmit, setBackUrl } = useFormContext();

    const [allRoles, setAllRoles] = useState<IAdminRole[]>([]);
    const [selectedRoles, setSelectedRoles] = useState<ERole[]>([]);
    const [admin, setAdmin] = useState<IAdminResponseP | null>(null);
    const [fetchStatus, setFetchStatus] = useState<FetchStatus>(
        FetchStatus.IDLE
    );
    const [adminRoles, setAdminRoles] = useState<ERole[] | null>(null);

    React.useEffect(() => {
        setFetchStatus(FetchStatus.LOADING);
        getAdminRoles(parseInt(adminId!)).then((res) => {
            setAdminRoles(res);
            setFetchStatus(FetchStatus.SUCCEEDED);
        });
        getAdmin(parseInt(adminId!)).then((res) => {
            setAdmin(res);
        });
    }, [adminId]);

    React.useEffect(() => {
        if (initialLoad && adminRoles?.length && allRoles?.length) {
            // set the selectedRoles at initial if adminRoles has it
            const newArr = allRoles.filter((role) =>
                adminRoles.includes(role.name)
            );
            setSelectedRoles(newArr.map((role) => role.name));
            setInitialLoad(false);
        }
    }, [adminRoles, initialLoad, allRoles]);

    React.useEffect(() => {
        console.log(selectedRoles);
    }, [selectedRoles]);

    React.useEffect(() => {
        getAllAdminRoles({ search: debouncedRoleSearch }).then((res) => {
            setAllRoles(res);
        });
    }, [debouncedRoleSearch]);

    const handleSaveRoles = () => {
        updateAdminRoles({
            id: parseInt(adminId!),
            data: {
                roles: selectedRoles,
            },
        })
            .then(() => {
                toast.success("Roller başarıyla güncellendi");
                navigate(-1);
            })
            .catch((error) => {
                toast.error("Roller güncellenirken bir hata oluştu");
                console.error(error);
            });
    };

    React.useEffect(() => {
        setHandleSubmit(() => handleSaveRoles);
        setBackUrl("/yoneticiler");
    }, [selectedRoles]);

    if (fetchStatus !== FetchStatus.SUCCEEDED && !allRoles?.length)
        return <Loader />;

    return (
        <>
            <div className="flex gap-1 items-center mb-8">
                <Link
                    to="/yoneticiler"
                    className="hover:bg-[#d4d4d4] p-2 rounded-lg cursor-pointer"
                >
                    <Icon icon="ph:arrow-left-bold" />
                </Link>
                <div>
                    <h2 className="text-[1.25rem] font-bold">
                        {admin?.name} {admin?.surname}
                    </h2>
                </div>
            </div>
            <main className="pb-10">
                <Table
                    selectionMode="multiple"
                    selectedKeys={selectedRoles as any}
                    aria-label="Example static collection table"
                    shadow="none"
                    className="shadow-sm p-0"
                    onSelectionChange={(keys) => {
                        if (keys === "all") {
                            setSelectedRoles(allRoles.map((role) => role.name));
                        } else {
                            const roles = [...keys];
                            if (roles.length) {
                                setSelectedRoles(roles);
                            } else {
                                setSelectedRoles([]);
                            }
                        }
                    }}
                    onChange={(e) => console.log(e)}
                    topContent={
                        <div className="flex justify-between items-center w-full gap-3">
                            <div className="w-full">
                                <Input
                                    value={roleSearch}
                                    onChange={(e) =>
                                        setRoleSearch(e.target.value)
                                    }
                                    type="search"
                                    id="default-search"
                                    placeholder="Yetki Ara"
                                />
                            </div>
                            {/* <div className="flex justify-end w-[32%] ">
                                <Button
                                    isLoading={
                                        updateStatus === FetchStatus.LOADING
                                    }
                                    color="primary"
                                    onClick={handleSaveRoles}
                                    disabled={
                                        updateStatus === FetchStatus.LOADING
                                    }
                                >
                                    Güncelle
                                </Button>
                            </div> */}
                        </div>
                    }
                >
                    <TableHeader>
                        <TableColumn>YETKİ</TableColumn>
                    </TableHeader>
                    <TableBody className="p-0">
                        {allRoles.map((row) => (
                            <TableRow key={row.name}>
                                <TableCell>{row.description}</TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </main>
        </>
    );
};

export default AdminRole;
