/**
 *
 * js file
 */

var KEYWORD = '';
$(document).ready(function () {
    var container = $(".youdao_container");
    $(this).mouseup(function (e) {
        recover();
        var txt;
        txt = window.getSelection();
        if (txt.toString().length > 1) {
            KEYWORD = keyWord = txt.toString();
            if(keyWord === 'x'){
                return;
            }
            var url = '/youdao/fanyi/get/' + keyWord;
            $.get(url, function (data) {
                var xx = e.originalEvent.x || e.originalEvent.layerX || 0;
                var yy = e.originalEvent.y || e.originalEvent.layerY || 0;
                container.append(data);
                container.css({"left": xx, 'top': yy, "display": "block"});
            });

        };

        $(".youdao_close").on('click', function () {
            recover();
        });

        $(".voice_icon").on('click', function(){
            $.get('http://dict.youdao.com/dictvoice?audio='+ KEYWORD +'&type=1', function(data){
                //
            });
        });

        function recover()
        {
            container.css({"left": 0, 'top': 0, "display": "none"});
            container.html('');
        }

    });

});