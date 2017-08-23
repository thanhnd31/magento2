define(['jquery'],function ($) {
    var messageComponent = function(config,node){
        $(node).append('<span>Node id: '+$(node).attr('id')+'</span><br/>');
        $(node).append('<span>'+config.message+'</span>');
    }

    return messageComponent;
});