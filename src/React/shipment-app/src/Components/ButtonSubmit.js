import React from "react";
import Button from "react-bootstrap/Button";

export default function (props) {
  const { click: submit } = props;
  return (
    <Button
      variant="primary"
      size="sm"
      className="my-btn"
      onClick={() => {
        submit();
      }}
      type="submit"
    >
      Submit
    </Button>
  );
}
