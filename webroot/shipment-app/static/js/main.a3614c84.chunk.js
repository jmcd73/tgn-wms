(this["webpackJsonpshipment-app"]=this["webpackJsonpshipment-app"]||[]).push([[0],{109:function(e,t,a){},111:function(e,t,a){},139:function(e,t,a){"use strict";a.r(t);var n=a(0),r=a.n(n),i=a(13),c=a.n(i),o=a(16),l=a(71),s=a(72),d=a(88),u=a(89),p=a(15),m=a(30),h=a(73),b=a.n(h),f=function(e){var t=e.loading;return t?r.a.createElement(m.a,null,r.a.createElement(p.a,{lg:12},r.a.createElement("div",{className:"text-center"},r.a.createElement(b.a,{loading:t,size:14,color:"#ddd"})))):r.a.createElement(r.a.Fragment,null)},E=a(20),g=function(e){return r.a.createElement(r.a.Fragment,null,e.children)},y=a(87),O=(a(109),a(146)),T=function(e){var t=e.onDismiss,a=e.content,n=a.alertVariant,i=a.alertTextBold,c=a.alertText,o=a.showAlert;return r.a.createElement(O.a,{in:o,timeout:300,classNames:"toggen",unmountOnExit:!0},r.a.createElement(y.a,{variant:n,onClose:t,dismissible:!0},r.a.createElement("strong",null,i," ")," ",c))},v=(a(110),a(111),a(27)),_=a(49);function D(e){var t=e.selectedCount,a=e.children;return r.a.createElement(v.a,null,r.a.createElement(v.a.Header,{as:"h5"},"Currently On Shipment ",r.a.createElement(_.a,{variant:"primary"},t)),r.a.createElement(v.a.Body,null,a))}var j=a(9),S=a(23),L=a(76),A=a(75),I=a(85),C=a(52),k=r.a.createElement(r.a.Fragment,null,r.a.createElement("p",null,"This pallet doesn't have enough days product life left before it expires to allow it to ship.")),P=function(e){var t=e.placement;return r.a.createElement(C.a,Object.assign({},e,{id:"popover-positioned-".concat(t)}),r.a.createElement(C.a.Title,null,"Low Dated Stock"),r.a.createElement(C.a.Content,null,k))},w=function(e){var t=e.disabled,a=e.children,n=e.childKey;return t?r.a.createElement(I.a,{placement:"bottom",trigger:"click",rootClose:!0,overlay:P},r.a.createElement("span",{key:n},a)):a},R=a(21),x="ADD_ALL_PALLETS",N="ADD_OPERATION_NAME",U="ADD_OPERATION",V="ADD_PRODUCT_TYPE_ID",H="HIDE_ALERT",B="LOAD_OPTIONS",M="SET_IS_EXPANDED",X="SET_LABEL_IDS",F="SET_LABEL_LIST",q="SET_LOADING",G="SET_PRODUCT_DESCRIPTIONS",K="SET_PRODUCT_TYPE_NAME",Y="SET_PRODUCTS",W="SET_TYPEAHEAD_LOADING",J="SHOW_ALERT",z="TOGGLE_ALERT",Q="UPDATE_BASE_URL",Z="SET_SHIPMENT_DETAIL",$="TOGGLE_SHIPPED",ee="UPDATE_IS_EXPANDED",te="UPDATE_ITEM_COUNTS",ae="UPDATE_PRODUCTS",ne="UPDATE_PRODUCT_DESCRIPTIONS",re="UPDATE_CODE_DESCRIPTIONS",ie="UPDATE_UI",ce="SUBMIT_START",oe="UPDATE_ERRORS",le="ADD_SHIPMENT_FROM_FETCH",se="FETCH_PRODUCT_TYPE_START",de=function(e){return{type:W,data:e}},ue=function(e,t){return{type:Z,data:{fieldName:e,fieldValue:t}}},pe=function(e){return{type:X,data:e}},me=function(e,t){return function(a,n){var r=n().shipment.labelIds;r=fe.addRemoveLabel(e,t,r),a(pe(r)),a(fe.updateCodeDescriptions(t))}},he=function(e){return{type:te,data:e}},be={loadProductsAndDescriptions:function(e){var t=[],a={},n={};e.forEach((function(r){-1===t.indexOf(r.item_id)&&(t.push(r.item_id),a[r.item_id]=r.code_desc,n=Object(j.a)({},n,{},be.updateSingleItemLabelCount(e,r.item_id)))}));var r=t.reduce((function(e,t,a){return e[t]=!1,e}),{});return{products:t,productDescriptions:a,isExpanded:r,itemCounts:n}},updateCodeDescriptions:function(e){return function(t,a){t({type:re});var n,r,i=a().products,c=i.products,o=i.allPallets,l=o.filter((function(t){return parseInt(t.id)===parseInt(e)}))[0],s=l.item_id,d=l.code_desc;t(he(be.updateSingleItemLabelCount(o,s))),-1===c.indexOf(s)&&(t((r=Object(R.a)({},s,!1),{type:ee,data:r})),t(function(e){return{type:ae,data:e}}(s)),t((n=Object(R.a)({},s,d),{type:ne,data:n})))}},updateSingleItemLabelCount:function(e,t){var a=e.filter((function(e,a){return e.item_id===t})).length;return Object(R.a)({},t,a)},getLabelList:function(e,t){var a=t.reduce((function(t,a,n){return a.item_id===e&&t.push(a),t}),[]);return Object(R.a)({},e,a)},toggleIsExpanded:function(e,t){return Object.keys(t).forEach((function(a){parseInt(a)===parseInt(e)?t[a]=!t[a]:t[a]=!1})),t},addRemoveLabel:function(e,t,a){return e&&-1===a.indexOf(t)&&a.push(t),e||(a=a.filter((function(e){return e!==t}))),a},parseRouterArgs:function(e){return{operation:e.operation,productTypeOrId:e.productTypeOrId}},getValidationState:function(e,t){return void 0!==t[e]},formatErrors:function(e,t){var a=[];if(t[e]){var n=t[e];a=Object.keys(n).map((function(e){return n[e]}))}return a.join(", ")},getLabelObject:function(e,t){return t.filter((function(t,a){return t.id===e}))[0]},buildLabelString:function(e){var t=e.location,a=e.item,n=e.bb_date,r=e.pl_ref,i=e.qty,c=e.description;return[t.location,a,new Date(n).toLocaleDateString(),r,i,c].join(", ")}},fe=be,Ee=Object(o.b)((function(e){return Object(j.a)({},e)}),(function(e){return{addRemoveLabel:function(t,a){e(me(t,a))}}}))((function(e){var t=e.labelLists,a=e.productId,n=e.labelIds,i=e.addRemoveLabel;return t[a].map((function(e,t){var a=null,c=n.indexOf(e.id)>-1,o={};e.disabled&&(a=r.a.createElement(A.a,{icon:L.a}),o={pointerEvents:"none"});var l=fe.buildLabelString(e);return r.a.createElement(w,{key:e.pl_ref,childKey:e.pl_ref,disabled:e.disabled},r.a.createElement(S.a.Check,{disabled:e.disabled,style:o,key:e.pl_ref,id:e.pl_ref},r.a.createElement(S.a.Check.Input,{checked:c,isInvalid:e.disabled,type:"checkbox",onChange:function(t){return i(t.target.checked,e.id)}}),r.a.createElement(S.a.Check.Label,null,a," ",l)))}))})),ge=Object(o.b)((function(e){var t=e.products;return{isExpanded:e.ui.isExpanded,products:t.products,allPallets:t.allPallets,labelLists:t.labelLists,labelCounts:t.labelCounts,productDescriptions:t.productDescriptions}}),(function(e){return{getLabelList:function(t,a){return e({type:F,data:fe.getLabelList(t,a)})},toggleIsExpanded:function(t,a){e({type:M,data:fe.toggleIsExpanded(t,a)})}}}))((function(e){var t=e.labelCounts,a=e.products,n=e.labelIds,i=e.getLabelList,c=e.toggleIsExpanded,o=e.isExpanded,l=e.labelLists,s=e.productDescriptions,d=e.allPallets,u=null;return a&&(u=a.map((function(e,a){var u=null;return l[e]&&o[e]&&(u=r.a.createElement(v.a.Body,{className:o[e]},r.a.createElement(Ee,{labelLists:l,labelIds:n,productId:e}))),r.a.createElement("div",{key:"wrap-".concat(a)},r.a.createElement(v.a.Header,{onClick:function(){i(e,d),c(e,o)},as:"h5",className:"toggen-header",key:"header-{idx}"}," ",s[e]," ",t[e]&&r.a.createElement(_.a,{variant:"primary"},t[e])),u)}))),r.a.createElement(v.a,{key:"card-top-level"},u)})),ye=a(77),Oe=function(e){var t=e.click;return r.a.createElement(ye.a,{variant:"primary",size:"sm",className:"my-btn",onClick:function(){t()},type:"submit"},"Submit")},Te=a(26),ve=Object(o.b)((function(e){var t=e.shipment,a=e.products;return{labelIds:t.labelIds,allPallets:a.allPallets}}),(function(e){return{addRemoveLabel:function(t,a,n){e(me(t,a))}}}))((function(e){var t=e.labelIds,a=e.allPallets,n=e.addRemoveLabel;return t?t.map((function(e){var t=fe.getLabelObject(e,a);return r.a.createElement(Te.a,{key:t.pl_ref,id:"checkbox-{id}",checked:!0,label:fe.buildLabelString(t),onChange:function(e){return n(e.target.checked,t.id)}})})):null})),_e={fetchData:function(e,t,a){return function(n){n({type:q});var r=[e,t].filter((function(e){return e})),i="".concat(a,"Shipments/")+r.join("/");return fetch(i,{headers:{Accept:"application/json","X-Requested-With":"XMLHttpRequest"}}).then((function(e){return e.json()})).then((function(r){var i,c=[],o="",l=t;switch(n({type:U,data:e}),e){case"add-shipment":o="Add",c=r.shipment_labels,n({type:N,data:o}),n({type:V,data:l}),n({type:x,data:c});break;case"edit-shipment":o="Edit";var s=r.shipment.pallets;c=s.concat(r.shipment_labels),n(function(e){return{type:N,data:e}}(o)),n(function(e){return{type:x,data:e}}(c));var d=s.map((function(e){return e.id}));l=r.shipment.product_type_id,n(function(e){return{type:V,data:e}}(l)),n((i=r.shipment,{type:le,data:i})),n(pe(d))}n(_e.fetchProductType(l,a));var u=fe.loadProductsAndDescriptions(c),p=u.products,m=u.productDescriptions,h=u.isExpanded,b=u.itemCounts;n(he(b)),n(function(e){return{type:Y,data:e}}(p)),n(function(e){return{type:G,data:e}}(m)),n(function(e){return{type:M,data:e}}(h)),n({type:q,data:!1})})).catch((function(e){return console.log(e)}))}},submitData:function(){return function(e,t){e({type:ie,data:{errors:{},loading:!0}});var a=t(),n=a.products,r=a.ui,i=a.shipment,c=i.operation,o=i.shipper,l=i.shipped,s=i.id,d=i.destination,u=i.labelIds,p=r.baseUrl,m=n.productType,h={shipper:o,destination:d,shipped:l,product_type_id:m,pallets:u},b="";switch(c){case"add-shipment":b=m;break;case"edit-shipment":b=s,h.id=s;var f=u.map((function(e){return{shipment_id:s,id:e}}));h=Object(j.a)({},h,{pallets:f});break;default:console.log("it broken")}var E=p+"Shipments/"+[c,b].filter((function(e){return e})).join("/"),g={method:"POST",mode:"cors",cache:"no-cache",credentials:"same-origin",headers:{"X-CSRF-Token":window.csrfToken,"Content-Type":"application/json",Accept:"application/json","X-Requested-With":"XMLHttpRequest"},redirect:"error",body:JSON.stringify(h)};return e({type:ce}),fetch(E,g).then((function(e){return e.json()})).then((function(t){var a=!0,n=t.error||{};Object.keys(n).length>0&&(n.pallets&&function e(t,a){for(var n in t)a.apply(this,[n,t[n]]),null!==t[n]&&"object"==typeof t[n]&&e(t[n],a)}(n=n.pallets,(function(e,t){"shipped"===e&&(n=Object(R.a)({},e,t))})),Object.keys(n).forEach((function(t){var a;e((a=Object(R.a)({},t,n[t]),{type:oe,data:a}))})),a=!1),e({type:ie,data:{loading:!1,redirect:a}})}))}},fetchProductType:function(e,t){return function(a){var n="".concat(t,"ProductTypes/view/").concat(e);if(e)return a({type:se}),fetch(n,{headers:{Accept:"application/json","X-Requested-With":"XMLHttpRequest"}}).then((function(e){return e.json()})).then((function(e){var t;e.productType&&a((t=e.productType.name,{type:K,data:t}))})).catch((function(e){throw e}))}},getSearchTerm:function(e){return function(t,a){t(de(!0)),t({type:"START_FETCH_TYPEAHEAD"});var n=a().ui.baseUrl;return fetch("".concat(n,"Shipments/destinationLookup?term=").concat(e),{headers:{Accept:"application/json"}}).then((function(e){return e.json()})).then((function(e){t(de(!1)),t({type:B,data:e})}))}}},De=_e,je=a(29),Se=Object(o.b)((function(e){var t=e.shipment,a=e.ui;return{shipped:t.shipped,errors:a.errors}}),(function(e){return{toggleShipped:function(){e({type:$})}}}))((function(e){var t=e.toggleShipped,a=e.getValidationState,n=e.shippedError,i=e.shipped,c=e.errors;return r.a.createElement(je.a,null,r.a.createElement(S.a.Check,{id:"shipped"},r.a.createElement(S.a.Check.Input,{type:"checkbox",checked:i,onChange:t,isValid:a("shipped",c)}),r.a.createElement(S.a.Check.Label,null,"Shipped"),r.a.createElement(S.a.Control.Feedback,null,n)))})),Le=a(41),Ae=a(42),Ie=a(43),Ce=a(86),ke=a(19),Pe=Object(o.b)((function(e){var t=e.ui,a=e.shipment;return{isTypeAheadLoading:t.isTypeAheadLoading,baseUrl:t.baseUrl,errors:t.errors,options:t.options,shipper:a.shipper,destination:a.destination,shipped:a.shipped}}),(function(e){return Object(ke.b)({setTypeaheadLoadingState:de,getSearchTerm:De.getSearchTerm,setShipmentDetail:ue,submitOnEnter:De.submitData},e)}))((function(e){var t=e.formatErrors,a=e.setShipmentDetail,n=e.isTypeAheadLoading,i=e.getSearchTerm,c=e.errors,o=e.options,l=e.destination,s=e.submitOnEnter,d=e.shipper;return r.a.createElement(S.a.Row,{onSubmit:function(e){return e.preventDefault()}},r.a.createElement(p.a,{lg:3},r.a.createElement(je.a,{controlId:"shipper"},r.a.createElement(Ae.a,null,"Shipment")," ",r.a.createElement(Le.a,{type:"text",value:d,onKeyDown:function(e){"Enter"===e.key&&s()},isValid:fe.getValidationState("shipper",c),placeholder:"Shipment",onChange:function(e){a(e.target.id,e.target.value)},required:"required"}),r.a.createElement(Le.a.Feedback,null),r.a.createElement(Ie.a,null,t("shipper",c)))),r.a.createElement(p.a,{lg:3,key:"row-col-2"},r.a.createElement(je.a,{controlId:"destination"},r.a.createElement(Ae.a,null,"Destination"),r.a.createElement(Ce.a,{minLength:1,placeholder:"Destination",isLoading:n,id:"destination",isValid:fe.getValidationState("destination",c),selected:[l],onChange:function(e){if(e.length>0){var t=e[0].value;a("destination",t)}},onInputChange:function(e){a("destination",e)},onSearch:function(e){i(e)},labelKey:"value",options:o,onKeyDown:function(e){"Enter"===e.key&&s()}}),r.a.createElement(Ie.a,null,t("destination",c)))))})),we=function(e){Object(u.a)(a,e);var t=Object(d.a)(a);function a(){return Object(l.a)(this,a),t.apply(this,arguments)}return Object(s.a)(a,[{key:"componentDidMount",value:function(){var e=fe.parseRouterArgs(this.props.match.params),t=e.operation,a=e.productTypeOrId,n=this.props,r=n.baseUrl,i=n.fetchData;(0,n.updateBaseUrl)(r),i(t,a,r)}},{key:"render",value:function(){var e=this.props,t=e.products,a=e.productDescriptions,n=e.labelLists,i=e.showAlert,c=e.labelCounts,o=e.toggleAlert,l=e.isExpanded,s=e.productTypeName,d=e.loading,u=e.baseUrl,h=e.redirect,b=e.operationName,E=e.options,y=e.alert,O=e.errors,v=e.submitData,_=e.isTypeAheadLoading,j=e.labelIds;return h&&(window.location=u+"Shipments/"),r.a.createElement(g,null,r.a.createElement(m.a,{key:"row-1"},r.a.createElement(p.a,{lg:12},r.a.createElement(T,{content:y,onDismiss:o}),r.a.createElement("h3",null,b," ",s," Shipment"))),r.a.createElement(m.a,{key:"row-2"},r.a.createElement(p.a,{lg:12,key:"row-col-1"},r.a.createElement(Pe,{options:E,getValidationState:fe.getValidationState,isTypeAheadLoading:_,formatErrors:fe.formatErrors}))),r.a.createElement(m.a,{key:"row-3"},r.a.createElement(p.a,{lg:6},r.a.createElement(Se,{toggleShipped:this.toggleShipped,getValidationState:fe.getValidationState,shippedError:fe.formatErrors("shipped",O)})),r.a.createElement(p.a,{lg:1,className:"mb-3"},r.a.createElement(Oe,{click:v,showAlert:i})),r.a.createElement(p.a,{lg:5},r.a.createElement(f,{loading:d}))),r.a.createElement(m.a,{key:"row-4"},r.a.createElement(p.a,null,r.a.createElement("div",{className:"pre-scrollable"},r.a.createElement("div",{className:"card-container"},r.a.createElement(ge,{labelLists:n,isExpanded:l,labelCounts:c,products:t,labelIds:j,productDescriptions:a})))),r.a.createElement(p.a,null,r.a.createElement(D,{selectedCount:j.length},r.a.createElement(ve,{count:j.length})))))}}]),a}(r.a.Component),Re={submitData:De.submitData,fetchData:De.fetchData,toggleAlert:function(){return{type:z}},showAlert:function(e,t,a){return{type:J,data:{alertTextBold:e,alertText:t,alertVariant:a}}},updateBaseUrl:function(e){return{type:Q,data:e}}},xe=Object(o.b)((function(e){var t=e.shipment,a=e.ui,n=e.products;return{alert:e.alert,labelIds:t.labelIds,labelCounts:n.labelCounts,errors:a.errors,products:n.products,productDescriptions:n.productDescriptions,labelLists:n.labelLists,isExpanded:a.isExpanded,productTypeName:n.productTypeName,loading:a.loading,options:a.options,redirect:a.redirect,operationName:a.operationName,isTypeAheadLoading:a.isTypeAheadLoading}}),(function(e){return Object(ke.b)(Re,e)}))(Object(E.f)(we)),Ne=a(84),Ue={operation:"",id:"",shipment_type:"",shipped:!1,shipper:"",destination:"",product_type_id:"",labelIds:[]};var Ve={showAlert:!1,alertTextBold:"Default Alert Bold",alertText:"Default alert text",alertVariant:"info"};var He={products:[],productDescriptions:{},labelLists:{},labelCounts:{},productType:0,productTypeName:"",allPallets:[],productTypes:[]};var Be={isExpanded:{},options:[],redirect:!1,loading:!1,errors:{},operationName:"",isTypeAheadLoading:!1,baseUrl:""};var Me=Object(ke.c)({shipment:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:Ue,t=arguments.length>1?arguments[1]:void 0;switch(t.type){case U:return Object(j.a)({},e,{operation:t.data});case X:return Object(j.a)({},e,{labelIds:t.data});case le:return Object(j.a)({},e,{},t.data);case Z:var a=t.data,n=a.fieldName,r=a.fieldValue;return Object.assign({},e,Object(R.a)({},n,r));case $:return Object(j.a)({},e,{shipped:!e.shipped});default:return e}},alert:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:Ve,t=arguments.length>1?arguments[1]:void 0;switch(t.type){case z:return Object(j.a)({},e,{showAlert:!e.showAlert});case J:return Object(j.a)({},e,{showAlert:!0},t.data);case H:return Object(j.a)({},e,{showAlert:!1});default:return e}},products:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:He,t=arguments.length>1?arguments[1]:void 0;switch(t.type){case F:return Object(j.a)({},e,{labelLists:Object(j.a)({},e.labelLists,{},t.data)});case V:return Object(j.a)({},e,{productType:t.data});case Y:return Object(j.a)({},e,{products:t.data});case K:return Object(j.a)({},e,{productTypeName:t.data});case G:return Object(j.a)({},e,{productDescriptions:t.data});case ne:return Object(j.a)({},e,{products:Object(j.a)({},e.products,{},t.data)});case te:return Object(j.a)({},e,{labelCounts:Object(j.a)({},e.labelCounts,{},t.data)});case x:return Object(j.a)({},e,{allPallets:t.data});default:return e}},ui:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:Be,t=arguments.length>1?arguments[1]:void 0;switch(t.type){case M:return Object(j.a)({},e,{isExpanded:t.data});case ie:return Object(j.a)({},e,{},t.data);case oe:return Object(j.a)({},e,{errors:Object(j.a)({},e.errors,{},t.data)});case ee:return Object(j.a)({},e,{isExpanded:Object(j.a)({},e.isExpanded,{},t.data)});case W:return Object(j.a)({},e,{isTypeAheadLoading:t.data});case B:return Object(j.a)({},e,{options:t.data});case Q:return Object(j.a)({},e,{baseUrl:t.data});case q:return Object(j.a)({},e,{loading:t.data});case z:return Object(j.a)({},e,{showAlert:!e.showAlert});case N:return Object(j.a)({},e,{operationName:t.data});default:return e}}}),Xe=a(82),Fe=a(83),qe=(Object(Fe.createLogger)(),window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__||ke.d),Ge=[Xe.a];var Ke=Object(ke.e)(Me,qe(ke.a.apply(void 0,Ge))),Ye=function(e){var t=e.baseUrl;return r.a.createElement(o.a,{store:Ke},r.a.createElement(Ne.a,null,r.a.createElement(E.c,null,r.a.createElement(E.a,{path:"/",exact:!0,render:function(e){return r.a.createElement(xe,Object.assign({},e,{baseUrl:t}))}}),r.a.createElement(E.a,{path:"/:operation(edit-shipment|add-shipment)/:productTypeOrId?",render:function(e){return r.a.createElement(xe,Object.assign({},e,{baseUrl:t}))}}),r.a.createElement(E.a,{path:"".concat(t,"shipments/process/:operation(edit-shipment|add-shipment)/:productTypeOrId?"),render:function(e){return r.a.createElement(xe,Object.assign({},e,{baseUrl:t}))}}))))},We=document.getElementById("root"),Je=We.getAttribute("data-baseurl");c.a.render(r.a.createElement(Ye,{baseUrl:Je}),We)},91:function(e,t,a){e.exports=a(139)}},[[91,1,2]]]);
//# sourceMappingURL=main.a3614c84.chunk.js.map