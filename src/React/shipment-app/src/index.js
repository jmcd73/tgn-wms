import React from "react";
import ReactDOM from "react-dom";
import { createStore, applyMiddleware, compose } from "redux";
import { Provider } from "react-redux";
import shipmentApp from "./Redux/reducers";
import thunkMiddleware from "redux-thunk";
import "./index.css";
import App from "./Components/App";
import { Switch } from "react-router";
import { BrowserRouter as Router, Route } from "react-router-dom";
import { createLogger } from "redux-logger";
const root = document.getElementById("root");

const baseUrl = root.getAttribute("data-baseurl");

const loggerMiddleware = createLogger();
const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;

let store = createStore(
  shipmentApp,
  composeEnhancers(
    applyMiddleware(
      thunkMiddleware, // lets us dispatch() functions
      loggerMiddleware // neat middleware that logs actions
    )
  )
);

ReactDOM.render(
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
  </Provider>,
  root
);

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
