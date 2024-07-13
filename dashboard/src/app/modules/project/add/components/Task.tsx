import { FieldArray, ErrorMessage, FormikProps } from "formik";
import {
  EOptionType,
  IProjectAdd,
  IProjectQuestion,
} from "../../core/models/project.interface";
import {
  DragDropContext,
  Draggable,
  Droppable,
  DropResult,
} from "react-beautiful-dnd";
import {
  Button,
  Card,
  CardBody,
  CardFooter,
  CardHeader,
  DatePicker,
  Input,
  Select,
  SelectItem,
  Switch,
  Table,
  TableBody,
  TableCell,
  TableColumn,
  TableHeader,
  TableRow,
  Textarea,
} from "@nextui-org/react";
import clsx from "clsx";
import { Icon } from "@iconify/react/dist/iconify.js";
import FileBrowserModal from "@app/modules/file-manager/components/modals/FileBrowserModal";
import { parseDate } from "@internationalized/date";

const CardTask = ({ formik }: { formik: FormikProps<IProjectAdd> }) => {
  const handleTaskDragEnd = (result: DropResult) => {
    if (!result.destination) return;

    const items = Array.from(formik.values.tasks);
    const [reorderedItem] = items.splice(result.source.index, 1);
    items.splice(result.destination.index, 0, reorderedItem);

    formik.setFieldValue("tasks", items);
  };

  const handleQuestionDragEnd = (result: DropResult, taskIndex: number) => {
    if (!result.destination) return;

    const items = Array.from(formik.values.tasks[taskIndex].questions);
    const [reorderedItem] = items.splice(result.source.index, 1);
    items.splice(result.destination.index, 0, reorderedItem);

    formik.setFieldValue(`tasks.${taskIndex}.questions`, items);
  };

  const handleOptionDragEnd = (
    result: DropResult,
    taskIndex: number,
    questionIndex: number
  ) => {
    if (!result.destination) return;

    const items = Array.from(
      formik.values.tasks[taskIndex].questions[questionIndex].options
    );
    const [reorderedItem] = items.splice(result.source.index, 1);

    if (!items[result.destination.index]) {
      items.splice(result.source.index, 0, reorderedItem);
    } else {
      items.splice(result.destination.index, 0, reorderedItem);
    }

    formik.setFieldValue(
      `tasks.${taskIndex}.questions.${questionIndex}.options`,
      items
    );
  };

  const addTask = () => {
    formik.setFieldValue("tasks", [
      ...formik.values.tasks,
      {
        title: "",
        questions: [],
        isCollapsed: false,
        is_active: true,
      },
    ]);
  };

  const addQuestion = (taskIndex: number) => {
    formik.setFieldValue(`tasks.${taskIndex}.questions`, [
      ...formik.values.tasks[taskIndex].questions,
      {
        title: "",
        type: "",
        options: [{ option_value: "" }],
        isCollapsed: false,
        description: "",
        option_type: EOptionType.checkbox,
      } as IProjectQuestion,
    ]);
  };

  const toggleTaskCollapse = (index: number) => {
    formik.setFieldValue(
      `tasks.${index}.isCollapsed`,
      !formik.values.tasks[index].isCollapsed
    );
  };

  const toggleQuestionCollapse = (taskIndex: number, questionIndex: number) => {
    formik.setFieldValue(
      `tasks.${taskIndex}.questions.${questionIndex}.isCollapsed`,
      !formik.values.tasks[taskIndex].questions[questionIndex].isCollapsed
    );
  };
  return (
    <Card className="w-full p-4 border-1" shadow="sm">
      <CardHeader className="p-0 flex justify-between">
        <p className="text-sm font-medium">Görevler</p>
      </CardHeader>
      <CardBody className="px-0">
        {formik.values.tasks.length ? (
          <div className="border p-1 px-0 rounded-md mb-4">
            <DragDropContext onDragEnd={handleTaskDragEnd}>
              <Droppable droppableId="tasks">
                {(provided) => (
                  <div {...provided.droppableProps} ref={provided.innerRef}>
                    <FieldArray name="tasks">
                      {(taskHelper) => (
                        <>
                          {formik.values.tasks.map((task, taskIndex) => (
                            <Draggable
                              key={taskIndex}
                              draggableId={`task-${taskIndex}`}
                              index={taskIndex}
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
                                        taskIndex > 0,
                                      "bg-white p-3": taskIndex === 0,
                                      "border-1 rounded-md":
                                        snapshot.isDragging,
                                      "!p-1": task.isCollapsed,
                                    })}
                                  >
                                    {!task.isCollapsed ? (
                                      <>
                                        <div
                                          className="cursor-pointer hidden"
                                          {...provided.dragHandleProps}
                                        >
                                          <Icon
                                            icon={clsx({
                                              "typcn:warning": !task?.title
                                                .length,
                                              "nimbus:drag-dots":
                                                task?.title.length,
                                            })}
                                            className={`${clsx({
                                              "text-danger-600": !task?.title
                                                .length,
                                            })}`}
                                          />
                                        </div>
                                        <label
                                          htmlFor={`tasks.${taskIndex}.title`}
                                          className="block mb-2 text-sm font-normal text-gray-600"
                                        >
                                          Görev başlığı
                                        </label>

                                        <Input
                                          type="text"
                                          id={`tasks.${taskIndex}.title`}
                                          name={`tasks.${taskIndex}.title`}
                                          variant="bordered"
                                          className="w-full"
                                          size="sm"
                                          value={task.title}
                                          onChange={formik.handleChange}
                                        />

                                        <ErrorMessage
                                          name={`tasks.${taskIndex}.title`}
                                          className="text-danger-600 text-xs mt-1"
                                          component="div"
                                        />

                                        <label
                                          htmlFor={`tasks.${taskIndex}.title`}
                                          className="block my-2 text-sm font-normal text-gray-600"
                                        >
                                          Görev açıklaması
                                        </label>

                                        <Textarea
                                          type="text"
                                          id={`tasks.${taskIndex}.description`}
                                          name={`tasks.${taskIndex}.description`}
                                          variant="bordered"
                                          className="w-full"
                                          size="sm"
                                          value={task.description}
                                          onChange={formik.handleChange}
                                          minRows={1}
                                        />

                                        <ErrorMessage
                                          name={`tasks.${taskIndex}.description`}
                                          className="text-danger-600 text-xs mt-1"
                                          component="div"
                                        />

                                        <label
                                          htmlFor={`tasks.${taskIndex}.questions`}
                                          className="block my-2 text-sm font-normal text-gray-600"
                                        >
                                          Sorular
                                        </label>

                                        {task.questions.length ? (
                                          <div className="border p-1 px-0 rounded-md">
                                            <DragDropContext
                                              onDragEnd={(result) =>
                                                handleQuestionDragEnd(
                                                  result,
                                                  taskIndex
                                                )
                                              }
                                            >
                                              <Droppable
                                                droppableId={`questions-${taskIndex}`}
                                                type={`droppableSubItem`}
                                              >
                                                {(provided) => (
                                                  <div
                                                    {...provided.droppableProps}
                                                    ref={provided.innerRef}
                                                  >
                                                    <FieldArray
                                                      name={`tasks.${taskIndex}.questions`}
                                                    >
                                                      {(questionHelper) => (
                                                        <>
                                                          {task.questions.map(
                                                            (
                                                              question,
                                                              questionIndex
                                                            ) => (
                                                              <Draggable
                                                                key={
                                                                  questionIndex
                                                                }
                                                                draggableId={`question-${taskIndex}-${questionIndex}`}
                                                                index={
                                                                  questionIndex
                                                                }
                                                              >
                                                                {(
                                                                  provided,
                                                                  snapshot
                                                                ) => (
                                                                  <div
                                                                    ref={
                                                                      provided.innerRef
                                                                    }
                                                                    {...provided.draggableProps}
                                                                    style={{
                                                                      ...provided
                                                                        .draggableProps
                                                                        .style,
                                                                    }}
                                                                  >
                                                                    <div
                                                                      className={clsx(
                                                                        {
                                                                          "bg-white border-t-1 border-gray-200 p-3":
                                                                            questionIndex >
                                                                            0,
                                                                          "bg-white p-3":
                                                                            questionIndex ===
                                                                            0,
                                                                          "border-1 rounded-md":
                                                                            snapshot.isDragging,
                                                                          "!p-1":
                                                                            question.isCollapsed,
                                                                        }
                                                                      )}
                                                                    >
                                                                      {!question.isCollapsed ? (
                                                                        <>
                                                                          <div
                                                                            className="cursor-pointer hidden"
                                                                            {...provided.dragHandleProps}
                                                                          >
                                                                            <Icon
                                                                              icon={clsx(
                                                                                {
                                                                                  "typcn:warning": !question
                                                                                    ?.title
                                                                                    .length,
                                                                                  "nimbus:drag-dots":
                                                                                    question
                                                                                      ?.title
                                                                                      .length,
                                                                                }
                                                                              )}
                                                                              className={clsx(
                                                                                {
                                                                                  "text-danger-600": !question
                                                                                    ?.title
                                                                                    .length,
                                                                                }
                                                                              )}
                                                                            />
                                                                          </div>
                                                                          <label
                                                                            htmlFor={`tasks.${taskIndex}.questions.${questionIndex}.title`}
                                                                            className="block mb-2 text-sm font-normal text-gray-600"
                                                                          >
                                                                            Soru
                                                                            başlığı
                                                                          </label>

                                                                          <Input
                                                                            type="text"
                                                                            id={`tasks.${taskIndex}.questions.${questionIndex}.title`}
                                                                            name={`tasks.${taskIndex}.questions.${questionIndex}.title`}
                                                                            variant="bordered"
                                                                            className="w-full"
                                                                            size="sm"
                                                                            value={
                                                                              question.title
                                                                            }
                                                                            onChange={
                                                                              formik.handleChange
                                                                            }
                                                                          />

                                                                          <ErrorMessage
                                                                            name={`tasks.${taskIndex}.questions.${questionIndex}.title`}
                                                                            className="text-danger-600 text-xs mt-1"
                                                                            component="div"
                                                                          />

                                                                          <label
                                                                            htmlFor={`tasks.${taskIndex}.questions.${questionIndex}.description`}
                                                                            className="block my-2 text-sm font-normal text-gray-600"
                                                                          >
                                                                            Soru
                                                                            açıklaması
                                                                          </label>

                                                                          <Textarea
                                                                            type="text"
                                                                            id={`tasks.${taskIndex}.questions.${questionIndex}.description`}
                                                                            name={`tasks.${taskIndex}.questions.${questionIndex}.description`}
                                                                            variant="bordered"
                                                                            className="w-full"
                                                                            size="sm"
                                                                            value={
                                                                              question.description
                                                                            }
                                                                            onChange={
                                                                              formik.handleChange
                                                                            }
                                                                            minRows={
                                                                              1
                                                                            }
                                                                          />

                                                                          <div className="mt-2">
                                                                            <label
                                                                              htmlFor={`tasks.${taskIndex}.questions.${questionIndex}.type`}
                                                                              className="block mb-2 text-sm font-normal text-gray-600"
                                                                              id={`tasks.${taskIndex}.questions.${questionIndex}.type-label`}
                                                                            >
                                                                              Soru
                                                                              Tipi
                                                                            </label>
                                                                            <Select
                                                                              id={`tasks.${taskIndex}.questions.${questionIndex}.option_type`}
                                                                              name={`tasks.${taskIndex}.questions.${questionIndex}.option_type`}
                                                                              value={
                                                                                question.option_type
                                                                              }
                                                                              selectedKeys={[
                                                                                question.option_type,
                                                                              ]}
                                                                              aria-label="option_type"
                                                                              onChange={(
                                                                                e
                                                                              ) =>
                                                                                formik.setFieldValue(
                                                                                  `tasks.${taskIndex}.questions.${questionIndex}.option_type`,
                                                                                  e
                                                                                    .target
                                                                                    .value
                                                                                )
                                                                              }
                                                                              variant="bordered"
                                                                              size="sm"
                                                                              aria-labelledby={`tasks.${taskIndex}.questions.${questionIndex}.option_type-label`}
                                                                            >
                                                                              <SelectItem
                                                                                key={
                                                                                  "radio"
                                                                                }
                                                                                value="radio"
                                                                              >
                                                                                Seçim
                                                                              </SelectItem>
                                                                              <SelectItem
                                                                                key={
                                                                                  "checkbox"
                                                                                }
                                                                                value="checkbox"
                                                                              >
                                                                                Çoklu
                                                                                Seçim
                                                                              </SelectItem>
                                                                              <SelectItem
                                                                                key={
                                                                                  "text"
                                                                                }
                                                                                value="text"
                                                                              >
                                                                                Metin
                                                                              </SelectItem>
                                                                              <SelectItem
                                                                                key={
                                                                                  "image"
                                                                                }
                                                                                value="image"
                                                                              >
                                                                                Resim
                                                                              </SelectItem>
                                                                              <SelectItem
                                                                                key={
                                                                                  "text_video"
                                                                                }
                                                                                value="text_video"
                                                                              >
                                                                                Metin
                                                                                &
                                                                                Video
                                                                              </SelectItem>
                                                                              <SelectItem
                                                                                key={
                                                                                  "text_image"
                                                                                }
                                                                                value="text_image"
                                                                              >
                                                                                Metin
                                                                                &
                                                                                Resim
                                                                              </SelectItem>
                                                                              <SelectItem
                                                                                key={
                                                                                  "video"
                                                                                }
                                                                                value="video"
                                                                              >
                                                                                Video
                                                                              </SelectItem>
                                                                            </Select>
                                                                          </div>

                                                                          <ErrorMessage
                                                                            name={`tasks.${taskIndex}.questions.${questionIndex}.option_type`}
                                                                            className="text-danger-600 text-xs mt-1"
                                                                            component="div"
                                                                          />

                                                                          {question.option_type ===
                                                                            "radio" ||
                                                                          question.option_type ===
                                                                            "checkbox" ? (
                                                                            <div className="mt-2">
                                                                              <label
                                                                                htmlFor={`tasks.${taskIndex}.questions.${questionIndex}.options`}
                                                                                className="block mb-2 text-sm font-normal text-gray-600"
                                                                              >
                                                                                Seçenekler
                                                                              </label>
                                                                              <DragDropContext
                                                                                onDragEnd={(
                                                                                  result
                                                                                ) =>
                                                                                  handleOptionDragEnd(
                                                                                    result,
                                                                                    taskIndex,
                                                                                    questionIndex
                                                                                  )
                                                                                }
                                                                              >
                                                                                <Droppable
                                                                                  droppableId={`options-${taskIndex}-${questionIndex}`}
                                                                                  type={`droppableSubItem`}
                                                                                >
                                                                                  {(
                                                                                    provided
                                                                                  ) => (
                                                                                    <div
                                                                                      {...provided.droppableProps}
                                                                                      ref={
                                                                                        provided.innerRef
                                                                                      }
                                                                                    >
                                                                                      <FieldArray
                                                                                        name={`tasks.${taskIndex}.questions.${questionIndex}.options`}
                                                                                      >
                                                                                        {(
                                                                                          optionHelper
                                                                                        ) => (
                                                                                          <>
                                                                                            {question.options.map(
                                                                                              (
                                                                                                option,
                                                                                                optIndex
                                                                                              ) => (
                                                                                                <Draggable
                                                                                                  key={
                                                                                                    optIndex
                                                                                                  }
                                                                                                  draggableId={`option-${taskIndex}-${questionIndex}-${optIndex}`}
                                                                                                  index={
                                                                                                    optIndex
                                                                                                  }
                                                                                                  isDragDisabled={
                                                                                                    !option.option_value
                                                                                                  } // Boş seçeneklerin sürüklenmesini engellemek için
                                                                                                >
                                                                                                  {(
                                                                                                    provided,
                                                                                                    snapshot
                                                                                                  ) => (
                                                                                                    <div
                                                                                                      ref={
                                                                                                        provided.innerRef
                                                                                                      }
                                                                                                      {...(option
                                                                                                        .option_value
                                                                                                        ?.length
                                                                                                        ? provided.draggableProps
                                                                                                        : {})}
                                                                                                      {...(option
                                                                                                        .option_value
                                                                                                        ?.length
                                                                                                        ? provided.dragHandleProps
                                                                                                        : {})}
                                                                                                      style={{
                                                                                                        ...provided
                                                                                                          .draggableProps
                                                                                                          .style,
                                                                                                        ...(snapshot.isDragging && {
                                                                                                          background:
                                                                                                            "#f0f0f0",
                                                                                                        }),
                                                                                                      }}
                                                                                                      className={`flex gap-2 items-center mt-2 ${
                                                                                                        snapshot.isDragging
                                                                                                          ? "bg-light-200"
                                                                                                          : ""
                                                                                                      }`}
                                                                                                    >
                                                                                                      <div>
                                                                                                        <Icon
                                                                                                          icon="nimbus:drag-dots"
                                                                                                          className={`${
                                                                                                            !option
                                                                                                              .option_value
                                                                                                              ?.length
                                                                                                              ? "text-[#cccccc]"
                                                                                                              : "cursor-pointer"
                                                                                                          }`}
                                                                                                        />
                                                                                                      </div>
                                                                                                      <Input
                                                                                                        type="text"
                                                                                                        id={`tasks.${taskIndex}.questions.${questionIndex}.options.${optIndex}.option_value`}
                                                                                                        name={`tasks.${taskIndex}.questions.${questionIndex}.options.${optIndex}.option_value`}
                                                                                                        variant="bordered"
                                                                                                        className="w-full"
                                                                                                        size="sm"
                                                                                                        placeholder={
                                                                                                          option
                                                                                                            ?.option_value
                                                                                                            .length
                                                                                                            ? "Seçenek"
                                                                                                            : "Başka bir değer ekle"
                                                                                                        }
                                                                                                        value={
                                                                                                          option?.option_value
                                                                                                        }
                                                                                                        onChange={(
                                                                                                          e
                                                                                                        ) => {
                                                                                                          if (
                                                                                                            e
                                                                                                              .target
                                                                                                              .value !==
                                                                                                            ""
                                                                                                          ) {
                                                                                                            formik.handleChange(
                                                                                                              e
                                                                                                            );
                                                                                                            if (
                                                                                                              e
                                                                                                                .target
                                                                                                                .value
                                                                                                                .length >
                                                                                                                0 &&
                                                                                                              option?.option_value ===
                                                                                                                ""
                                                                                                            ) {
                                                                                                              optionHelper.push(
                                                                                                                {
                                                                                                                  option_value:
                                                                                                                    "",
                                                                                                                }
                                                                                                              );
                                                                                                            }
                                                                                                          }
                                                                                                        }}
                                                                                                        endContent={
                                                                                                          option
                                                                                                            ?.option_value
                                                                                                            .length ? (
                                                                                                            <span
                                                                                                              onClick={() =>
                                                                                                                optionHelper.remove(
                                                                                                                  optIndex
                                                                                                                )
                                                                                                              }
                                                                                                              className="cursor-pointer"
                                                                                                            >
                                                                                                              <Icon icon="mynaui:trash" />
                                                                                                            </span>
                                                                                                          ) : null
                                                                                                        }
                                                                                                      />
                                                                                                    </div>
                                                                                                  )}
                                                                                                </Draggable>
                                                                                              )
                                                                                            )}
                                                                                          </>
                                                                                        )}
                                                                                      </FieldArray>
                                                                                      {
                                                                                        provided.placeholder
                                                                                      }
                                                                                    </div>
                                                                                  )}
                                                                                </Droppable>
                                                                              </DragDropContext>
                                                                            </div>
                                                                          ) : null}

                                                                          <div className="mt-4 flex justify-between">
                                                                            <div className="flex justify-between w-full px-0">
                                                                              <Button
                                                                                className="p-1"
                                                                                variant="bordered"
                                                                                size="sm"
                                                                                onClick={() => {
                                                                                  questionHelper.remove(
                                                                                    questionIndex
                                                                                  );
                                                                                }}
                                                                              >
                                                                                Sil
                                                                              </Button>

                                                                              <Button
                                                                                className="bg-black text-white"
                                                                                size="sm"
                                                                                onClick={() => {
                                                                                  if (
                                                                                    question.title &&
                                                                                    question.option_type
                                                                                  ) {
                                                                                    toggleQuestionCollapse(
                                                                                      taskIndex,
                                                                                      questionIndex
                                                                                    );
                                                                                  } else {
                                                                                    formik.setFieldTouched(
                                                                                      `tasks.${taskIndex}.questions.${questionIndex}.title`
                                                                                    );
                                                                                    formik.setFieldTouched(
                                                                                      `tasks.${taskIndex}.questions.${questionIndex}.type`
                                                                                    );
                                                                                  }
                                                                                }}
                                                                              >
                                                                                Tamam
                                                                              </Button>
                                                                            </div>
                                                                          </div>
                                                                        </>
                                                                      ) : (
                                                                        <div className="my-2">
                                                                          <div className="flex gap-2 items-center">
                                                                            <div
                                                                              className="cursor-pointer"
                                                                              {...provided.dragHandleProps}
                                                                            >
                                                                              <Icon
                                                                                icon={clsx(
                                                                                  {
                                                                                    "typcn:warning": !question
                                                                                      ?.title
                                                                                      .length,
                                                                                    "nimbus:drag-dots":
                                                                                      question
                                                                                        ?.title
                                                                                        .length,
                                                                                  }
                                                                                )}
                                                                                className={clsx(
                                                                                  {
                                                                                    "text-danger-600": !question
                                                                                      ?.title
                                                                                      .length,
                                                                                  }
                                                                                )}
                                                                              />
                                                                            </div>
                                                                            <div
                                                                              onClick={() =>
                                                                                toggleQuestionCollapse(
                                                                                  taskIndex,
                                                                                  questionIndex
                                                                                )
                                                                              }
                                                                              className="cursor-pointer"
                                                                            >
                                                                              {question
                                                                                ?.title
                                                                                .length ? (
                                                                                <p className="text-sm font-bold">
                                                                                  {
                                                                                    question.title
                                                                                  }
                                                                                </p>
                                                                              ) : (
                                                                                <p className="text-danger-600 text-xs">
                                                                                  {
                                                                                    "Soru boş olamaz"
                                                                                  }
                                                                                </p>
                                                                              )}
                                                                            </div>
                                                                          </div>
                                                                        </div>
                                                                      )}
                                                                    </div>
                                                                  </div>
                                                                )}
                                                              </Draggable>
                                                            )
                                                          )}
                                                        </>
                                                      )}
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
                                          className="text-blue-500 inline-flex gap-2 items-center text-sm cursor-pointer mt-3 bg-white"
                                          onClick={() => addQuestion(taskIndex)}
                                        >
                                          <Icon icon="octicon:plus-16" /> Soru
                                          ekle
                                        </button>

                                        <div className="mt-4 flex justify-between">
                                          <div className="flex justify-between w-full px-0">
                                            <Button
                                              className="p-1"
                                              variant="bordered"
                                              size="sm"
                                              onClick={() => {
                                                taskHelper.remove(taskIndex);
                                              }}
                                            >
                                              Sil
                                            </Button>

                                            <Button
                                              className="bg-black text-white"
                                              size="sm"
                                              onClick={() => {
                                                if (task.title) {
                                                  toggleTaskCollapse(taskIndex);
                                                } else {
                                                  formik.setFieldTouched(
                                                    `tasks.${taskIndex}.title`
                                                  );
                                                }
                                              }}
                                            >
                                              Tamam
                                            </Button>
                                          </div>
                                        </div>
                                      </>
                                    ) : (
                                      <div className="my-2">
                                        <div className="flex gap-2 items-center">
                                          <div
                                            className="cursor-pointer"
                                            {...provided.dragHandleProps}
                                          >
                                            <Icon
                                              icon={clsx({
                                                "typcn:warning": !task?.title
                                                  .length,
                                                "nimbus:drag-dots":
                                                  task?.title.length,
                                              })}
                                              className={`${clsx({
                                                "text-danger-600": !task?.title
                                                  .length,
                                              })}`}
                                            />
                                          </div>
                                          <div
                                            onClick={() =>
                                              toggleTaskCollapse(taskIndex)
                                            }
                                            className="cursor-pointer"
                                          >
                                            {task?.title.length ? (
                                              <p className="text-sm font-bold">
                                                {task.title}
                                              </p>
                                            ) : (
                                              <p className="text-danger-600 text-xs">
                                                Görev başlığı boş olamaz
                                              </p>
                                            )}
                                          </div>
                                        </div>
                                      </div>
                                    )}
                                  </div>
                                </div>
                              )}
                            </Draggable>
                          ))}
                        </>
                      )}
                    </FieldArray>
                    {provided.placeholder}
                  </div>
                )}
              </Droppable>
            </DragDropContext>
          </div>
        ) : null}

        <div>
          <button
            type="button"
            className="text-blue-500 inline-flex gap-2 items-center text-sm cursor-pointer bg-white"
            onClick={addTask}
          >
            <Icon icon="octicon:plus-16" />
            Görev ekle
          </button>
        </div>
      </CardBody>
      <CardFooter className="p-0">
        {formik.values.tasks.length ? (
          <Table
            aria-label="Görevler Tablosu"
            shadow="none"
            className="[&>div]:px-0 mt-1"
          >
            <TableHeader>
              <TableColumn>Görsel</TableColumn>
              <TableColumn>Başlık</TableColumn>
              <TableColumn>Başlangıç Tarihi</TableColumn>
              <TableColumn>Bitiş Tarihi</TableColumn>
              <TableColumn>Aktiflik</TableColumn>
            </TableHeader>
            <TableBody>
              {formik.values.tasks.map((task, taskIndex) => (
                <TableRow key={taskIndex}>
                  <TableCell>
                    <FileBrowserModal
                      setPickUrl={(value) =>
                        formik.setFieldValue(`tasks.${taskIndex}.cover`, value)
                      }
                      OpenComponent={
                        <div className="rounded-lg border border-dashed border-zinc-600 bg-neutral-50 w-16 h-16 flex items-center justify-center cursor-pointer p-1">
                          {task.cover ? (
                            <img
                              src={task.cover}
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
                      value={task.cover}
                    />
                  </TableCell>
                  <TableCell className="min-w-40">{task.title}</TableCell>
                  <TableCell>
                    <DatePicker
                      id={`tasks.${taskIndex}.start_date`}
                      name={`tasks.${taskIndex}.start_date`}
                      variant="bordered"
                      aria-label="Date"
                      size="sm"
                      value={
                        task?.start_date ? parseDate(task?.start_date) : null
                      }
                      onChange={(e) =>
                        formik.setFieldValue(
                          `tasks.${taskIndex}.start_date`,
                          e.toString()
                        )
                      }
                    />
                  </TableCell>
                  <TableCell>
                    <DatePicker
                      id={`tasks.${taskIndex}.end_date`}
                      name={`tasks.${taskIndex}.end_date`}
                      variant="bordered"
                      size="sm"
                      value={task?.end_date ? parseDate(task?.end_date) : null}
                      onChange={(e) =>
                        formik.setFieldValue(
                          `tasks.${taskIndex}.end_date`,
                          e.toString()
                        )
                      }
                    />
                  </TableCell>
                  <TableCell className="min-w-40">
                    <Switch
                      size="sm"
                      isSelected={task.is_active}
                      aria-label="Automatic updates"
                      onClick={() =>
                        formik.setFieldValue(
                          `announcements.${taskIndex}.is_active`,
                          !task.is_active
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
};

export default CardTask;
