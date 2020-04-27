import React from "react";
import Form from "react-bootstrap/Form";
import FormControl from "react-bootstrap/FormControl";
import FormGroup from "react-bootstrap/FormGroup";
import FormLabel from "react-bootstrap/FormLabel";
import FormText from "react-bootstrap/FormText";
import { AsyncTypeahead } from "react-bootstrap-typeahead"; // ES2015
import Col from "react-bootstrap/Col";
import { connect } from "react-redux";
import funcs from "../Utils/functions";
import fetchAPI from "../Utils/fetchFunctions";
import { bindActionCreators } from "redux";
import * as actionCreators from "../Redux/creators";

const FormRow = function (props) {
  const {
    formatErrors,
    setShipmentDetail,
    isTypeAheadLoading,
    getSearchTerm,
    errors,
    options,
    destination,
    submitOnEnter,
    shipper,
  } = props;

  return (
    <Form.Row onSubmit={(e) => e.preventDefault()}>
      <Col lg={3}>
        <FormGroup controlId="shipper">
          <FormLabel>Shipment</FormLabel>{" "}
          <FormControl
            type="text"
            value={shipper}
            onKeyDown={(event) => {
              if (event.key === "Enter") {
                submitOnEnter();
              }
            }}
            isValid={funcs.getValidationState("shipper", errors)}
            placeholder="Shipment"
            onChange={(e) => {
              /*   const { shipper, ...newState } = errors;
              setState({
                errors: {
                  ...newState,
                },
              }); */

              setShipmentDetail(e.target.id, e.target.value);
            }}
            required="required"
          />
          <FormControl.Feedback />
          <FormText>{formatErrors("shipper", errors)}</FormText>
        </FormGroup>
      </Col>
      <Col lg={3} key="row-col-2">
        <FormGroup controlId="destination">
          <FormLabel>Destination</FormLabel>
          <AsyncTypeahead
            minLength={1}
            placeholder="Destination"
            isLoading={isTypeAheadLoading}
            id="destination"
            isValid={funcs.getValidationState("destination", errors)}
            selected={[destination]}
            onChange={(selected) => {
              if (selected.length > 0) {
                let destination = selected[0].value;
                setShipmentDetail("destination", destination);
              }
            }}
            onInputChange={(destination) => {
              setShipmentDetail("destination", destination);
            }}
            onSearch={(query) => {
              getSearchTerm(query);
            }}
            labelKey="value"
            options={options}
            onKeyDown={(event) => {
              if (event.key === "Enter") {
                submitOnEnter();
              }
            }}
          />
          <FormText>{formatErrors("destination", errors)}</FormText>
        </FormGroup>
      </Col>
    </Form.Row>
  );
};

const mapStateToProps = (state) => {
  const { ui, shipment: s } = state;

  return {
    isTypeAheadLoading: ui.isTypeAheadLoading,
    baseUrl: ui.baseUrl,
    errors: ui.errors,
    options: ui.options,
    shipper: s.shipper,
    destination: s.destination,
    shipped: s.shipped,
  };
};

const mapDispatchToProps = (dispatch) => {
  return bindActionCreators(
    {
      setTypeaheadLoadingState: actionCreators.setTypeAheadLoading,
      getSearchTerm: fetchAPI.getSearchTerm,
      setShipmentDetail: actionCreators.setShipmentDetail,
      submitOnEnter: fetchAPI.submitData,
    },
    dispatch
  );
};

export default connect(mapStateToProps, mapDispatchToProps)(FormRow);
