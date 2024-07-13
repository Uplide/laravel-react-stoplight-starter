import React, {
    createContext,
    useContext,
    useRef,
    MutableRefObject,
    useState,
} from "react";

interface FormContextProps {
    formRef: MutableRefObject<HTMLFormElement | null>;
    setHandleSubmit: (fn: () => void) => void;
    handleSubmit?: (() => void) | null;
    clearHandleSubmit: () => void;
    backUrl: string;
    setBackUrl: (url: string) => void;
}

const FormContext = createContext<FormContextProps | undefined>(undefined);

export const useFormContext = () => {
    const context = useContext(FormContext);
    if (!context) {
        throw new Error("useFormContext must be used within a FormProvider");
    }
    return context;
};

export const FormProvider: React.FC<{ children: React.ReactNode }> = ({
    children,
}) => {
    const formRef = useRef<HTMLFormElement>(null);
    const [handleSubmit, setHandleSubmit] = useState<(() => void) | null>(null);
    const [backUrl, setBackUrl] = useState<string>("/");
    const clearHandleSubmit = () => {
        setHandleSubmit(null);
    };

    return (
        <FormContext.Provider
            value={{
                formRef,
                setHandleSubmit,
                handleSubmit: handleSubmit,
                clearHandleSubmit,
                backUrl,
                setBackUrl,
            }}
        >
            {children}
        </FormContext.Provider>
    );
};
