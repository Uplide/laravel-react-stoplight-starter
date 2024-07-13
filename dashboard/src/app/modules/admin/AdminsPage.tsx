import { Route, Routes } from "react-router";
import AdminList from "./list/AdminList";
import AddAdmin from "./add/AddAdmin";
import EditAdmin from "./edit/EditAdmin";
import AdminRole from "@app/modules/admin/role/AdminRole";
import { BreadcrumbItem, Breadcrumbs } from "@nextui-org/react";
import { Link } from "react-router-dom";

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
              <BreadcrumbItem>Yöneticiler</BreadcrumbItem>
            </Breadcrumbs>
            <AdminList />
          </>
        }
      />
      <Route
        path="/ekle"
        element={
          <div className="mx-0 md:mx-10 lg:mx-28">
            <AddAdmin />
          </div>
        }
      />
      <Route
        path="/duzenle/:id"
        element={
          <>
            <div className="mx-0 md:mx-10 lg:mx-28">
              <EditAdmin />
            </div>
          </>
        }
      />
      <Route
        path="/yetki/:id"
        element={
          <>
            <div className="mx-0 md:mx-10 lg:mx-28">
              <AdminRole />
            </div>
          </>
        }
      />
    </Routes>
  );
};

export default AdminsPage;
