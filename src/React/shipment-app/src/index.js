import React from "react";
import ReactDOM from "react-dom";
import Root from "./Components/Root";

const root = document.getElementById("root");

if(process.env.NODE_ENV === 'development'){
    root.setAttribute('data-baseurl', 'http://localhost:8051/');
}

const baseUrl = root.getAttribute("data-baseurl");

ReactDOM.render(<Root baseUrl={baseUrl} />, root);

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
