/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/admin/attachments/index.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/admin/attachments/index.js":
/*!****************************************!*\
  !*** ./src/admin/attachments/index.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }\n\nfunction _nonIterableSpread() { throw new TypeError(\"Invalid attempt to spread non-iterable instance\"); }\n\nfunction _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === \"[object Arguments]\") return Array.from(iter); }\n\nfunction _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }\n\n(function () {\n  window.addEventListener('load', function () {\n    addListeners();\n  });\n\n  function addListeners() {\n    window.addEventListener('click', checkModal);\n  }\n\n  function checkModal() {\n    var modal = document.querySelector('.media-modal.wp-core-ui');\n\n    if (modal != null) {\n      var visible = window.getComputedStyle(modal.parentElement).display === \"none\" ? false : true;\n      var details = modal.querySelector('.attachment-details') === null ? false : true;\n      var isSidebar = modal.querySelector('.media-sidebar') === null ? false : true;\n      var isAudio = document.querySelector('#audioByline') === null ? false : true;\n\n      if (visible && details) {\n        modifyModal(modal, isSidebar, isAudio);\n      }\n    }\n  }\n\n  function modifyModal(modal, isSidebar, isAudio) {\n    console.log('modify this modal!', isSidebar, isAudio);\n    var details = modal.querySelector('.attachment-details');\n\n    if (details.getAttribute('data-modified') === 'true') {\n      return;\n    }\n\n    if (isAudio) {\n      var settings = modal.querySelectorAll('.setting');\n\n      _toConsumableArray(settings).forEach(function (setting) {\n        if (setting.getAttribute('data-setting') != 'title') {\n          setting.setAttribute('style', 'display: none');\n        }\n      });\n\n      var required = modal.querySelector('.media-types.media-types-required-info');\n      required.setAttribute('style', 'display: none');\n    }\n\n    if (isSidebar === true) {\n      console.log('is sidebar!');\n      modal.querySelector('.thumbnail.thumbnail-audio').remove();\n    } else {\n      var info = details.querySelector('.attachment-info');\n      var specs = info.querySelector('.details').cloneNode(true);\n      info.querySelector('.details').remove();\n      info.insertBefore(specs, info.querySelector('.actions'));\n    }\n\n    details.setAttribute('data-modified', 'true');\n  }\n})();\n\n//# sourceURL=webpack:///./src/admin/attachments/index.js?");

/***/ })

/******/ });