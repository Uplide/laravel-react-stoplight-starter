import { StyledBurgerButton } from "./navbar.styles";
import { useSidebarContext } from "@base/layout/contexts/LayoutContext";

export const BurguerButton = () => {
    const { setCollapsed } = useSidebarContext();
    return (
        <div className={StyledBurgerButton()} onClick={setCollapsed}>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="1em"
                height="1em"
                viewBox="0 0 32 32"
            >
                <path
                    fill="none"
                    stroke="currentColor"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth="2"
                    d="M5 8h22M5 16h22M5 24h22"
                />
            </svg>
        </div>
    );
};
