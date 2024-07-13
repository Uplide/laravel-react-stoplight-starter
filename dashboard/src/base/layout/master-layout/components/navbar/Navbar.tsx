import { Navbar } from "@nextui-org/react";
import React, { useEffect } from "react";
import { NotificationsDropdown } from "./NotificationsDropdown";
import { UserDropdown } from "./UserDropdown";
import RouteSearcher from "./RouteSearcher";
import { useFormContext } from "@base/layout/contexts/FormContext";
import { useLocation } from "react-router-dom";
import { NavbarFormSubmit } from "./NavbarFormSubmit";
import { BurguerButton } from "./BurgerButton";
import AppLogo from "../../../../../app/core/components/AppLogo";
import AppFavIconLogo from "../../../../../app/core/components/AppFavIcon";

interface Props {
    children: React.ReactNode;
}

export const NavbarWrapper = ({ children }: Props) => {
    const { handleSubmit, clearHandleSubmit } = useFormContext();
    const location = useLocation();

    useEffect(() => {
        const { pathname } = location;
        if (!pathname.includes("ekle") && !pathname.includes("duzenle")) {
            clearHandleSubmit();
        }
    }, [location]);

    return (
        <div className="w-full bg-black z-0">
            <Navbar className="sticky top-0 z-10 bg-black flex !w-full !justify-between max-w-full [&>header]:max-w-full [&>header]:h-[3.5rem]">
                <div className="col-3 flex justify-start items-center gap-2">
                    <AppLogo
                        className="w-36 hidden lg:block"
                    />

                    <AppFavIconLogo
                        className="w-6 h-6 lg:hidden"
                        fill="#fff"
                    ></AppFavIconLogo>
                    {/* <h3 className="lg:text-xl md:text-lg  text-[10px] font-medium m-0 text-white whitespace-nowrap">
            Uplide Laravel Starter
          </h3> */}
                </div>
                <div className="col-3  justify-start items-center gap-2 m-2 lg:hidden md:hiden flex">
                    <BurguerButton />
                </div>
                <div className="col-3 flex justify-center w-[8rem] lg:w-[40rem] md:w-[30rem]">
                    {handleSubmit ? <NavbarFormSubmit /> : <RouteSearcher />}
                </div>
                <div className="col-3 flex justify-end items-end gap-2">
                    <NotificationsDropdown />
                    <UserDropdown />
                </div>
            </Navbar>
            {children}
        </div>
    );
};
