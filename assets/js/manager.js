(function() {
    'use strict';

    $('.setting-delete').click(function(){
        if(confirm(i18n['confirm'])){
            deleteSetting($(this));
        }
    });
    
    function deleteSetting(element){
        $.ajax({
            url: element.data('href'),
            method: 'POST',
            dataType: 'json',
            cache: false,
            success: function(data, textStatus, jqXHR){
                if(data.result){
                    element.closest('.custom-setting-wr').remove();
                }
                else{
                    console.error('Something went wrong');
                }
            },
        });
    }
})();