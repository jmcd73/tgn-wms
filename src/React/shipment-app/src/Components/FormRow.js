import React from "react";
import Form from "react-bootstrap/Form";
import FormControl from "react-bootstrap/FormControl";
import FormGroup from "react-bootstrap/FormGroup";
import FormLabel from "react-bootstrap/FormLabel";
import FormText from "react-bootstrap/FormText";
import { AsyncTypeahead } from "react-bootstrap-typeahead"; // ES2015
import Col from "react-bootstrap/Col";

export default function (props) {
  const {
    shipperError,
    shipper,
    getValidationState,
    setShipmentDetail,
    destinationError,
    isTypeAheadLoading,
    getSearchTerm,
    errors,
    shipment,
    setState,
    options,
  } = props;
  const { destination } = shipment;

  return (
    <Form.Row onSubmit={(e) => e.preventDefault()}>
      <Col lg={3}>
        <FormGroup controlId="shipper">
          <FormLabel>Shipment</FormLabel>{" "}
          <FormControl
            type="text"
            value={shipper}
            isValid={getValidationState("shipper")}
            placeholder="Shipment"
            onChange={(e) => {
              const { shipper, ...newState } = errors;
              setState({
                errors: {
                  ...newState,
                },
              });

              setShipmentDetail(e.target.id, e.target.value);
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
            isLoading={isTypeAheadLoading}
            id="destination"
            name="destination"
            isValid={getValidationState("destination")}
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
              setState({ isTypeAheadLoading: true });
              getSearchTerm(query);
            }}
            labelKey="value"
            options={options}
          />
          <FormText>{destinationError}</FormText>
        </FormGroup>
      </Col>
    </Form.Row>
  );
}
