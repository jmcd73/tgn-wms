import React from "react";
import Alert from "react-bootstrap/lib/Alert";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
	faCheckCircle,
	faExclamation,
	faInfoCircle,
	faExclamationTriangle
} from "@fortawesome/free-solid-svg-icons";
import './AlertMessage.css';
import { CSSTransition } from "react-transition-group";
const AlertMessage = props => {
	const { bsStyle, strongText, normalText, onDismiss } = props;
	const options = {
		success: { icon: faCheckCircle },
		warning: { icon: faExclamation },
		info: { icon: faInfoCircle },
		danger: { icon: faExclamationTriangle }
	};

	return (
		<CSSTransition
			in={props.show}
			timeout={300}
			classNames="toggen"
			unmountOnExit
		>
			<Alert onDismiss={onDismiss} bsStyle={bsStyle}>
				<strong>
					<FontAwesomeIcon icon={options[bsStyle].icon} /> {strongText}{" "}
				</strong>{" "}
				{normalText}
			</Alert>
		</CSSTransition>
	);
};

export default AlertMessage;
