import React from "react";
/* wrap in div if dev and nothing if production */
const Wrap = (props) => {
	let renderThis = null

	if(process.env.NODE_ENV === 'development') {
		renderThis = ( <div className="container">
							{props.children}
		</div> )
	} else {
		renderThis = (
			<>
				{props.children}
			</>
		);
	}
	return renderThis;
}

export default Wrap;
