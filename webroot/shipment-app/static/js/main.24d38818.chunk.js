(this["webpackJsonpshipment-app"]=this["webpackJsonpshipment-app"]||[]).push([[0],{150:function(e,t,a){e.exports=a(331)},155:function(e,t,a){},170:function(e,t,a){},172:function(e,t,a){},331:function(e,t,a){"use strict";a.r(t);var n=a(0),i=a.n(n),r=a(6),s=a.n(r),l=(a(155),a(147)),o=a(89),c=a(24),d=a(9),p=a(134),u=a(135),h=a(11),m=a(146),b=a(148),g=a(32),f=a(44),y=a(36),v=a(45),E=a(13),k=a(38),O=a(23),j=a(87),S=a(140),T=a(136),L=a(141),x=a(14),C=a(137),D=a.n(C),w=a(46),A=function(e){return i.a.createElement(i.a.Fragment,null,e.children)},I=a(144),_=a(62),N=i.a.createElement(i.a.Fragment,null,i.a.createElement("p",null,"This pallet doesn't have enough days product life left before it expires to allow it to ship.")),R=function(e){var t=e.placement;return i.a.createElement(_.a,Object.assign({},e,{id:"popover-positioned-".concat(t)}),i.a.createElement(_.a.Title,null,"Low Dated Stock"),i.a.createElement(_.a.Content,null,N))},U=function(e){var t=e.disabled,a=e.children,n=e.childKey;return t?i.a.createElement(I.a,{placement:"bottom",trigger:"click",rootClose:!0,overlay:R},i.a.createElement("span",{style:{padding:0,margin:0},key:n},a)):a},V=a(145),q=(a(170),a(337)),B=function(e){var t=e.variant,a=e.strongText,n=e.normalText,r=e.onDismiss;return i.a.createElement(q.a,{in:e.show,timeout:300,classNames:"toggen",unmountOnExit:!0},i.a.createElement(V.a,{variant:t,onClose:r,dismissible:!0},i.a.createElement("strong",null,a," ")," ",n))},K=a(21),P=(a(171),a(172),a(139)),F=function(e){Object(b.a)(a,e);var t=Object(m.a)(a);function a(e){var n;return Object(p.a)(this,a),(n=t.call(this,e)).defaults={isExpanded:{},products:[],shipmentTypeDisabled:!1,labelLists:{},loading:!1,redirect:!1,labelCounts:{},showAlert:!1,errors:{},operationName:"",shipment:{operation:"",id:"",shipment_type:"",shipped:!1,shipper:"",destination:"",product_type_id:"",labelIds:[]},isTypeAheadLoading:!1,productType:0,productTypeName:"",activeKey:99999,loadedData:[],options:[],productTypes:[],baseUrl:n.props.baseUrl,alertTextBold:"Default Alert Bold",alertText:"Default alert text",alertVariant:"info"},n.state=Object(d.a)({},n.defaults),n.setProductType=n.setProductType.bind(Object(h.a)(n)),n.updateActiveKey=n.updateActiveKey.bind(Object(h.a)(n)),n.getLabelList=n.getLabelList.bind(Object(h.a)(n)),n.addRemoveLabel=n.addRemoveLabel.bind(Object(h.a)(n)),n.toggleIsExpanded=n.toggleIsExpanded.bind(Object(h.a)(n)),n.buildLabelString=n.buildLabelString.bind(Object(h.a)(n)),n.getLabelObject=n.getLabelObject.bind(Object(h.a)(n)),n.toggleShipped=n.toggleShipped.bind(Object(h.a)(n)),n.toggleAlert=n.toggleAlert.bind(Object(h.a)(n)),n.setShipmentDetail=n.setShipmentDetail.bind(Object(h.a)(n)),n.submitData=n.submitData.bind(Object(h.a)(n)),n}return Object(u.a)(a,[{key:"setShipmentDetail",value:function(e,t){this.setState({shipment:Object(d.a)({},this.state.shipment,Object(c.a)({},e,t))})}},{key:"updateActiveKey",value:function(e){this.setState({activeKey:e})}},{key:"fetchData",value:function(e,t){var a=this;this.setState(Object(d.a)({},this.defaults,{loading:!0}));var n=[e,t].filter((function(e){return e})),i=this.state.baseUrl+"Shipments/"+n.join("/");fetch(i,{headers:{Accept:"application/json","X-Requested-With":"XMLHttpRequest"}}).then((function(e){return e.json()})).then((function(n){var i=[],r="";switch(e){case"add-shipment":r="Add",i=n.shipment_labels,a.setState({operationName:r,productType:t,loadedData:i,shipment:Object(d.a)({},a.state.shipment,{operation:e})});break;case"edit-shipment":r="Edit";var s=n.shipment.pallets;i=s.concat(n.shipment_labels),a.setState({operationName:r,loadedData:i});var l=s.map((function(e){return e.id}));a.setState({productType:n.shipment.product_type_id,shipment:Object(d.a)({},a.state.shipment,{},n.shipment,{operation:e,labelIds:l})})}i.forEach((function(e){a.updateCodeDescriptions(e)})),a.getProductType(a.state.productType),a.setState({loading:!1})})).catch((function(e){return console.log(e)}))}},{key:"updateCodeDescriptions",value:function(e){var t=this.state,a=t.products,n=t.loadedData,i=t.isExpanded,r=e.code_desc,s=e.item_id;this.updateSingleLabelCount(r,this.getSingleItemLabelCount(n,s)),-1===a.indexOf(r)&&this.setState({isExpanded:Object(d.a)({},i,Object(c.a)({},r,!1)),products:[r].concat(Object(o.a)(a))})}},{key:"getSingleItemLabelCount",value:function(e,t){return e.filter((function(e,a){return e.item_id===t})).length}},{key:"updateSingleLabelCount",value:function(e,t){var a=Object(d.a)({},this.state.labelCounts);this.setState({labelCounts:Object(d.a)({},a,Object(c.a)({},e,t))})}},{key:"createCodeDescriptions",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:[],t=0,a={},n=e.reduce((function(e,n){var i=n.code_desc;return-1===e.indexOf(i)&&(e.push(i),t=1),a[i]=t++,e}),[]);return this.setState({labelCounts:Object(d.a)({},this.state.labelCounts,{},a)}),n}},{key:"getLabelList",value:function(e){console.log("getLabelList");var t=this.state.loadedData.reduce((function(t,a,n){return a.code_desc===e&&t.push(a),t}),[]),a=this.state.labelLists,n=Object(d.a)({},a,Object(c.a)({},e,t));this.setState({labelLists:n})}},{key:"toggleIsExpanded",value:function(e,t){var a=Object(d.a)({},this.state.isExpanded);Object.keys(a).forEach((function(t){a[t]=t===e&&!a[t]})),console.log("toggleExpanded",a,e),this.setState({isExpanded:a})}},{key:"toggleAlert",value:function(e,t,a){var n=this,i=!this.state.showAlert;this.setState({alertVariant:a,alertText:e,alertTextBold:t,showAlert:i}),i&&setTimeout((function(){n.setState({showAlert:!i})}),4e3)}},{key:"submitData",value:function(){var e=this;this.setState({errors:{},loading:!0});var t=this.state,a=t.baseUrl,n=t.productType,i=this.state.shipment,r=i.operation,s=i.shipper,l=i.shipped,o=i.id,p=i.destination,u=i.labelIds,h={shipper:s,destination:p,shipped:l,product_type_id:n,pallets:u},m="";switch(r){case"add-shipment":m=n;break;case"edit-shipment":m=o,h.id=o;var b=u.map((function(e){return{shipment_id:o,id:e}}));h=Object(d.a)({},h,{pallets:b});break;default:console.log("it broken")}var g=a+"Shipments/"+[r,m].filter((function(e){return e})).join("/"),f={method:"POST",mode:"cors",cache:"no-cache",credentials:"same-origin",headers:{"X-CSRF-Token":window.csrfToken,"Content-Type":"application/json",Accept:"application/json","X-Requested-With":"XMLHttpRequest"},redirect:"error",body:JSON.stringify(h)};fetch(g,f).then((function(e){return e.json()})).then((function(t){var a=!0,n=t.error||{};Object.keys(n).length>0&&(n.pallets&&(n=n.pallets[0]),Object.keys(n).forEach((function(t){e.setState({errors:Object(d.a)({},e.state.errors,Object(c.a)({},t,n[t]))})})),a=!1),e.setState({loading:!1,redirect:a})}))}},{key:"toggleShipped",value:function(){this.setState({shipment:Object(d.a)({},this.state.shipment,{shipped:!this.state.shipment.shipped})})}},{key:"addRemoveLabel",value:function(e,t){var a=this.state.shipment,n=Object(o.a)(a.labelIds);this.updateCodeDescriptions(this.getLabelObject(t)[0]),e&&-1===n.indexOf(t)&&n.push(t),e||(n=n.filter((function(e){return e!==t}))),this.setState({shipment:Object(d.a)({},a,{labelIds:n})})}},{key:"setProductType",value:function(e){var t=e.target.value;if(""!==t){if(this.state.productType!==t){this.setState({productType:t});var a=this.parseRouterArgs(),n=a.operation,i=a.productTypeOrId;this.fetchData(n,i)}}else this.setState({products:[]})}},{key:"parseRouterArgs",value:function(){var e=this.props.match.params;return{operation:e.operation,productTypeOrId:e.productTypeOrId}}},{key:"getValidationState",value:function(e){return void 0!==this.state.errors[e]}},{key:"componentDidMount",value:function(){var e=this.parseRouterArgs(),t=e.operation,a=e.productTypeOrId;this.setState({baseUrl:this.props.baseUrl}),this.fetchData(t,a)}},{key:"getProductType",value:function(e){var t=this,a=this.state.baseUrl+"ProductTypes/view/".concat(e);e&&fetch(a,{headers:{Accept:"application/json","X-Requested-With":"XMLHttpRequest"}}).then((function(e){return e.json()})).then((function(e){console.log("ProductType",e),e.productType&&t.setState({productTypeName:e.productType.name}),console.log("pt",e)})).catch((function(e){throw e}))}},{key:"formatErrors",value:function(e){var t=[];if(this.state.errors[e]){var a=this.state.errors[e];t=Object.keys(a).map((function(e){return a[e]}))}return t.join(", ")}},{key:"getLabelObject",value:function(e){return this.state.loadedData.filter((function(t,a){return t.id===e}))}},{key:"buildLabelString",value:function(e){var t=e.location,a=e.item,n=e.bb_date,i=e.pl_ref,r=e.qty,s=e.description;return[t.location,a,new Date(n).toLocaleDateString(),i,r,s].join(", ")}},{key:"render",value:function(){var e=this,t=this.state,a=t.products,n=t.labelLists,r=t.showAlert,s=t.labelCounts,o=t.isExpanded,c=t.shipment,p=t.productTypeName,u=t.loading,h=t.baseUrl,m=t.operationName,b=this.formatErrors("shipper"),x=this.formatErrors("shipped"),C=this.formatErrors("destination"),I=c.labelIds,_=c.shipper,N=c.shipped,R=I.length,V=null,q=["FormCheck","fixed","pallet-list"],F=null;return u&&(F=i.a.createElement(k.a,null,i.a.createElement(E.a,{lg:12},i.a.createElement("div",{className:"text-center"},i.a.createElement(D.a,{loading:u,size:14,color:"#ddd"}))))),I&&(V=I.map((function(t,a){var n=e.getLabelObject(t)[0];return i.a.createElement(O.a,{key:n.pl_ref,id:"checkbox-{id}",checked:!0,label:e.buildLabelString(n),onChange:function(t){return e.addRemoveLabel(t.target.checked,n.id)}})}))),this.state.redirect&&(window.location=h+"Shipments/"),i.a.createElement(A,null,i.a.createElement(k.a,{key:"row-1"},i.a.createElement(E.a,{lg:12},i.a.createElement(B,{strongText:this.state.alertTextBold,normalText:this.state.alertText,variant:this.state.alertVariant,show:r,onDismiss:this.toggleAlert}),i.a.createElement("h3",null,m," ",p," Shipment"))),i.a.createElement(k.a,{key:"row-2"},i.a.createElement(E.a,{lg:12,key:"row-col-1"},i.a.createElement(K.a.Row,{onSubmit:function(e){return e.preventDefault()}},i.a.createElement(E.a,{lg:3},i.a.createElement(y.a,{controlId:"shipper"},i.a.createElement(v.a,null,"Shipment")," ",i.a.createElement(f.a,{type:"text",value:_,isValid:this.getValidationState("shipper"),placeholder:"Shipment",onChange:function(t){var a=e.state.errors,n=(a.shipper,Object(l.a)(a,["shipper"]));e.setState({errors:Object(d.a)({},n)}),e.setShipmentDetail(t.target.id,t.target.value)},required:"required"}),i.a.createElement(f.a.Feedback,null),i.a.createElement(w.a,null,b))),i.a.createElement(E.a,{lg:3,key:"row-col-2"},i.a.createElement(y.a,{controlId:"destination"},i.a.createElement(v.a,null,"Destination"),i.a.createElement(P.AsyncTypeahead,{placeholder:"Destination",isLoading:this.state.isTypeAheadLoading,id:"destination",name:"destination",isValid:this.getValidationState("destination"),selected:[this.state.shipment.destination],onChange:function(t){if(t.length>0){var a=t[0].value;e.setShipmentDetail("destination",a)}},onInputChange:function(t){e.setShipmentDetail("destination",t)},onSearch:function(t){e.setState({isTypeAheadLoading:!0}),fetch("".concat(e.state.baseUrl,"Shipments/destinationLookup?term=").concat(t),{headers:{Accept:"application/json"}}).then((function(e){return e.json()})).then((function(t){console.log(t),e.setState({isTypeAheadLoading:!1,options:t})}))},labelKey:"value",options:this.state.options}),i.a.createElement(w.a,null,C)))))),i.a.createElement(k.a,{key:"row-3"},i.a.createElement(E.a,{lg:6},i.a.createElement(y.a,null,i.a.createElement(K.a.Check,{id:"shipped"},i.a.createElement(K.a.Check.Input,{type:"checkbox",checked:N,onChange:this.toggleShipped,isValid:this.getValidationState("shipped")}),i.a.createElement(K.a.Check.Label,null,"Shipped"),i.a.createElement(K.a.Control.Feedback,null,x)))),i.a.createElement(E.a,{lg:1,className:"mb-3"},i.a.createElement(S.a,{variant:"primary",size:"sm",className:"my-btn",onClick:this.submitData,type:"submit"},"Submit")),i.a.createElement(E.a,{lg:5},F)),i.a.createElement(k.a,{key:"row-4"},i.a.createElement(E.a,null,i.a.createElement("div",{className:"pre-scrollable"},i.a.createElement("div",{className:"card-container"},i.a.createElement(g.a,{key:"card-top-level"},a&&a.map((function(t,a){return i.a.createElement("div",{key:"wrap-".concat(a)},i.a.createElement(g.a.Header,{onClick:function(){e.getLabelList(t),e.toggleIsExpanded(t,a)},as:"h5",className:"toggen-header",key:"header-{idx}"}," ",t," ",s[t]&&i.a.createElement(j.a,{variant:"primary"},s[t])),n[t]&&o[t]&&i.a.createElement(g.a.Body,{className:o[t]&&"open"},n[t].map((function(t,a){var n=null,r=q.slice(),s=e.state.shipment.labelIds.indexOf(t.id)>-1,l={};t.disabled&&(r.push("bg-danger"),n=i.a.createElement(i.a.Fragment,null,i.a.createElement(T.a,{icon:L.a})," "),l={pointerEvents:"none"});var o=e.buildLabelString(t);return i.a.createElement(U,{key:t.pl_ref,childKey:t.pl_ref,disabled:t.disabled},i.a.createElement(K.a.Check,{disabled:t.disabled,style:l,key:t.pl_ref,id:t.pl_ref},i.a.createElement(K.a.Check.Input,{checked:s,type:"checkbox",onChange:function(a){return e.addRemoveLabel(a.target.checked,t.id)}}),i.a.createElement(K.a.Check.Label,null,n," ",o)))}))))})))))),i.a.createElement(E.a,null,i.a.createElement(g.a,null,i.a.createElement(g.a.Header,{as:"h5"},"Currently On Shipment"," ",i.a.createElement(j.a,{variant:"primary"},R)),V.length>0&&i.a.createElement(g.a.Body,null,V)))))}}]),a}(i.a.Component),X=Object(x.f)(F),H=a(143);Boolean("localhost"===window.location.hostname||"[::1]"===window.location.hostname||window.location.hostname.match(/^127(?:\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}$/));var W=document.getElementById("root"),M=W.getAttribute("data-baseurl");s.a.render(i.a.createElement(H.a,null,i.a.createElement(x.c,null,i.a.createElement(x.a,{path:"/",exact:!0,render:function(e){return i.a.createElement(X,Object.assign({},e,{baseUrl:M}))}}),i.a.createElement(x.a,{path:"/:operation(edit-shipment|add-shipment)/:productTypeOrId?",render:function(e){return i.a.createElement(X,Object.assign({},e,{baseUrl:M}))}}),i.a.createElement(x.a,{path:"".concat(M,"shipments/process/:operation(edit-shipment|add-shipment)/:productTypeOrId?"),render:function(e){return i.a.createElement(X,Object.assign({},e,{baseUrl:M}))}}))),W),"serviceWorker"in navigator&&navigator.serviceWorker.ready.then((function(e){e.unregister()}))}},[[150,1,2]]]);
//# sourceMappingURL=main.24d38818.chunk.js.map