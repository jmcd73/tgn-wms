import actions from "./actions";

let initialState = {
  operation: "",
  id: "",
  shipment_type: "",
  shipped: false,
  shipper: "",
  destination: "",
  product_type_id: "",
  labelIds: [],
};

export function shipment(state = initialState, action) {
  switch (action.type) {
    case actions.ADD_OPERATION:
      return {
        ...state,
        operation: action.data,
      };
    case actions.SET_LABEL_IDS:
      return {
        ...state,
        labelIds: action.data,
      };

    case actions.ADD_SHIPMENT_FROM_FETCH: {
      return {
        ...state,
        ...action.data,
      };
    }
    case actions.SET_SHIPMENT_DETAIL:
      const { fieldName, fieldValue } = action.data;
      return Object.assign({}, state, {
        [fieldName]: fieldValue,
      });
    case actions.TOGGLE_SHIPPED: {
      return {
        ...state,
        shipped: !state.shipped,
      };
    }
    default:
      return state;
  }
}
