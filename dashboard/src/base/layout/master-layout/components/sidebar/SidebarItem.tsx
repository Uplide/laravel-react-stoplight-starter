import React from "react";
import { useSidebarContext } from "@base/layout/contexts/LayoutContext";
import { NavLink } from "react-router-dom";

interface Props {
    title: string;
    icon: React.ReactNode;
    to?: string;
}

export const SidebarItem = ({ icon, title, to = "" }: Props) => {
    const { setCollapsed } = useSidebarContext();
    const handleClick = () => {
        if (window.innerWidth < 768) {
            setCollapsed();
        }
    };
    return (
        <NavLink to={to} className="max-w-full hover:bg-default-100 rounded-xl">
            <button
                className="flex gap-1 py-1 pr-1 pl-2 max-w-full text-sm leading-5 items-center whitespace-nowrap rounded-[var(--p-border-radius-200)] text-[color:var(--p-color-text)] w-[216px]"
                onClick={handleClick}
            >
                {icon}
                <span className="text-ellipsis">{title}</span>
            </button>
        </NavLink>

        // <div className="flex gap-2 py-1 pr-1 pl-2 max-w-full text-sm leading-5 whitespace-nowrap rounded-[var(--p-border-radius-200)] text-[color:var(--p-color-text)] w-[216px]">
        //     <img
        //         loading="lazy"
        //         src="https://cdn.builder.io/api/v1/image/assets/TEMP/57f407ed86b0bc301cf6182ba234dffe4177bb3b7e4f8f8ca9b3370bd21130d5?apiKey=46cf2f3510b14b039a40336146fa4b2d&"
        //         className="shrink-0 w-5 aspect-square"
        //     />
        //     <div className="flex-1 text-ellipsis">Home</div>
        // </div>
    );
};
