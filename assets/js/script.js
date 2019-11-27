(function() {
    'use strict';

    $('.setting-delete').click(function(){
        if(confirm(i18n['confirm'])){
            deleteSetting($(this).data('href'));
        }
    });
    
    function deleteSetting(href){
        $.ajax({
            url: href,
            method: 'GET',
            dataType: 'json',
            cache: false,
            success: function(data, textStatus, jqXHR){
                console.log(data);
            },
        });
    }
})();