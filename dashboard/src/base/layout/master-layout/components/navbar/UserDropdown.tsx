import {
    Avatar,
    Dropdown,
    DropdownItem,
    DropdownMenu,
    DropdownTrigger,
    NavbarItem,
} from "@nextui-org/react";
import { useAuth } from "@app/modules/auth/core/contexts/AuthContext";
import { Link } from "react-router-dom";
export const UserDropdown = () => {
    const { currentUser, logout } = useAuth();
    return (
        <Dropdown backdrop="blur">
            <NavbarItem>
                <DropdownTrigger>
                    <div className="">
                        <Avatar
                            as="button"
                            color="success"
                            radius="md"
                            name={
                                currentUser?.data.name?.charAt(0) ??
                                "" +
                                    currentUser?.data.name
                                        .split(" ")?.[1]
                                        ?.charAt(0) ??
                                ""
                            }
                            showFallback
                            className="w-8 h-8"
                        />
                    </div>
                </DropdownTrigger>
            </NavbarItem>
            <DropdownMenu
                aria-label="User menu actions"
                onAction={(actionKey) => console.log({ actionKey })}
            >
                <DropdownItem
                    key="profile"
                    className="flex flex-col justify-start w-full items-start"
                >
                    <p>Olarak giriş yapıldı</p>
                    <p>{currentUser?.data.email}</p>
                </DropdownItem>
                <DropdownItem key="settings">
                    <Link to="/hesabim">Hesabım</Link>
                </DropdownItem>
                <DropdownItem
                    onClick={() =>
                        logout({
                            alert: true,
                        })
                    }
                    key="logout"
                    color="danger"
                    className="text-danger "
                >
                    Çıkış Yap
                </DropdownItem>
                {/* <DropdownItem key="switch">
                    <DarkModeSwitch />
                </DropdownItem> */}
            </DropdownMenu>
        </Dropdown>
    );
};
