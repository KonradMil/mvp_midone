
const doubleClick = ref(false);
const mousePositionY = ref(0);
const mousePositionX = ref(0);

export default function useRadialMenu(loaded, currentRadialMenu, callback) {
    if (loaded) {
        if (doubleClick.value) {
            if ((mousePositionX.value > (e.clientX - 10) && mousePositionX.value < (e.clientX + 10)) && (mousePositionY.value > (e.clientY - 10) && mousePositionY.value < (e.clientY + 19))) {
                let data = JSON.stringify({menu: currentRadialMenu});
                callback({action: 'showRadialMenu', data: data});
            } else {
                doubleClick.value = false;
            }
        } else {
            mousePositionX.value = e.clientX;
            mousePositionY.value = e.clientY;
            doubleClick.value = true;
            callback({action: 'closeRadialMenu', data: ''});
            setTimeout(function () {
                doubleClick.value = false;
            }, 1000);
        }
    }
}
