var traverse = function (o, fn) {
  for (var i in o) {
    fn.apply(this, [i, o[i]]);
    if (o[i] !== null && typeof o[i] == "object") {
      traverse(o[i], fn);
    }
  }
};

export default {
  fetchData: function (operation, productTypeOrId) {
    this.setState({
      ...this.defaults,
      loading: true,
    });
    const suffix = [operation, productTypeOrId].filter((x) => x);

    const url = this.state.baseUrl + "Shipments/" + suffix.join("/");

    fetch(url, {
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
        switch (operation) {
          case "add-shipment":
            operationName = "Add";
            allPallets = d["shipment_labels"];
            this.setState({
              operationName,
              productType: productTypeId,
              allPallets: allPallets,
              shipment: {
                ...this.state.shipment,
                operation,
              },
            });
            break;
          case "edit-shipment":
            operationName = "Edit";
            const shipmentPallets = d["shipment"]["pallets"];
            allPallets = shipmentPallets.concat(d.shipment_labels);
            this.setState({
              operationName,
              allPallets: allPallets,
            });
            const labelIds = shipmentPallets.map((pallet) => {
              return pallet.id;
            });
            productTypeId = d["shipment"]["product_type_id"];
            this.setState({
              productType: productTypeId,
              shipment: {
                ...this.state.shipment,
                ...d.shipment,
                operation,
                labelIds: labelIds,
              },
            });
            break;
          default:
            break;
        }
        this.fetchProductType(productTypeId);
        this.loadProductsAndDescriptions(allPallets);
        /* allPallets.forEach((pl) => {
          this.updateCodeDescriptions(pl);
        });*/

        this.setState({
          loading: false,
        });
      })
      .catch((e) => console.log(e));
  },

  submitData: function () {
    this.setState({
      errors: {},
      loading: true,
    });
    const { baseUrl, productType } = this.state;

    const {
      operation,
      shipper,
      shipped,
      id,
      destination,
      labelIds,
    } = this.state.shipment;

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

    fetch(url, fetchOptions)
      .then((response) => response.json())
      .then((d) => {
        let redirect = true;

        let errorObject = d.error || {};

        if (Object.keys(errorObject).length > 0) {
          // eslint-disable-next-line array-callback-return

          if (errorObject.pallets) {
            errorObject = errorObject.pallets;

            traverse(errorObject, function (k, v) {
              if (k === "shipped") {
                errorObject = { [k]: v };
              }
            });
          }
          Object.keys(errorObject).forEach((fieldName) => {
            this.setState({
              errors: {
                ...this.state.errors,
                [fieldName]: errorObject[fieldName],
              },
            });
          });

          redirect = false;
        }
        this.setState({
          loading: false,
          redirect: redirect,
        });
      });
  },

  fetchProductType: function (productType) {
    const url = this.state.baseUrl + `ProductTypes/view/${productType}`;

    if (!productType) return;

    fetch(url, {
      headers: {
        Accept: "application/json",
        "X-Requested-With": "XMLHttpRequest",
      },
    })
      .then((resp) => {
        return resp.json();
      })
      .then((d) => {
        console.log("ProductType", d);
        if (d.productType) {
          this.setState({
            productTypeName: d.productType.name,
          });
        }
        console.log("pt", d);
      })
      .catch((e) => {
        throw e;
      });
  },

  getSearchTerm: function (query) {
    fetch(`${this.state.baseUrl}Shipments/destinationLookup?term=${query}`, {
      headers: {
        Accept: "application/json",
      },
    })
      .then((resp) => resp.json())
      .then((json) => {
        console.log(json);
        this.setState({
          isTypeAheadLoading: false,
          options: json,
        });
      });
  },
};
