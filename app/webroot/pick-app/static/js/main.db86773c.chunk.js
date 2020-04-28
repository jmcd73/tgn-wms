(this["webpackJsonppick-app"]=this["webpackJsonppick-app"]||[]).push([[0],{124:function(e,t,a){e.exports=a(229)},162:function(e,t,a){},229:function(e,t,a){"use strict";a.r(t);a(125);var s=a(0),n=a.n(s),i=a(112),l=a.n(i),c=(a(162),a(121)),o=a(81),r=a(113),h=a(114),m=a(122),p=a(115),u=a(27),d=a(123),g=a(119),f=a.n(g),k=a(120),v=a.n(k),E=a(47),S=a.n(E),b=a(116),w=a.n(b),y=a(117),O=a.n(y),P=a(118),j=a.n(P),N=a(80),A=a.n(N),C=function(e){function t(e){var a;return Object(r.a)(this,t),(a=Object(m.a)(this,Object(p.a)(t).call(this,e))).state={allPicked:!1,selectMessage:"Select a shipper",shipments:[],shipment:{},message:"",showAlert:!1},a.selectOnChange=a.selectOnChange.bind(Object(u.a)(a)),a.fetchShipperPallets=a.fetchShipperPallets.bind(Object(u.a)(a)),a.handleDismiss=a.handleDismiss.bind(Object(u.a)(a)),a}return Object(d.a)(t,e),Object(h.a)(t,[{key:"handleDismiss",value:function(){this.setState({showAlert:!this.state.showAlert})}},{key:"togglePicked",value:function(e,t){var a=this,s=arguments.length>2&&void 0!==arguments[2]&&arguments[2],n=this.props.baseUrl+"Labels/multiEdit/",i=JSON.parse(JSON.stringify(this.state.shipment.Pallet)),l=[],r={};if(s)l=i.map((function(e,a){return i[a].picked=t,{id:e.id,picked:t}})),r={allPicked:t};else{l=i.map((function(a,s){return i[s].id===e?(i[s].picked=t,{id:a.id,picked:t}):null})).filter((function(e){return e}));var h=i.every((function(e,t){return e.picked}));r={allPicked:h}}var m=Object(o.a)({},this.state,{shipment:Object(o.a)({},this.state.shipment,{Pallet:Object(c.a)(i)})},r);this.setState(m),fetch(n,{method:"POST",headers:{Accept:"application/json","Content-Type":"application/json","X-Requested-With":"XMLHttpRequest"},body:JSON.stringify(l)}).then((function(e){if(e.ok)return e.json();throw new Error("Failed to POST to "+n+": "+e.status+" "+e.statusText)})).then((function(e){a.setState({message:e.message,messageResult:e.result,showAlert:!0},(function(){setTimeout((function(){a.setState({showAlert:!1})}),3e3)}))})).catch((function(e){a.setState({message:e.message||"error updating picked status",messageResult:"danger",showAlert:!0})}))}},{key:"fetchShipperPallets",value:function(e){var t=this,a=this.props.baseUrl+"Shipments/view/";fetch(a+e,{method:"GET",headers:{Accept:"application/json"}}).then((function(e){if(e.ok)return e.json();throw new Error("failed to request "+a)})).then((function(e){t.setState(e);var a=e.shipment.Pallet.every((function(e){return e.picked}));t.setState({allPicked:a})})).catch((function(e){}))}},{key:"selectOnChange",value:function(e){0!==parseInt(e.target.value)?this.fetchShipperPallets(e.target.value):this.setState({shipment:{}})}},{key:"componentDidMount",value:function(){var e=this,t=this.props.baseUrl+"Shipments/openShipments";fetch(t,{method:"GET",headers:{Accept:"application/json"}}).then((function(e){if(e.ok)return e.json();throw new Error("failed to request "+t+" "+e.status+" "+e.statusText)})).then((function(t){0===t.shipments.length?e.setState({selectMessage:"Reload the page to check for new shippers"}):e.setState(t)})).catch((function(t){console.log(t),e.setState({message:t.message,messageResult:"danger",showAlert:!0})}))}},{key:"render",value:function(){var e=this,t=this.state,a=t.shipments,s=t.shipment,i=s.Pallet,l=0,c=0,o="label-warning",r=!1;return i&&(i.sort((function(e,t){return e.Location.location<t.Location.location?-1:e.Location.location>t.Location.location?1:0})),(l=i.length)===(c=i.filter((function(e){return!0===e.picked})).length)&&(r=!0,o="label-success")),n.a.createElement("div",{className:"col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 col-xs-12"},n.a.createElement("div",{className:"row"},n.a.createElement("div",{className:"col-lg-12 col-md-12 col-sm-12"},n.a.createElement(w.a,{controlId:"formControlsSelect"},n.a.createElement(O.a,null,"Select a shipper"),n.a.createElement(j.a,{onChange:this.selectOnChange,componentClass:"select",placeholder:"select"},n.a.createElement("option",{key:1,value:0},this.state.selectMessage),a.map((function(e,t){var a=e.Shipment;return n.a.createElement("option",{key:a.id,value:a.id},a.shipper," ",a.destination)})))))),n.a.createElement("div",{className:"row"},n.a.createElement("div",{className:"col-lg-12 col-md-12 col-sm-12"},this.state.showAlert&&n.a.createElement(f.a,{onDismiss:this.handleDismiss,bsStyle:this.state.messageResult},this.state.message))),n.a.createElement("div",{className:"row"},n.a.createElement("div",{className:"col-lg-12 col-md-12 col-sm-12"},i&&n.a.createElement(v.a,{as:"ul"},n.a.createElement(S.a,{key:0,as:"li",active:!0},n.a.createElement("h3",{className:"list-group-item-heading"},s.Shipment.shipper,n.a.createElement("span",{style:{float:"right"},className:"label ".concat(o)},c,"/",l)),n.a.createElement("p",{className:"list-group-item-text"},s.Shipment.destination),n.a.createElement(A.a,{checked:this.state.allPicked,onChange:function(t){return e.togglePicked(null,!e.state.allPicked,!0)}},"Mark all as picked")),i.map((function(t,a){var s=t.picked,i="list-group-item";return s&&!r&&(i+=" list-group-item-info"),r&&(i+=" list-group-item-success"),n.a.createElement(S.a,{as:"li",className:i,key:t.id},n.a.createElement("h4",{className:"list-group-item-heading"},t.Location.location),n.a.createElement("p",{className:"list-group-item-text"},t.pl_ref),n.a.createElement("p",{className:"list-group-item-text"}," ",t.item," ",t.description),n.a.createElement(A.a,{checked:s,onChange:function(a){e.togglePicked(t.id,a.target.checked)}},"Picked"))}))))))}}]),t}(s.Component);Boolean("localhost"===window.location.hostname||"[::1]"===window.location.hostname||window.location.hostname.match(/^127(?:\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}$/));var T=document.getElementById("root"),x=T.getAttribute("data-baseurl");l.a.render(n.a.createElement(C,{baseUrl:x}),T),"serviceWorker"in navigator&&navigator.serviceWorker.ready.then((function(e){e.unregister()}))}},[[124,1,2]]]);
//# sourceMappingURL=main.db86773c.chunk.js.map