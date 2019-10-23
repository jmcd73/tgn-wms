import React from "react";
import "./App.css";
import PanelGroup from "react-bootstrap/lib/PanelGroup";
import Panel from "react-bootstrap/lib/Panel";
import FormControl from "react-bootstrap/lib/FormControl";
import FormGroup from "react-bootstrap/lib/FormGroup";
import ControlLabel from "react-bootstrap/lib/ControlLabel";
import Col from "react-bootstrap/lib/Col";
import Row from "react-bootstrap/lib/Row";
import Checkbox from "react-bootstrap/lib/Checkbox";
import Badge from "react-bootstrap/lib/Badge";
import Button from "react-bootstrap/lib/Button";
import Glyphicon from "react-bootstrap/lib/Glyphicon";
import { withRouter } from "react-router";
import PulseLoader from "react-spinners/PulseLoader";
import HelpBlock from "react-bootstrap/lib/HelpBlock";
import Wrap from "./Wrap";
import WrapCheckbox from "./WrapCheckbox";
import AlertMessage from "./AlertMessage";
import Form from "react-bootstrap/lib/Form";
import "react-bootstrap-typeahead/css/Typeahead.css";

// import queryString from "query-string";

import { AsyncTypeahead } from "react-bootstrap-typeahead"; // ES2015

class App extends React.Component {
	constructor(props) {
		super(props);

		this.defaults = {
			isExpanded: [],
			products: [],
			shipmentTypeDisabled: false,
			labelLists: {},
			loading: false,
			redirect: false,
			labelCounts: {},
			showAlert: false,
			errors: {},
			shipment: {
				operation: "",
				id: "",
				shipment_type: "",
				shipped: false,
				shipper: "",
				destination: "",
				product_type_id: '',
				labelIds: []
			},
			isLoading: false,
			productType: 0,
			productTypeName: '',
			activeKey: 99999,
			loadedData: [],
			options: [],
			productTypes: [],
			baseUrl: this.props.baseUrl
		};
		this.state = {
			...this.defaults
		};

		this.setProductType = this.setProductType.bind(this);
		this.updateActiveKey = this.updateActiveKey.bind(this);
		this.getLabelList = this.getLabelList.bind(this);
		this.addRemoveLabel = this.addRemoveLabel.bind(this);
		this.toggleIsExpanded = this.toggleIsExpanded.bind(this);
		this.buildLabelString = this.buildLabelString.bind(this);
		this.getLabelObject = this.getLabelObject.bind(this);
		this.toggleShipped = this.toggleShipped.bind(this);
		this.toggleAlert = this.toggleAlert.bind(this);
		this.setShipmentDetail = this.setShipmentDetail.bind(this);
		this.submitData = this.submitData.bind(this);
	}

	setShipmentDetail(key, value) {
		this.setState({
			shipment: { ...this.state.shipment, [key]: value }
		});
	}

	updateActiveKey(n) {
		this.setState({ activeKey: n });
	}

	fetchData(operation, productType, id) {
		this.setState({
			...this.defaults,
			loading: true,
			productType: productType || ""

		});

		const suffix = [operation, productType, id].filter(x => x);
		const url = this.state.baseUrl + "Shipments/" + suffix.join("/");

		fetch(url, {
			headers: {
				Accept: "application/json",
				"X-Requested-With": "XMLHttpRequest"
			}
		})
			.then(resp => {
				return resp.json();
			})
			.then(d => {
				const codeDescs = this.createCodeDescriptions(d.shipment_labels);
				console.log(d);
				this.setState({
					loadedData: d.shipment_labels,
					isExpanded: [...codeDescs].fill(false),
					products: codeDescs,
					shipment: { ...this.state.shipment, operation: operation },
					loading: false
				});
				if (d.type) {
					this.setState({
						productType: d.type
					});
				}
				if (d.thisShipment) {
					const {
						shipper,
						destination,
						shipped,
						shipment_type,
						product_type_id,
						id
					} = d.thisShipment.Shipment;
					const { Label } = d.thisShipment;
					const loadedData = Label.map(value => {
						const location = { ...value.Location };
						delete value.Location;
						return {
							Label: value,
							Location: location
						};
					});
					const labelIds = Label.map(value => {
						return value.id;
					});

					this.setState({
						loadedData: loadedData.concat(d.shipment_labels),
						shipmentTypeDisabled: true,
						productType: product_type_id,
						shipment: {
							...this.state.shipment,
							shipment_type,
							shipped,
							id,
							shipper,
							product_type_id,
							destination,
							labelIds
						}
					});
				}
			})
			.catch(e => console.log(e));
	}

