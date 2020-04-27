import React from "react";
import ReactDOM from "react-dom";
import Root from "./Root";

it("renders without crashing", () => {
  const div = document.createElement("div", {
    id: "root",
    "data-baseurl": "http://tgn-wms-cakephp4.test/",
  });

  const baseUrl = div.getAttribute("data-baseurl");

  ReactDOM.render(<Root baseUrl={baseUrl} />, div);
  ReactDOM.unmountComponentAtNode(div);
});
