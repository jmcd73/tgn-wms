import React from "react";
import OverlayTrigger from "react-bootstrap/OverlayTrigger";
import Popover from "react-bootstrap/Popover";

const popoverText = (
  <>
    <p>
      This pallet doesn&apos;t have enough days product life left before it
      expires to allow it to ship.
    </p>
  </>
);

const CustomPopover = (props) => {
  const { placement } = props;

  return (
    <Popover {...props} id={`popover-positioned-${placement}`}>
      <Popover.Title>Low Dated Stock</Popover.Title>
      <Popover.Content>{popoverText}</Popover.Content>
    </Popover>
  );
};
const WrapCheckbox = (props) => {
  const { disabled, children, childKey } = props;
  if (disabled) {
    return (
      <OverlayTrigger
        placement="bottom"
        trigger="click"
        rootClose={true}
        overlay={CustomPopover}
      >
        <span style={{ padding: 0, margin: 0 }} key={childKey}>
          {children}
        </span>
      </OverlayTrigger>
    );
  } else {
    return children;
  }
};

export default WrapCheckbox;
