import { Link, Route, Routes } from "react-router-dom";
import FileBrowser from "./file-manager/FileBrowser";
import { BreadcrumbItem, Breadcrumbs } from "@nextui-org/react";

const FileManagerPage = () => {
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
                            <BreadcrumbItem>Dosya Yöneticisi</BreadcrumbItem>
                        </Breadcrumbs>
                        <FileBrowser setPickUrl={() => ""} />
                    </>
                }
            ></Route>
        </Routes>
    );
};

export default FileManagerPage;
