import { Sidebar } from "./sidebar.styles";
import { CollapseItems } from "./CollapseItems";
import { useSidebarContext } from "@base/layout/contexts/LayoutContext";
import { SidebarItem } from "./SidebarItem";
import { SidebarMenu } from "./SidebarMenu";
import { sidebarData } from "./sidebar.data";
import { hasPermission } from "@base/helpers/permissions/permission.helper";

export const SidebarWrapper = () => {
    const { collapsed, setCollapsed } = useSidebarContext();

    return (
        <aside className="sticky top-0 z-50 md:w-32 lg:w-64">
            {collapsed ? (
                <button
                    className={Sidebar.Overlay()}
                    tabIndex={0}
                    onClick={setCollapsed}
                />
            ) : null}
            <div
                className={Sidebar({
                    collapsed: collapsed,
                    className: "fancy-scrollbar bg-[#ebebeb]",
                })}
            >
                <div className={Sidebar.Body()}>
                    {sidebarData.map((item) => {
                        if (
                            item.type === "single" &&
                            hasPermission(item.roles)
                        ) {
                            return (
                                <SidebarItem
                                    key={item.id}
                                    title={item.title}
                                    icon={item.icon}
                                    to={item.to}
                                />
                            );
                        } else if (item.type === "collapse") {
                            return (
                                <CollapseItems
                                    key={item.id}
                                    icon={item.icon}
                                    items={item.items}
                                    title={item.title}
                                />
                            );
                        } else if (
                            hasPermission(item?.roles) &&
                            item?.items.length
                        ) {
                            return (
                                <SidebarMenu key={item.id} title={item.title}>
                                    {item?.items?.map((subItem) => {
                                        if (
                                            subItem.type === "single" &&
                                            hasPermission(subItem.roles)
                                        ) {
                                            return (
                                                <SidebarItem
                                                    key={subItem.id}
                                                    title={subItem.title}
                                                    icon={subItem.icon}
                                                    to={subItem.to}
                                                />
                                            );
                                        } else if (
                                            subItem.type === "collapse"
                                        ) {
                                            return (
                                                <CollapseItems
                                                    key={subItem.id}
                                                    icon={subItem.icon}
                                                    items={subItem.items}
                                                    title={subItem.title}
                                                />
                                            );
                                        }
                                    })}
                                </SidebarMenu>
                            );
                        }
                    })}
                </div>
            </div>
        </aside>
    );
};
