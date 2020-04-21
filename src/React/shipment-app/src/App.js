import React from "react";
import Card from "react-bootstrap/Card";
import FormControl from "react-bootstrap/FormControl";
import FormGroup from "react-bootstrap/FormGroup";
import FormLabel from "react-bootstrap/FormLabel";
import Col from "react-bootstrap/Col";
import Row from "react-bootstrap/Row";
import FormCheck from "react-bootstrap/FormCheck";
import Badge from "react-bootstrap/Badge";
import Button from "react-bootstrap/Button";

import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faBan } from "@fortawesome/free-solid-svg-icons";

import { withRouter } from "react-router";
import PulseLoader from "react-spinners/PulseLoader";
import FormText from "react-bootstrap/FormText";
import Wrap from "./Components/Wrap";
import WrapCheckbox from "./Components/WrapCheckbox";
import AlertMessage from "./Components/AlertMessage";
import Form from "react-bootstrap/Form";

import "react-bootstrap-typeahead/css/Typeahead.css";
import "./ShipApp.css";

// import queryString from "query-string";

import { AsyncTypeahead } from "react-bootstrap-typeahead"; // ES2015

class App extends React.Component {
  constructor(props) {
    super(props);

    this.defaults = {
      isExpanded: {},
      products: [],
      shipmentTypeDisabled: false,
      labelLists: {},
      loading: false,
      redirect: false,
      labelCounts: {},
      showAlert: false,
      errors: {},
      operationName: "",
      shipment: {
        operation: "",
        id: "",
        shipment_type: "",
        shipped: false,
        shipper: "",
        destination: "",
        product_type_id: "",
        labelIds: [],
      },
      isTypeAheadLoading: false,
      productType: 0,
      productTypeName: "",
      activeKey: 99999,
      loadedData: [],
      options: [],
      productTypes: [],
      baseUrl: this.props.baseUrl,
    };
    this.state = {
      ...this.defaults,
    };

    this.setProductType = this.setProductType.bind(this);
    this.updateActiveKey = this.updateActiveKey.bind(this);
    this.getLabelList = this.getLabelList.bind(this);
    this.addRemoveLabel = this.addRemoveLabel.bind(this);
    this.toggleIsExpanded = this.toggleIsExpanded.bind(this);
    this.buildLabelString = this.buildLabelString.bind(this);
    this.getLabelObject = this.getLabelObject.bind(this);
    this.toggleShipped = this.toggleShipped.bind(this);
    this.toggleAlert = this.toggleAlert.bind(this);
    this.setShipmentDetail = this.setShipmentDetail.bind(this);
    this.submitData = this.submitData.bind(this);
  }

  setShipmentDetail(key, value) {
    this.setState({
      shipment: { ...this.state.shipment, [key]: value },
    });
  }

  updateActiveKey(n) {
    this.setState({ activeKey: n });
  }

