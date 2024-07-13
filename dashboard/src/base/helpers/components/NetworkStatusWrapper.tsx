import React from 'react';
import { useNetworkState } from '@uidotdev/usehooks';

interface NetworkStatusWrapperProps {
    children: React.ReactNode;
}

const NetworkStatusWrapper: React.FC<NetworkStatusWrapperProps> = ({ children }) => {
    const { online } = useNetworkState();

    const handleRetry = () => {
        window.location.reload();
    };

    if (!online) {
        return <div className="bg-gray-50 text-gray-800">
            <div className="flex h-screen">
                <div className="m-auto text-center">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="384" height="384" viewBox="0 0 24 24"><path fill="currentColor" d="M19.8 22.6L17.15 20H6.5q-2.3 0-3.9-1.6T1 14.5q0-1.92 1.19-3.42q1.19-1.51 3.06-1.93q.08-.2.15-.39q.1-.19.15-.41L1.4 4.2l1.4-1.4l18.4 18.4M6.5 18h8.65L7.1 9.95q-.05.28-.07.55q-.03.23-.03.5h-.5q-1.45 0-2.47 1.03Q3 13.05 3 14.5q0 1.45 1.03 2.5q1.02 1 2.47 1m15.1.75l-1.45-1.4q.43-.35.64-.81q.21-.46.21-1.04q0-1.05-.73-1.77q-.72-.73-1.77-.73H17v-2q0-2.07-1.46-3.54Q14.08 6 12 6q-.67 0-1.3.16q-.63.17-1.2.52L8.05 5.23q.88-.6 1.86-.92Q10.9 4 12 4q2.93 0 4.96 2.04Q19 8.07 19 11q1.73.2 2.86 1.5q1.14 1.28 1.14 3q0 1-.37 1.81q-.38.84-1.03 1.44m-6.77-6.72" /></svg>                    </div>
                    <p className="text-sm md:text-base text-gray-300 p-2 mb-4">You aren't connected to a working internet
                        connection</p>
                    <button onClick={handleRetry}
                        className="bg-transparent hover:bg-gray-300 text-gray-300 hover:text-white rounded shadow hover:shadow-lg py-2 px-4 border border-gray-300 hover:border-transparent">
                        Retry</button>
                </div>
            </div>
        </div>
    }

    return <>{children}</>;
};

export default NetworkStatusWrapper;