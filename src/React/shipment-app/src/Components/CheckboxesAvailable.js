import React from "react";
import Form from "react-bootstrap/Form";
import { faBan } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import WrapCheckbox from "./WrapCheckbox";
import { connect } from "react-redux";
import funcs from "../Utils/functions";
import * as actionCreators from "../Redux/creators";

const CheckboxesAvailable = function (props) {
  const { labelLists, productId, labelIds, addRemoveLabel } = props;

  return labelLists[productId].map((value, idx) => {
    let icon = null;

    const checked = labelIds.indexOf(value.id) > -1;
    let style = {};
    if (value.disabled) {
      icon = <FontAwesomeIcon icon={faBan} />;
      style = { pointerEvents: "none" };
    }
    let labelText = funcs.buildLabelString(value);

    return (
      <WrapCheckbox
        key={value.pl_ref}
        childKey={value.pl_ref}
        disabled={value.disabled}
      >
        <Form.Check
          disabled={value.disabled}
          style={style}
          key={value.pl_ref}
          id={value.pl_ref}
        >
          <Form.Check.Input
            checked={checked}
            isInvalid={value.disabled}
            type={"checkbox"}
            onChange={(e) => addRemoveLabel(e.target.checked, value.id)}
          />
          <Form.Check.Label>
            {icon} {labelText}
          </Form.Check.Label>
        </Form.Check>
      </WrapCheckbox>
    );
  });
};

const mapDispatchToProps = (dispatch) => {
  return {
    addRemoveLabel: (isAdd, labelId) => {
      dispatch(actionCreators.addRemoveLabel(isAdd, labelId));
    },
  };
};

export default connect(null, mapDispatchToProps)(CheckboxesAvailable);
