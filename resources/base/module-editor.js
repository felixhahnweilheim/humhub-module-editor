humhub.module("module_editor", function(module, require, $)
{
    module.initOnPjaxLoad = true;
    
    var init = function(isPjax) {
        // Redirect if another module is chosen
        var moduleDropDown = $('#module-editor-topbar #module-editor-module-dropdown');
        if (moduleDropDown.length) {
            moduleDropDown.on("change", function(e) {
                var val = $('#module-editor-topbar #module-editor-module-dropdown select').select2('data')[0].id;
                window.location.href = location.pathname + '?moduleId=' + val;
            });
        }
        
        var navHeading = $('.module-editor-nav-heading');
        var navContent = $('#file-nav-content-main');
        
        if (window.screen.width >= 768) {
            navContent.css('display', 'block');
        }
        
        navHeading.click(function(e) {
            if (e.target.tagName.toLowerCase() == 'a') return;
            if (navContent.css('display') == 'none') {
                navContent.css('display', 'block');
            } else {
                navContent.css('display', 'none');
            }
        });
        
        // Close navigator if focus lost
        $('.module-editor-nav').on( "focusout", function(e) {
            var el = this;
            if (!el.contains(e.relatedTarget)) {
                el.open = false;
            }
        });
    };
    module.export({
        init: init
    });
});