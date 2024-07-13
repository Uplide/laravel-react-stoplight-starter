import { Quill } from "react-quill";

// eslint-disable-next-line @typescript-eslint/no-explicit-any
export function undoChange(quill: any) {
    quill.history.undo();
}

// eslint-disable-next-line @typescript-eslint/no-explicit-any
export function redoChange(quill: any) {
    quill.history.redo();
}

const Size = Quill.import("formats/size");
Size.whitelist = ["extra-small", "small", "medium", "large"];
Quill.register(Size, true);

const Font = Quill.import("formats/font");
Font.whitelist = [
    "arial",
    "comic-sans",
    "courier-new",
    "georgia",
    "helvetica",
    "lucida",
];
Quill.register(Font, true);
