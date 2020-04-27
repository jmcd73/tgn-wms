import actions from "./actions";

const initialState = {
  isExpanded: {},
  options: [],
  redirect: false,
  loading: false,
  errors: {},
  operationName: "",
  isTypeAheadLoading: false,
  baseUrl: "",
};

export function ui(state = initialState, action) {
  switch (action.type) {
    case actions.SET_IS_EXPANDED: {
      return {
        ...state,
        isExpanded: action.data,
      };
    }
    case actions.UPDATE_UI: {
      return {
        ...state,
        ...action.data,
      };
    }
    case actions.UPDATE_ERRORS: {
      return {
        ...state,
        errors: {
          ...state.errors,
          ...action.data,
        },
      };
    }
    case actions.UPDATE_IS_EXPANDED: {
      return {
        ...state,
        isExpanded: {
          ...state.isExpanded,
          ...action.data,
        },
      };
    }
    case actions.SET_TYPEAHEAD_LOADING: {
      return {
        ...state,
        isTypeAheadLoading: action.data,
      };
    }
    case actions.LOAD_OPTIONS: {
      return {
        ...state,
        options: action.data,
      };
    }
    case actions.UPDATE_BASE_URL:
      return {
        ...state,
        baseUrl: action.data,
      };

    case actions.SET_LOADING:
      return {
        ...state,
        loading: action.data,
      };

    case actions.TOGGLE_ALERT:
      return {
        ...state,
        showAlert: !state.showAlert,
      };
    case actions.SHOW_ALERT: {
    }
    case actions.ADD_OPERATION_NAME:
      return {
        ...state,
        operationName: action.data,
      };
    default:
      return state;
  }
}
