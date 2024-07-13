declare global {
    interface Window {
        Quill: typeof Quill;
    }
}
import React from "react";
import ReactQuill, { Quill } from "react-quill";
import "react-quill/dist/quill.snow.css";
import ImageResize from "quill-image-resize-module-react";
import { redoChange, undoChange } from "./QuillEditorToolbar";
import { QuillEditorProps } from "./QuillEditor.types";

Quill.register("modules/imageResize", ImageResize);
window.Quill = Quill;
const BlockEmbed = Quill.import("blots/block/embed");

class ImageBlot extends BlockEmbed {
    static create(value: {
        alt: string;
        src: string;
        width: string;
        height: string;
        className: string;
    }) {
        const div = document.createElement("div");
        const img = document.createElement("img");
        img.setAttribute("alt", value?.alt ?? "");
        img.setAttribute("src", value?.src ?? "");
        img.setAttribute("width", value?.width?.toString() ?? "");
        img.setAttribute("height", value?.height?.toString() ?? "");
        div.setAttribute("class", value?.className ?? "");
        div.appendChild(img);
        return div;
    }

    static value(node: HTMLElement) {
        const imageNode = node.querySelector("img");
        const divNode = node.querySelector("div");
        return {
            alt: imageNode?.getAttribute("alt"),
            src: imageNode?.getAttribute("src"),
            width: imageNode?.getAttribute("width"),
            height: imageNode?.getAttribute("height"),
            class: divNode?.getAttribute("class"),
        };
    }
}

ImageBlot.blotName = "image";
ImageBlot.tagName = "div";

Quill.register(ImageBlot);

export default function QuillEditor({
    setEditorHtml,
    editorHtml = "",
    name = "",
    placeholder = "Harika bir şey yaz...",
    readOnly = false,
}: QuillEditorProps) {
    const quillRef = React.useRef<ReactQuill>(null);
    const [selectedFileUrl, setSelectedFileUrl] = React.useState("");

    const handleChange = (html: string) => {
        try {
            setEditorHtml(null, name, html);
        } catch (error) {
            console.log(error);
        }
    };

    const modules = React.useMemo(
        () => ({
            toolbar: {
                container: [
                    ["bold", "italic", "underline", "strike"],
                    ["blockquote", "code-block"],
                    [{ header: 1 }, { header: 2 }],
                    [{ list: "ordered" }, { list: "bullet" }],
                    [{ script: "sub" }, { script: "super" }],
                    [{ indent: "-1" }, { indent: "+1" }],
                    [{ direction: "rtl" }],
                    [{ size: ["small", false, "large", "huge"] }],
                    [{ header: [1, 2, 3, 4, 5, 6, false] }],
                    [{ color: [] }, { background: [] }],
                    [{ font: [] }],
                    [{ align: [] }],
                    ["link", "image"],
                    ["clean"],
                ],
                handlers: {
                    undo: undoChange,
                    redo: redoChange,
                    // image: imageHandler,
                },
            },
            history: {
                delay: 500,
                maxStack: 100,
                userOnly: true,
            },
            imageResize: {
                parchment: Quill.import("parchment"),
                modules: ["Resize", "DisplaySize"],
            },
        }),
        []
    );

    const formats = [
        "header",
        "bold",
        "italic",
        "underline",
        "strike",
        "color",
        "font",
        "list",
        "bullet",
        "link",
        "image",
    ];

    React.useEffect(() => {
        if (quillRef.current && selectedFileUrl) {
            const quill = quillRef.current.getEditor();
            const cursorPosition = quill.getSelection();
            if (cursorPosition) {
                const { index } = cursorPosition;
                const image = {
                    src: selectedFileUrl,
                };
                quill.insertEmbed(index, "image", image);
                quill.formatLine(index, 1, "align", "center");
                quill.setSelection({ index: index + 2, length: 0 });
            }
        }
        setSelectedFileUrl("");
        // setOpenFileManager(false);
    }, [selectedFileUrl]);

    return (
        <div className="text-editor bg-white">
            <ReactQuill
                readOnly={readOnly}
                theme="snow"
                ref={quillRef}
                value={editorHtml}
                onChange={handleChange}
                placeholder={placeholder}
                modules={modules}
                formats={formats}
            />
        </div>
    );
}
