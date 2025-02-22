humhub.module("module_editor.ace", function(module, require, $)
{
    module.initOnPjaxLoad = true;
    
    const theme = 'ace/theme/monokai';
    
    var mode;
    var userConfirmed;
    var isFirstChange;
    var submitButton;
    var editor;
    
    var msg = module.text("warning.notSaved");
    var buttonHelpText = $('.form-group .button-help-text');
    var buttonHelpTextContent = buttonHelpText.html();

    var init = function(isPjax) {

        var viewState = humhub.modules.ui.view.getState();
        if (viewState.moduleId !== 'module-editor' || viewState.controllerId !== 'editor') {
            return;
        }
        
        mode = module.config.mode;
        userConfirmed = false;
        isFirstChange = true;
        submitButton =  $("#file-editor-form button[type=submit]");
        editor = ace.edit("editor");
        editor.setTheme(theme);
        editor.session.setMode("ace/mode/" + mode);
        editor.session.setUseWrapMode(true);
        editor.session.setTabSize(4);
        editor.session.setUseSoftTabs(true);
        editor.setOption("showInvisibles", true);
        editor.session.on("changeAnnotation", onAnnotations);
        
        editor.session.on("change", function(delta){
            // Sync contents of editor with form
            document.forms["file-editor-form"]["FileEditor[content]"].value = editor.getValue();
            
            // Add event listeners on first change
            if (isFirstChange) {
                window.onbeforeunload = unloadListener;
                window.addEventListener("beforeunload", unloadListener);
                $(document).on("pjax:beforeSend", "**", pjaxBeforeListener);
                isFirstChange = false;
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
        
       // add command to lazy-load keybinding_menu extension
        editor.commands.addCommand({
            name: "showKeyboardShortcuts",
            bindKey: {win: "Ctrl-Alt-h", mac: "Command-Alt-h"},
            exec: function(editor) {
                ace.config.loadModule("ace/ext/keybinding_menu", function(module) {
                    module.init(editor);
                    editor.showKeyboardShortcuts();
                });
            }
        });

        if(isPjax) {
            // Remove event handlers
            $(document).off("pjax:beforeSend", "**");
            window.removeEventListener("beforeunload", unloadListener);
            window.onbeforeunload = null;
        }
    };
    
    var unloadListener = function() {
        return msg;
    };
    
    var pjaxBeforeListener = function(evt, xhr, options) {
        if (userConfirmed === false) {
            userConfirmed = confirm(msg);
        }
        return userConfirmed;
    };
    
    var onAnnotations = function() {
        if (mode !== 'php') {
            return;
        }
        var annots = editor.session.getAnnotations();
        submitButton.attr('disabled', null);
        buttonHelpText.html(buttonHelpTextContent);
        for (var key in annots){
            if (annots.hasOwnProperty(key) && annots[key].type == 'error') {
                submitButton.attr('disabled', '');
                buttonHelpText.html(module.text("warning.solveErrors"));
                    break;
            }
        }
    };
    
    var unload = function($pjax) {
        // Remove event handlers
        $(document).off("pjax:beforeSend", "**");
        window.removeEventListener("beforeunload", unloadListener);
        window.onbeforeunload = null;
    };
    
    module.export({
        init: init,
        unload: unload
    });
});
