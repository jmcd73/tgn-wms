import React from "react";
import FormCheck from "react-bootstrap/FormCheck";

export default function (props) {
  const { labelIds, getLabelObject, buildLabelString, addRemoveLabel } = props;
  if (labelIds) {
    return labelIds.map((id, idx) => {
      const palletObject = getLabelObject(id);
      return (
        <FormCheck
          key={palletObject.pl_ref}
          id={`checkbox-{id}`}
          checked
          label={buildLabelString(palletObject)}
          onChange={(e) => addRemoveLabel(e.target.checked, palletObject.id)}
        />
      );
    });
  }
}
