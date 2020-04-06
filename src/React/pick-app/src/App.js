import React, { Component } from "react";
import Alert from "react-bootstrap/lib/Alert";
import ListGroup from "react-bootstrap/lib/ListGroup";
import ListGroupItem from "react-bootstrap/lib/ListGroupItem";
import FormGroup from "react-bootstrap/lib/FormGroup";
import ControlLabel from "react-bootstrap/lib/ControlLabel";
import FormControl from "react-bootstrap/lib/FormControl";
import Checkbox from "react-bootstrap/lib/Checkbox";
import Cookies from "js-cookie";

class App extends Component {
  constructor(props) {
    super(props);

    this.state = {
      allPicked: false,
      selectMessage: "Select a shipper",
      shipments: [],
      shipment: {},
      message: "",
      showAlert: false,
    };
    this.selectOnChange = this.selectOnChange.bind(this);
    this.fetchShipperPallets = this.fetchShipperPallets.bind(this);
    this.handleDismiss = this.handleDismiss.bind(this);
  }

  handleDismiss() {
    this.setState({ showAlert: !this.state.showAlert });
  }

  togglePicked(id, isChecked, pickAll = false) {
    const postPickedEditUrl = this.props.baseUrl + "Pallets/multiEdit/";

    let labels = JSON.parse(JSON.stringify(this.state.shipment.pallets));
    let ids = [];
    let pickedState = {};

    if (pickAll) {
      ids = labels.map((obj, idx) => {
        labels[idx].picked = isChecked;
        return { id: obj.id, picked: isChecked };
      });

      pickedState = { allPicked: isChecked };
    } else {
      ids = labels
        .map((obj, idx) => {
          if (labels[idx].id === id) {
            labels[idx].picked = isChecked;
            return { id: obj.id, picked: isChecked };
          }
          return null;
        })
        .filter((x) => x);

      const allArePicked = labels.every((obj, idx) => {
        return obj.picked;
      });
      pickedState = { allPicked: allArePicked };
    }

    let newState = {
      ...this.state,
      shipment: {
        ...this.state.shipment,
        pallets: [...labels],
      },
      ...pickedState,
    };

    this.setState(newState);

    fetch(postPickedEditUrl, {
      method: "POST",
      mode: "cors",
      credentials: "include",
      headers: {
        "X-CSRF-Token": window.csrfToken,
        Accept: "application/json",
        "Content-Type": "application/json",
        "X-Requested-With": "XMLHttpRequest",
      },
      body: JSON.stringify(ids),
    })
      .then((r) => {
        if (r.ok) {
          return r.json();
        }
        throw new Error(
          "Failed to POST to " +
            postPickedEditUrl +
            ": " +
            r.status +
            " " +
            r.statusText
        );
      })
      .then((d) => {
        this.setState(
          {
            message: d.message,
            messageResult: d.result,
            showAlert: true,
          },
          () => {
            setTimeout(() => {
              this.setState({ showAlert: false });
            }, 3000);
          }
        );
      })
      .catch((e) => {
        this.setState({
          message: e.message || "error updating picked status",
          messageResult: "danger",
          showAlert: true,
        });
      });
  }

  fetchShipperPallets(id) {
    const fetchShipperPalletsUrl = this.props.baseUrl + "Shipments/view/";
    fetch(fetchShipperPalletsUrl + id, {
      method: "GET",
      mode: "cors",
      crendentials: "include",
      headers: {
        Accept: "application/json",
      },
    })
      .then((r) => {
        if (r.ok) {
          return r.json();
        }
        throw new Error("failed to request " + fetchShipperPalletsUrl);
      })
      .then((d) => {
        this.setState({ shipment: d });
        const allArePicked = d.pallets.every((label) => {
          return label.picked;
        });

        this.setState({
          allPicked: allArePicked,
        });
      })
      .catch((e) => {});
  }

