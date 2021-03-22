const primaryColors = require("@left4code/tw-starter/dist/js/colors");

module.exports = {
  // purge: [
  //   "./src/**/*.php",
  //   "./src/**/*.html",
  //   "./src/**/*.vue",
  //   "./resources/**/*.php",
  //   "./resources/**/*.html",
  //   "./node_modules/@left4code/tw-starter/**/*.js"
  // ],
  darkMode: "class",
  theme: {
    borderColor: theme => ({
      ...theme("colors"),
      DEFAULT: primaryColors.gray["300"]
    }),
    extend: {
      colors: {
        ...primaryColors,
        theme: {
          1: "#930F68",
          2: "#F1F5F8",
          3: "#97156c",
          4: "#93186b",
          5: "#DEE7EF",
          6: "#D32929",
          7: "#93186b",
          8: "#a85c90",
          9: "#91C714",
          10: "#828282",
          11: "#F78B00",
          12: "#FBC500",
          13: "#93186b",
          14: "#E6F3FF",
          15: "#8DA9BE",
          16: "#607f96",
          17: "#FFEFD9",
          18: "#D8F8BC",
          19: "#a85c90",
          20: "#a85c90",
          21: "#C6D4FD",
          22: "#E8EEFF",
          23: "#7b0d57",
          24: "#5f0743",
          25: "#C7D2FF",
          26: "#7b0d57",
          27: "#5D52AE",
          28: "#BBC8FD",
          29: "#5d52ae",
          30: "#93186b"
        }
      },
      fontFamily: {
        roboto: ["Roboto"]
      },
      container: {
        center: true
      },
      maxWidth: {
        "1/4": "25%",
        "1/2": "50%",
        "3/4": "75%"
      },
      screens: {
        sm: "640px",
        md: "768px",
        lg: "1024px",
        xl: "1280px",
        xxl: "1600px"
      },
      strokeWidth: {
        0.5: 0.5,
        1.5: 1.5,
        2.5: 2.5
      }
    }
  },
  variants: {
    extend: {
      zIndex: ["responsive", "hover"],
      position: ["responsive", "hover"],
      padding: ["responsive", "last"],
      margin: ["responsive", "last"],
      borderWidth: ["responsive", "last"],
      backgroundColor: ["last", "first", "odd", "responsive", "hover", "dark"],
      borderColor: ["last", "first", "odd", "responsive", "hover", "dark"],
      textColor: ["last", "first", "odd", "responsive", "hover", "dark"],
      boxShadow: ["last", "first", "odd", "responsive", "hover", "dark"],
      borderOpacity: ["last", "first", "odd", "responsive", "hover", "dark"],
      backgroundOpacity: ["last", "first", "odd", "responsive", "hover", "dark"]
    }
  }
};
