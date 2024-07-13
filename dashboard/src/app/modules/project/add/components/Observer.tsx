import { ErrorMessage, FieldArray, FormikProps } from "formik";
import {
  IProjectAdd,
  IProjectAddObserver,
} from "../../core/models/project.interface";
import { Button, Card, CardBody, CardHeader, Input } from "@nextui-org/react";
import { Icon } from "@iconify/react/dist/iconify.js";
import ReactPhoneInput from "@base/components/common/inputs/PhoneInput";
import clsx from "clsx";

function CardObserver({ formik }: { formik: FormikProps<IProjectAdd> }) {
  const addObserver = () => {
    formik.setFieldValue("observers", [
      ...formik.values.observers,
      {
        name: "",
        surname: "",
        phone: "",
        phone_code: "",
        email: "",
        isCollapsed: false,
      } as IProjectAddObserver,
    ]);
  };

  const toggleObserverCollapse = (index: number) => {
    formik.setFieldValue(
      `observers.${index}.isCollapsed`,
      !formik.values.observers[index].isCollapsed
    );
  };

  return (
    <Card className="w-full p-4 border-1" shadow="sm">
      <CardHeader className="p-0 flex justify-between">
        <p className="text-sm font-medium">Gözlemciler</p>
      </CardHeader>
      <CardBody className="px-0">
        <FieldArray name="observers">
          {({ remove }) =>
            formik.values.observers.length ? (
              <div className="border-1 rounded-lg mb-3">
                {formik.values.observers.map((moderator, index) =>
                  !moderator.isCollapsed ? (
                    <div
                      className={`p-4 ${clsx({
                        "border-t-1": index > 0,
                      })}`}
                    >
                      <div className="mb-3">
                        <label
                          htmlFor="name"
                          className="block mb-2 text-sm font-normal text-gray-600 "
                        >
                          Adı*
                        </label>
                        <Input
                          type="text"
                          id={`observers.${index}.name`}
                          name={`observers.${index}.name`}
                          variant="bordered"
                          placeholder=""
                          size="sm"
                          value={moderator.name}
                          onChange={formik.handleChange}
                        />

                        <ErrorMessage
                          name={`observers.${index}.name`}
                          className="text-danger-600 text-xs mt-1"
                          component="div"
                        />
                      </div>
                      <div className="mb-3">
                        <label
                          htmlFor="name"
                          className="block mb-2 text-sm font-normal text-gray-600 "
                        >
                          Soyadı*
                        </label>
                        <Input
                          type="text"
                          id={`observers.${index}.surname`}
                          name={`observers.${index}.surname`}
                          variant="bordered"
                          placeholder=""
                          size="sm"
                          value={moderator.surname}
                          onChange={formik.handleChange}
                        />

                        <ErrorMessage
                          name={`observers.${index}.surname`}
                          className="text-danger-600 text-xs mt-1"
                          component="div"
                        />
                      </div>
                      <div className="mb-3">
                        <label
                          htmlFor="name"
                          className="block mb-2 text-sm font-normal text-gray-600 "
                        >
                          E-posta*
                        </label>
                        <Input
                          type="text"
                          id={`observers.${index}.email`}
                          name={`observers.${index}.email`}
                          variant="bordered"
                          placeholder=""
                          size="sm"
                          value={moderator.email}
                          onChange={formik.handleChange}
                        />

                        <ErrorMessage
                          name={`observers.${index}.email`}
                          className="text-danger-600 text-xs mt-1"
                          component="div"
                        />
                      </div>
                      <div className="mb-3">
                        <label
                          htmlFor="name"
                          className="block mb-2 text-sm font-normal text-gray-600 "
                        >
                          Telefon*
                        </label>
                        <ReactPhoneInput
                          withCode
                          value={moderator.phone}
                          id={`observers.${index}.phone`}
                          name={`observers.${index}.phone`}
                          onChange={(e) => {
                            formik.setFieldValue(
                              `observers.${index}.phone`,
                              e.target.value.phone
                            );
                            formik.setFieldValue(
                              `observers.${index}.phone_code`,
                              "+" + e.target.value.phone_code
                            );
                          }}
                        />
                      </div>
                      <div className="mt-4 flex justify-between">
                        <div className="flex justify-between w-full px-0">
                          <Button
                            className="p-1"
                            variant="bordered"
                            size="sm"
                            onClick={() => {
                              remove(index);
                            }}
                          >
                            Sil
                          </Button>

                          <Button
                            className="bg-black text-white"
                            size="sm"
                            onClick={() => {
                              if (
                                moderator.name &&
                                moderator.email &&
                                moderator.phone &&
                                moderator.surname
                              ) {
                                toggleObserverCollapse(index);
                              } else {
                                formik.setFieldTouched(
                                  `observers.${index}.name`
                                );
                                formik.setFieldTouched(
                                  `observers.${index}.email`
                                );
                                formik.setFieldTouched(
                                  `observers.${index}.phone`
                                );
                                formik.setFieldTouched(
                                  `observers.${index}.surname`
                                );
                              }
                            }}
                          >
                            Tamam
                          </Button>
                        </div>
                      </div>
                    </div>
                  ) : (
                    <div
                      className={`p-2 ${clsx({
                        "border-t-1": index > 0,
                      })}`}
                    >
                      <div className="flex gap-2 items-center">
                        <div
                          onClick={() => toggleObserverCollapse(index)}
                          className="cursor-pointer"
                        >
                          <p className="text-sm font-sm">
                            {moderator?.name} {moderator?.surname}
                          </p>
                        </div>
                      </div>
                    </div>
                  )
                )}
              </div>
            ) : null
          }
        </FieldArray>
        <button
          type="button"
          className="text-blue-500 inline-flex gap-2 items-center text-sm cursor-pointer bg-white"
          onClick={addObserver}
        >
          <Icon icon="octicon:plus-16" />
          Gözlemci ekle
        </button>
      </CardBody>
    </Card>
  );
}

export default CardObserver;
