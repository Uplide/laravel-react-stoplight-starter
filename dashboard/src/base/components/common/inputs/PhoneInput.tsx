import PhoneInput, { CountryData } from "react-phone-input-2";
import "react-phone-input-2/lib/high-res.css";
import React from "react";
import { ReactPhoneInputProps } from "./PhoneInput.types";
import styled from "styled-components";
import { useTheme } from "@base/layout/contexts/ThemeContext";

const CustomPhoneInputContainer = styled.div`
    .selected-flag {
        background-color: transparent !important; // Hover durumunda arka plan rengini transparent yap
        &:hover {
            background-color: transparent !important; // Hover durumunda arka plan rengini transparent yap
        }
    }
    .divider {
        padding: 0px !important;
        margin: 0px !important;
    }
`;

const ReactPhoneInput: React.FC<ReactPhoneInputProps> = ({
    value,
    name,
    onChange,
    id,
    withCode = false,
}) => {
    const { theme } = useTheme();

    const lightTheme = {
        inputBackground: "#FFF",
        inputBorder: "#D0D7DE",
        inputText: "#000",
        dropdownBackground: "#FFF",
        dropdownHoverBackground: "#F0F0F0",
        dropdownText: "#000",
        buttonBackground: "transparent",
    };

    const darkTheme = {
        inputBackground: "transparent",
        inputBorder: "#555",
        inputText: "#FFF",
        dropdownBackground: "#18181b",
        dropdownHoverBackground: "#555",
        dropdownText: "#FFF",
        buttonBackground: "transparent",
    };

    const currentTheme = theme === "light" ? lightTheme : darkTheme;

    return (
        <CustomPhoneInputContainer>
            <PhoneInput
                preferredCountries={["tr"]}
                country={"tr"}
                value={value}
                onChange={(value, data) => {
                    if (!withCode) {
                        onChange &&
                            onChange({ target: { value: value, name: name } });
                    } else {
                        onChange &&
                            onChange({
                                target: {
                                    value: {
                                        phone: value,
                                        phone_code: (data as CountryData)
                                            .dialCode,
                                    },
                                    name: name,
                                },
                            });
                    }
                }}
                searchPlaceholder="Bir ülke arayın"
                inputProps={{
                    name: name,
                    id: id,
                }}
                containerStyle={{
                    width: "100%",
                }}
                inputStyle={{
                    width: "100%",
                    backgroundColor: currentTheme.inputBackground,
                    color: currentTheme.inputText,
                    padding: "1.250rem",
                    paddingLeft: "3.5rem",
                    borderRadius: "0.5rem",
                    border: `1px solid ${currentTheme.inputBorder}`,
                    outline: "2px solid transparent !important",
                    outlineOffset: "2px !important",
                }}
                inputClass="shadow-sm !border-default-200 !border-medium !rounded-medium !min-h-10 !h-10 hover:border-black"
                buttonStyle={{
                    backgroundColor: currentTheme.buttonBackground,
                    padding: "0px",
                    border: "0px",
                    left: "3px",
                }}
                dropdownStyle={{
                    backgroundColor: currentTheme.dropdownBackground,
                    color: currentTheme.dropdownText,
                }}
            />
            <style>{`
                .country-list .country:hover,
                .highlight {
                    background-color: ${currentTheme.dropdownHoverBackground} !important;
                }
                .dial-code {
                    color: ${currentTheme.dropdownText} !important;
                }
            `}</style>
        </CustomPhoneInputContainer>
    );
};

export default ReactPhoneInput;
