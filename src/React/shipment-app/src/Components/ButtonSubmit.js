import React from "react";
import Button from "react-bootstrap/Button";

export default function (props) {
  const { click } = props;
  return (
    <Button
      variant="primary"
      size="sm"
      className="my-btn"
      onClick={click}
      type="submit"
    >
      Submit
    </Button>
  );
}
