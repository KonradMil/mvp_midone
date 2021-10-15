
export default function useLayoutButtonClick(val, callback) {
    switch (val) {
        case "edit":
            callback({action: "beginLayoutEdit", data: ''})
            break;
        case "addlabel":
            callback({action: "beginLayoutLabel", data: ''});
            break;
        case "addlayout":
            callback({action: "beginLayoutDraw", data: ''});
            break;
        case "notatka":
            callback({action: "beginLayoutComment", data: ''});
            break;
    }
}
