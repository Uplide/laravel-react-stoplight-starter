import { Outlet } from "react-router-dom";
import React from "react";
import { useAuth } from "@app/modules/auth/core/contexts/AuthContext";
import { SidebarContext } from "@base/layout/contexts/LayoutContext";
import { useLockedBody } from "@base/layout/hooks/useBodyLock";
import { SidebarWrapper } from "./components/sidebar/Sidebar";
import { NavbarWrapper } from "./components/navbar/Navbar";
import { FormProvider } from "../contexts/FormContext";
/**
 * @author ziyakaragoz
 * Yazilacak butun componentlerin ust yapisidir.
 * Ornegin header, footer, sidebar gibi componentlerin hepsi bu componentin icinde olacak.
 * bu componentin bir ustunde intl provider oldugu icin bu
 * componentin ustundeki componentlerde react-intl metodlari kullanilamaz.
 */

const MasterLayout: React.FC = () => {
  const { currentUser } = useAuth();
  const [sidebarOpen, setSidebarOpen] = React.useState(true);

  // eslint-disable-next-line @typescript-eslint/no-unused-vars
  const [_, setLocked] = useLockedBody(false);
  const handleToggleSidebar = () => {
    setSidebarOpen(!sidebarOpen);
    setLocked(!sidebarOpen);
  };

  const memoizedValue = React.useMemo(
    () => ({
      collapsed: sidebarOpen,
      setCollapsed: handleToggleSidebar,
    }),
    [sidebarOpen, handleToggleSidebar]
  );

  if (!currentUser) return <Outlet />;
  return (
    <SidebarContext.Provider value={memoizedValue}>
      <section className="flex bg-zinc-100 dark:bg-black">
        <FormProvider>
          <NavbarWrapper>
            <div className="flex">
              <SidebarWrapper />
              <div className="rounded-tr-[1rem] bg-[#f1f1f1] w-full h-full">
                <div className="outlet-scroll p-8">
                  <Outlet />
                </div>
              </div>
            </div>
          </NavbarWrapper>
        </FormProvider>
      </section>
    </SidebarContext.Provider>
  );
};

export { MasterLayout };
