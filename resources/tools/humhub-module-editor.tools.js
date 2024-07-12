humhub.module("module_editor.tools", function(module, require, $)
{
    module.initOnPjaxLoad = true;

    var init = function(isPjax) {
        
        var moduleSelect = $('#modulemessages-moduleid');
        var zipBtn = $('#download-zip-btn');
        var msgBtn = $('#messages-btn');
        var updateBtn = function() {
            if (moduleSelect.val()) {
                zipBtn.prop("href", "/module-editor/tools/download-zip?moduleId=" + moduleSelect.val());
                zipBtn.attr("disabled", false);
                msgBtn.attr("disabled", false);
            } else {
                zipBtn.attr("disabled", true);
                msgBtn.attr("disabled", true);
            }
        }
        
        updateBtn();
        
        moduleSelect.on( "change", function() {
            updateBtn();
        });
        
        if(isPjax) {
        }
    }
    module.export({
        init: init
    });
});
