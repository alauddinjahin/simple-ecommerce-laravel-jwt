$(document).ready(function(){
    

    //eventlistener
    $(document).on('click','#add-new-category',formattingAddnewBtn);
    $(document).on('click','#categoryForm #form-reset',resetForm);

    $(document).on('click','#form-submit',addnewCategory);
    $(document).on('click','.fa-edit',getEditableContent);
    $(document).on('click','#form-submit-edit',editCategory);



    // init dataTable 
    load_dataTable({
        tableId         : '#categories-table',
        lengthMenu      : [15, 25, 50, 75, 100, 250, 500, 1000],
        data            : [],
        columns		    : [],
        paging			: true,
        drawCallback    : true,
        fnRowCallback   : true,
        responsive      : true,
        columnDefs      : [],
        order           : [],
        attr            : ['data-categories']
    });
    

});


// category func start from here 

function formattingAddnewBtn()
{
    $("button#form-submit-edit").attr('id','form-submit');
    resetForm();
}




function addnewCategory()
{
    $.ajax({
        url         : CREATE_CATEGORY,
        method      : 'post',
        data        : getFormData(),
        dataType    : 'json',
        beforeSend  : function(){ submitBtn('loading') },
        success     : addnewCategoryOnSuccess,
        error       : function(err){ leaveErrorMessage(err.responseJSON.msg) },
        complete    : function(){ submitBtn('reset') }
    });
}



function getFormData()
{
    let obj={}
    obj.category_title          = $('#category_title').val(),
    obj.category_description    = $("#categoryForm textarea[name=category_description]").val(),
    obj.is_active               = Number($('#is_active').prop('checked'));
    
    return obj;
}




function addnewCategoryOnSuccess(res,state,reqinfo){
    $('#categories-table>tbody').prepend(renderSingleRow(res.data));
    leaveSuccessMessage(res.msg);
    resetForm();
    $(document).find('.dataTables_empty').parent().remove();
    
}



function renderSingleRow(data)
{
    let switch_on   = Boolean(Number(data.is_active)) ? "<i class='mdi mdi-record text-success'>Active</i>" : "<i class='mdi mdi-record text-danger'>Inactive</i>",
        dataStatus  = Boolean(Number(data.is_active)) ? "active" : "inactive",

        new_row = `
                <tr data-categoryId="${data.id}" data-status="${dataStatus}">
                    <td>${data.category_title}</td>
                    <td>${data.category_description??''}</td>
                    <td>${switch_on}</td>
                    <td class="text-center" data-categoryId="${data.id}">
                        <i class="fa fa-edit"></i>
                    </td>
                </tr>
            `;

    return new_row;
}


function submitBtn(state)
{
    if(state='reset')
        $('#form-submit').prop('disabled', false).html(`<i class="fa fa-save"></i> SAVE`);

    else if(state='loading')
        $('#form-submit').prop('disabled', true).html(`<i class="fa fa-sync fa-spin"></i> Processing...`);
    
}



function resetForm()
{
    $('#categoryForm')[0].reset();
    $("textarea[name=category_description]").text('');
}



function getEditableContent(e)
{

    resetForm();
    
    $("button#form-submit").attr('id','form-submit-edit');

    let row             = $(this).closest('tr'),
        status          = row.data('status'),
        dataCategoryId  = row.data('categoryid'),
        selectStatus    = $("input[name=is_active]"),
        arrayOftd       = [];

        $("button#form-submit-edit").attr('data-categoryid',dataCategoryId);
        $('.active-row').removeClass('active-row');
        row.addClass('active-row');

        arrayOftd = [...$(row).find('td')];
        arrayOftd.pop();

    $.each(arrayOftd,function(i,td){
        let v = td.textContent || td.innerText;
        switch(i)
        {
            case 0:
                $("input[name=category_title]").val(v);
            break;

            case 1: 
                $("textarea[name=category_description]").text(v);
            break;

            case 2: 
                String(status).toLowerCase() == 'active' ? selectStatus.prop('checked',true) : selectStatus.prop('checked',false);
            break;
        }


    });
}





// edit func will start from here 

function editCategory()
{
    let data = getFormData();
        data.category_id = $(this).attr('data-categoryid');

    $.ajax({
        url         : UPDATE_CATEGORY,
        method      : 'post',
        data        : data,
        dataType    : 'json',
        beforeSend  : function(){ submitBtn('loading') },
        success     : renderOnExistingRow,
        error       : function(err) { 
            console.log(err)
            leaveErrorMessage(err.responseJSON.msg??null) 
        },
        complete    : function(){ submitBtn('reset') }
    });

}


function renderOnExistingRow(res)
{
    let categoryId  = $('#form-submit-edit').attr('data-categoryid'),
        presentRow  = $(document).find(`tr[data-categoryid="${categoryId}"]`).replaceWith(renderSingleRow(res.data));
        leaveSuccessMessage(res.msg);
        resetForm();
        $("button#form-submit-edit").attr('id','form-submit');
}
