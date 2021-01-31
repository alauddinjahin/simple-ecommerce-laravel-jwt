function timestamp(expectedFormat=null)
{
    let date 	= new Date(),
    fullYear 	= date.getFullYear(),
    month 		= date.getMonth(),
    currentDate	= date.getDate(),
    h			= date.getHours(),
    m			= date.getMinutes(),
    s			= date.getSeconds(),
    format		= "am";

    if(h===0) h=12; format='pm';

    if(h>12) h=h-12;

    y	= fullYear<10 ? '0'+fullYear : fullYear;
    mon	= month<10 ? '0'+month : month;
    d  	= currentDate<10 ? '0'+currentDate : currentDate;

    hours	= h<10 ? '0'+h : h;
    minutes = m<10 ? '0'+m : m;
    seconds	= s<10 ? '0'+s : s;
    fTime 	= `${hours}:${minutes}:${seconds}`;

    
    let formattedDate = expectedFormat=="db_time"? y+'-'+mon+'-'+d+' '+fTime : d+'/'+mon+'/'+y+' '+fTime+' '+format;
    return String(formattedDate);
}


function gettime()
{
    var date 	= new Date(),
        newdate = (date.getHours() % 12 || 12) + "_" + date.getMinutes() + "_" + date.getSeconds();
    return newdate;
}

function printWebPage()
{
    window.print();
}



// init dataTable Globally
function load_dataTable(obj={})
{

    let dataTableObj = {
        responsive 		: obj.hasOwnProperty('responsive')? obj.responsive : true,
        columnDefs		: obj.hasOwnProperty('columnDefs')? obj.columnDefs : [],
        lengthMenu		: obj.hasOwnProperty('lengthMenu')? obj.lengthMenu : [10, 25, 50, 75, 100, 250, 500, 1000],
        order			: obj.hasOwnProperty('order')? obj.order : [   [ 2, 'desc' ]  ],
        data			: obj.hasOwnProperty('data') && obj.data.length>0? obj.data : false,
        columns		    : obj.hasOwnProperty('columns') && obj.columns.length>0 ? obj.columns : null,
        buttons         : obj.hasOwnProperty('buttons') ? obj.buttons : [],
        dom             : obj.hasOwnProperty('dom') ? obj.dom : 'Bflrtip',
        // pagingType      : "full_numbers",
        scrollCollapse	: obj.hasOwnProperty('scrollCollapse')? obj.scrollCollapse : false,
        paging			: obj.hasOwnProperty('paging')? obj.paging : false,
        fnRowCallback	: function(nRow, aData, iDisplayIndex) {
            nRow.setAttribute('id',aData.id);
            var tblAttr = obj.hasOwnProperty('attr')? obj.attr : [];
            nRow.setAttribute(tblAttr[0],JSON.stringify(aData));
        },
        footerCallback : obj.hasOwnProperty('footerCallback')? obj.footerCallback : function (row, data, start, end, display) {},
    };


    // extra param init 
    if(obj.hasOwnProperty('scrollY') && obj.scrollY) dataTableObj.scrollY = obj.scrollY;




    var table = $(obj.tableId).DataTable( dataTableObj );

    // $(obj.tableId+' tbody')
    // .on( 'mouseenter', 'td', function () {
    //     var colIdx = table.cell(this).index().column;
    //     if(colIdx && colIdx != undefined)
    //     {
    //         $( table.cells().nodes() ).removeClass( 'highlight' );
    //         $( table.column( colIdx ).nodes() ).addClass( 'highlight' );
    //     }
    // } );


}


// select2 single init
function load_select2(obj={}){
    try {

        if(obj.hasOwnProperty('selector'))
        {
            let selector    = obj.selector,
                res_data    = obj.hasOwnProperty('res_data') ? obj.res_data : [],
                selectedVal = obj.hasOwnProperty('selectedVal') ? obj.selectedVal : null;

            $(selector).select2({
                data        : res_data,
                placeholder : obj.hasOwnProperty('placeholder') ? obj.placeholder : 'SELECT AN ITEM',
                multiple    : obj.hasOwnProperty('multiple') ? obj.multiple : false,
                tags        : obj.hasOwnProperty('tags') ? obj.tags : false,
                theme       : obj.hasOwnProperty('theme') ? obj.theme : "default",
            }).val(selectedVal).trigger('change');

        }else{
            throw ('SELECTOR IS MISSING');
        }    
        
    } catch (error) {
        console.error(error);
    }
}



function leaveSuccessMessage(msg=null)
{
    successToast({
        text 	: msg !== null ? msg : "Successfully Done!",
        icon	: "success",
        heading	: "Success",
        position: "top-right",
        bgColor	: "#35a837",
        timer 	: 3000
    }); 

}


function leaveErrorMessage(msg=null)
{
    errorToast({
        text 	: msg !== null ? msg : "Please try again!",
        icon	: "error",
        heading	: "Error",
        position: "top-right",
        bgColor	: "#ac0707",
        timer 	: 3000
    }); 

}


function leaveWarningMessage(msg=null)
{
    warningToast({
        text 	: msg !== null ? msg : "Something wents wrong!",
        icon	: "error",
        heading	: "Error",
        position: "top-right",
        bgColor	: "coral",
        timer 	: 3000
    }); 

}



