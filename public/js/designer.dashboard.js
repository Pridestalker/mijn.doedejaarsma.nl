(window.webpackJsonp=window.webpackJsonp||[]).push([[4],{543:function(e,t,n){e.exports=n(548)},548:function(e,t,n){"use strict";n.r(t);var r,o=n(9),a=n(49),u=n(10),c=n.n(u),i=n(13),s=n(151),f=n(139),p=n(152),l=n(259),y=n(85);function d(e){return(d="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}function v(e){return(v="function"==typeof Symbol&&"symbol"===d(Symbol.iterator)?function(e){return d(e)}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":d(e)})(e)}function b(e,t,n,r,o,a,u){try{var c=e[a](u),i=c.value}catch(e){return void n(e)}c.done?t(i):Promise.resolve(i).then(r,o)}function m(e){return function(){var t=this,n=arguments;return new Promise((function(r,o){var a=e.apply(t,n);function u(e){b(a,r,o,u,c,"next",e)}function c(e){b(a,r,o,u,c,"throw",e)}u(void 0)}))}}function g(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function h(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}function _(e,t){return!t||"object"!==v(t)&&"function"!=typeof t?w(e):t}function j(e){return(j=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)})(e)}function w(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}function O(e,t){return(O=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e})(e,t)}function S(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}var k=Object(i.default)({components:{TitleComponent:f.default,CardContainer:s.default}})(r=function(e){function t(){var e,n;g(this,t);for(var r=arguments.length,o=new Array(r),a=0;a<r;a++)o[a]=arguments[a];return S(w(n=_(this,(e=j(t)).call.apply(e,[this].concat(o)))),"user",{}),S(w(n),"User",y.userModule),n}var n,r,o,a,u;return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),t&&O(e,t)}(t,e),n=t,(r=[{key:"mounted",value:(u=m(c.a.mark((function e(){return c.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,this.fetchData();case 2:case"end":return e.stop()}}),e,this)}))),function(){return u.apply(this,arguments)})},{key:"fetchData",value:(a=m(c.a.mark((function e(){return c.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,this.User.loadUser();case 2:this.user=e.sent,console.log(this.user);case 4:case"end":return e.stop()}}),e,this)}))),function(){return a.apply(this,arguments)})},{key:"today",get:function(){return Object(p.a)(new Date,"cccc dd MMMM YYYY",{awareOfUnicodeTokens:!0,locale:l.a})}},{key:"randomProject",get:function(){return this.user.projects.aangevraagd.data[Math.floor(Math.random()*this.user.projects.aangevraagd.count)]}}])&&h(n.prototype,r),o&&h(n,o),t}(o.default))||r,P=n(8),x=Object(P.a)(k,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("card-container",[n("title-component",[e._v("\n        Welkom, "+e._s(e.user.name)+"\n    ")]),e._v(" "),n("small",{staticClass:"text-muted"},[e._v("Het is vandaag "+e._s(e.today))]),e._v(" "),e.user.projects?n("section",[e.user.projects.aangevraagd.count>5?n("p",[e._v("\n            Het is vandaag druk met "+e._s(e.user.projects.aangevraagd.count)+" aanvragen die nog niet zijn opgepakt.\n        ")]):e.user.projects.aangevraagd.count>=2?n("p",[e._v("\n            Het is vandaag redelijk druk met "+e._s(e.user.projects.aangevraagd.count)+" aanvragen die nog niet zijn opgepakt.\n        ")]):e.user.projects.aangevraagd.count>0?n("p",[e._v("\n            Er is nog maar "+e._s(e.user.projects.aangevraagd.count)+" aanvraag.\n        ")]):n("p",[e._v("\n            Er zijn geen aanvragen.\n        ")])]):e._e(),e._v(" "),n("section",[n("title-component",{attrs:{size:"large"}},[e._v("Gegevens")]),e._v(" "),n("p",[e._v("\n            E-mail: "+e._s(e.user.email)+"\n        ")])],1),e._v(" "),e.user.projects?n("section",[n("title-component",{attrs:{size:"large"}},[e._v("Aanvragen")]),e._v(" "),e.user.projects.aangevraagd.count>1?n("p",[e._v("\n            Niks te doen? Probeer dit project anders eens\n            "),n("a",{attrs:{href:"/products#/single/"+e.randomProject.id}},[e._v("\n                "+e._s(e.randomProject.name)+"\n            ")])]):1==e.user.projects.aangevraagd.count?n("p",[e._v("\n            Niks te doen? Probeer dit project anders eens\n            "),n("a",{attrs:{href:"/products#/single/"+e.user.projects.aangevraagd.data[0].id}},[e._v("\n                "+e._s(e.user.projects.aangevraagd.data[0].name)+"\n            ")])]):e._e()],1):e._e()],1)}),[],!1,null,"73f09377",null).exports;o.default.use(a.a);var E,M=[{path:"/",name:"index",component:x}],C=new a.a({routes:M});function T(e){return(T="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}function z(e){return(z="function"==typeof Symbol&&"symbol"===T(Symbol.iterator)?function(e){return T(e)}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":T(e)})(e)}function U(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function Y(e,t){return!t||"object"!==z(t)&&"function"!=typeof t?function(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}(e):t}function D(e){return(D=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)})(e)}function H(e,t){return(H=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e})(e,t)}var $=Object(i.default)(E=function(e){function t(){return U(this,t),Y(this,D(t).apply(this,arguments))}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),t&&H(e,t)}(t,e),t}(o.default))||E,A=Object(P.a)($,(function(){var e=this.$createElement,t=this._self._c||e;return t("main",[t("router-view")],1)}),[],!1,null,"06740732",null).exports;window.addEventListener("load",(function(){new o.default({router:C,render:function(e){return e(A)}}).$mount("#profile-dashboard")}))}},[[543,0,1]]]);