	buildCodeDescString(labelObject) {
		return labelObject.Label.item + " " + labelObject.Label.description;
	}
	/**
	 *
	 * @param {*} labelObject
	 */
	updateCodeDescriptions(labelObject) {
		let { products, loadedData } = this.state;

		const codeDesc = this.buildCodeDescString(labelObject);
		const { item_id: itemId } = labelObject.Label;
		this.updateSingleLabelCount(
			codeDesc,
			this.getSingleItemLabelCount(loadedData, itemId)
		);

		if (products.indexOf(codeDesc) === -1) {
			this.setState({
				products: [codeDesc, ...products]
			});
		}
	}

	getSingleItemLabelCount(productArray, itemId) {
		return productArray.filter((value, index) => {
			return value.Label.item_id === itemId;
		}).length;
	}
	updateSingleLabelCount(itemString, count) {
		let labelCounts = { ...this.state.labelCounts };

		this.setState({
			labelCounts: {...labelCounts, [itemString]: count}
		});
	}
	createCodeDescriptions(productArray = []) {
		let ctr = 0;
		let labelCounts = {};

		const codeDesc = productArray.reduce((accum, current) => {
			const codeDesc = this.buildCodeDescString(current);
			if (accum.indexOf(codeDesc) === -1) {
				accum.push(codeDesc);
				ctr = 1;
			}

			labelCounts[codeDesc] = ctr++;

			return accum;
		}, []);
		this.setState({
			labelCounts: { ...this.state.labelCounts, ...labelCounts }
		});
		return codeDesc;
	}
	getLabelList(productTitle) {
		const loadedData = this.state.loadedData;

		const labelList = loadedData.reduce((accum, current, idx) => {
			const codeDesc = current.Label.item + " " + current.Label.description;
			if (codeDesc === productTitle) {
				accum.push(current);
			}
			return accum;
		}, []);
		let currentLabelList = this.state.labelLists;
		let newLabelList = { ...currentLabelList, [productTitle]: labelList };
		this.setState({ labelLists: newLabelList });
	}
	toggleIsExpanded(b, idx) {
		let isExpanded = [...this.state.isExpanded];
		isExpanded[idx] = b;
		this.setState({ isExpanded: isExpanded });
	}

	toggleAlert() {
		const newAlertState = !this.state.showAlert;
		this.setState({ showAlert: newAlertState });
		if (newAlertState) {
			setTimeout(() => {
				this.setState({ showAlert: !newAlertState });
			}, 4000);
		}
	}

	submitData() {
		this.setState({
			errors: {},
			loading: true
		});
		const { baseUrl, productType } = this.state;

		const {
			operation,
			shipper,
			shipped,
			id,
			destination,
			labelIds
		} = this.state.shipment;

		const parts = [operation, id].filter(x => x);

		const url = baseUrl + "Shipments/" + parts.join("/");

		let postObject = {
			Shipment: {
				shipper: shipper,
				destination: destination,
				shipped: shipped,
				product_type_id: productType
			},
			Label: labelIds
		};

		switch (operation) {
			case "add":
				break;
			case "edit":
				postObject.Shipment.id = id;
				const labels = labelIds.map((cur) => {
					return { shipment_id: id, id: cur }
				})
				postObject = { ...postObject, Label: labels }
				console.log('postObject', postObject)
				break;
			default:
				console.log("it broken");
		}

		fetch(url, {
			method: "POST", // *GET, POST, PUT, DELETE, etc.
			mode: "cors", // no-cors, cors, *same-origin
			cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
			credentials: "same-origin", // include, *same-origin, omit
			headers: {
				"Content-Type": "application/json",
				Accept: "application/json",
				"X-Requested-With": "XMLHttpRequest"
			},
			redirect: "error", // manual, *follow, error
			//referrer: "no-referrer", // no-referrer, *client
			body: JSON.stringify(postObject) // body data type must match "Content-Type" header
		})
			.then(response => response.json())
			.then(d => {
				/**
                 *  "error": {
        "shipper": [
            "Shipment number must be unique"
        ]
    },
                 */
				if (d.error) {
					// eslint-disable-next-line array-callback-return
					Object.keys(d.error).map(fieldName => {
						this.setState({
							errors: {
								...this.state.errors,
								[fieldName]: d.error[fieldName].join(", ")
							}
						});
					});
				} else {
					this.setState({
						redirect: true
					});
				}
				this.setState({ loading: false });
			});
	}

	toggleShipped() {
		this.setState({
			shipment: {
				...this.state.shipment,
				shipped: !this.state.shipment.shipped
			}
		});
	}

