import { useFormContext } from "@base/layout/contexts/FormContext";
import { Icon } from "@iconify/react/dist/iconify.js";
import { useEffect } from "react";
import { useNavigate } from "react-router-dom";

export function NavbarFormSubmit() {
  const { handleSubmit, backUrl } = useFormContext();
  const navigate = useNavigate();

  const handleSave = () => {
    if (handleSubmit) {
      handleSubmit();
    }
  };

  useEffect(() => {
    const handleBeforeUnload = (event: BeforeUnloadEvent) => {
      const message = "Form gönderilmeden sayfadan çıkamazsınız.";
      event.returnValue = message; // Modern tarayıcılarda bu satır gerekli.
      return message; // Eski tarayıcılarda bu satır gerekli.
    };

    window.addEventListener("beforeunload", handleBeforeUnload);

    return () => {
      window.removeEventListener("beforeunload", handleBeforeUnload);
    };
  }, []);

  return (
    <div className="flex flex-col justify-center w-full text-xs rounded-xl bg-zinc-800 border-1 border-zinc-600">
      <div className="flex overflow-hidden relative flex-col justify-center w-full min-h-[36px] max-md:max-w-full">
        <div className="flex relative gap-2 justify-center md:justify-between lg:justify-between py-1 pr-1 pl-1.5 w-full max-md:flex-wrap max-md:max-w-full">
          <div className="gap-2 hidden md:flex lg:flex pr-5 my-auto font-medium leading-[133%] text-neutral-200 max-md:gap-1 max-md:pr-2">
            <Icon icon="uil:sync-exclamation" width={"15"} />
            <div className="my-auto max-md:text-xs">
              Kaydedilmemiş değişiklikler
            </div>
          </div>
          <div className="flex gap-1 justify-center md:justify-between lg:justify-between font-semibold text-center whitespace-nowrap max-md:gap-0.5 max-md:text-xs">
            <button
              onClick={() => navigate(backUrl)}
              className="justify-center px-2 py-1.5 rounded-lg bg-white bg-opacity-10 text-neutral-200 max-md:px-1.5 max-md:py-1"
            >
              İptal
            </button>
            <button
              onClick={handleSave}
              className="justify-center px-3 py-1.5 bg-white rounded-lg border border-white border-solid text-zinc-800 max-md:px-2.5 max-md:py-1"
            >
              Kaydet
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}