  selectOnChange(e) {
    const selectValue = parseInt(e.target.value);
    if (selectValue !== 0) {
      this.fetchShipperPallets(e.target.value);
    } else {
      this.setState({ shipment: {} });
    }
  }
  componentDidMount() {
    const openShipmentsUrl = this.props.baseUrl + "Shipments/openShipments";
    fetch(openShipmentsUrl, {
      method: "GET",
      mode: "cors",
      crendentials: "include",
      headers: {
        Accept: "application/json",
      },
    })
      .then((r) => {
        if (r.ok) {
          return r.json();
        }
        throw new Error(
          "failed to request " +
            openShipmentsUrl +
            " " +
            r.status +
            " " +
            r.statusText
        );
      })
      .then((d) => {
        if (d.shipments.length === 0) {
          this.setState({
            selectMessage: "Reload the page to check for new shippers",
          });
        } else {
          this.setState(d);
        }
      })
      .catch((e) => {
        console.log(e);
        this.setState({
          message: e.message,
          messageResult: "danger",
          showAlert: true,
        });
      });
  }
  render() {
    const { shipments, shipment } = this.state;
    let { pallets } = shipment;
    let palletsCount = 0;
    let palletsPicked = 0;
    const defaultPickedClass = "label-warning";
    let pickedClass = defaultPickedClass;
    let allPicked = false;

    if (pallets) {
      pallets.sort(function (a, b) {
        if (a.location.location < b.location.location) return -1;
        if (a.location.location > b.location.location) return 1;
        return 0;
      });
      palletsCount = pallets.length;
      palletsPicked = pallets.filter((x) => {
        //console.log(x);
        return x.picked === true;
      }).length;

      if (palletsCount === palletsPicked) {
        allPicked = true;
        pickedClass = "label-success";
      }
    }

    return (
      <div className="col">
        <div className="row">
          <div className="col">
            <FormGroup controlId="formControlsSelect">
              <ControlLabel>Select a shipper</ControlLabel>
              <FormControl
                onChange={this.selectOnChange}
                componentClass="select"
                placeholder="select"
              >
                <option key={1} value={0}>
                  {this.state.selectMessage}
                </option>
                {shipments.map((shipper, idx) => {
                  return (
                    <option key={shipper.id} value={shipper.id}>
                      {shipper.shipper} {shipper.destination}
                    </option>
                  );
                })}
              </FormControl>
            </FormGroup>
          </div>
        </div>
        <div className="row">
          <div className="col-lg-12 col-md-12 col-sm-12">
            {this.state.showAlert && (
              <Alert
                onDismiss={this.handleDismiss}
                bsStyle={this.state.messageResult}
              >
                {this.state.message}
              </Alert>
            )}
          </div>
        </div>
        <div className="row">
          <div className="col-lg-12 col-md-12 col-sm-12">
            {pallets && (
              <ListGroup as="ul">
                <ListGroupItem key={0} as="li" active>
                  <h3 className="list-group-item-heading">
                    {shipments.shipper}
                    <span
                      style={{ float: "right" }}
                      className={`label ${pickedClass}`}
                    >
                      {palletsPicked}/{palletsCount}
                    </span>
                  </h3>
                  <p className="list-group-item-text">
                    {shipments.destination}
                  </p>

                  <Checkbox
                    checked={this.state.allPicked}
                    onChange={(e) =>
                      this.togglePicked(null, !this.state.allPicked, true)
                    }
                  >
                    Mark all as picked
                  </Checkbox>
                </ListGroupItem>

                {pallets.map((value, idx) => {
                  const isPicked = value.picked;
                  let isPickedClass = "list-group-item";

                  if (isPicked && !allPicked) {
                    isPickedClass += " list-group-item-info";
                  }
                  if (allPicked) {
                    isPickedClass += " list-group-item-success";
                  }

                  return (
                    <ListGroupItem
                      as="li"
                      className={isPickedClass}
                      key={value.id}
                    >
                      <h4 className="list-group-item-heading">
                        {value.location.location}
                      </h4>
                      <p className="list-group-item-text">{value.pl_ref}</p>
                      <p className="list-group-item-text">
                        {" "}
                        {value.item} {value.description}
                      </p>
                      <Checkbox
                        checked={isPicked}
                        onChange={(e) => {
                          this.togglePicked(value.id, e.target.checked);
                        }}
                      >
                        Picked
                      </Checkbox>
                    </ListGroupItem>
                  );
                })}
              </ListGroup>
            )}
          </div>
        </div>
      </div>
    );
  }
}

export default App;
