import React from "react";
import Card from "react-bootstrap/Card";
import Badge from "react-bootstrap/Badge";

export default function CardOnShipment(props) {
  const { selectedCount, children } = props;

  return (
    <Card>
      <Card.Header as="h5">
        Currently On Shipment <Badge variant="primary">{selectedCount}</Badge>
      </Card.Header>
      <Card.Body>{children}</Card.Body>
    </Card>
  );
}
