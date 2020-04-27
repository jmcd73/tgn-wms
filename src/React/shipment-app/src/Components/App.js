import React from "react";

import Col from "react-bootstrap/Col";
import Row from "react-bootstrap/Row";
import Spinner from "./Spinner";
import { connect } from "react-redux";
import { withRouter } from "react-router";
import Wrap from "./Wrap";
import AlertMessage from "./AlertMessage";
import "react-bootstrap-typeahead/css/Typeahead.css";
import "./ShipApp.css";
import CardOnShipment from "./CardOnShipment";
import CardAvailableItems from "./CardAvailableItems";
import ButtonSubmit from "./ButtonSubmit";
import CheckboxesOnShipments from "./CheckboxesOnShipments";
import fetchApi from "../Utils/fetchFunctions";
import funcs from "../Utils/functions";
import CheckboxShipped from "./CheckboxShipped";
import FormRow from "./FormRow";
import * as actionCreators from "../Redux/creators";
import { bindActionCreators } from "redux";
// import queryString from "query-string";

class App extends React.Component {
  componentDidMount() {
    const { operation, productTypeOrId } = funcs.parseRouterArgs(
      this.props.match.params
    );
    const { baseUrl, fetchData, updateBaseUrl } = this.props;

    updateBaseUrl(baseUrl);

    fetchData(operation, productTypeOrId, baseUrl);
  }

  render() {
    const {
      products,
      productDescriptions,
      labelLists,
      showAlert,
      labelCounts,
      toggleAlert,
      isExpanded,
      productTypeName,
      loading,
      baseUrl,
      redirect,
      operationName,
      options,
      alert,
      errors,
      submitData,
      isTypeAheadLoading,

      labelIds,
    } = this.props;

    if (redirect && process.env.NODE_ENV === "production") {
      window.location = baseUrl + "Shipments/";
    }

    return (
      <Wrap>
        <Row key="row-1">
          <Col lg={12}>
            <AlertMessage content={alert} onDismiss={toggleAlert} />
            <h3>
              {operationName} {productTypeName} Shipment
            </h3>
          </Col>
        </Row>
        <Row key="row-2">
          <Col lg={12} key="row-col-1">
            <FormRow
              options={options}
              getValidationState={funcs.getValidationState}
              isTypeAheadLoading={isTypeAheadLoading}
              formatErrors={funcs.formatErrors}
            ></FormRow>
          </Col>
        </Row>
        <Row key="row-3">
          <Col lg={6}>
            <CheckboxShipped
              toggleShipped={this.toggleShipped}
              getValidationState={funcs.getValidationState}
              shippedError={funcs.formatErrors("shipped", errors)}
            />
          </Col>
          <Col lg={1} className="mb-3">
            <ButtonSubmit click={submitData} showAlert={showAlert} />
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
                  isExpanded={isExpanded}
                  labelCounts={labelCounts}
                  products={products}
                  labelIds={labelIds}
                  productDescriptions={productDescriptions}
                />
              </div>
            </div>
          </Col>
          <Col>
            <CardOnShipment selectedCount={labelIds.length}>
              <CheckboxesOnShipments count={labelIds.length} />
            </CardOnShipment>
          </Col>
        </Row>
      </Wrap>
    );
  }
}

const mapStateToProps = (state) => {
  const { shipment: s, ui, products: p, alert } = state;
  return {
    alert,
    labelIds: s.labelIds,
    labelCounts: p.labelCounts,
    errors: ui.errors,
    products: p.products,
    productDescriptions: p.productDescriptions,
    labelLists: p.labelLists,
    isExpanded: ui.isExpanded,
    productTypeName: p.productTypeName,
    loading: ui.loading,
    options: ui.options,
    redirect: ui.redirect,
    operationName: ui.operationName,
    isTypeAheadLoading: ui.isTypeAheadLoading,
  };
};

const wrapWithDispatch = {
  submitData: fetchApi.submitData,
  fetchData: fetchApi.fetchData,
  toggleAlert: actionCreators.toggleAlert,
  showAlert: actionCreators.showAlert,
  updateBaseUrl: actionCreators.updateBaseUrl,
};

/* const mapDispatchToProps = (dispatch) => {
  return {
    dispatch,
    fetchData: (operation, productTypeOrId, baseUrl) => {
      dispatch(fetchApi.fetchData(operation, productTypeOrId, baseUrl));
    },
    submitData: () => {
      dispatch(fetchApi.submitData());
    },
    toggleAlert: () => {
      dispatch(actionCreators.toggleAlert());
    },
    showAlertFunc: () => {
      dispatch(actionCreators.showAlert("Bold Text", "Normal Text", "warning"));
    },
  };
};
 */

const mapDispatchToProps = (dispatch) => {
  return bindActionCreators(wrapWithDispatch, dispatch);
};
export default connect(mapStateToProps, mapDispatchToProps)(withRouter(App));
