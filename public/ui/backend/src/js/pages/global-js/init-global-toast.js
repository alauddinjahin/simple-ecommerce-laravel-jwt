

function successToast(obj)
{
    try {
        $.toast({
			text				: obj.text,
			heading				: obj.heading, 
			icon				: obj.icon, 
			showHideTransition	: 'fade',
			allowToastClose		: true,
			hideAfter			: obj.timer,
			stack				: 5, 
			position			: obj.position,
			textAlign			: 'left',
			loader				: true,
			loaderBg			: '#9EC600',
			bgColor				: obj.bgColor,
			beforeShow			: function () {},
			afterShown			: function () {}, 
			beforeHide			: function () {},
			afterHidden			: function () {}
		});
    } catch (error) {
        console.error(error);
    }
}


function errorToast(obj)
{
    try {
        $.toast({
			text				: obj.text,
			heading				: obj.heading, 
			icon				: obj.icon, 
			showHideTransition	: 'fade',
			allowToastClose		: true,
			hideAfter			: obj.timer,
			stack				: 5, 
			position			: obj.position,
			textAlign			: 'left',
			loader				: true,
			loaderBg			: '#790606',
			bgColor				: obj.bgColor,
			beforeShow			: function () {},
			afterShown			: function () {}, 
			beforeHide			: function () {},
			afterHidden			: function () {}
		});
    } catch (error) {
        console.error(error);
    }
}


function warningToast(obj)
{
    try {
        $.toast({
			text				: obj.text,
			heading				: obj.heading, 
			icon				: obj.icon, 
			showHideTransition	: 'fade',
			allowToastClose		: true,
			hideAfter			: obj.timer,
			stack				: 5, 
			position			: obj.position,
			textAlign			: 'left',
			loader				: true,
			loaderBg			: '#e84408',
			bgColor				: obj.bgColor,
			beforeShow			: function () {},
			afterShown			: function () {}, 
			beforeHide			: function () {},
			afterHidden			: function () {}
		});
    } catch (error) {
        console.error(error);
    }
}