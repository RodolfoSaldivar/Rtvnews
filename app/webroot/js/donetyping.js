;(function($){$.fn.extend({donetyping:function(callback,timeout){timeout=timeout||1e3;var timeoutReference,doneTyping=function(el){if(!timeoutReference)return;timeoutReference=null;callback.call(el);};return this.each(function(i,el){var $el=$(el);$el.is(':input')&&$el.on('keyup keypress paste',function(e){if(e.type=='keyup'&&e.keyCode!=8)return;if(timeoutReference)clearTimeout(timeoutReference);timeoutReference=setTimeout(function(){doneTyping(el);},timeout);}).on('blur',function(){doneTyping(el);});});}});})(jQuery);function ponerFocus(input) {var length_texto=input.val().length;input.focus();input[0].setSelectionRange(length_texto,length_texto);}