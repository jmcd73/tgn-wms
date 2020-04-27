/* showAlert: false,
 alertTextBold: "Default Alert Bold",
 alertText: "Default alert text",
 alertVariant: "info", */

import actions from "./actions";
import funcs from "../Utils/functions";

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

export const addOperationName = (operationName) => ({
  type: actions.ADD_OPERATION_NAME,
  data: operationName,
});

export const addAllPallets = (allPallets) => ({
  type: actions.ADD_ALL_PALLETS,
  data: allPallets,
});

export const addShipmentFromFetch = (shipment) => ({
  type: actions.ADD_SHIPMENT_FROM_FETCH,
  data: shipment,
});

export const addProductTypeId = (productTypeId) => ({
  type: actions.ADD_PRODUCT_TYPE_ID,
  data: productTypeId,
});

export const setLabelIds = (labelIds) => ({
  type: actions.SET_LABEL_IDS,
  data: labelIds,
});

export const addRemoveLabel = (isAdd, labelId) => {
  return function (dispatch, getState) {
    let labelIds = getState().shipment.labelIds;

    labelIds = funcs.addRemoveLabel(isAdd, labelId, labelIds);

    dispatch(setLabelIds(labelIds));

    dispatch(funcs.updateCodeDescriptions(labelId));
  };
};

export const updateCodeDescriptions = () => ({
  type: actions.UPDATE_CODE_DESCRIPTIONS,
});
export const updateItemCounts = (itemCount) => ({
  type: actions.UPDATE_ITEM_COUNTS,
  data: itemCount,
});

export const setProducts = (products) => ({
  type: actions.SET_PRODUCTS,
  data: products,
});

export const setProductTypeName = (productTypeName) => ({
  type: actions.SET_PRODUCT_TYPE_NAME,
  data: productTypeName,
});

export const setProductDescriptions = (productDescriptions) => ({
  type: actions.SET_PRODUCT_DESCRIPTIONS,
  data: productDescriptions,
});

export const setIsExpanded = (isExpanded) => ({
  type: actions.SET_IS_EXPANDED,
  data: isExpanded,
});

export const toggleIsExpanded = (productId) => {
  return function (dispatch, getState) {
    const isExpanded = getState().ui.isExpanded;
    const newExpanded = funcs.toggleIsExpanded(productId, isExpanded);
    dispatch({
      type: actions.SET_IS_EXPANDED,
      data: newExpanded,
    });
  };
};

export const updateIsExpanded = (isExpanded) => ({
  type: actions.UPDATE_IS_EXPANDED,
  data: isExpanded,
});

export const setLoading = (b) => ({
  type: actions.SET_LOADING,
  data: b,
});

export const submitStart = () => ({
  type: actions.SUBMIT_START,
});

export const updateErrors = (obj) => ({
  type: actions.UPDATE_ERRORS,
  data: obj,
});
export const updateUI = (obj) => ({
  type: actions.UPDATE_UI,
  data: obj,
});

export const loadOptions = (options) => ({
  type: actions.LOAD_OPTIONS,
  data: options,
});

export const startFetchTypeAhead = () => ({ type: "START_FETCH_TYPEAHEAD" });

export const fetchProductTypeStart = () => ({
  type: actions.FETCH_PRODUCT_TYPE_START,
});

export const updateProducts = (itemId) => ({
  type: actions.UPDATE_PRODUCTS,
  data: itemId,
});

export const updateProductDescriptions = (itemCodeDesc) => ({
  type: actions.UPDATE_PRODUCT_DESCRIPTIONS,
  data: itemCodeDesc,
});

export const getLabelList = (productId) => {
  return function (dispatch, getState) {
    const allPallets = getState().products.allPallets;
    dispatch({
      type: actions.SET_LABEL_LIST,
      data: funcs.getLabelList(productId, allPallets),
    });
  };
};
