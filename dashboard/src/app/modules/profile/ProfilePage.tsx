import { Route, Routes } from "react-router";
import { BreadcrumbItem, Breadcrumbs } from "@nextui-org/react";
import { Link } from "react-router-dom";
import Profile from "./Profile";

const AdminsPage = () => {
    return (
        <Routes>
            <Route
                path="/"
                element={
                    <>
                        <Breadcrumbs className="mb-5">
                            <BreadcrumbItem>
                                <Link to="/anasayfa">Ana Sayfa</Link>
                            </BreadcrumbItem>
                            <BreadcrumbItem>Hesabım</BreadcrumbItem>
                        </Breadcrumbs>
                        <Profile></Profile>
                    </>
                }
            />
        </Routes>
    );
};

export default AdminsPage;
