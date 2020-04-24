import React from "react";

import Col from "react-bootstrap/Col";
import Row from "react-bootstrap/Row";
import async from "../Utils/fetchFunctions";
import Spinner from "./Spinner";

import { withRouter } from "react-router";

import Wrap from "./Wrap";

import AlertMessage from "./AlertMessage";

import "react-bootstrap-typeahead/css/Typeahead.css";
import "./ShipApp.css";
import CardOnShipment from "./CardOnShipment";
import CardAvailableItems from "./CardAvailableItems";
import ButtonSubmit from "./ButtonSubmit";
import CheckboxesOnShipments from "./CheckboxesOnShipments";
import defaultState from "../Utils/defaultState";
import funcs from "../Utils/functions";
import CheckboxShipped from "./CheckboxShipped";
import FormRow from "./FormRow";
// import queryString from "query-string";

class App extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      ...defaultState,
      baseUrl: this.props.baseUrl,
    };

    // bind all function to "this"
    Object.keys(funcs).forEach((value) => {
      this[value] = funcs[value].bind(this);
    });

    Object.keys(async).forEach((value) => {
      this[value] = async[value].bind(this);
    });
  }

  componentDidMount() {
    const { operation, productTypeOrId } = this.parseRouterArgs();
    this.setState({
      baseUrl: this.props.baseUrl,
    });
    this.fetchData(operation, productTypeOrId);
  }

  render() {
    const {
      newProducts,
      newProductDescriptions,
      labelLists,
      showAlert,
      labelCounts,
      newIsExpanded,
      shipment,
      productTypeName,
      loading,
      baseUrl,
      redirect,
      operationName,
      options,
      alertText,
      errors,
      isTypeAheadLoading,
      alertTextBold,
      alertVariant,
    } = this.state;

    const shipperError = this.formatErrors("shipper");
    const shippedError = this.formatErrors("shipped");
    const destinationError = this.formatErrors("destination");
    const { labelIds, shipper, shipped } = shipment;
    const selectedCount = labelIds.length;

    if (redirect && process.env.NODE_ENV === "production") {
      window.location = baseUrl + "Shipments/";
    }

    return (
      <Wrap>
        <Row key="row-1">
          <Col lg={12}>
            <AlertMessage
              strongText={alertTextBold}
              normalText={alertText}
              variant={alertVariant}
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
            <FormRow
              shipperError={shipperError}
              shipper={shipper}
              setState={(o) => this.setState(o)}
              getSearchTerm={this.getSearchTerm}
              getValidationState={this.getValidationState}
              setShipmentDetail={this.setShipmentDetail}
              destinationError={destinationError}
              isTypeAheadLoading={isTypeAheadLoading}
              shipment={shipment}
              options={options}
              errors={errors}
            ></FormRow>
          </Col>
        </Row>
        <Row key="row-3">
          <Col lg={6}>
            <CheckboxShipped
              shipped={shipped}
              toggleShipped={this.toggleShipped}
              getValidationState={this.getValidationState}
              shippedError={shippedError}
            />
          </Col>
          <Col lg={1} className="mb-3">
            <ButtonSubmit click={this.submitData} />
          </Col>
          <Col lg={5}>
            <Spinner loading={loading} />
          </Col>
        </Row>
        <Row key="row-4">
          <Col>
            <div className="pre-scrollable">
              <div className="card-container">
                <CardAvailableItems
                  labelLists={labelLists}
                  newIsExpanded={newIsExpanded}
                  labelCounts={labelCounts}
                  newProducts={newProducts}
                  labelIds={labelIds}
                  getLabelList={this.getLabelList}
                  toggleIsExpanded={this.toggleIsExpanded}
                  addRemoveLabel={this.addRemoveLabel}
                  newProductDescriptions={newProductDescriptions}
                  buildLabelString={this.buildLabelString}
                />
              </div>
            </div>
          </Col>
          <Col>
            <CardOnShipment selectedCount={selectedCount}>
              <CheckboxesOnShipments
                getLabelObject={this.getLabelObject}
                buildLabelString={this.buildLabelString}
                addRemoveLabel={this.addRemoveLabel}
                labelIds={labelIds}
              />
            </CardOnShipment>
          </Col>
        </Row>
      </Wrap>
    );
  }
}

const exported = withRouter(App);

export default exported;
