import { ErrorMessage, FieldArray, FormikProps } from "formik";
import {
  IProjectAdd,
  IProjectAddModerator,
} from "../../core/models/project.interface";
import { Button, Card, CardBody, CardHeader, Input } from "@nextui-org/react";
import { Icon } from "@iconify/react/dist/iconify.js";
import ReactPhoneInput from "@base/components/common/inputs/PhoneInput";
import clsx from "clsx";

function CardModerator({ formik }: { formik: FormikProps<IProjectAdd> }) {
  const addModerator = () => {
    formik.setFieldValue("moderators", [
      ...formik.values.moderators,
      {
        name: "",
        surname: "",
        phone: "",
        phone_code: "",
        email: "",
        isCollapsed: false,
      } as IProjectAddModerator,
    ]);
  };

  const toggleModeratorCollapse = (index: number) => {
    formik.setFieldValue(
      `moderators.${index}.isCollapsed`,
      !formik.values.moderators[index].isCollapsed
    );
  };

  return (
    <Card className="w-full p-4 border-1" shadow="sm">
      <CardHeader className="p-0 flex justify-between">
        <p className="text-sm font-medium">Moderatörler</p>
      </CardHeader>
      <CardBody className="px-0">
        <FieldArray name="moderators">
          {({ remove }) =>
            formik.values.moderators.length ? (
              <div className="border-1 rounded-lg mb-3">
                {formik.values.moderators.map((moderator, index) =>
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
                          id={`moderators.${index}.name`}
                          name={`moderators.${index}.name`}
                          variant="bordered"
                          placeholder=""
                          size="sm"
                          value={moderator.name}
                          onChange={formik.handleChange}
                        />

                        <ErrorMessage
                          name={`moderators.${index}.name`}
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
                          id={`moderators.${index}.surname`}
                          name={`moderators.${index}.surname`}
                          variant="bordered"
                          placeholder=""
                          size="sm"
                          value={moderator.surname}
                          onChange={formik.handleChange}
                        />

                        <ErrorMessage
                          name={`moderators.${index}.surname`}
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
                          id={`moderators.${index}.email`}
                          name={`moderators.${index}.email`}
                          variant="bordered"
                          placeholder=""
                          size="sm"
                          value={moderator.email}
                          onChange={formik.handleChange}
                        />

                        <ErrorMessage
                          name={`moderators.${index}.email`}
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
                          id={`moderators.${index}.phone`}
                          name={`moderators.${index}.phone`}
                          onChange={(e) => {
                            formik.setFieldValue(
                              `moderators.${index}.phone`,
                              e.target.value.phone
                            );
                            formik.setFieldValue(
                              `moderators.${index}.phone_code`,
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
                                toggleModeratorCollapse(index);
                              } else {
                                formik.setFieldTouched(
                                  `moderators.${index}.name`
                                );
                                formik.setFieldTouched(
                                  `moderators.${index}.email`
                                );
                                formik.setFieldTouched(
                                  `moderators.${index}.phone`
                                );
                                formik.setFieldTouched(
                                  `moderators.${index}.surname`
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
                          onClick={() => toggleModeratorCollapse(index)}
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
          onClick={addModerator}
        >
          <Icon icon="octicon:plus-16" />
          Moderatör ekle
        </button>
      </CardBody>
    </Card>
  );
}

export default CardModerator;
