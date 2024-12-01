humhub.module("module_editor.tools", function(module, require, $)
{
    module.initOnPjaxLoad = true;

    var init = function(isPjax) {
        
        const defaultEx =
"^/\\\.\n^/tests\n^\\\.github\n^/build.*\\\.sh";
    
        var moduleSelect = $('#modulemessages-moduleid');
        var zipBtn = $('#download-zip-btn');
        var excludeInput = $('textarea[name="exclude-input"');
        var defExBtn = $('#default-exclude-button');
        var removeBtn = $('#remove-button');
        
        zipBtn.on("click", function() {
            try {
            var moduleId = moduleSelect.val();
            var exclude = excludeInput.val();
            exclude = exclude.replace(/^(?=\n)$|^\s*|\s*$|\n\n+/gm, "");//remove blank lines
            if (exclude !== '') {
                exclude = '(' + exclude.replace(/(?:\r\n|\r|\n)/g, ')|(') + ')';//combine to one regex
            }
            window.location.href = "/module-editor/tools/download-zip?moduleId=" + moduleId + "&exclude=" + exclude;
            } catch(err) {
                alert(err);
            }
        });
        
        defExBtn.on("click", function() {
            excludeInput.val(defaultEx);
        });
        
        removeBtn.on("click", function() {
            excludeInput.val('');
        });
        
        if(isPjax) {
        }
    };
    module.export({
        init: init
    });
});
