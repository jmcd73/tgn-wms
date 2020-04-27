import actions from "../Redux/actions";
import funcs from "../Utils/functions";

var traverse = function (o, fn) {
  for (var i in o) {
    fn.apply(this, [i, o[i]]);
    if (o[i] !== null && typeof o[i] == "object") {
      traverse(o[i], fn);
    }
  }
};

export const fetchApi = {
  fetchData: function (operation, productTypeOrId, baseUrl) {
    return function (dispatch) {
      dispatch({
        type: actions.SET_LOADING,
      });
      const suffix = [operation, productTypeOrId].filter((x) => x);

      const url = `${baseUrl}Shipments/` + suffix.join("/");

      return fetch(url, {
        headers: {
          Accept: "application/json",
          "X-Requested-With": "XMLHttpRequest",
        },
      })
        .then((resp) => {
          return resp.json();
        })
        .then((d) => {
          let allPallets = [];
          let operationName = "";
          let productTypeId = productTypeOrId;
          dispatch({
            type: actions.ADD_OPERATION,
            data: operation,
          });
          switch (operation) {
            case "add-shipment":
              operationName = "Add";
              allPallets = d["shipment_labels"];
              dispatch({
                type: actions.ADD_OPERATION_NAME,
                data: operationName,
              });

              dispatch({
                type: actions.ADD_PRODUCT_TYPE_ID,
                data: productTypeId,
              });
              dispatch({
                type: actions.ADD_ALL_PALLETS,
                data: allPallets,
              });

              break;
            case "edit-shipment":
              operationName = "Edit";
              const shipmentPallets = d["shipment"]["pallets"];
              allPallets = shipmentPallets.concat(d.shipment_labels);
              dispatch({
                type: actions.ADD_OPERATION_NAME,
                data: operationName,
              });

              dispatch({
                type: actions.ADD_ALL_PALLETS,
                data: allPallets,
              });

              const labelIds = shipmentPallets.map((pallet) => {
                return pallet.id;
              });
              productTypeId = d["shipment"]["product_type_id"];
              dispatch({
                type: actions.ADD_PRODUCT_TYPE_ID,
                data: productTypeId,
              });
              dispatch({
                type: actions.ADD_SHIPMENT_FROM_FETCH,
                data: d.shipment,
              });

              dispatch({
                type: actions.SET_LABEL_IDS,
                data: labelIds,
              });

              break;
            default:
              break;
          }

          dispatch(fetchApi.fetchProductType(productTypeId, baseUrl));

          const {
            products,
            productDescriptions,
            isExpanded,
            itemCounts,
          } = funcs.loadProductsAndDescriptions(allPallets);

          dispatch({
            type: actions.UPDATE_ITEM_COUNTS,
            data: itemCounts,
          });

          dispatch({
            type: actions.SET_PRODUCTS,
            data: products,
          });
          dispatch({
            type: actions.SET_PRODUCT_DESCRIPTIONS,
            data: productDescriptions,
          });

          dispatch({
            type: actions.SET_IS_EXPANDED,
            data: isExpanded,
          });

          dispatch({
            type: actions.SET_LOADING,
            data: false,
          });
        })
        .catch((e) => console.log(e));
    };
  },

  submitData: function () {
    return function (dispatch, getState) {
      dispatch({
        type: actions.UPDATE_UI,
        data: {
          errors: {},
          loading: true,
        },
      });

      const state = getState();
      const { products: p, ui, shipment: s } = state;

      const { operation, shipper, shipped, id, destination, labelIds } = s;
      const { baseUrl } = ui;
      const { productType } = p;

      let postObject = {
        shipper: shipper,
        destination: destination,
        shipped: shipped,
        product_type_id: productType,
        pallets: labelIds,
      };

      let urlArg = "";
      switch (operation) {
        case "add-shipment":
          urlArg = productType;
          break;
        case "edit-shipment":
          urlArg = id;
          postObject.id = id;
          const labels = labelIds.map((cur) => {
            return { shipment_id: id, id: cur };
          });
          postObject = { ...postObject, pallets: labels };

          break;
        default:
          console.log("it broken");
      }

      const parts = [operation, urlArg].filter((x) => x);

      const url = baseUrl + "Shipments/" + parts.join("/");

      let fetchOptions = {
        method: "POST", // *GET, POST, PUT, DELETE, etc.
        mode: "cors", // no-cors, cors, *same-origin
        cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
        credentials: "same-origin", // include, *same-origin, omit
        headers: {
          "X-CSRF-Token": window.csrfToken,
          "Content-Type": "application/json",
          Accept: "application/json",
          "X-Requested-With": "XMLHttpRequest",
        },
        redirect: "error",
        body: JSON.stringify(postObject),
      };

      dispatch({
        type: actions.SUBMIT_START,
      });

      return fetch(url, fetchOptions)
        .then((response) => response.json())
        .then((d) => {
          let redirect = true;

          let errorObject = d.error || {};

          if (Object.keys(errorObject).length > 0) {
            // eslint-disable-next-line array-callback-return

            if (errorObject.pallets) {
              errorObject = errorObject.pallets;
              // de nest d.error.pallets
              traverse(errorObject, function (k, v) {
                if (k === "shipped") {
                  errorObject = { [k]: v };
                }
              });
            }
            Object.keys(errorObject).forEach((fieldName) => {
              dispatch({
                type: actions.UPDATE_ERRORS,
                data: { [fieldName]: errorObject[fieldName] },
              });
            });

            redirect = false;
          }
          dispatch({
            type: actions.UPDATE_UI,
            data: {
              loading: false,
              redirect: redirect,
            },
          });
        });
    };
  },

  fetchProductType: function (productType, baseUrl) {
    return function (dispatch) {
      const url = `${baseUrl}ProductTypes/view/${productType}`;

      if (!productType) return;
      dispatch({ type: "FETCH_PRODUCT_START" });
      return fetch(url, {
        headers: {
          Accept: "application/json",
          "X-Requested-With": "XMLHttpRequest",
        },
      })
        .then((resp) => {
          return resp.json();
        })
        .then((d) => {
          if (d.productType) {
            dispatch({
              type: actions.SET_PRODUCT_TYPE_NAME,
              data: d.productType.name,
            });
          }
        })
        .catch((e) => {
          throw e;
        });
    };
  },

  getSearchTerm: function (query) {
    return function (dispatch, getState) {
      dispatch({
        type: actions.SET_TYPEAHEAD_LOADING,
        data: true,
      });
      dispatch({ type: "START_FETCH_TYPEAHEAD" });
      const baseUrl = getState().ui.baseUrl;

      return fetch(`${baseUrl}Shipments/destinationLookup?term=${query}`, {
        headers: {
          Accept: "application/json",
        },
      })
        .then((resp) => resp.json())
        .then((json) => {
          dispatch({
            type: actions.SET_TYPEAHEAD_LOADING,
            data: false,
          });
          dispatch({
            type: actions.LOAD_OPTIONS,
            data: json,
          });
        });
    };
  },
};

export default fetchApi;
