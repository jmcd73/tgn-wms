import React from "react";
//import Alert from "react-bootstrap/lib/Alert";
import Alert from "react-bootstrap/Alert";
import "./AlertMessage.css";
import { CSSTransition } from "react-transition-group";
const AlertMessage = (props) => {
  const { variant, strongText, normalText, onDismiss } = props;

  return (
    <CSSTransition
      in={props.show}
      timeout={300}
      classNames="toggen"
      unmountOnExit
    >
      <Alert variant={variant} onClose={onDismiss} dismissible>
        <strong>{strongText} </strong> {normalText}
      </Alert>
    </CSSTransition>
  );
};

export default AlertMessage;
