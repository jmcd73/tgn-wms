export default {
  setShipmentDetail: function (key, value) {
    this.setState({
      shipment: { ...this.state.shipment, [key]: value },
    });
  },

  loadProductsAndDescriptions: function (pallets) {
    let newProducts = [];
    let newProductDescriptions = {};
    pallets.forEach((pl) => {
      if (newProducts.indexOf(pl.item_id) === -1) {
        newProducts.push(pl.item_id);
        newProductDescriptions[pl.item_id] = pl.code_desc;
        this.updateSingleItemLabelCount(pallets, pl.item_id);
      }
    });
    const newIsExpanded = newProducts.reduce((prev, curr, idx) => {
      prev[curr] = false;
      return prev;
    }, {});

    this.setState({
      newProducts,
      newProductDescriptions,
      newIsExpanded,
    });
  },
  /**
   *
   * @param {*} palletObject
   */
  updateCodeDescriptions: function (labelId) {
    let {
      newProducts,
      newProductDescriptions,
      allPallets,
      newIsExpanded,
    } = this.state;

    const plObject = allPallets.filter((plObj) => {
      return parseInt(plObj.id) === parseInt(labelId);
    });

    const { item_id: itemId } = plObject[0];

    this.updateSingleItemLabelCount(allPallets, itemId);

    if (newProducts.indexOf(itemId) === -1) {
      this.setState({
        newIsExpanded: {
          ...newIsExpanded,
          [itemId]: false,
        },
        newProducts: [...newProducts, itemId],
        newProductDescriptions: {
          ...newProductDescriptions,
          [itemId]: "A new description " + itemId,
        },
      });
    }
  },

  updateSingleItemLabelCount: function (productArray, itemId) {
    const count = productArray.filter((value, index) => {
      return value.item_id === itemId;
    }).length;

    let labelCounts = { ...this.state.labelCounts };

    this.setState({
      labelCounts: { ...labelCounts, [itemId]: count },
    });
  },

  createCodeDescriptions: function createCodeDescriptions(productArray = []) {
    let ctr = 0;
    let labelCounts = {};

    const codeDesc = productArray.reduce((accum, current) => {
      const codeDesc = current.code_desc;
      if (accum.indexOf(codeDesc) === -1) {
        accum.push(codeDesc);
        ctr = 1;
      }

      labelCounts[codeDesc] = ctr++;

      return accum;
    }, []);
    this.setState({
      labelCounts: { ...this.state.labelCounts, ...labelCounts },
    });
    return codeDesc;
  },
  getLabelList: function (productId) {
    const allPallets = this.state.allPallets;

    const labelList = allPallets.reduce((accum, current, idx) => {
      if (current.item_id === productId) {
        accum.push(current);
      }
      return accum;
    }, []);

    let currentLabelList = this.state.labelLists;
    let newLabelList = { ...currentLabelList, [productId]: labelList };
    this.setState({ labelLists: newLabelList });
  },

  toggleIsExpanded: function (productId, idx) {
    let isExpanded = { ...this.state.newIsExpanded };

    Object.keys(isExpanded).forEach((key) => {
      if (parseInt(key) === parseInt(productId)) {
        isExpanded[key] = !isExpanded[key];
      } else {
        isExpanded[key] = false;
      }
    });

    this.setState({ newIsExpanded: isExpanded });
  },

  toggleAlert: function (txt, bold, variant) {
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
  },

  toggleShipped: function () {
    this.setState({
      shipment: {
        ...this.state.shipment,
        shipped: !this.state.shipment.shipped,
      },
    });
  },

  addRemoveLabel: function (isAdd, labelId) {
    let { shipment } = this.state;
    let labelIds = [...shipment.labelIds];
    console.log(labelId, isAdd);
    this.updateCodeDescriptions(labelId);

    if (isAdd && labelIds.indexOf(labelId) === -1) {
      labelIds.push(labelId);
    }
    if (!isAdd) {
      labelIds = labelIds.filter((value) => {
        return value !== labelId;
      });
    }

    this.setState({
      shipment: { ...shipment, labelIds: labelIds },
    });
  },

  parseRouterArgs: function () {
    // gotta fix this it's ugggggly move it out of here
    let { operation, productTypeOrId } = this.props.match.params;

    return { operation, productTypeOrId };
  },

  getValidationState: function (fieldName) {
    if (this.state.errors[fieldName] !== undefined) {
      return true;
    }
    return false;
  },

  formatErrors: function (fieldName) {
    let errors = [];
    if (this.state.errors[fieldName]) {
      let obj = this.state.errors[fieldName];

      errors = Object.keys(obj).map((key) => {
        return obj[key];
      });
    }

    return errors.join(", ");
  },

  getLabelObject: function (id) {
    const { allPallets } = this.state;

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
