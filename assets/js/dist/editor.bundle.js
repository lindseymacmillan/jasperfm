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
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/editor/index.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/editor/blocks/audio-block/index.js":
/*!************************************************!*\
  !*** ./src/editor/blocks/audio-block/index.js ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\nvar blocks = wp.blocks;\nvar element = wp.element;\nvar data = wp.data;\n\nvar registerAudioBlock = function registerAudioBlock() {\n  var el = element.createElement,\n      registerBlockType = blocks.registerBlockType,\n      withSelect = data.withSelect;\n  registerBlockType('jfm-blocks/audio', {\n    title: 'Audio',\n    icon: 'microphone',\n    category: 'widgets',\n    edit: withSelect(function (select) {\n      return {\n        posts: select('core').getEntityRecords('postType', 'post')\n      };\n    })(function (props) {\n      if (!props.posts) {\n        return \"Loading...\";\n      }\n\n      if (props.posts.length === 0) {\n        return \"No posts\";\n      }\n\n      var className = props.className;\n      var post = props.posts[0];\n      return el('a', {\n        className: className,\n        href: post.link\n      }, post.title.rendered);\n    }),\n    save: function save() {\n      return null;\n    }\n  });\n};\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (registerAudioBlock);\n\n//# sourceURL=webpack:///./src/editor/blocks/audio-block/index.js?");

/***/ }),

/***/ "./src/editor/blocks/dynamic-block/index.js":
/*!**************************************************!*\
  !*** ./src/editor/blocks/dynamic-block/index.js ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\nvar blocks = wp.blocks;\nvar element = wp.element;\nvar data = wp.data;\n\nvar registerDynamicBlock = function registerDynamicBlock() {\n  var el = element.createElement,\n      registerBlockType = blocks.registerBlockType,\n      withSelect = data.withSelect;\n  registerBlockType('gutenberg-examples/example-05-dynamic', {\n    title: 'Example: last post',\n    icon: 'megaphone',\n    category: 'widgets',\n    edit: withSelect(function (select) {\n      return {\n        posts: select('core').getEntityRecords('postType', 'post')\n      };\n    })(function (props) {\n      if (!props.posts) {\n        return \"Loading...\";\n      }\n\n      if (props.posts.length === 0) {\n        return \"No posts\";\n      }\n\n      var className = props.className;\n      var post = props.posts[0];\n      return el('a', {\n        className: className,\n        href: post.link\n      }, post.title.rendered);\n    }),\n    save: function save() {\n      return null;\n    }\n  });\n};\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (registerDynamicBlock);\n\n//# sourceURL=webpack:///./src/editor/blocks/dynamic-block/index.js?");

/***/ }),

/***/ "./src/editor/blocks/index.js":
/*!************************************!*\
  !*** ./src/editor/blocks/index.js ***!
  \************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _dynamic_block__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./dynamic-block */ \"./src/editor/blocks/dynamic-block/index.js\");\n/* harmony import */ var _audio_block__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./audio-block */ \"./src/editor/blocks/audio-block/index.js\");\n\n\n\nvar registerBlocks = function registerBlocks() {\n  Object(_audio_block__WEBPACK_IMPORTED_MODULE_1__[\"default\"])();\n  Object(_dynamic_block__WEBPACK_IMPORTED_MODULE_0__[\"default\"])();\n};\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (registerBlocks);\n\n//# sourceURL=webpack:///./src/editor/blocks/index.js?");

/***/ }),

/***/ "./src/editor/index.js":
/*!*****************************!*\
  !*** ./src/editor/index.js ***!
  \*****************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./blocks */ \"./src/editor/blocks/index.js\");\n\n\n(function () {\n  Object(_blocks__WEBPACK_IMPORTED_MODULE_0__[\"default\"])();\n  wp.domReady(function () {\n    wp.blocks.unregisterBlockType('core/audio');\n  });\n})();\n\n//# sourceURL=webpack:///./src/editor/index.js?");

/***/ })

/******/ });