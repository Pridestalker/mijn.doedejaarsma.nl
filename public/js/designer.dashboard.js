(window.webpackJsonp=window.webpackJsonp||[]).push([[4],{146:function(t,e,n){t.exports=n(152)},152:function(t,e,n){"use strict";n.r(e);var r,o=n(6),a=n(19),u=n(8),c=n.n(u),i=n(9),s=n(59),f=n(47),p=n(60),l=n(88),y=n(69);function d(t){return(d="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}function v(t){return(v="function"==typeof Symbol&&"symbol"===d(Symbol.iterator)?function(t){return d(t)}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":d(t)})(t)}function b(t,e,n,r,o,a,u){try{var c=t[a](u),i=c.value}catch(t){return void n(t)}c.done?e(i):Promise.resolve(i).then(r,o)}function m(t){return function(){var e=this,n=arguments;return new Promise(function(r,o){var a=t.apply(e,n);function u(t){b(a,r,o,u,c,"next",t)}function c(t){b(a,r,o,u,c,"throw",t)}u(void 0)})}}function g(t,e){for(var n=0;n<e.length;n++){var r=e[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(t,r.key,r)}}function h(t){return(h=Object.setPrototypeOf?Object.getPrototypeOf:function(t){return t.__proto__||Object.getPrototypeOf(t)})(t)}function _(t,e){return(_=Object.setPrototypeOf||function(t,e){return t.__proto__=e,t})(t,e)}function j(t){if(void 0===t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return t}function w(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var O=Object(i.default)({components:{TitleComponent:f.default,CardContainer:s.default}})(r=function(t){function e(){var t,n,r,o;!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,e);for(var a=arguments.length,u=new Array(a),c=0;c<a;c++)u[c]=arguments[c];return r=this,n=!(o=(t=h(e)).call.apply(t,[this].concat(u)))||"object"!==v(o)&&"function"!=typeof o?j(r):o,w(j(j(n)),"user",{}),w(j(j(n)),"User",y.userModule),n}var n,r,a;return function(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function");t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,writable:!0,configurable:!0}}),e&&_(t,e)}(e,o["default"]),n=e,(r=[{key:"mounted",value:function(){var t=m(c.a.mark(function t(){return c.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,this.fetchData();case 2:case"end":return t.stop()}},t,this)}));return function(){return t.apply(this,arguments)}}()},{key:"fetchData",value:function(){var t=m(c.a.mark(function t(){return c.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,this.User.loadUser();case 2:this.user=t.sent,console.log(this.user);case 4:case"end":return t.stop()}},t,this)}));return function(){return t.apply(this,arguments)}}()},{key:"today",get:function(){return Object(p.a)(new Date,"cccc dd MMMM YYYY",{awareOfUnicodeTokens:!0,locale:l.a})}},{key:"randomProject",get:function(){return this.user.projects.aangevraagd.data[Math.floor(Math.random()*this.user.projects.aangevraagd.count)]}}])&&g(n.prototype,r),a&&g(n,a),e}())||r,S=n(7),k=Object(S.a)(O,function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("card-container",[n("title-component",[t._v("\n        Welkom, "+t._s(t.user.name)+"\n    ")]),t._v(" "),n("small",{staticClass:"text-muted"},[t._v("Het is vandaag "+t._s(t.today))]),t._v(" "),t.user.projects?n("section",[t.user.projects.aangevraagd.count>5?n("p",[t._v("\n            Het is vandaag druk met "+t._s(t.user.projects.aangevraagd.count)+" aanvragen die nog niet zijn opgepakt.\n        ")]):t.user.projects.aangevraagd.count>=2?n("p",[t._v("\n            Het is vandaag redelijk druk met "+t._s(t.user.projects.aangevraagd.count)+" aanvragen die nog niet zijn opgepakt.\n        ")]):t.user.projects.aangevraagd.count>0?n("p",[t._v("\n            Er is nog maar "+t._s(t.user.projects.aangevraagd.count)+" aanvraag.\n        ")]):n("p",[t._v("\n            Er zijn geen aanvragen.\n        ")])]):t._e(),t._v(" "),n("section",[n("title-component",{attrs:{size:"large"}},[t._v("Gegevens")]),t._v(" "),n("p",[t._v("\n            E-mail: "+t._s(t.user.email)+"\n        ")])],1),t._v(" "),t.user.projects?n("section",[n("title-component",{attrs:{size:"large"}},[t._v("Aanvragen")]),t._v(" "),t.user.projects.aangevraagd.count>1?n("p",[t._v("\n            Niks te doen? Probeer dit project anders eens\n            "),n("a",{attrs:{href:"/products#/single/"+t.randomProject.id}},[t._v("\n                "+t._s(t.randomProject.name)+"\n            ")])]):1==t.user.projects.aangevraagd.count?n("p",[t._v("\n            Niks te doen? Probeer dit project anders eens\n            "),n("a",{attrs:{href:"/products#/single/"+t.user.projects.aangevraagd.data[0].id}},[t._v("\n                "+t._s(t.user.projects.aangevraagd.data[0].name)+"\n            ")])]):t._e()],1):t._e()],1)},[],!1,null,"73f09377",null).exports;o.default.use(a.a);var P,x=[{path:"/",name:"index",component:k}],E=new a.a({routes:x});function M(t){return(M="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}function C(t){return(C="function"==typeof Symbol&&"symbol"===M(Symbol.iterator)?function(t){return M(t)}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":M(t)})(t)}function T(t,e){return!e||"object"!==C(e)&&"function"!=typeof e?function(t){if(void 0===t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return t}(t):e}function z(t){return(z=Object.setPrototypeOf?Object.getPrototypeOf:function(t){return t.__proto__||Object.getPrototypeOf(t)})(t)}function U(t,e){return(U=Object.setPrototypeOf||function(t,e){return t.__proto__=e,t})(t,e)}var Y=Object(i.default)(P=function(t){function e(){return function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,e),T(this,z(e).apply(this,arguments))}return function(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function");t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,writable:!0,configurable:!0}}),e&&U(t,e)}(e,o["default"]),e}())||P,D=Object(S.a)(Y,function(){var t=this.$createElement,e=this._self._c||t;return e("main",[e("router-view")],1)},[],!1,null,"06740732",null).exports;window.addEventListener("load",function(){new o.default({router:E,render:function(t){return t(D)}}).$mount("#profile-dashboard")})}},[[146,0,1]]]);