import { Icon } from "@iconify/react/dist/iconify.js";
import * as Yup from "yup";
import React, { useEffect } from "react";
import { Link } from "react-router-dom";
import { IProjectAdd } from "../core/models/project.interface";
import { ErrorMessage, Form, Formik, useFormikContext } from "formik";
import { useFormContext } from "@base/layout/contexts/FormContext";
import {
  Card,
  CardBody,
  CardHeader,
  DateRangePicker,
  Input,
  Select,
  SelectItem,
  Textarea,
} from "@nextui-org/react";
import { parseDate } from "@internationalized/date";
import moment from "moment";
import FileBrowserModal from "@app/modules/file-manager/components/modals/FileBrowserModal";
import CardModerator from "./components/Moderator";
import CardObserver from "./components/Observer";
import CardTask from "./components/Task";
import CardAnnouncement from "./components/Announcement";

const today = moment();

const validationSchema = Yup.object({
  title: Yup.string().required("Başlık alanı zorunlu"),
  start_date: Yup.string().required("Proje tarihi zorunlu"),
  end_date: Yup.string().required("Proje tarihi zorunlu"),
  company_id: Yup.string().required("Şirket zorunlu"),
  tasks: Yup.array().of(
    Yup.object().shape({
      title: Yup.string().required("Görev başlığı zorunlu"),
      description: Yup.string().required("Açıklama zorunlu"),
      cover: Yup.string().required("Kapak zorunlu"),
      start_date: Yup.string().required("Başlangıç tarihi zorunlu"),
      end_date: Yup.string().required("Bitiş tarihi zorunlu"),
      questions: Yup.array().of(
        Yup.object().shape({
          title: Yup.string().required("Soru başlığı zorunlu"),
          type: Yup.string().required("Soru tipi zorunlu"),
        })
      ),
    })
  ),
  announcements: Yup.array().of(
    Yup.object().shape({
      title: Yup.string().required("Duyuru başlığı zorunlu"),
      description: Yup.string().required("Açıklama zorunlu"),
      cover: Yup.string().required("Kapak zorunlu"),
    })
  ),
  moderators: Yup.array().of(
    Yup.object().shape({
      name: Yup.string().required("Ad alanı zorunlu"),
      surname: Yup.string().required("Soyad alanı zorunlu"),
      email: Yup.string()
        .email("Geçerli bir email adresi giriniz")
        .required("Email alanı zorunludur"),
      phone: Yup.string().required("Telefon alanı zorunlu"),
    })
  ),
  observers: Yup.array().of(
    Yup.object().shape({
      name: Yup.string().required("Ad alanı zorunlu"),
      surname: Yup.string().required("Soyad alanı zorunlu"),
      email: Yup.string()
        .email("Geçerli bir email adresi giriniz")
        .required("Email alanı zorunludur"),
      phone: Yup.string().required("Telefon alanı zorunlu"),
    })
  ),
});

const initialValues: IProjectAdd = {
  title: "",
  description: "",
  company_id: 1,
  cover: "",
  start_date: today.format("YYYY-MM-DD"),
  end_date: today.add(3, "days").format("YYYY-MM-DD"),
  moderators: [],
  observers: [],
  tasks: [],
  target_groups: [],
  announcements: [],
};

const FormikExtra = () => {
  const { values, errors, handleSubmit } = useFormikContext<IProjectAdd>();
  const { setHandleSubmit, setBackUrl } = useFormContext();

  useEffect(() => {
    console.log("Form Values:", values);
  }, [values]);

  useEffect(() => {
    console.log("Form errors:", errors);
  }, [errors]);

  useEffect(() => {
    setHandleSubmit(() => handleSubmit);
    setBackUrl("/yoneticiler");
  }, []);

  return null;
};

