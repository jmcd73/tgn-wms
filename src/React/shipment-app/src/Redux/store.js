import { createStore, applyMiddleware, compose } from "redux";
import shipmentApp from "./reducers/rootReducer";
import thunkMiddleware from "redux-thunk";
import { createLogger } from "redux-logger";

const loggerMiddleware = createLogger();
const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;

let middleWare = [thunkMiddleware];

if (process.env.NODE_ENV !== "production") {
  middleWare.push(loggerMiddleware);
}

export let store = createStore(
  shipmentApp,
  composeEnhancers(applyMiddleware(...middleWare))
);
