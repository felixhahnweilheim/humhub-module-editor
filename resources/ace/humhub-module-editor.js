humhub.module("module_editor", function(module, require, $)
{
    module.initOnPjaxLoad = true;

    var init = function(isPjax) {
        var editor = ace.edit("editor");
        editor.setTheme("ace/theme/monokai");
        editor.session.setMode("ace/mode/" + module.config.mode);
        editor.session.setUseWrapMode(true);
        editor.session.setTabSize(4);
        editor.session.setUseSoftTabs(true);
        editor.setOption("showInvisibles", true);
        
        var msg = module.text("warning.notsaved");
        var userConfirmed = false;
        var unloadListener = function() {
            return msg;
        };
        var pjaxBeforeListener = function(evt, xhr, options) {
            if (userConfirmed === false) {
                userConfirmed = confirm(msg);
            }
            return userConfirmed;
        };
        var isFirstChange = 1;
        
        editor.session.on("change", function(delta){
            // Sync contents of editor with form
            document.forms["file-editor-form"]["FileEditor[content]"].value = editor.getValue();
            
            // Add event listeners on first change
            if (isFirstChange === 1) {
                window.onbeforeunload = unloadListener;
                window.addEventListener("beforeunload", unloadListener);
                $(document).on("pjax:beforeSend", "**", pjaxBeforeListener);
                isFirstChange = 0;
            }
        });
        
        // Do not warn if form is submitted
        $( "#file-editor-form" ).on( "submit", function( event ) {
            window.removeEventListener("beforeunload", unloadListener);
            window.onbeforeunload = null;
        });
        
        // Save on Ctrl+S
        $(document).bind("keyup keydown", function(e){
            if(e.ctrlKey && e.which == 83){
                $("#file-editor-form button[type=submit]").click();
                e.preventDefault();
            }
        });
        
        if(isPjax) {
            // Remove event handlers
            $(document).off("pjax:beforeSend", "**");
            window.removeEventListener("beforeunload", unloadListener);
            window.onbeforeunload = null;
        }
    }
    module.export({
        init: init
    });
});
