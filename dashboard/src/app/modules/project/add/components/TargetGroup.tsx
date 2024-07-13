import { ErrorMessage, FieldArray, FormikProps } from "formik";
import {
  ESesType,
  ESesTypeL,
  IProjectAdd,
  IProjectAddTargetGroup,
} from "../../core/models/project.interface";
import {
  Button,
  Card,
  CardBody,
  CardHeader,
  Input,
  Select,
  SelectItem,
  Textarea,
} from "@nextui-org/react";
import { Icon } from "@iconify/react/dist/iconify.js";
import clsx from "clsx";

function CardTargetGroup({ formik }: { formik: FormikProps<IProjectAdd> }) {
  const addObserver = () => {
    formik.setFieldValue("target_groups", [
      ...formik.values.target_groups,
      {
        title: "",
        description: "",
        isCollapsed: false,
        ses: ESesType.BELOW_POVERTY_LINE,
      } as IProjectAddTargetGroup,
    ]);
  };

  const toggleObserverCollapse = (index: number) => {
    formik.setFieldValue(
      `target_groups.${index}.isCollapsed`,
      !formik.values.target_groups[index].isCollapsed
    );
  };

  return (
    <Card className="w-full p-4 border-1" shadow="sm">
      <CardHeader className="p-0 flex justify-between">
        <p className="text-sm font-medium">Gözlemciler</p>
      </CardHeader>
      <CardBody className="px-0">
        <FieldArray name="target_groups">
          {({ remove }) =>
            formik.values.target_groups.length ? (
              <div className="border-1 rounded-lg mb-3">
                {formik.values.target_groups.map((moderator, index) =>
                  !moderator.isCollapsed ? (
                    <div
                      className={`p-4 ${clsx({
                        "border-t-1": index > 0,
                      })}`}
                    >
                      <div className="mb-3">
                        <label
                          htmlFor={`target_groups.${index}.title`}
                          className="block mb-2 text-sm font-normal text-gray-600 "
                        >
                          Başlık
                        </label>
                        <Input
                          type="text"
                          id={`target_groups.${index}.title`}
                          name={`target_groups.${index}.title`}
                          variant="bordered"
                          placeholder=""
                          size="sm"
                          value={moderator.title}
                          onChange={formik.handleChange}
                        />

                        <ErrorMessage
                          name={`target_groups.${index}.title`}
                          className="text-danger-600 text-xs mt-1"
                          component="div"
                        />
                      </div>
                      <div className="mb-3">
                        <label
                          htmlFor="name"
                          className="block mb-2 text-sm font-normal text-gray-600 "
                        >
                          Açıklama
                        </label>
                        <Textarea
                          type="text"
                          id={`target_groups.${index}.description`}
                          name={`target_groups.${index}.description`}
                          variant="bordered"
                          placeholder=""
                          size="sm"
                          value={moderator.description}
                          onChange={formik.handleChange}
                        />

                        <ErrorMessage
                          name={`target_groups.${index}.description`}
                          className="text-danger-600 text-xs mt-1"
                          component="div"
                        />
                      </div>
                      <div className="mb-3">
                        <label
                          htmlFor="name"
                          className="block mb-2 text-sm font-normal text-gray-600 "
                        >
                          Sınıf
                        </label>
                        <Select
                          value={moderator.ses}
                          selectedKeys={[moderator.ses]}
                          onChange={(e) =>
                            formik.setFieldValue(
                              `target_groups.${index}.ses`,
                              e.target.value
                            )
                          }
                          placeholder="Sınıf seçiniz."
                          variant="bordered"
                          size="sm"
                        >
                          <SelectItem key="" value={ESesType.HIGH}>
                            {ESesTypeL.HIGH}
                          </SelectItem>
                          <SelectItem key="" value={ESesType.MIDDLE}>
                            {ESesTypeL.MIDDLE}
                          </SelectItem>
                          <SelectItem key="" value={ESesType.LOW}>
                            {ESesTypeL.LOW}
                          </SelectItem>
                          <SelectItem
                            key=""
                            value={ESesType.IMMIGRANT_MINORITY}
                          >
                            {ESesTypeL.IMMIGRANT_MINORITY}
                          </SelectItem>
                          <SelectItem
                            key=""
                            value={ESesType.BELOW_POVERTY_LINE}
                          >
                            {ESesTypeL.BELOW_POVERTY_LINE}
                          </SelectItem>
                        </Select>

                        <ErrorMessage
                          name={`target_groups.${index}.description`}
                          className="text-danger-600 text-xs mt-1"
                          component="div"
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
                              if (moderator.title && moderator.description) {
                                toggleObserverCollapse(index);
                              } else {
                                formik.setFieldTouched(
                                  `target_groups.${index}.title`
                                );
                                formik.setFieldTouched(
                                  `target_groups.${index}.description`
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
                          <p className="text-sm font-sm">{moderator?.title}</p>
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

export default CardTargetGroup;