	addRemoveLabel(isAdd, labelId) {
		let { shipment } = this.state;
		let labelIds = [...shipment.labelIds];

		this.updateCodeDescriptions(this.getLabelObject(labelId)[0]);

		if (isAdd && labelIds.indexOf(labelId) === -1) {
			labelIds.push(labelId);
		}
		if (!isAdd) {
			labelIds = labelIds.filter(value => {
				return value !== labelId;
			});
		}

		this.setState({
			shipment: { ...shipment, labelIds: labelIds }
		});
	}
	setProductType(e) {
		const productType = e.target.value;

		if (productType === "") {
			this.setState({ products: [] });
			return;
		}
		if (this.state.productType !== productType) {
			this.setState({ productType: productType });
			const { operation, id } = this.parseRouterArgs();
			this.fetchData(operation, productType, id);
		}
	}

	parseRouterArgs() {
		// gotta fix this it's ugggggly move it out of here
		let { operation, typeOrId } = this.props.match.params;
		let productType = null;
		let id = null;

		switch (operation) {
			case "add": {
				if (!typeOrId) {
					productType = this.state.productType;
				} else {
					productType = typeOrId;
				}
				break;
			}
			case "edit": {
				if (!isNaN(typeOrId)) {
					console.log("typeOrId isInteger");
					id = typeOrId;
				}
				this.setState({
					shipmentTypeDisabled: true
				});
				break;
			}
			default:
				operation = "add";
				productType = this.state.productType;
		}

		return { operation: operation, productType: productType, id: id };
	}

	getValidationState(fieldName) {
		if (this.state.errors[fieldName] !== undefined) {
			return "error";
		}
		return null;
	}

	componentDidMount() {
		const { operation, productType, id } = this.parseRouterArgs();

		this.setState({
			baseUrl: this.props.baseUrl

		});
		this.fetchData(operation, productType, id);

		this.getProductType(productType);
	}

	getProductType(productType){
		const url = this.state.baseUrl + `ProductTypes/view/${productType}`;
		console.log('pt', productType);
		if(productType) {
			fetch(url, {
				headers: {
					Accept: "application/json",
					"X-Requested-With": "XMLHttpRequest"
				}
			})
				.then(resp => {
					return resp.json();
				})
				.then(d => {

					if(d.productType.ProductType){
						this.setState({
							productTypeName: d.productType.ProductType.name
						})
					}
					console.log('pt', d)})
				.catch(e => {
					throw e
				});
	}
}

