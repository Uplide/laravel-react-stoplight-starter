import { Icon } from "@iconify/react/dist/iconify.js";
import {
    ICollapseItem,
    ISidebarItem,
    ISidebarMenu,
} from "./sidebar.interfaces";
import { ERole } from "@base/enums/role.enum";

export const sidebarData: (ISidebarItem | ICollapseItem | ISidebarMenu)[] = [
    {
        id: "home",
        title: "Ana Sayfa",
        type: "single",
        icon: (
            <Icon
                icon="fluent:home-16-filled"
                width="1rem"
                height="1rem"
                className="text-black dark:text-gray-200"
            />
        ),
        to: "/anasayfa",
        roles: `${ERole.Public}`,
    } as ISidebarItem,
    {
        id: "admin",
        icon: (
            <Icon
                icon="ic:round-person"
                width="1rem"
                height="1rem"
                className="text-black dark:text-gray-200"
            />
        ),
        title: "Yöneticiler",
        to: "/yoneticiler",
        type: "single",
        roles: `${ERole.ADMIN_VIEW}`,
    } as ISidebarItem,
    {
        id: "file-mananer",
        icon: (
            <Icon
                icon="mdi:folder-file"
                width="1rem"
                height="1rem"
                className="text-black dark:text-gray-200"
            />
        ),
        title: "Dosyalar",
        to: "/dosya-yoneticisi",
        type: "single",
        roles: `${ERole.ADMIN_VIEW}`,
    } as ISidebarItem,
];
