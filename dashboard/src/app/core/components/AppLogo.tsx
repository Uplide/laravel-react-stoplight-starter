import React from "react";

type Props = {
    className?: string;
    fill?: string;
};

const AppLogo: React.FC<Props> = ({ className }) => {
    return (
        <>
            <img src="/beyazlogo.png" className={className} alt="" />
        </>
    );
};

export default AppLogo;
