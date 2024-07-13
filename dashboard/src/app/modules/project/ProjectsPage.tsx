import { BreadcrumbItem, Breadcrumbs } from "@nextui-org/react";
import { Route, Routes } from "react-router";
import { Link } from "react-router-dom";
import ProjectList from "./list/ProjectList";
import { AddProject } from "./add/AddProject";

const ProjectsPage = () => {
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
              <BreadcrumbItem>Projeler</BreadcrumbItem>
            </Breadcrumbs>
            <ProjectList />
          </>
        }
      />
      <Route
        path="/ekle"
        element={
          <div className="mx-0 md:mx-10 lg:mx-28">
            <AddProject />
          </div>
        }
      />
      <Route
        path="/duzenle/:id"
        element={
          <>
            <Breadcrumbs className="mb-5">
              <BreadcrumbItem>
                <Link to="/anasayfa">Ana Sayfa</Link>
              </BreadcrumbItem>
              <BreadcrumbItem>
                <Link to="/projeler">Projeler</Link>
              </BreadcrumbItem>
              <BreadcrumbItem>Proje Düzenle</BreadcrumbItem>
            </Breadcrumbs>
            {/* <EditCompany /> */}
          </>
        }
      />
    </Routes>
  );
};

export default ProjectsPage;
