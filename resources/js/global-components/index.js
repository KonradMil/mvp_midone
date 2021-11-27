
import Tippy from "./tippy/Main.vue";
import TippyContent from "./tippy-content/Main.vue";

import TinySlider from "./tiny-slider/Main.vue";
import Dropzone from "./dropzone/Main.vue";
import * as featherIcons from "@zhuowenli/vue-feather-icons";

export default app => {
  app.component("Tippy", Tippy);
  app.component("TippyContent", TippyContent);
  app.component("TinySlider", TinySlider);
  app.component("Dropzone", Dropzone);

  for (const [key, icon] of Object.entries(featherIcons)) {
    icon.props.size.default = "24";
    app.component(key, icon);
  }
};
