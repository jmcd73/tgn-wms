import actions from "./actions";

let initialState = {
  showAlert: false,
  alertTextBold: "Default Alert Bold",
  alertText: "Default alert text",
  alertVariant: "info",
};

export function alert(state = initialState, action) {
  switch (action.type) {
    case actions.SHOW_ALERT:
      return {
        ...state,
        showAlert: true,
      };
    case actions.HIDE_ALERT:
      return {
        ...state,
        showAlert: false,
      };
    default:
      return state;
  }
}
