import { combineReducers } from "redux";
import { shipment } from "./shipment";
import { alert } from "./alert";
import { products } from "./products";
import { ui } from "./ui";

const shipmentApp = combineReducers({
  shipment,
  alert,
  products,
  ui,
});

export default shipmentApp;
