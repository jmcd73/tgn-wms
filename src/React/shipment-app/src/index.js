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
  <BrowserRouter key={`br-1`}>
    <Switch key={`sw-1`}>
      <Route
        key={`route-1`}
        path="/"
        exact
        render={(props) => <App {...props} key={`app-1`} baseUrl={baseUrl} />}
      />
      <Route
        key={`route-2`}
        path="/:operation(edit-shipment|add-shipment)/:productTypeOrId?"
        render={(props) => <App {...props} key={`app-2`} baseUrl={baseUrl} />}
      />
      <Route
        key={`route-3`}
        path={`${baseUrl}shipments/process/:operation(edit-shipment|add-shipment)/:productTypeOrId?`}
        render={(props) => <App {...props} key={`app-3`} baseUrl={baseUrl} />}
      />
    </Switch>
  </BrowserRouter>,
  root
);

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
serviceWorker.unregister();
