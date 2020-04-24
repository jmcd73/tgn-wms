import React from "react";
import Card from "react-bootstrap/Card";
import Badge from "react-bootstrap/Badge";
import Form from "react-bootstrap/Form";
import { faBan } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import WrapCheckbox from "./WrapCheckbox";

export default function CardAvailableItems(props) {
  const {
    labelCounts,
    newProducts,
    labelIds,
    getLabelList,
    toggleIsExpanded,
    newIsExpanded,
    labelLists,
    addRemoveLabel,
    newProductDescriptions,
    buildLabelString,
  } = props;

  let classes = ["FormCheck", "fixed", "pallet-list"];
  let cardContents = null;
  if (newProducts) {
    cardContents = newProducts.map((productId, idx) => {
      return (
        <div key={`wrap-${idx}`}>
          <Card.Header
            onClick={() => {
              getLabelList(productId);
              toggleIsExpanded(productId, idx);
            }}
            as="h5"
            className="toggen-header"
            key={`header-{idx}`}
          >
            {" "}
            {newProductDescriptions[productId]}{" "}
            {labelCounts[productId] && (
              <Badge variant="primary">{labelCounts[productId]}</Badge>
            )}
          </Card.Header>
          {labelLists[productId] && newIsExpanded[productId] && (
            <Card.Body className={newIsExpanded[productId]}>
              {labelLists[productId].map((value, idx) => {
                let icon = null;
                let formCheckClasses = classes.slice();
                const checked = labelIds.indexOf(value.id) > -1;
                let style = {};
                if (value.disabled) {
                  formCheckClasses.push("bg-danger");
                  icon = (
                    <>
                      <FontAwesomeIcon icon={faBan} />{" "}
                    </>
                  );
                  style = { pointerEvents: "none" };
                }
                let labelText = buildLabelString(value);

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
                        onChange={(e) =>
                          addRemoveLabel(e.target.checked, value.id)
                        }
                      />
                      <Form.Check.Label>
                        {icon} {labelText}
                      </Form.Check.Label>
                    </Form.Check>
                  </WrapCheckbox>
                );
              })}
            </Card.Body>
          )}
        </div>
      );
    });
  }

  return <Card key={`card-top-level`}>{cardContents}</Card>;
}
