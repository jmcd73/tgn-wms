import actions from "./actions";

const initialState = {
  products: [],
  productDescriptions: {},
  labelLists: {},
  labelCounts: {},
  productType: 0,
  productTypeName: "",
  allPallets: [],
  productTypes: [],
};

export function products(state = initialState, action) {
  switch (action.type) {
    case actions.SET_LABEL_LIST: {
      return {
        ...state,
        labelLists: {
          ...state.labelLists,
          ...action.data,
        },
      };
    }
    case actions.ADD_PRODUCT_TYPE_ID: {
      return {
        ...state,
        productType: action.data,
      };
    }
    case actions.SET_PRODUCTS: {
      return {
        ...state,
        products: action.data,
      };
    }
    case actions.SET_PRODUCT_TYPE_NAME: {
      return {
        ...state,
        productTypeName: action.data,
      };
    }
    case actions.SET_PRODUCT_DESCRIPTIONS: {
      return {
        ...state,
        productDescriptions: action.data,
      };
    }
    case actions.UPDATE_PRODUCT_DESCRIPTIONS: {
      return {
        ...state,
        products: {
          ...state.products,
          ...action.data,
        },
      };
    }
    case actions.UPDATE_ITEM_COUNTS: {
      return {
        ...state,
        labelCounts: {
          ...state.labelCounts,
          ...action.data,
        },
      };
    }

    case actions.ADD_ALL_PALLETS:
      return {
        ...state,
        allPallets: action.data,
      };
    default:
      return state;
  }
}