	getLabelObject(id) {
		const { loadedData } = this.state;
		const ret = loadedData.filter((current, idx) => {
			return current.Label.id === id;
		});
		return ret;
	}
	buildLabelString(labelObject) {
		const { Location, Label } = labelObject;
		const { location } = Location;
		const { item, best_before, pl_ref, qty, description } = Label;

		const stringValues = [
			location,
			item,
			best_before,
			pl_ref,
			qty,
			description
		];
		return stringValues.join(", ");
	}
	render() {
		const {
			products,
			labelLists,
			showAlert,
			labelCounts,
			isExpanded,
			shipment,
			productTypeName,
			loading,
			errors,
			baseUrl
		} = this.state;

		const shipperError = errors["shipper"] || "";
		const shippedError = errors["shipped"] || "";
		const destinationError = errors["destination"] || "";
		const { labelIds, shipper, shipped, operation } = shipment;
		const selectedCount = labelIds.length;
		let labelsOnShipment = null;
		let classes = ["checkbox", "fixed", "pallet-list"];
		let spinner = null;
		if (loading) {
			spinner = (
				<Row>
					<Col lg={12}>
						<div className="text-center">
							<PulseLoader loading={loading} size={14} color={"#ddd"} />
						</div>
					</Col>
				</Row>
			);
		}

		if (labelIds) {
			labelsOnShipment = labelIds.map((id, idx) => {
				const labelObject = this.getLabelObject(id)[0];
				return (
					<Checkbox
						bsClass={classes.join(" ")}
						key={labelObject.Label.pl_ref}
						checked
						onChange={e =>
							this.addRemoveLabel(e.target.checked, labelObject.Label.id)
						}
					>
						{this.buildLabelString(labelObject)}
					</Checkbox>
				);
			});
		}

		if (this.state.redirect && process.env.NODE_ENV === "production") {
			window.location = baseUrl + "Shipments/";
		}

		return (
			<Wrap>
				<Row>
					<Col lg={12}>
						<AlertMessage
							strongText="bold this"
							normalText="Message that"
							bsStyle="info"
							show={showAlert}
							onDismiss={this.toggleAlert}
						/>

						<h3
							style={{ textTransform: "capitalize" }}
						>{`${operation} ${productTypeName} Shipment`}</h3>
					</Col>
				</Row>
				<Row className="bpad">
					<Col lg={12}>
						<Form onSubmit={e => e.preventDefault()}>
							<Row>
								<Col lg={3}>
									<FormGroup
										validationState={this.getValidationState("shipper")}
										bsSize="sm"
										controlId="shipper"
									>
										<ControlLabel>Shipment</ControlLabel>{" "}
										<FormControl
											type="text"
											value={shipper}
											placeholder="Shipment"
											onChange={e => {
												const { shipper, ...newState } = this.state.errors;
												this.setState({
													errors: {
														...newState
													}
												});

												this.setShipmentDetail(e.target.id, e.target.value);
											}}
											required="required"
										/>
										<FormControl.Feedback />
										<HelpBlock>{shipperError}</HelpBlock>
									</FormGroup>
								</Col>
								<Col lg={3}>
									<FormGroup
										controlId="destination"
										bsSize={"sm"}
										validationState={this.getValidationState("destination")}
									>
										<ControlLabel>Destination</ControlLabel>
										<AsyncTypeahead
											placeholder="Destination"
											isLoading={this.state.isLoading}
											id="destination"
											name="destination"
											selected={[this.state.shipment.destination]}
											onChange={selected => {
												if (selected.length > 0) {
													let destination = selected[0].value;
													this.setShipmentDetail("destination", destination);
												}
											}}
											onInputChange={destination => {
												this.setShipmentDetail("destination", destination);
											}}
											onSearch={query => {
												this.setState({ isLoading: true });
												fetch(
													`${
														this.state.baseUrl
													}Shipments/destinationLookup?term=${query}`,
													{
														headers: {
															Accept: "application/json"
														}
													}
												)
													.then(resp => resp.json())
													.then(json => {
														console.log(json);
														this.setState({
															isLoading: false,
															options: json
														});
													});
											}}
											labelKey="value"
											options={this.state.options}
										/>
										<HelpBlock>{destinationError}</HelpBlock>
									</FormGroup>
								</Col>
								<Col lg={4}>
									<FormGroup
										className="cb-shipped"
										validationState={this.getValidationState("shipped")}
									>
										<Checkbox
											validationState={this.getValidationState("shipped")}
											checked={shipped}
											onChange={this.toggleShipped}
										>
											Shipped
										</Checkbox>
										<HelpBlock>{shippedError}</HelpBlock>
									</FormGroup>
								</Col>
							</Row>
							<Row>
								<Col lg={6}>
									<Button
										bsStyle="primary"
										bsSize="sm"
										className="my-btn"
										onClick={this.submitData}
										type="submit"
									>
										Submit
									</Button>
								</Col>
								<Col lg={6}>{spinner}</Col>
							</Row>
						</Form>
					</Col>
				</Row>

				<Row>
					<Col lg={6}>
						<div className="pre-scrollable">
							<PanelGroup
								id="accordion-controlled-example"
								activeKey={this.state.activeKey}
								onSelect={this.updateActiveKey}
							>
								{products &&
									products.map((product, idx) => {
										return (
											<Panel
												key={`panel-${idx}`}
												eventKey={`panel-${idx}`}
												expanded={isExpanded[idx]}
												onToggle={b => {
													this.toggleIsExpanded(b, idx);
												}}
											>
												<Panel.Heading>
													<Panel.Title
														onClick={() => this.getLabelList(product)}
														toggle
													>
														{product}{" "}
														{labelCounts[product] && (
															<Badge>{labelCounts[product]}</Badge>
														)}
													</Panel.Title>
												</Panel.Heading>
												<Panel.Body collapsible>
													{labelLists[product] &&
														labelLists[product].map((value, idx) => {
															let icon = null;
															let checkboxClasses = classes.slice();
															const checked =
																this.state.shipment.labelIds.indexOf(
																	value.Label.id
																) > -1;
															let style = {};
															if (!!+value.Label.disabled) {
																checkboxClasses.push("bg-danger");
																icon = (
																	<>
																		<Glyphicon glyph="ban-circle" />{" "}
																	</>
																);
																style = { pointerEvents: "none" };
															}
															return (
																<WrapCheckbox
																	key={value.Label.pl_ref}
																	childKey={value.Label.pl_ref}
																	disabled={value.Label.disabled}
																>
																	<Checkbox
																		bsClass={checkboxClasses.join(" ")}
																		disabled={value.Label.disabled}
																		checked={checked}
																		style={style}
																		key={value.Label.pl_ref}
																		onChange={e =>
																			this.addRemoveLabel(
																				e.target.checked,
																				value.Label.id
																			)
																		}
																	>
																		{icon}
																		{this.buildLabelString(value)}
																	</Checkbox>
																</WrapCheckbox>
															);
														})}
												</Panel.Body>
											</Panel>
										);
									})}
							</PanelGroup>
						</div>
					</Col>
					<Col lg={6}>
						<Panel>
							<Panel.Heading>
								<Panel.Title componentClass="h3">
									Currently On Shipment <Badge>{selectedCount}</Badge>
								</Panel.Title>
							</Panel.Heading>
							<Panel.Body>{labelsOnShipment}</Panel.Body>
						</Panel>
					</Col>
				</Row>
			</Wrap>
		);
	}
}

const exported = withRouter(App);

export default exported;
