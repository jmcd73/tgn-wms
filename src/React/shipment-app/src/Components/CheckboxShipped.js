import React from "react";
import FormGroup from "react-bootstrap/FormGroup";
import Form from "react-bootstrap/Form";

export default function (props) {
  const { shipped, toggleShipped, getValidationState, shippedError } = props;
  return (
    <FormGroup>
      <Form.Check id="shipped">
        <Form.Check.Input
          type="checkbox"
          checked={shipped}
          onChange={toggleShipped}
          isValid={getValidationState("shipped")}
        />
        <Form.Check.Label>Shipped</Form.Check.Label>
        <Form.Control.Feedback>{shippedError}</Form.Control.Feedback>
      </Form.Check>
    </FormGroup>
  );
}