export function AddProject() {
  const { clearHandleSubmit } = useFormContext();
  const handleSubmit = (values: IProjectAdd) => {
    console.log("Form Values:", values);
    clearHandleSubmit();
  };

  return (
    <React.Fragment>
      <div className="flex gap-1 items-center mb-8">
        <Link
          to="/projeler"
          className="hover:bg-[#d4d4d4] p-2 rounded-lg cursor-pointer"
        >
          <Icon icon="ph:arrow-left-bold" />
        </Link>
        <h2 className="text-[1.25rem] font-bold">Yeni proje</h2>
      </div>

      <Formik
        initialValues={initialValues}
        validationSchema={validationSchema}
        onSubmit={handleSubmit}
      >
        {(formik) => (
          <Form>
            <div className="mt-5">
              <div className="pb-10 grid grid-cols-1 md:grid-cols-12 gap-4">
                <div className="lg:col-span-8 md:col-span-12 col-span-12 flex flex-col gap-4">
                  <Card className="w-full p-4 border-1" shadow="sm">
                    <CardHeader className="flex gap-3 p-0">
                      <div className="flex flex-col">
                        <p className="text-sm font-medium">Temel bilgiler</p>
                      </div>
                    </CardHeader>
                    <CardBody className="px-0">
                      <div className="grid grid-cols-1 gap-5 mb-3">
                        <div className="">
                          <label
                            htmlFor="name"
                            className="block mb-2 text-sm font-normal text-gray-600 "
                          >
                            Başlık
                          </label>
                          <Input
                            type="text"
                            id="title"
                            name="title"
                            variant="bordered"
                            value={formik.values.title}
                            onChange={formik.handleChange}
                            size="sm"
                          />

                          <ErrorMessage
                            name={`title`}
                            className="text-danger-600 text-xs mt-1"
                            component="div"
                          />
                        </div>
                        <div className="">
                          <label
                            htmlFor="email"
                            className="block mb-2 text-sm font-normal text-gray-600 "
                          >
                            Açıklama
                          </label>
                          <Textarea
                            type="text"
                            id="description"
                            name="description"
                            variant="bordered"
                            size="sm"
                          />
                        </div>
                      </div>
                      <div className="grid grid-cols-2 gap-5">
                        <div>
                          <label
                            htmlFor="name"
                            className="block mb-2 text-sm font-normal text-gray-600 "
                          >
                            Proje tarihi
                          </label>
                          <DateRangePicker
                            variant="bordered"
                            className="max-w-xs"
                            color="default"
                            value={{
                              start: parseDate(formik.values.start_date),
                              end: parseDate(formik.values.end_date),
                            }}
                            onChange={(e) => {
                              formik.setFieldValue(
                                "start_date",
                                e.start.toString()
                              );
                              formik.setFieldValue(
                                "end_date",
                                e.end.toString()
                              );
                            }}
                            size="sm"
                          />
                          <ErrorMessage
                            name={`start_date`}
                            className="text-danger-600 text-xs mt-1"
                            component="div"
                          />
                        </div>
                        <div>
                          <label
                            htmlFor="name"
                            className="block mb-2 text-sm font-normal text-gray-600 "
                          >
                            Şirket
                          </label>
                          <Select
                            value={formik.values.company_id}
                            selectedKeys={[formik.values.company_id]}
                            onChange={(e) =>
                              formik.setFieldValue(`company_id`, e.target.value)
                            }
                            placeholder="Şirket seçiniz"
                            variant="bordered"
                            size="sm"
                          >
                            <SelectItem key="1" value={1}>
                              Vestel
                            </SelectItem>
                            <SelectItem key="2" value={2}>
                              Apple
                            </SelectItem>
                          </Select>

                          <ErrorMessage
                            name={`company_id`}
                            className="text-danger-600 text-xs mt-1"
                            component="div"
                          />
                        </div>
                      </div>
                    </CardBody>
                  </Card>
                  <CardTask formik={formik} />
                  <CardAnnouncement formik={formik} />
                </div>
                <div className="lg:col-span-4 md:col-span-12 col-span-12 flex flex-col gap-4">
                  <Card className="w-full p-4 border-1" shadow="sm">
                    <CardHeader className="p-0">
                      <p className="text-sm font-medium">Proje resmi</p>
                    </CardHeader>
                    <CardBody className="p-0 pt-2">
                      <div className="flex justify-center flex-col items-center gap-3">
                        <FileBrowserModal
                          setPickUrl={(value) =>
                            formik.setFieldValue("cover", value)
                          }
                          value={formik.values.cover}
                        />
                      </div>
                    </CardBody>
                  </Card>
                  <CardModerator formik={formik} />
                  <CardObserver formik={formik} />
                </div>
              </div>
            </div>
            <FormikExtra />
          </Form>
        )}
      </Formik>
    </React.Fragment>
  );
}
