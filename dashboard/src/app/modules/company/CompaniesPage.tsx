import { Route, Routes } from "react-router";
import CompanyList from "./list/CompanyList";
import AddCompany from "./add/AddCompany";
import EditCompany from "./edit/EditCompany";
import { BreadcrumbItem, Breadcrumbs } from "@nextui-org/react";
import { Link } from "react-router-dom";

const CompanysPage = () => {
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
              <BreadcrumbItem>Şirketler</BreadcrumbItem>
            </Breadcrumbs>
            <CompanyList />
          </>
        }
      />
      <Route
        path="/ekle"
        element={
          <div className="mx-0 md:mx-10 lg:mx-28">
            <AddCompany />
          </div>
        }
      />
      <Route
        path="/duzenle/:id"
        element={
          <div className="mx-0 md:mx-10 lg:mx-28">
            <EditCompany />
          </div>
        }
      />
    </Routes>
  );
};

export default CompanysPage;
