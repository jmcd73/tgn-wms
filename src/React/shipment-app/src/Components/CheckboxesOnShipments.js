import React from "react";
import FormCheck from "react-bootstrap/FormCheck";
import { connect } from "react-redux";
import funcs from "../Utils/functions";
import * as actionCreators from "../Redux/creators";

const CheckboxesOnShipments = function (props) {
  const { labelIds, allPallets, addRemoveLabel } = props;

  if (labelIds) {
    return labelIds.map((id) => {
      const palletObject = funcs.getLabelObject(id, allPallets);
      return (
        <FormCheck
          key={palletObject.pl_ref}
          id={`checkbox-{id}`}
          checked
          label={funcs.buildLabelString(palletObject)}
          onChange={(e) => addRemoveLabel(e.target.checked, palletObject.id)}
        />
      );
    });
  }
  return null;
};

const mapStateToProps = (state) => {
  const { shipment: s, products: p } = state;
  return {
    labelIds: s.labelIds,
    allPallets: p.allPallets,
  };
};

const mapDispatchToProps = (dispatch) => {
  return {
    addRemoveLabel: (isAdd, labelId, labelIds) => {
      dispatch(actionCreators.addRemoveLabel(isAdd, labelId));
    },
  };
};

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(CheckboxesOnShipments);
