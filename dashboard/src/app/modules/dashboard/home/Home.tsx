import { CardBalance1 } from "./partials/card-balance1";
import { CardBalance2 } from "./partials/card-balance2";
import { CardBalance3 } from "./partials/card-balance3";
import { CardAgents } from "./partials/card-agents";

export const Home = () => {
    return (
        <div className="h-full ">
            <div className="flex justify-center gap-4 xl:gap-6 lg:px-0  flex-wrap xl:flex-nowrap  max-w-[90rem] mx-auto w-full">
                <div className="gap-6 flex flex-col w-full">
                    {/* Card Section Top */}

                    <div className="flex flex-col gap-2">
                        <h3 className="text-xl font-semibold">
                            Available Balance
                        </h3>
                        <div className="grid md:grid-cols-2 grid-cols-1 2xl:grid-cols-3 gap-5  justify-center w-full">
                            <CardBalance1 />
                            <CardBalance2 />
                            <CardBalance3 />
                        </div>
                    </div>
                </div>
                {/* Left Section */}
                <div className="mt-4 gap-2 flex flex-col xl:max-w-md w-full">
                    <h3 className="text-xl font-semibold">Section</h3>
                    <div className="flex flex-col justify-center gap-4 flex-wrap md:flex-nowrap md:flex-col">
                        <CardAgents />
                    </div>
                </div>
            </div>
        </div>
    );
};
