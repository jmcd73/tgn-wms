import React from "react";
import OverlayTrigger from "react-bootstrap/OverlayTrigger";
import Popover from "react-bootstrap/Popover";

const popoverText = (
  <>
    <p>
      This pallet doesn&apos;t have enough days product life left before it
      expires to allow it to ship.
    </p>
    <p>
      You won&apos;t be able to add this pallet to a shipper until you mark it
      as being allowed to ship.
    </p>
    <ol>
      <li>Leave this screen and go to Warehouse => View Stock.</li>
      <li>Find the pallet and click it&apos;s "Edit" link</li>
      <li>If a login screen appears login with your username and password</li>
      <li>Tick the &quot;Ship low dated&quot; checkbox</li>
      <li>click Submit</li>
    </ol>
  </>
);

const CustomPopover = (props) => {
  const { placement } = props;
  console.log(props);

  return (
    <Popover
      {...props}
      id={`popover-positioned-${placement}`}
      title={`Low Dated Stock`}
    >
      {popoverText}
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
        //container={document}
        overlay={<CustomPopover />}
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