  fetchData(operation, productTypeOrId) {
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
        switch (operation) {
          case "add-shipment":
            operationName = "Add";
            allPallets = d["shipment_labels"];
            this.setState({
              operationName,
              productType: productTypeOrId,
              loadedData: allPallets,
              shipment: {
                ...this.state.shipment,
                operation,
              },
            });
            break;
          case "edit-shipment":
            operationName = "Edit";
            const thisShipmentPallets = d["thisShipment"]["pallets"];
            allPallets = thisShipmentPallets.concat(d.shipment_labels);
            this.setState({
              operationName,
              loadedData: allPallets,
            });
            const labelIds = thisShipmentPallets.map((pallet) => {
              return pallet.id;
            });
            this.setState({
              productType: d["thisShipment"]["product_type_id"],
              shipment: {
                ...this.state.shipment,
                ...d.thisShipment,
                operation,
                labelIds: labelIds,
              },
            });
            break;
          default:
            break;
        }

        allPallets.forEach((pl) => {
          this.updateCodeDescriptions(pl);
        });

        this.getProductType(this.state.productType);

        this.setState({
          loading: false,
        });
      })
      .catch((e) => console.log(e));
  }

  buildCodeDescString(palletObject) {
    return palletObject.item + " " + palletObject.description;
  }
  /**
   *
   * @param {*} palletObject
   */
  updateCodeDescriptions(palletObject) {
    let { products, loadedData, isExpanded } = this.state;

    const codeDesc = this.buildCodeDescString(palletObject);
    const { item_id: itemId } = palletObject;
    this.updateSingleLabelCount(
      codeDesc,
      this.getSingleItemLabelCount(loadedData, itemId)
    );

    if (products.indexOf(codeDesc) === -1) {
      this.setState({
        isExpanded: {
          ...isExpanded,
          [codeDesc]: false,
        },
        products: [codeDesc, ...products],
      });
    }
  }

  getSingleItemLabelCount(productArray, itemId) {
    return productArray.filter((value, index) => {
      return value.item_id === itemId;
    }).length;
  }
  updateSingleLabelCount(itemString, count) {
    let labelCounts = { ...this.state.labelCounts };

    this.setState({
      labelCounts: { ...labelCounts, [itemString]: count },
    });
  }
  createCodeDescriptions(productArray = []) {
    let ctr = 0;
    let labelCounts = {};

    const codeDesc = productArray.reduce((accum, current) => {
      const codeDesc = this.buildCodeDescString(current);
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
  }
  getLabelList(productTitle) {
    console.log("getLabelList");
    const loadedData = this.state.loadedData;

    const labelList = loadedData.reduce((accum, current, idx) => {
      const codeDesc = current.item + " " + current.description;
      if (codeDesc === productTitle) {
        accum.push(current);
      }
      return accum;
    }, []);
    let currentLabelList = this.state.labelLists;
    let newLabelList = { ...currentLabelList, [productTitle]: labelList };
    this.setState({ labelLists: newLabelList });
  }
  toggleIsExpanded(product, idx) {
    let isExpanded = { ...this.state.isExpanded };

    Object.keys(isExpanded).forEach((key) => {
      if (key === product) {
        isExpanded[key] = !isExpanded[key];
      } else {
        isExpanded[key] = false;
      }
    });
    //isExpanded[product] = !isExpanded[product];
    console.log("toggleExpanded", isExpanded, product);
    this.setState({ isExpanded: isExpanded });
  }

  toggleAlert() {
    const newAlertState = !this.state.showAlert;
    this.setState({ showAlert: newAlertState });
    if (newAlertState) {
      setTimeout(() => {
        this.setState({ showAlert: !newAlertState });
      }, 4000);
    }
  }

  submitData() {
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
        /**
                 *  "error": {
        "shipper": [
            "Shipment number must be unique"
        ]
    },
                 */
        if (d.error) {
          // eslint-disable-next-line array-callback-return
          Object.keys(d.error).map((fieldName) => {
            this.setState({
              errors: {
                ...this.state.errors,
                [fieldName]: d.error[fieldName],
              },
            });
          });
        } else {
          this.setState({
            redirect: true,
          });
        }
        this.setState({ loading: false });
      });
  }

  toggleShipped() {
    this.setState({
      shipment: {
        ...this.state.shipment,
        shipped: !this.state.shipment.shipped,
      },
    });
  }

  addRemoveLabel(isAdd, labelId) {
    let { shipment } = this.state;
    let labelIds = [...shipment.labelIds];

    this.updateCodeDescriptions(this.getLabelObject(labelId)[0]);

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
  }
  setProductType(e) {
    const productType = e.target.value;

    if (productType === "") {
      this.setState({ products: [] });
      return;
    }
    if (this.state.productType !== productType) {
      this.setState({ productType: productType });
      const { operation, productTypeOrId } = this.parseRouterArgs();
      this.fetchData(operation, productTypeOrId);
    }
  }

  parseRouterArgs() {
    // gotta fix this it's ugggggly move it out of here
    let { operation, productTypeOrId } = this.props.match.params;

    return { operation, productTypeOrId };
  }

  getValidationState(fieldName) {
    if (this.state.errors[fieldName] !== undefined) {
      return "error";
    }
    return null;
  }

  componentDidMount() {
    const { operation, productTypeOrId } = this.parseRouterArgs();
    this.setState({
      baseUrl: this.props.baseUrl,
    });
    this.fetchData(operation, productTypeOrId);
  }

  getProductType(productType) {
    const url = this.state.baseUrl + `ProductTypes/view/${productType}`;

    if (productType) {
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
    }
  }

  formatErrors(fieldName) {
    let errors = [];
    if (this.state.errors[fieldName]) {
      let obj = this.state.errors[fieldName];

      errors = Object.keys(obj).map((key) => {
        return obj[key];
      });
    }

    return errors.join(", ");
  }

  getLabelObject(id) {
    const { loadedData } = this.state;

    const ret = loadedData.filter((current, idx) => {
      return current.id === id;
    });
    return ret;
  }
  buildLabelString(palletObject) {
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
  }
  render() {
    const {
      products,
      labelLists,
      showAlert,
      labelCounts,
      isExpanded,
      shipment,
      productTypeName,
      loading,
      errors,
      baseUrl,
      operationName,
    } = this.state;

    const shipperError = this.formatErrors("shipper");
    const shippedError = this.formatErrors("shipped");
    const destinationError = this.formatErrors("destination");
    const { labelIds, shipper, shipped, operation } = shipment;
    const selectedCount = labelIds.length;
    let labelsOnShipment = null;
    let classes = ["FormCheck", "fixed", "pallet-list"];
    let spinner = null;
    if (loading) {
      spinner = (
        <Row>
          <Col lg={12}>
            <div className="text-center">
              <PulseLoader loading={loading} size={14} color={"#ddd"} />
            </div>
          </Col>
        </Row>
      );
    }

    if (labelIds) {
      labelsOnShipment = labelIds.map((id, idx) => {
        const palletObject = this.getLabelObject(id)[0];
        return (
          <FormCheck
            key={palletObject.pl_ref}
            id={`checkbox-{id}`}
            checked
            label={this.buildLabelString(palletObject)}
            onChange={(e) =>
              this.addRemoveLabel(e.target.checked, palletObject.id)
            }
          />
        );
      });
    }

    if (this.state.redirect && process.env.NODE_ENV === "production") {
      window.location = baseUrl + "Shipments/";
    }

    return (
      <Wrap>
        <Row key="row-1">
          <Col lg={12}>
            <AlertMessage
              strongText="bold this"
              normalText="Message that"
              variant="info"
              show={showAlert}
              onDismiss={this.toggleAlert}
            />
            <h3>
              {operationName} {productTypeName} Shipment
            </h3>
          </Col>
        </Row>
        <Row key="row-2">
          <Col lg={12} key="row-col-1">
            <Form.Row onSubmit={(e) => e.preventDefault()}>
              <Col lg={3}>
                <FormGroup controlId="shipper">
                  <FormLabel>Shipment</FormLabel>{" "}
                  <FormControl
                    type="text"
                    value={shipper}
                    isValid={this.getValidationState("shipper")}
                    placeholder="Shipment"
                    onChange={(e) => {
                      const { shipper, ...newState } = this.state.errors;
                      this.setState({
                        errors: {
                          ...newState,
                        },
                      });

                      this.setShipmentDetail(e.target.id, e.target.value);
                    }}
                    required="required"
                  />
                  <FormControl.Feedback />
                  <FormText>{shipperError}</FormText>
                </FormGroup>
              </Col>
              <Col lg={3} key="row-col-2">
                <FormGroup controlId="destination">
                  <FormLabel>Destination</FormLabel>
                  <AsyncTypeahead
                    placeholder="Destination"
                    isLoading={this.state.isTypeAheadLoading}
                    id="destination"
                    name="destination"
                    isValid={this.getValidationState("destination")}
                    selected={[this.state.shipment.destination]}
                    onChange={(selected) => {
                      if (selected.length > 0) {
                        let destination = selected[0].value;
                        this.setShipmentDetail("destination", destination);
                      }
                    }}
                    onInputChange={(destination) => {
                      this.setShipmentDetail("destination", destination);
                    }}
                    onSearch={(query) => {
                      this.setState({ isTypeAheadLoading: true });
                      fetch(
                        `${this.state.baseUrl}Shipments/destinationLookup?term=${query}`,
                        {
                          headers: {
                            Accept: "application/json",
                          },
                        }
                      )
                        .then((resp) => resp.json())
                        .then((json) => {
                          console.log(json);
                          this.setState({
                            isTypeAheadLoading: false,
                            options: json,
                          });
                        });
                    }}
                    labelKey="value"
                    options={this.state.options}
                  />
                  <FormText>{destinationError}</FormText>
                </FormGroup>
              </Col>
            </Form.Row>
          </Col>
        </Row>
        <Row key="row-3">
          <Col lg={1}>
            <FormGroup validation={this.getValidationState("shipped")}>
              <FormCheck
                validation={this.getValidationState("shipped")}
                checked={shipped}
                id="shipped"
                onChange={this.toggleShipped}
                label="Shipped"
              />
              <FormText>{shippedError}</FormText>
            </FormGroup>
          </Col>
          <Col lg={5} className="mb-3">
            <Button
              variant="primary"
              size="sm"
              className="my-btn"
              onClick={this.submitData}
              type="submit"
            >
              Submit
            </Button>
          </Col>
          <Col lg={6}>{spinner}</Col>
        </Row>
        <Row key="row-4">
          <Col>
            <div className="pre-scrollable">
              <div className="card-container">
                <Card key={`card-top-level`}>
                  {products &&
                    products.map((product, idx) => {
                      return (
                        <div key={`wrap-{idx}`}>
                          <Card.Header
                            onClick={() => {
                              this.getLabelList(product);
                              this.toggleIsExpanded(product, idx);
                            }}
                            as="h5"
                            className="toggen-header"
                            key={`header-{idx}`}
                          >
                            {" "}
                            {product}{" "}
                            {labelCounts[product] && (
                              <Badge variant="primary">
                                {labelCounts[product]}
                              </Badge>
                            )}
                          </Card.Header>
                          {labelLists[product] && isExpanded[product] && (
                            <Card.Body
                              className={isExpanded[product] && "open"}
                            >
                              {labelLists[product].map((value, idx) => {
                                let icon = null;
                                let FormCheckClasses = classes.slice();
                                const checked =
                                  this.state.shipment.labelIds.indexOf(
                                    value.id
                                  ) > -1;
                                let style = {};
                                if (value.disabled) {
                                  FormCheckClasses.push("bg-danger");
                                  icon = (
                                    <>
                                      <FontAwesomeIcon icon={faBan} />{" "}
                                    </>
                                  );
                                  style = { pointerEvents: "none" };
                                }
                                let labelText = this.buildLabelString(value);
                                if (icon) {
                                  labelText = icon + labelText;
                                }

                                return (
                                  <WrapCheckbox
                                    key={value.pl_ref}
                                    childKey={value.pl_ref}
                                    disabled={value.disabled}
                                  >
                                    <FormCheck
                                      disabled={value.disabled}
                                      checked={checked}
                                      style={style}
                                      key={value.pl_ref}
                                      id={value.pl_ref}
                                      onChange={(e) =>
                                        this.addRemoveLabel(
                                          e.target.checked,
                                          value.id
                                        )
                                      }
                                      label={labelText}
                                    />
                                  </WrapCheckbox>
                                );
                              })}
                            </Card.Body>
                          )}
                        </div>
                      );
                    })}
                </Card>
              </div>
            </div>
          </Col>
          <Col>
            <Card>
              <Card.Header as="h5">
                Currently On Shipment{" "}
                <Badge variant="primary">{selectedCount}</Badge>
              </Card.Header>
              {labelsOnShipment.length > 0 && (
                <Card.Body>{labelsOnShipment}</Card.Body>
              )}
            </Card>
          </Col>
        </Row>
      </Wrap>
    );
  }
}

const exported = withRouter(App);

export default exported;
