import DynamoFileManager from "@base/components/common/dynamo-file-manager/DynamoFileManager";
import {
    createFolder,
    deleteFile,
    fetchFiles,
    renameFile,
    uploadFile,
} from "../core/api/file-manager.requests";
import Loader from "@base/layout/components/loader/Loader";
import { FileBrowserProps } from "./FileBrowser.types";

function FileBrowser({ setPickUrl = () => "" }: FileBrowserProps) {
    return (
        <DynamoFileManager
            title="Dosya Yöneticisi"
            addDirectory={async (folder_path) => {
                await createFolder({ folder_path });
            }}
            uploadFile={async (pathname: string, file: File) => {
                await uploadFile({ pathname, file });
            }}
            fetchFiles={fetchFiles}
            deleteFile={async (filename: string) => {
                await deleteFile({ filename });
            }}
            renameFile={async (oldName: string, newName: string) => {
                renameFile({ oldName, newName });
            }}
            pickUrl={(url: string) => {
                setPickUrl(url);
            }}
            config={{
                loader: <Loader />,
            }}
        />
    );
}

export default FileBrowser;
