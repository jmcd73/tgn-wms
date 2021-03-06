import React from "react";
import Card from "react-bootstrap/Card";
import Badge from "react-bootstrap/Badge";
import CheckboxesAvailable from "./CheckboxesAvailable";
import { connect } from "react-redux";
import * as actionCreators from "../Redux/creators";
import { bindActionCreators } from "redux";

const CardAvailableItems = function (props) {
  const {
    labelCounts,
    products,
    labelIds,
    getLabelList,
    toggleIsExpanded,
    isExpanded,
    labelLists,
    productDescriptions,
  } = props;

  let cardContents = null;

  if (products) {
    cardContents = products.map((productId, idx) => {
      let cardBody = null;
      if (labelLists[productId] && isExpanded[productId]) {
        cardBody = (
          <Card.Body className={isExpanded[productId]}>
            <CheckboxesAvailable
              labelLists={labelLists}
              labelIds={labelIds}
              productId={productId}
            />
          </Card.Body>
        );
      }

      return (
        <div key={`wrap-${idx}`}>
          <Card.Header
            onClick={() => {
              getLabelList(productId);
              toggleIsExpanded(productId);
            }}
            as="h5"
            className="toggen-header"
            key={`header-{idx}`}
          >
            {" "}
            {productDescriptions[productId]}{" "}
            {labelCounts[productId] && (
              <Badge variant="primary">{labelCounts[productId]}</Badge>
            )}
          </Card.Header>
          {cardBody}
        </div>
      );
    });
  }

  return <Card key={`card-top-level`}>{cardContents}</Card>;
};

const mapStateToProps = (state) => {
  const { products: p, ui } = state;
  return {
    isExpanded: ui.isExpanded,
    products: p.products,
    allPallets: p.allPallets,
    labelLists: p.labelLists,
    labelCounts: p.labelCounts,
    productDescriptions: p.productDescriptions,
  };
};

const mapDispatchToProps = (dispatch) => {
  return bindActionCreators(
    {
      getLabelList: actionCreators.getLabelList,
      toggleIsExpanded: actionCreators.toggleIsExpanded,
    },
    dispatch
  );
};

export default connect(mapStateToProps, mapDispatchToProps)(CardAvailableItems);
