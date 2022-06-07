/*!
 * Bootstrap-select v1.11.2 (http://silviomoreto.github.io/bootstrap-select)
 *
 * Copyright 2013-2016 bootstrap-select
 * Licensed under MIT (https://github.com/silviomoreto/bootstrap-select/blob/master/LICENSE)
 */

(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module unless amdModuleId is set
    define(["jquery"], function (a0) {
      return (factory(a0));
    });
  } else if (typeof exports === 'object') {
    // Node. Does not work with strict CommonJS, but
    // only CommonJS-like environments that support module.exports,
    // like Node.
    module.exports = factory(require("jquery"));
  } else {
    factory(jQuery);
  }
}(this, function (jQuery) {

(function ($) {
  $.fn.selectpicker.defaults = {
    noneSelectedText: '沒有選中任何項',
    noneResultsText: '沒有找到匹配項',
    countSelectedText: '選中{1}中的{0}項',
    maxOptionsText: ['超出限制 (最多選擇{n}項)', '組選擇超出限制(最多選擇{n}組)'],
    multipleSeparator: ', '
  };
})(jQuery);


}));
