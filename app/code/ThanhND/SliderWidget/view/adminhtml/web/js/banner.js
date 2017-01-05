require(['jquery'], function($){
    $(document).ready(function()
    {
        var fileLabel = '<span>Browse Image</span>';
        $('.admin__control-file').parent().append(fileLabel);
        $('.admin__control-file').css('position','fixed');
    });
});