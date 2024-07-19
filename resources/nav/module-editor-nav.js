humhub.module("module_editor.nav", function(module, require, $)
{
    module.initOnPjaxLoad = true;
    
    var init = function(isPjax) {
        // Close navigator if focus lost
        $('.module-editor-nav').on( "focusout", function(e) {
            var el = this;
            if (!el.contains(e.relatedTarget)) {
                el.open = false;
            }
        });
    }
    module.export({
        init: init
    });
});