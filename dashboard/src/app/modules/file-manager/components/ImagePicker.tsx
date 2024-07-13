import FileBrowserModal from "@app/modules/file-manager/components/modals/FileBrowserModal";
import { ImagePickerProps } from "./ImagePicker.types";
import { Image } from "@nextui-org/react";

const ImagePicker = ({ value, exClass = "", setPickUrl }: ImagePickerProps) => {
    return (
        <div className={`flex flex-col ${exClass}`}>
            <div className={`flex flex-col gap-2 `}>
                {value && (
                    <div className="flex py-1">
                        <Image src={value} alt="avatar" width={"80px"} />
                    </div>
                )}
            </div>
            <FileBrowserModal setPickUrl={setPickUrl} value={value} />
        </div>
    );
};

export default ImagePicker;
