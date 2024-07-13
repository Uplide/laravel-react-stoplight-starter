import { useFormik } from "formik";
import {
  ICompanyCreateRequest,
  ICompanyResponseP,
} from "../core/models/company.interface";
import * as Yup from "yup";
import { getCompany, updateCompany } from "../core/api/company.request";
import toast from "react-hot-toast";
import { useNavigate, useParams } from "react-router";
import { Card, CardBody, CardHeader, Input, Textarea } from "@nextui-org/react";
import React, { useEffect } from "react";
import { FetchStatus } from "@base/enums/api.enum";
import Loader from "@base/layout/components/loader/Loader";
import ReactPhoneInput from "@base/components/common/inputs/PhoneInput";
import FileBrowserModal from "@app/modules/file-manager/components/modals/FileBrowserModal";
import { Link } from "react-router-dom";
import { Icon } from "@iconify/react/dist/iconify.js";
import { useFormContext } from "@base/layout/contexts/FormContext";

const validationSchema = Yup.object().shape({
  name: Yup.string().required("Ad alanı zorunludur"),
  phone: Yup.string().required("Telefon alanı zorunludur"),
  email: Yup.string()
    .email("Geçerli bir email adresi giriniz")
    .required("Email alanı zorunludur"),
});

const EditCompany = () => {
  const navigate = useNavigate();
  const { id: companyId } = useParams();
  const [company, setCompany] = React.useState<ICompanyResponseP | null>(null);
  const [fetchStatus, setFetchStatus] = React.useState<FetchStatus>(
    FetchStatus.IDLE
  );
  const { setHandleSubmit, clearHandleSubmit, setBackUrl } = useFormContext();

  useEffect(() => {
    if (companyId) {
      setFetchStatus(FetchStatus.LOADING);
      getCompany(parseInt(companyId)).then((res) => {
        setCompany(res);
        setFetchStatus(FetchStatus.SUCCEEDED);
      });
    }
  }, [companyId]);

  const formik = useFormik({
    initialValues: {
      email: company?.email,
      address: company?.address,
      description: company?.description,
      logo: company?.logo,
      phone: company?.phone,
      phone_code: company?.phone_code,
      name: company?.name,
    } as ICompanyCreateRequest,
    validationSchema: validationSchema,
    enableReinitialize: true,
    onSubmit: (values) => {
      updateCompany({
        id: parseInt(companyId ?? "0"),
        data: values,
      }).then(() => {
        toast.success("Şirket başarıyla güncellendi");
        navigate(-1);
        clearHandleSubmit();
      });
    },
  });

  useEffect(() => {
    setHandleSubmit(() => formik.handleSubmit);
    setBackUrl("/sirketler");
  }, [formik.handleSubmit]);

  if (fetchStatus !== FetchStatus.SUCCEEDED) return <Loader />;

  return (
    <>
      <div className="flex gap-1 items-center mb-8">
        <Link
          to="/sirketler"
          className="hover:bg-[#d4d4d4] p-2 rounded-lg cursor-pointer"
        >
          <Icon icon="ph:arrow-left-bold" />
        </Link>
        <h2 className="text-[1.25rem] font-bold">{company?.name}</h2>
      </div>{" "}
      <form onSubmit={formik.handleSubmit}>
        <div className="pb-10 grid grid-cols-1 md:grid-cols-12 gap-4">
          <div className="lg:col-span-8 md:col-span-12 col-span-12">
            <Card className="w-full p-4 border-1 mb-4" shadow="sm">
              <CardHeader className="flex gap-3 p-0">
                <p className="text-sm font-medium">Şirket genel bilgiler</p>
              </CardHeader>
              <CardBody className="px-0 overflow-y-clip">
                <div className="grid grid-cols-1 md:grid-cols-1 gap-5">
                  <div className="mb-3 ">
                    <div className="flex gap-4 items-end">
                      <div className="w-full">
                        <label
                          htmlFor="name"
                          className="block mb-2 text-sm font-normal text-gray-600 "
                        >
                          Şirket Adı*
                        </label>
                        <Input
                          type="text"
                          id="name"
                          name="name"
                          placeholder="Uplide.."
                          variant="bordered"
                          value={formik.values.name}
                          onChange={formik.handleChange}
                        />
                        {formik.touched.name && formik.errors.name && (
                          <p className="mt-2 text-sm text-red-500">
                            {formik.errors.name}
                          </p>
                        )}
                      </div>
                    </div>
                  </div>
                </div>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
                  <div className="mb-3">
                    <label
                      htmlFor="email"
                      className="block mb-2 text-sm font-normal text-gray-600 "
                    >
                      E-posta*
                    </label>
                    <Input
                      type="email"
                      id="email"
                      name="email"
                      variant="bordered"
                      placeholder="ornek@uplide.com"
                      value={formik.values.email}
                      onChange={formik.handleChange}
                    />
                    {formik.touched.email && formik.errors.email && (
                      <p className="mt-2 text-sm text-red-500">
                        {formik.errors.email}
                      </p>
                    )}
                  </div>
                  <div className="mb-3">
                    <label
                      htmlFor="name"
                      className="block mb-2 text-sm font-normal text-gray-600 "
                    >
                      Telefon Numarası*
                    </label>
                    <ReactPhoneInput
                      withCode
                      value={formik.values.phone}
                      name="phone"
                      onChange={(e) => {
                        formik.setFieldValue("phone", e.target.value.phone);
                        formik.setFieldValue(
                          "phone_code",
                          "+" + e.target.value.phone_code
                        );
                      }}
                      id="phone"
                    />
                    {formik.touched.phone && formik.errors.phone ? (
                      <p className="mt-2 text-sm text-red-500">
                        {formik.errors.phone}
                      </p>
                    ) : null}
                  </div>
                </div>
              </CardBody>
            </Card>

            <Card className="w-full p-4 border-1" shadow="sm">
              <CardHeader className="flex gap-3 p-0">
                <p className="text-sm font-medium">Diğer bilgiler</p>
              </CardHeader>
              <CardBody className="px-0 overflow-y-clip">
                <div className="grid grid-cols-1 md:grid-cols-1 gap-5">
                  <div className="mb-3">
                    <label
                      htmlFor="name"
                      className="block mb-2 text-sm font-normal text-gray-600 "
                    >
                      Addres
                    </label>
                    <Textarea
                      type="text"
                      id="address"
                      name="address"
                      variant="bordered"
                      placeholder="Şirket adresi..."
                      value={formik.values.address}
                      onChange={formik.handleChange}
                    />
                    {formik.touched.address && formik.errors.address && (
                      <p className="mt-2 text-sm text-red-500">
                        {formik.errors.address}
                      </p>
                    )}
                  </div>
                </div>
                <div className="grid grid-cols-1 md:grid-cols-1 gap-5">
                  <div className="mb-3">
                    <label
                      htmlFor="name"
                      className="block mb-2 text-sm font-normal text-gray-600 "
                    >
                      Açıklama
                    </label>
                    <Textarea
                      type="text"
                      id="description"
                      name="description"
                      variant="bordered"
                      placeholder="Şirket açıklaması..."
                      value={formik.values.description}
                      onChange={formik.handleChange}
                    />
                    {formik.touched.description &&
                      formik.errors.description && (
                        <p className="mt-2 text-sm text-red-500">
                          {formik.errors.description}
                        </p>
                      )}
                  </div>
                </div>
              </CardBody>
            </Card>
          </div>
          <div className="lg:col-span-4 md:col-span-12 col-span-12">
            <Card className="w-full p-4 border-1" shadow="sm">
              <CardHeader className="p-0">
                <p className="text-sm font-medium">Şirket logosu</p>
              </CardHeader>
              <CardBody className="p-0 pt-2">
                <div className="flex justify-center flex-col items-center gap-3">
                  <FileBrowserModal
                    setPickUrl={(value) => formik.setFieldValue("logo", value)}
                    value={formik.values.logo}
                  />
                </div>
              </CardBody>
            </Card>
          </div>
        </div>
      </form>
    </>
  );
};

export default EditCompany;
