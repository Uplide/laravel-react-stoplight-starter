import { Modal, ModalContent, useDisclosure } from "@nextui-org/react";
import FileBrowser from "../../file-manager/FileBrowser";
import { FileBrowserModalProps } from "./FileBrowserModal.types";
import { useEffect } from "react";

const FileBrowserModal = ({
  setPickUrl,
  value,
  OpenComponent,
}: FileBrowserModalProps) => {
  const { isOpen, onOpen, onOpenChange, onClose } = useDisclosure();
  useEffect(() => {
    if (value) {
      onClose();
    }
  }, [value]);
  return (
    <>
      {OpenComponent ? (
        <div onClick={value ? () => setPickUrl("") : onOpen}>
          {OpenComponent}
        </div>
      ) : (
        <button
          type="button"
          onClick={value ? () => setPickUrl("") : onOpen}
          className="flex flex-col justify-center items-center self-stretch text-xs font-semibold leading-4 text-center rounded-lg aspect-square  text-zinc-800"
        >
          <div className="flex justify-center p-2 max-w-[250px] max-h-[250px] items-center  w-full rounded-lg border border-dashed border-zinc-600 bg-neutral-50">
            {value ? (
              <img src={value} className="object-cover h-full w-full" />
            ) : (
              <div className="px-16 py-20">
                <div className="justify-center px-3 py-1.5 mt-8 mb-2.5 bg-white rounded-lg shadow-sm">
                  Resim ekle
                </div>
              </div>
            )}
          </div>
        </button>
      )}

      <Modal size="4xl" isOpen={isOpen} onOpenChange={onOpenChange}>
        <ModalContent>
          <FileBrowser setPickUrl={setPickUrl}></FileBrowser>
        </ModalContent>
      </Modal>
    </>
  );
};

export default FileBrowserModal;
