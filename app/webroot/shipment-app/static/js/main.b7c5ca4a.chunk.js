(window.webpackJsonp=window.webpackJsonp||[]).push([[0],{193:function(e,t,a){e.exports=a(446)},198:function(e,t,a){},199:function(e,t,a){},273:function(e,t,a){},446:function(e,t,a){"use strict";a.r(t);var n=a(0),i=a.n(n),l=a(12),s=a.n(l),r=(a(198),a(189)),o=a(47),c=a(36),d=a(10),p=a(173),u=a(174),h=a(190),b=a(175),m=a(13),g=a(191),f=(a(199),a(186)),y=a.n(f),v=a(26),E=a.n(v),S=a(107),L=a.n(S),j=a(65),O=a.n(j),k=a(106),T=a.n(k),D=a(21),w=a.n(D),C=a(37),x=a.n(C),A=a(64),I=a.n(A),_=a(108),R=a.n(_),K=a(185),N=a.n(K),U=a(104),q=a.n(U),P=a(16),V=a(176),W=a.n(V),X=a(66),z=a.n(X),F=function(e){return i.a.createElement(i.a.Fragment,null,e.children)},H=a(178),M=a.n(H),B=a(177),J=a.n(B),Y=i.a.createElement(i.a.Fragment,null,i.a.createElement("p",null,"This pallet doesn't have enough days product life left before it expires to allow it to ship."),i.a.createElement("p",null,"You won't be able to add this pallet to a shipper until you mark it as being allowed to ship."),i.a.createElement("ol",null,i.a.createElement("li",null,"Leave this screen and go to Warehouse => View Stock."),i.a.createElement("li",null,'Find the pallet and click it\'s "Edit" link'),i.a.createElement("li",null,"If a login screen appears login with your username and password"),i.a.createElement("li",null,'Tick the "Ship low dated" checkbox'),i.a.createElement("li",null,"click Submit"))),$=function(e){var t=e.placement;return console.log(e),i.a.createElement(J.a,Object.assign({},e,{id:"popover-positioned-".concat(t),title:"Low Dated Stock"}),Y)},G=function(e){var t=e.disabled,a=e.children,n=e.childKey;return t?i.a.createElement(M.a,{placement:"bottom",trigger:"click",rootClose:!0,overlay:i.a.createElement($,null)},i.a.createElement("span",{style:{padding:0,margin:0},key:n},a)):a},Q=a(182),Z=a.n(Q),ee=a(179),te=a(46),ae=(a(273),a(448)),ne=function(e){var t=e.bsStyle,a=e.strongText,n=e.normalText,l=e.onDismiss,s={success:{icon:te.a},warning:{icon:te.b},info:{icon:te.d},danger:{icon:te.c}};return i.a.createElement(ae.a,{in:e.show,timeout:300,classNames:"toggen",unmountOnExit:!0},i.a.createElement(Z.a,{onDismiss:l,bsStyle:t},i.a.createElement("strong",null,i.a.createElement(ee.a,{icon:s[t].icon})," ",a," ")," ",n))},ie=a(184),le=a.n(ie),se=(a(278),a(183)),re=function(e){function t(e){var a;return Object(p.a)(this,t),(a=Object(h.a)(this,Object(b.a)(t).call(this,e))).defaults={isExpanded:[],products:[],shipmentTypeDisabled:!1,labelLists:{},loading:!1,redirect:!1,labelCounts:{},showAlert:!1,errors:{},shipment:{operation:"",id:"",shipment_type:"",shipped:!1,shipper:"",destination:"",product_type_id:"",labelIds:[]},isLoading:!1,productType:0,productTypeName:"",activeKey:99999,loadedData:[],options:[],productTypes:[],baseUrl:a.props.baseUrl},a.state=Object(d.a)({},a.defaults),a.setProductType=a.setProductType.bind(Object(m.a)(a)),a.updateActiveKey=a.updateActiveKey.bind(Object(m.a)(a)),a.getLabelList=a.getLabelList.bind(Object(m.a)(a)),a.addRemoveLabel=a.addRemoveLabel.bind(Object(m.a)(a)),a.toggleIsExpanded=a.toggleIsExpanded.bind(Object(m.a)(a)),a.buildLabelString=a.buildLabelString.bind(Object(m.a)(a)),a.getLabelObject=a.getLabelObject.bind(Object(m.a)(a)),a.toggleShipped=a.toggleShipped.bind(Object(m.a)(a)),a.toggleAlert=a.toggleAlert.bind(Object(m.a)(a)),a.setShipmentDetail=a.setShipmentDetail.bind(Object(m.a)(a)),a.submitData=a.submitData.bind(Object(m.a)(a)),a}return Object(g.a)(t,e),Object(u.a)(t,[{key:"setShipmentDetail",value:function(e,t){this.setState({shipment:Object(d.a)({},this.state.shipment,Object(c.a)({},e,t))})}},{key:"updateActiveKey",value:function(e){this.setState({activeKey:e})}},{key:"fetchData",value:function(e,t,a){var n=this;this.setState(Object(d.a)({},this.defaults,{loading:!0,productType:t||""}));var i=[e,t,a].filter(function(e){return e}),l=this.state.baseUrl+"Shipments/"+i.join("/");fetch(l,{headers:{Accept:"application/json","X-Requested-With":"XMLHttpRequest"}}).then(function(e){return e.json()}).then(function(t){var a=n.createCodeDescriptions(t.shipment_labels);if(console.log(t),n.setState({loadedData:t.shipment_labels,isExpanded:Object(o.a)(a).fill(!1),products:a,shipment:Object(d.a)({},n.state.shipment,{operation:e}),loading:!1}),t.type&&n.setState({productType:t.type}),t.thisShipment){var i=t.thisShipment.Shipment,l=i.shipper,s=i.destination,r=i.shipped,c=i.shipment_type,p=i.product_type_id,u=i.id,h=t.thisShipment.Label,b=h.map(function(e){var t=Object(d.a)({},e.Location);return delete e.Location,{Label:e,Location:t}}),m=h.map(function(e){return e.id});n.setState({loadedData:b.concat(t.shipment_labels),shipmentTypeDisabled:!0,productType:p,shipment:Object(d.a)({},n.state.shipment,{shipment_type:c,shipped:r,id:u,shipper:l,product_type_id:p,destination:s,labelIds:m})})}}).catch(function(e){return console.log(e)})}},{key:"buildCodeDescString",value:function(e){return e.Label.item+" "+e.Label.description}},{key:"updateCodeDescriptions",value:function(e){var t=this.state,a=t.products,n=t.loadedData,i=this.buildCodeDescString(e),l=e.Label.item_id;this.updateSingleLabelCount(i,this.getSingleItemLabelCount(n,l)),-1===a.indexOf(i)&&this.setState({products:[i].concat(Object(o.a)(a))})}},{key:"getSingleItemLabelCount",value:function(e,t){return e.filter(function(e,a){return e.Label.item_id===t}).length}},{key:"updateSingleLabelCount",value:function(e,t){var a=Object(d.a)({},this.state.labelCounts);this.setState({labelCounts:Object(d.a)({},a,Object(c.a)({},e,t))})}},{key:"createCodeDescriptions",value:function(){var e=this,t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:[],a=0,n={},i=t.reduce(function(t,i){var l=e.buildCodeDescString(i);return-1===t.indexOf(l)&&(t.push(l),a=1),n[l]=a++,t},[]);return this.setState({labelCounts:Object(d.a)({},this.state.labelCounts,n)}),i}},{key:"getLabelList",value:function(e){var t=this.state.loadedData.reduce(function(t,a,n){return a.Label.item+" "+a.Label.description===e&&t.push(a),t},[]),a=this.state.labelLists,n=Object(d.a)({},a,Object(c.a)({},e,t));this.setState({labelLists:n})}},{key:"toggleIsExpanded",value:function(e,t){var a=Object(o.a)(this.state.isExpanded);a[t]=e,this.setState({isExpanded:a})}},{key:"toggleAlert",value:function(){var e=this,t=!this.state.showAlert;this.setState({showAlert:t}),t&&setTimeout(function(){e.setState({showAlert:!t})},4e3)}},{key:"submitData",value:function(){var e=this;this.setState({errors:{},loading:!0});var t=this.state,a=t.baseUrl,n=t.productType,i=this.state.shipment,l=i.operation,s=i.shipper,r=i.shipped,o=i.id,p=i.destination,u=i.labelIds,h=a+"Shipments/"+[l,o].filter(function(e){return e}).join("/"),b={Shipment:{shipper:s,destination:p,shipped:r,product_type_id:n},Label:u};switch(l){case"add":break;case"edit":b.Shipment.id=o;var m=u.map(function(e){return{shipment_id:o,id:e}});b=Object(d.a)({},b,{Label:m}),console.log("postObject",b);break;default:console.log("it broken")}fetch(h,{method:"POST",mode:"cors",cache:"no-cache",credentials:"same-origin",headers:{"Content-Type":"application/json",Accept:"application/json","X-Requested-With":"XMLHttpRequest"},redirect:"error",body:JSON.stringify(b)}).then(function(e){return e.json()}).then(function(t){t.error?Object.keys(t.error).map(function(a){e.setState({errors:Object(d.a)({},e.state.errors,Object(c.a)({},a,t.error[a].join(", ")))})}):e.setState({redirect:!0}),e.setState({loading:!1})})}},{key:"toggleShipped",value:function(){this.setState({shipment:Object(d.a)({},this.state.shipment,{shipped:!this.state.shipment.shipped})})}},{key:"addRemoveLabel",value:function(e,t){var a=this.state.shipment,n=Object(o.a)(a.labelIds);this.updateCodeDescriptions(this.getLabelObject(t)[0]),e&&-1===n.indexOf(t)&&n.push(t),e||(n=n.filter(function(e){return e!==t})),this.setState({shipment:Object(d.a)({},a,{labelIds:n})})}},{key:"setProductType",value:function(e){var t=e.target.value;if(""!==t){if(this.state.productType!==t){this.setState({productType:t});var a=this.parseRouterArgs(),n=a.operation,i=a.id;this.fetchData(n,t,i)}}else this.setState({products:[]})}},{key:"parseRouterArgs",value:function(){var e=this.props.match.params,t=e.operation,a=e.typeOrId,n=null,i=null;switch(t){case"add":n=a||this.state.productType;break;case"edit":isNaN(a)||(console.log("typeOrId isInteger"),i=a),this.setState({shipmentTypeDisabled:!0});break;default:t="add",n=this.state.productType}return{operation:t,productType:n,id:i}}},{key:"getValidationState",value:function(e){return void 0!==this.state.errors[e]?"error":null}},{key:"componentDidMount",value:function(){var e=this.parseRouterArgs(),t=e.operation,a=e.productType,n=e.id;this.setState({baseUrl:this.props.baseUrl}),this.fetchData(t,a,n),this.getProductType(a)}},{key:"getProductType",value:function(e){var t=this,a=this.state.baseUrl+"ProductTypes/view/".concat(e);console.log("pt",e),e&&fetch(a,{headers:{Accept:"application/json","X-Requested-With":"XMLHttpRequest"}}).then(function(e){return e.json()}).then(function(e){e.productType.ProductType&&t.setState({productTypeName:e.productType.ProductType.name}),console.log("pt",e)}).catch(function(e){throw e})}},{key:"getLabelObject",value:function(e){return this.state.loadedData.filter(function(t,a){return t.Label.id===e})}},{key:"buildLabelString",value:function(e){var t=e.Location,a=e.Label;return[t.location,a.item,a.best_before,a.pl_ref,a.qty,a.description].join(", ")}},{key:"render",value:function(){var e=this,t=this.state,a=t.products,n=t.labelLists,l=t.showAlert,s=t.labelCounts,o=t.isExpanded,c=t.shipment,p=t.productTypeName,u=t.loading,h=t.errors,b=t.baseUrl,m=h.shipper||"",g=h.shipped||"",f=h.destination||"",v=c.labelIds,S=c.shipper,j=c.shipped,k=c.operation,D=v.length,C=null,A=["checkbox","fixed","pallet-list"],_=null;return u&&(_=i.a.createElement(x.a,null,i.a.createElement(w.a,{lg:12},i.a.createElement("div",{className:"text-center"},i.a.createElement(W.a,{loading:u,size:14,color:"#ddd"}))))),v&&(C=v.map(function(t,a){var n=e.getLabelObject(t)[0];return i.a.createElement(I.a,{bsClass:A.join(" "),key:n.Label.pl_ref,checked:!0,onChange:function(t){return e.addRemoveLabel(t.target.checked,n.Label.id)}},e.buildLabelString(n))})),this.state.redirect&&(window.location=b+"Shipments/"),i.a.createElement(F,null,i.a.createElement(x.a,null,i.a.createElement(w.a,{lg:12},i.a.createElement(ne,{strongText:"bold this",normalText:"Message that",bsStyle:"info",show:l,onDismiss:this.toggleAlert}),i.a.createElement("h3",{style:{textTransform:"capitalize"}},"".concat(k," ").concat(p," Shipment")))),i.a.createElement(x.a,{className:"bpad"},i.a.createElement(w.a,{lg:12},i.a.createElement(le.a,{onSubmit:function(e){return e.preventDefault()}},i.a.createElement(x.a,null,i.a.createElement(w.a,{lg:3},i.a.createElement(O.a,{validationState:this.getValidationState("shipper"),bsSize:"sm",controlId:"shipper"},i.a.createElement(T.a,null,"Shipment")," ",i.a.createElement(L.a,{type:"text",value:S,placeholder:"Shipment",onChange:function(t){var a=e.state.errors,n=(a.shipper,Object(r.a)(a,["shipper"]));e.setState({errors:Object(d.a)({},n)}),e.setShipmentDetail(t.target.id,t.target.value)},required:"required"}),i.a.createElement(L.a.Feedback,null),i.a.createElement(z.a,null,m))),i.a.createElement(w.a,{lg:3},i.a.createElement(O.a,{controlId:"destination",bsSize:"sm",validationState:this.getValidationState("destination")},i.a.createElement(T.a,null,"Destination"),i.a.createElement(se.AsyncTypeahead,{placeholder:"Destination",isLoading:this.state.isLoading,id:"destination",name:"destination",selected:[this.state.shipment.destination],onChange:function(t){if(t.length>0){var a=t[0].value;e.setShipmentDetail("destination",a)}},onInputChange:function(t){e.setShipmentDetail("destination",t)},onSearch:function(t){e.setState({isLoading:!0}),fetch("".concat(e.state.baseUrl,"Shipments/destinationLookup?term=").concat(t),{headers:{Accept:"application/json"}}).then(function(e){return e.json()}).then(function(t){console.log(t),e.setState({isLoading:!1,options:t})})},labelKey:"value",options:this.state.options}),i.a.createElement(z.a,null,f))),i.a.createElement(w.a,{lg:4},i.a.createElement(O.a,{className:"cb-shipped",validationState:this.getValidationState("shipped")},i.a.createElement(I.a,{validationState:this.getValidationState("shipped"),checked:j,onChange:this.toggleShipped},"Shipped"),i.a.createElement(z.a,null,g)))),i.a.createElement(x.a,null,i.a.createElement(w.a,{lg:6},i.a.createElement(N.a,{bsStyle:"primary",bsSize:"sm",className:"my-btn",onClick:this.submitData,type:"submit"},"Submit")),i.a.createElement(w.a,{lg:6},_))))),i.a.createElement(x.a,null,i.a.createElement(w.a,{lg:6},i.a.createElement("div",{className:"pre-scrollable"},i.a.createElement(y.a,{id:"accordion-controlled-example",activeKey:this.state.activeKey,onSelect:this.updateActiveKey},a&&a.map(function(t,a){return i.a.createElement(E.a,{key:"panel-".concat(a),eventKey:"panel-".concat(a),expanded:o[a],onToggle:function(t){e.toggleIsExpanded(t,a)}},i.a.createElement(E.a.Heading,null,i.a.createElement(E.a.Title,{onClick:function(){return e.getLabelList(t)},toggle:!0},t," ",s[t]&&i.a.createElement(R.a,null,s[t]))),i.a.createElement(E.a.Body,{collapsible:!0},n[t]&&n[t].map(function(t,a){var n=null,l=A.slice(),s=e.state.shipment.labelIds.indexOf(t.Label.id)>-1,r={};return+t.Label.disabled&&(l.push("bg-danger"),n=i.a.createElement(i.a.Fragment,null,i.a.createElement(q.a,{glyph:"ban-circle"})," "),r={pointerEvents:"none"}),i.a.createElement(G,{key:t.Label.pl_ref,childKey:t.Label.pl_ref,disabled:t.Label.disabled},i.a.createElement(I.a,{bsClass:l.join(" "),disabled:t.Label.disabled,checked:s,style:r,key:t.Label.pl_ref,onChange:function(a){return e.addRemoveLabel(a.target.checked,t.Label.id)}},n,e.buildLabelString(t)))})))})))),i.a.createElement(w.a,{lg:6},i.a.createElement(E.a,null,i.a.createElement(E.a.Heading,null,i.a.createElement(E.a.Title,{componentClass:"h3"},"Currently On Shipment ",i.a.createElement(R.a,null,D))),i.a.createElement(E.a.Body,null,C)))))}}]),t}(i.a.Component),oe=Object(P.f)(re),ce=a(188);Boolean("localhost"===window.location.hostname||"[::1]"===window.location.hostname||window.location.hostname.match(/^127(?:\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}$/));var de=document.getElementById("root"),pe=de.getAttribute("data-baseurl");s.a.render(i.a.createElement(ce.a,null,i.a.createElement(P.c,null,i.a.createElement(P.a,{path:"/",exact:!0,render:function(e){return i.a.createElement(oe,Object.assign({},e,{baseUrl:pe}))}}),i.a.createElement(P.a,{path:"/:operation(add|edit)/:typeOrId?",render:function(e){return i.a.createElement(oe,Object.assign({},e,{baseUrl:pe}))}}),i.a.createElement(P.a,{path:"".concat(pe,"Shipments/addApp/:operation(add|edit)/:typeOrId?"),render:function(e){return i.a.createElement(oe,Object.assign({},e,{baseUrl:pe}))}}))),de),"serviceWorker"in navigator&&navigator.serviceWorker.ready.then(function(e){e.unregister()})}},[[193,1,2]]]);
//# sourceMappingURL=main.b7c5ca4a.chunk.js.map