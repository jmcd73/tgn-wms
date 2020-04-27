import React from "react";
//import Alert from "react-bootstrap/lib/Alert";
import Alert from "react-bootstrap/Alert";
import "./AlertMessage.css";
import { CSSTransition } from "react-transition-group";
const AlertMessage = (props) => {
  const { onDismiss, content } = props;
  const { alertVariant, alertTextBold, alertText, showAlert } = content;

  return (
    <CSSTransition
      in={showAlert}
      timeout={300}
      classNames="toggen"
      unmountOnExit
    >
      <Alert variant={alertVariant} onClose={onDismiss} dismissible>
        <strong>{alertTextBold} </strong> {alertText}
      </Alert>
    </CSSTransition>
  );
};

export default AlertMessage;
