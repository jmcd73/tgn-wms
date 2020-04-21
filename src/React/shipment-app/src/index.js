import React from "react";
import ReactDOM from "react-dom";
import "./index.css";
import App from "./App";
import { Switch } from "react-router";
import { BrowserRouter, Route } from "react-router-dom";
import * as serviceWorker from "./serviceWorker";

const root = document.getElementById("root");

const baseUrl = root.getAttribute("data-baseurl");

ReactDOM.render(
  <BrowserRouter>
    <Switch>
      <Route
        path="/"
        exact
        render={(props) => <App {...props} baseUrl={baseUrl} />}
      />
      <Route
        path="/:operation(edit-shipment|add-shipment)/:productTypeOrId?"
        render={(props) => <App {...props} baseUrl={baseUrl} />}
      />
      <Route
        path={`${baseUrl}shipments/process/:operation(edit-shipment|add-shipment)/:productTypeOrId?`}
        render={(props) => <App {...props} baseUrl={baseUrl} />}
      />
    </Switch>
  </BrowserRouter>,
  root
);

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
serviceWorker.unregister();
