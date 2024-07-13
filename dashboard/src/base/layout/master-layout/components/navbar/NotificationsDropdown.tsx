import { Icon } from "@iconify/react/dist/iconify.js";
import {
    Dropdown,
    DropdownItem,
    DropdownMenu,
    DropdownSection,
    DropdownTrigger,
    NavbarItem,
} from "@nextui-org/react";

export const NotificationsDropdown = () => {
    return (
        <Dropdown backdrop="blur" placement="bottom-end">
            <DropdownTrigger>
                <NavbarItem>
                    <div className="bg-[#303030] p-2 rounded-lg">
                        <Icon
                            icon="akar-icons:bell"
                            width="1rem"
                            height="1rem"
                            className="text-gray-400 cursor-pointer "
                        />
                    </div>
                </NavbarItem>
            </DropdownTrigger>
            <DropdownMenu className="w-80" aria-label="Avatar Actions">
                <DropdownSection title="Notificacions">
                    <DropdownItem
                        classNames={{
                            base: "py-2",
                            title: "text-base font-semibold",
                        }}
                        key="1"
                        description="Sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim."
                    >
                        📣 Edit your information
                    </DropdownItem>
                    <DropdownItem
                        key="2"
                        classNames={{
                            base: "py-2",
                            title: "text-base font-semibold",
                        }}
                        description="Sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim."
                    >
                        🚀 Say goodbye to paper receipts!
                    </DropdownItem>
                    <DropdownItem
                        key="3"
                        classNames={{
                            base: "py-2",
                            title: "text-base font-semibold",
                        }}
                        description="Sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim."
                    >
                        📣 Edit your information
                    </DropdownItem>
                </DropdownSection>
            </DropdownMenu>
        </Dropdown>
    );
};
