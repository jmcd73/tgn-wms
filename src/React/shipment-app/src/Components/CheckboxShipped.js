import React from "react";
import FormGroup from "react-bootstrap/FormGroup";
import Form from "react-bootstrap/Form";
import { connect } from "react-redux";
import actions from "../Redux/actions";

const CheckboxShipped = function (props) {
  const {
    toggleShipped,
    getValidationState,
    shippedError,
    shipped,
    errors,
  } = props;
  return (
    <FormGroup>
      <Form.Check id="shipped">
        <Form.Check.Input
          type="checkbox"
          checked={shipped}
          onChange={toggleShipped}
          isValid={getValidationState("shipped", errors)}
        />
        <Form.Check.Label>Shipped</Form.Check.Label>
        <Form.Control.Feedback>{shippedError}</Form.Control.Feedback>
      </Form.Check>
    </FormGroup>
  );
};

const mapStateToProps = (state) => {
  const { shipment: s, ui } = state;
  return {
    shipped: s.shipped,
    errors: ui.errors,
  };
};
const mapDispatchToProps = (dispatch) => {
  return {
    toggleShipped: () => {
      dispatch({ type: actions.TOGGLE_SHIPPED });
    },
  };
};
export default connect(mapStateToProps, mapDispatchToProps)(CheckboxShipped);
