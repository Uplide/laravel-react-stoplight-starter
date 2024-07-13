import { useNavigate } from "react-router-dom";
import { useFormik } from "formik";
import * as Yup from "yup";
import { useAuth } from "../core/contexts/AuthContext";
import { ILoginRequest } from "../core/models/auth.interfaces";
import { fetchCurrentUser, login } from "../core/api/auth.requests";
import { swal } from "@base/components/common/swal/SwalAlert";
import { Button, Checkbox, Input } from "@nextui-org/react";
import { Icon } from "@iconify/react/dist/iconify.js";
import React from "react";

const validationSchema = Yup.object().shape({
    email: Yup.string().email("Invalid email").required("Email is required"),
    password: Yup.string().required("Password is required"),
});

const Login = () => {
    const { saveAuth, setCurrentUser } = useAuth();
    const navigate = useNavigate();

    const [isVisible, setIsVisible] = React.useState(false);

    const toggleVisibility = () => setIsVisible((prev) => !prev);

    const handleLogin = async ({
        email,
        password,
        rememberMe,
    }: ILoginRequest) => {
        const { accessToken } = await login(email, password).catch((error) => {
            formik.resetForm();
            swal.fire({
                title: "Hata",
                text:
                    error.response?.data?.message ||
                    "Bir hata oluştu. Lütfen tekrar deneyin.",
                icon: "error",
            });
            throw error;
        });
        saveAuth(accessToken, rememberMe);
        const user = await fetchCurrentUser();
        setCurrentUser(user);
        navigate("/anasayfa");
    };

    const formik = useFormik({
        initialValues: {
            email: "",
            password: "",
            rememberMe: false,
        },
        validationSchema: validationSchema,
        onSubmit: (values) => {
            handleLogin(values);
        },
    });

    return (
        <div className="bg-white dark:bg-gray-900">
            <div className="flex justify-center h-screen">
                <div
                    className="hidden bg-cover lg:block lg:w-2/3"
                    style={{
                        backgroundImage: "url(/login-page.jpg)",
                    }}
                >
                    <div className="flex items-center h-full px-20 bg-gray-900 bg-opacity-40">
                        <div>
                            <h2 className="text-4xl font-bold text-white">
                                Uplide Laravel Starter
                            </h2>
                            <p className="max-w-xl mt-3 text-gray-300">
                                Sosyallik, bireylerin topluluk içinde etkileşim
                                kurarak kendilerini geliştirmelerini,
                                streslerini azaltmalarını ve mutluluklarını
                                artırmalarını sağlar. Destekleyici ilişkiler,
                                duygusal ve sosyal sağlığa katkıda bulunur.
                            </p>
                        </div>
                    </div>
                </div>
                <div className="flex items-center w-full max-w-md px-6 mx-auto lg:w-2/6">
                    <div className="flex-1">
                        <div className="text-center">
                            <h2 className="text-4xl font-bold text-center text-gray-700 dark:text-white">
                                Uplide Laravel Starter
                            </h2>
                            <p className="mt-3 text-gray-500 dark:text-gray-300">
                                Hesabınıza erişmek için oturum açın
                            </p>
                        </div>
                        <div className="mt-8">
                            <form
                                onSubmit={formik.handleSubmit}
                                className="space-y-6"
                                action="#"
                                method="POST"
                            >
                                <div>
                                    <label
                                        htmlFor="email"
                                        className="block mb-2 text-sm text-gray-600 dark:text-gray-200"
                                    >
                                        Email Address
                                    </label>
                                    <Input
                                        type="email"
                                        name="email"
                                        variant="bordered"
                                        size="md"
                                        value={formik.values.email}
                                        onChange={formik.handleChange}
                                        isInvalid={
                                            !!formik.touched.email &&
                                            !!formik.errors.email
                                        }
                                        errorMessage={formik.errors.email}
                                    />
                                </div>
                                <div className="mt-6">
                                    <div className="flex justify-between mb-2">
                                        <label
                                            htmlFor="password"
                                            className="text-sm text-gray-600 dark:text-gray-200"
                                        >
                                            Şifre
                                        </label>
                                    </div>
                                    <Input
                                        type={isVisible ? "text" : "password"}
                                        className="animation-wiggle"
                                        name="password"
                                        variant="bordered"
                                        size="md"
                                        value={formik.values.password}
                                        onChange={formik.handleChange}
                                        isInvalid={
                                            !!formik.touched.password &&
                                            !!formik.errors.password
                                        }
                                        errorMessage={formik.errors.password}
                                        endContent={
                                            <button
                                                className="focus:outline-none hover:animate-wiggle"
                                                type="button"
                                                onClick={toggleVisibility}
                                            >
                                                {isVisible ? (
                                                    <Icon
                                                        icon="heroicons:eye-slash-16-solid"
                                                        width="1.2rem"
                                                        height="1.2rem"
                                                        className="text-2xl text-default-400 pointer-events-none"
                                                    />
                                                ) : (
                                                    <Icon
                                                        icon="heroicons:eye-16-solid"
                                                        width="1.2rem"
                                                        height="1.2rem"
                                                        className="text-2xl text-default-400 pointer-events-none"
                                                    />
                                                )}
                                            </button>
                                        }
                                    />
                                </div>

                                <div className="flex justify-between items-center mt-5">
                                    <Checkbox
                                        name="rememberMe"
                                        isSelected={formik.values.rememberMe}
                                        onChange={formik.handleChange}
                                    >
                                        Beni hatırla
                                    </Checkbox>
                                </div>

                                <div className="mt-4">
                                    <Button
                                        type="submit"
                                        variant="solid"
                                        className="w-full"
                                        color="primary"
                                        isLoading={formik.isSubmitting}
                                    >
                                        Hesabınıza giriş yapın
                                    </Button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Login;
