humhub.module("module_editor", function(module, require, $)
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
        
        var buildDom = require("ace/lib/dom").buildDom;
        var refs = {};
        var updateToolbar = function() {
            refs.undoButton.disabled = !editor.session.getUndoManager().hasUndo();
            refs.redoButton.disabled = !editor.session.getUndoManager().hasRedo();
        
            buildDom(["div", { class: "toolbar" },
              ["button", {
                ref: "undoButton",
                onclick: function() {
                    editor.undo();
                }
              }, "undo"],
              ["button", {  
                ref: "redoButton",
                onclick: function() {
                    editor.redo();
                }
              }, "redo"],
            ], document.body, refs);
            document.body.appendChild(editor.container);
        };
        //editor.on("input", updateToolbar);

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
    
    module.export({
        init: init
    });
});
