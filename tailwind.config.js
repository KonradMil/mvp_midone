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
          1: "#5e50ac",
          2: "#F1F5F8",
          3: "#4c3f92",
          4: "#372d65",
          5: "#DEE7EF",
          6: "#D32929",
          7: "#271c69",
          8: "#5D52AE",
          9: "#91C714",
          10: "#828282",
          11: "#F78B00",
          12: "#FBC500",
          13: "#352b6c",
          14: "#E6F3FF",
          15: "#798796",
          16: "#4a5862",
          17: "#FFEFD9",
          18: "#D8F8BC",
          19: "#6b5db2",
          20: "#6b5db2",
          21: "#C6D4FD",
          22: "#E8EEFF",
          23: "#201950",
          24: "#271c69",
          25: "#C7D2FF",
          26: "#271c69",
          27: "#5D52AE",
          28: "#BBC8FD",
          29: "#5d52ae",
          30: "#43369d"
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
