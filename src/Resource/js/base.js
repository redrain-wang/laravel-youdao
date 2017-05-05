/**
 *
 * js file
 */

$(document).ready(function () {
    var KEYWORD = '';
    var container = $(".youdao_container");


    $(this).mouseup(function (e) {

        var txt;
        txt = window.getSelection();
        if (txt.toString().length > 1) {
            KEYWORD = txt.toString();
            if (KEYWORD === 'x') {
                return;
            }

            if(container.html() !== ''){
                return ;
            }
            var url = '/youdao/fanyi/get/' + KEYWORD;
            $.get(url, function (data) {
                var xx = e.originalEvent.x || e.originalEvent.layerX || 0;
                var yy = e.originalEvent.y || e.originalEvent.layerY || 0;
                container.append(data);
                container.css({"left": xx, 'top': yy, "display": "block"});
            });
        }

    });

    function recover() {
        container.css({"left": 0, 'top': 0, "display": "none"});
        container.html('');
    }

    $(document).click(function(){
        recover();
    });


    $(".voice_icon").on('click', function () {
        $.get('http://dict.youdao.com/dictvoice?audio=' + KEYWORD + '&type=1', function (data) {
            //
        });
    });

    //防止冒泡事件
    container.click(function(event){
        event.stopPropagation();
    });


    $(this).mousedown(function(e){
        if (window.getSelection) {
            if (!window.getSelection().empty) {  // Chrome
                window.getSelection().empty();
            } else if (window.getSelection().removeAllRanges) {  // Firefox
                window.getSelection().removeAllRanges();
            }
        } else if (document.selection) {  // IE?
            if(!document.selection.empty()){
                document.selection.empty();
            }
        }
    });

});