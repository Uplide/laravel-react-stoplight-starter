import { ErrorMessage, FieldArray, FormikProps } from "formik";
import {
  IProjectAdd,
  IProjectAddAnnouncement,
} from "../../core/models/project.interface";
import {
  Button,
  Card,
  CardBody,
  CardFooter,
  CardHeader,
  Input,
  Switch,
  Table,
  TableBody,
  TableCell,
  TableColumn,
  TableHeader,
  TableRow,
  Textarea,
} from "@nextui-org/react";
import { Icon } from "@iconify/react/dist/iconify.js";
import clsx from "clsx";
import {
  DragDropContext,
  Draggable,
  Droppable,
  DropResult,
} from "react-beautiful-dnd";
import FileBrowserModal from "@app/modules/file-manager/components/modals/FileBrowserModal";

function CardAnnouncement({ formik }: { formik: FormikProps<IProjectAdd> }) {
  const addModerator = () => {
    formik.setFieldValue("announcements", [
      ...formik.values.announcements,
      {
        title: "",
        description: "",
        cover: "",
        isCollapsed: false,
        is_active: true,
      } as IProjectAddAnnouncement,
    ]);
  };

  const toggleModeratorCollapse = (index: number) => {
    formik.setFieldValue(
      `announcements.${index}.isCollapsed`,
      !formik.values.announcements[index].isCollapsed
    );
  };

  const handleAnnouncementDragEnd = (result: DropResult) => {
    if (!result.destination) return;

    const items = Array.from(formik.values.announcements);
    const [reorderedItem] = items.splice(result.source.index, 1);
    items.splice(result.destination.index, 0, reorderedItem);

    formik.setFieldValue("announcements", items);
  };

  return (
    <Card className="w-full p-4 border-1" shadow="sm">
      <CardHeader className="p-0 flex justify-between">
        <p className="text-sm font-medium">Duyurular</p>
      </CardHeader>
      <CardBody className="px-0">
        {formik.values.announcements.length ? (
          <div className="border p-1 px-0 rounded-md mb-4">
            <DragDropContext onDragEnd={handleAnnouncementDragEnd}>
              <Droppable droppableId="announcements">
                {(provided) => (
                  <div {...provided.droppableProps} ref={provided.innerRef}>
                    <FieldArray name="announcements">
                      {({ remove }) =>
                        formik.values.announcements.map(
                          (announcement, index) => (
                            <Draggable
                              key={index}
                              draggableId={`announcement-${index}`}
                              index={index}
                            >
                              {(provided, snapshot) => (
                                <div
                                  ref={provided.innerRef}
                                  {...provided.draggableProps}
                                  style={{
                                    ...provided.draggableProps.style,
                                  }}
                                >
                                  <div
                                    className={clsx({
                                      "bg-white border-t-1 border-gray-200 p-3":
                                        index > 0,
                                      "bg-white p-3": index === 0,
                                      "border-1 rounded-md":
                                        snapshot.isDragging,
                                      "!p-1": announcement.isCollapsed,
                                    })}
                                  >
                                    {!announcement.isCollapsed ? (
                                      <div>
                                        <div className="mb-3">
                                          <label
                                            htmlFor={`announcements.${index}.title`}
                                            className="block mb-2 text-sm font-normal text-gray-600 "
                                          >
                                            Başlık
                                          </label>
                                          <Input
                                            type="text"
                                            id={`announcements.${index}.title`}
                                            name={`announcements.${index}.title`}
                                            variant="bordered"
                                            placeholder=""
                                            size="sm"
                                            value={announcement.title}
                                            onChange={formik.handleChange}
                                          />

                                          <ErrorMessage
                                            name={`announcements.${index}.title`}
                                            className="text-danger-600 text-xs mt-1"
                                            component="div"
                                          />
                                        </div>
                                        <div className="mb-3">
                                          <label
                                            htmlFor={`announcements.${index}.description`}
                                            className="block mb-2 text-sm font-normal text-gray-600 "
                                          >
                                            Açıklama
                                          </label>
                                          <Textarea
                                            type="text"
                                            id={`announcements.${index}.description`}
                                            name={`announcements.${index}.description`}
                                            variant="bordered"
                                            placeholder=""
                                            size="sm"
                                            value={announcement.description}
                                            onChange={formik.handleChange}
                                          />

                                          <ErrorMessage
                                            name={`announcements.${index}.description`}
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
                                                if (
                                                  announcement.title &&
                                                  announcement.description
                                                ) {
                                                  toggleModeratorCollapse(
                                                    index
                                                  );
                                                } else {
                                                  formik.setFieldTouched(
                                                    `announcements.${index}.title`
                                                  );
                                                  formik.setFieldTouched(
                                                    `announcements.${index}.description`
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
                                        className={`p-2 flex gap-2 items-center`}
                                      >
                                        <div
                                          className="cursor-pointer"
                                          {...provided.dragHandleProps}
                                        >
                                          <Icon
                                            icon={clsx({
                                              "typcn:warning": !announcement
                                                ?.title.length,
                                              "nimbus:drag-dots":
                                                announcement?.title.length,
                                            })}
                                            className={`${clsx({
                                              "text-danger-600": !announcement
                                                ?.title.length,
                                            })}`}
                                          />
                                        </div>
                                        <div className="flex gap-2 items-center">
                                          <div
                                            onClick={() =>
                                              toggleModeratorCollapse(index)
                                            }
                                            className="cursor-pointer"
                                          >
                                            <p className="text-sm font-sm">
                                              {announcement?.title}
                                            </p>
                                          </div>
                                        </div>
                                      </div>
                                    )}
                                  </div>
                                </div>
                              )}
                            </Draggable>
                          )
                        )
                      }
                    </FieldArray>
                    {provided.placeholder}
                  </div>
                )}
              </Droppable>
            </DragDropContext>
          </div>
        ) : null}

        <button
          type="button"
          className="text-blue-500 inline-flex gap-2 items-center text-sm cursor-pointer bg-white"
          onClick={addModerator}
        >
          <Icon icon="octicon:plus-16" />
          Duyuru ekle
        </button>
      </CardBody>
      <CardFooter className="p-0">
        {formik.values.announcements.length ? (
          <Table
            aria-label="Görevler Tablosu"
            shadow="none"
            className="[&>div]:px-0 mt-1"
          >
            <TableHeader>
              <TableColumn>Görsel</TableColumn>
              <TableColumn>Başlık</TableColumn>
              <TableColumn>Aktiflik</TableColumn>
            </TableHeader>
            <TableBody>
              {formik.values.announcements.map((announcement, index) => (
                <TableRow key={index}>
                  <TableCell>
                    <FileBrowserModal
                      setPickUrl={(value) =>
                        formik.setFieldValue(
                          `announcements.${index}.cover`,
                          value
                        )
                      }
                      OpenComponent={
                        <div className="rounded-lg border border-dashed border-zinc-600 bg-neutral-50 w-16 h-16 flex items-center justify-center cursor-pointer p-1">
                          {announcement.cover ? (
                            <img
                              src={announcement.cover}
                              className="object-cover h-full w-full"
                            />
                          ) : (
                            <Icon
                              icon="fluent:image-add-20-regular"
                              className="w-5 h-5"
                            />
                          )}
                        </div>
                      }
                      value={announcement.cover}
                    />
                  </TableCell>
                  <TableCell className="min-w-40">
                    {announcement.title}
                  </TableCell>
                  <TableCell className="min-w-40">
                    <Switch
                      size="sm"
                      isSelected={announcement.is_active}
                      aria-label="Automatic updates"
                      onClick={() =>
                        formik.setFieldValue(
                          `announcements.${index}.is_active`,
                          !announcement.is_active
                        )
                      }
                    />
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        ) : null}
      </CardFooter>
    </Card>
  );
}

export default CardAnnouncement;
