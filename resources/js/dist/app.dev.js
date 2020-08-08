"use strict";

var _vue = _interopRequireDefault(require("vue"));

var _vueRouter = _interopRequireDefault(require("vue-router"));

var _BookComponent = _interopRequireDefault(require("./components/Book/BookComponent.vue"));

var _LoanComponent = _interopRequireDefault(require("./components/Loan/LoanComponent.vue"));

var _UserComponent = _interopRequireDefault(require("./components/User/UserComponent.vue"));

var _NavBar = _interopRequireDefault(require("./components/GenericComponents/NavBar.vue"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

window.addEventListener('load', function () {
  _vue["default"].use(_vueRouter["default"]);

  _vue["default"].component('nav-bar', _NavBar["default"]);

  var router = new _vueRouter["default"]({
    mode: 'history',
    base: '/',
    routes: [{
      path: "/",
      redirect: "/user"
    }, {
      path: '/book',
      component: _BookComponent["default"]
    }, {
      path: '/loan',
      component: _LoanComponent["default"]
    }, {
      path: '/user',
      component: _UserComponent["default"]
    }, {
      path: '*',
      component: _UserComponent["default"]
    }]
  });

  _vue["default"].extend();

  new _vue["default"]({
    router: router
  }).$mount('#main-app');
});