import { tv } from "@nextui-org/react";

// NEEDS TO BE REFACTORED

export const StyledBurgerButton = tv({
  base: "absolute flex flex-col text-with text-white",

  variants: {
    open: {
      true: "[&",
    },
  },
  //   "",
  //   "& div": {

  //     "&:first-child": {
  //       transform: "translateY(-4px) rotate(0deg)",
  //       height: "1px",
  //       marginTop: "10px",
  //     },
  //     "&:nth-child(2)": {
  //       transform: "translateY(4px) rotate(0deg)",
  //       height: "1px",
  //       marginBottom: "10px",
  //     },
  //   },
  //   variants: {
  //     open: {
  //       true: {
  //         "& div": {
  //           "&:first-child": {
  //             marginTop: "0px",
  //             transform: "translateY(1px) rotate(45deg)",
  //           },
  //           "&:nth-child(2)": {
  //             marginBottom: "0px",
  //             transform: "translateY(4px) rotate(-45deg)",
  //           },
  //         },
  //       },
  //     },
  //   },
});
