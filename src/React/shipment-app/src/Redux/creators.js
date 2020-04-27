/* showAlert: false,
 alertTextBold: "Default Alert Bold",
 alertText: "Default alert text",
 alertVariant: "info", */

import actions from "./actions";

export const showAlert = (alertTextBold, alertText, alertVariant) => {
  return {
    type: actions.SHOW_ALERT,
    data: {
      alertTextBold,
      alertText,
      alertVariant,
    },
  };
};

export const toggleAlert = () => {
  return {
    type: actions.TOGGLE_ALERT,
  };
};

export const updateBaseUrl = (baseUrl) => {
  return { type: actions.UPDATE_BASE_URL, data: baseUrl };
};

export const setTypeAheadLoading = (b) => ({
  type: actions.SET_TYPEAHEAD_LOADING,
  data: b,
});

export const setShipmentDetail = (fieldName, fieldValue) => ({
  type: actions.SET_SHIPMENT_DETAIL,
  data: {
    fieldName: fieldName,
    fieldValue: fieldValue,
  },
});
