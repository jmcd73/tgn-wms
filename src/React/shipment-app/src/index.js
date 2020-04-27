import React from "react";
import ReactDOM from "react-dom";

import { Provider } from "react-redux";

import Root from "./Components/Root";

import { Switch } from "react-router";
import { BrowserRouter as Router, Route } from "react-router-dom";
import { store } from "./Redux/store";

const root = document.getElementById("root");

const baseUrl = root.getAttribute("data-baseurl");

ReactDOM.render(<Root baseUrl={baseUrl} />, root);

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
