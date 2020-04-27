import React from "react";
import ReactDOM from "react-dom";

import { Provider } from "react-redux";
import App from "./App";
import { Switch } from "react-router";
import { BrowserRouter as Router, Route } from "react-router-dom";
import { store } from "../Redux/store";

export const Root = (props) => {
  const { baseUrl } = props;
  return (
    <Provider store={store}>
      <Router>
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
      </Router>
    </Provider>
  );
};

export default Root;
