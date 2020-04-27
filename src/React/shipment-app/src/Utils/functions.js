import * as actionCreators from "../Redux/creators";

export const funcs = {
  loadProductsAndDescriptions: function (pallets) {
    let products = [];
    let productDescriptions = {};
    let itemCounts = {};
    pallets.forEach((pl) => {
      if (products.indexOf(pl.item_id) === -1) {
        products.push(pl.item_id);
        productDescriptions[pl.item_id] = pl.code_desc;
        itemCounts = {
          ...itemCounts,
          ...funcs.updateSingleItemLabelCount(pallets, pl.item_id),
        };
      }
    });
    const isExpanded = products.reduce((prev, curr, idx) => {
      prev[curr] = false;
      return prev;
    }, {});

    return { products, productDescriptions, isExpanded, itemCounts };
  },
  /**
   *
   * @param {*} palletObject
   */
  updateCodeDescriptions: function (labelId) {
    return function (dispatch, getState) {
      dispatch(actionCreators.updateCodeDescriptions());
      let { products: p } = getState();

      const { products, allPallets } = p;

      const plObject = allPallets.filter((plObj) => {
        return parseInt(plObj.id) === parseInt(labelId);
      });

      const { item_id: itemId, code_desc } = plObject[0];

      dispatch(
        actionCreators.updateItemCounts(
          funcs.updateSingleItemLabelCount(allPallets, itemId)
        )
      );

      if (products.indexOf(itemId) === -1) {
        dispatch(actionCreators.updateIsExpanded({ [itemId]: false }));
        dispatch(actionCreators.updateProducts(itemId));
        dispatch(
          actionCreators.updateProductDescriptions({ [itemId]: code_desc })
        );
      }
    };
  },

  updateSingleItemLabelCount: function (productArray, itemId) {
    const count = productArray.filter((value, index) => {
      return value.item_id === itemId;
    }).length;

    return { [itemId]: count };
  },
  getLabelList: function (productId, allPallets) {
    const labelList = allPallets.reduce((accum, current, idx) => {
      if (current.item_id === productId) {
        accum.push(current);
      }
      return accum;
    }, []);

    return { [productId]: labelList };
  },

  toggleIsExpanded: function (productId, isExpanded) {
    Object.keys(isExpanded).forEach((key) => {
      if (parseInt(key) === parseInt(productId)) {
        isExpanded[key] = !isExpanded[key];
      } else {
        isExpanded[key] = false;
      }
    });

    return isExpanded;
  },

  /* toggleAlert: function (txt, bold, variant) {
    const newAlertState = !this.state.showAlert;
    this.setState({
      alertVariant: variant,
      alertText: txt,
      alertTextBold: bold,
      showAlert: newAlertState,
    });
    if (newAlertState) {
      setTimeout(() => {
        this.setState({ showAlert: !newAlertState });
      }, 4000);
    }
  }, */
  addRemoveLabel: function (isAdd, labelId, labelIds) {
    if (isAdd && labelIds.indexOf(labelId) === -1) {
      labelIds = labelIds.concat(labelId);
    }
    if (!isAdd) {
      labelIds = labelIds.filter((value) => {
        return value !== labelId;
      });
    }

    return labelIds;
  },

  parseRouterArgs: function (props) {
    // gotta fix this it's ugggggly move it out of here
    let { operation, productTypeOrId } = props;

    return { operation, productTypeOrId };
  },

  getValidationState: function (fieldName, errors) {
    if (errors[fieldName] !== undefined) {
      return true;
    }
    return false;
  },

  formatErrors: function (fieldName, fieldErrors) {
    let errors = [];
    if (fieldErrors[fieldName]) {
      let obj = fieldErrors[fieldName];

      errors = Object.keys(obj).map((key) => {
        return obj[key];
      });
    }

    return errors.join(", ");
  },

  getLabelObject: function (id, allPallets) {
    const ret = allPallets.filter((current, idx) => {
      return current.id === id;
    });
    return ret[0];
  },
  buildLabelString: function (palletObject) {
    const { location, item, bb_date, pl_ref, qty, description } = palletObject;

    const locationName = location.location;

    const d = new Date(bb_date);

    const stringValues = [
      locationName,
      item,
      d.toLocaleDateString(),
      pl_ref,
      qty,
      description,
    ];
    return stringValues.join(", ");
  },
};

export default funcs;
