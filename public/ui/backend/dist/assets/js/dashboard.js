
$(document).ready(function(){

    $.each($(this).find('.animate'),function(i,el){

        switch (i) {
            case 0:
                $(el).zoomIn(200);
                break;
            case 1:
                $(el).zoomIn(400);
                break;
            case 2:
                $(el).zoomIn(500);
                break;
            case 3:
                $(el).zoomIn(700);
                break;
        }
    })
});