$(document).ready(function(){

    // init select2 with data 
    $.get(CATEGORY_LIST, loadCategoryListData);


    //eventlistener

    $(document).on('click','#add-new-subcategory',formattingAddnewBtn);
    $(document).on('click','#subcategoryForm #form-reset',resetForm);

    $(document).on('click','#form-submit',addnewSubcategory);
    $(document).on('click','.fa-edit',getEditableContent);
    $(document).on('click','#form-submit-edit',updateSubcategory);

    // init dataTable 
    load_dataTable({
        tableId         : '#subcategories-table',
        lengthMenu      : [15, 25, 50, 75, 100, 250, 500, 1000],
        data            : [],
        columns		    : [],
        // scrollY         : 600,
        // scrollCollapse  : true,
        paging			: true,
        drawCallback    : true,
        fnRowCallback   : true,
        responsive      : true,
        columnDefs      : [],
        order           : [],
        attr            : ['data-subcategories']
    });

   
    

});


function loadCategoryListData(res)
{
    if(res.success)
    {
        load_select2({
            selector    :'#subcategoryForm #category_id',
            placeholder : 'SELECT A CATEGORY',
            res_data    : res.data,
            theme       : "default",
        });

    }else
    {
        leaveErrorMessage(res.msg ??'Unable to load store!');
    }
}


// subcategory create func start from here 

function formattingAddnewBtn()
{
    $("button#form-submit-edit").attr('id','form-submit');
    resetForm();
}


function addnewSubcategory()
{
    $.ajax({
        url         : CREATE_SUBCATEGORY,
        method      : 'post',
        data        : getFormData(),
        dataType    : 'json',
        beforeSend  : function(){ submitBtn('loading') },
        success     : addnewSubcategoryOnSuccess,
        error       : function(err){ leaveErrorMessage(err.responseJSON.msg) },
        complete    : function(){ submitBtn('reset') }
    });
}



function getFormData()
{
    let obj={}
    obj.category_id             = $('#category_id').val(),
    obj.subcategory_title       = $('#subcategory_title').val(),
    obj.subcategory_description = $("#subcategoryForm textarea[name=subcategory_description]").val(),
    obj.is_active               = Number($('#is_active').prop('checked'));
    console.log(obj)
    return obj;
}




function addnewSubcategoryOnSuccess(res,state,reqinfo){
    $('#subcategories-table>tbody').prepend(renderSingleRow(res.data));
    leaveSuccessMessage(res.msg);
    resetForm();
    $(document).find('.dataTables_empty').parent().remove();
    
}



function renderSingleRow(data)
{
    let switch_on   = Boolean(Number(data.is_active)) ? "<i class='mdi mdi-record text-success'>Active</i>" : "<i class='mdi mdi-record text-danger'>Inactive</i>",
        dataStatus  = Boolean(Number(data.is_active)) ? "active" : "inactive",

        new_row = `
                <tr data-categoryId="${data.category_id}" data-subcategoryId="${data.id}" data-status="${dataStatus}">
                    <td>${data.categories.category_title}</td>
                    <td>${data.subcategory_title}</td>
                    <td>${data.subcategory_description??''}</td>
                    <td>${switch_on}</td>
                    <td class="text-center" data-categoryId="${data.category_id}" data-subcategoryId="${data.id}">
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
    $('#subcategoryForm')[0].reset();
    $("textarea[name=subcategory_description]").text('');
    $("#category_id").find('option:selected').removeAttr('selected');
    $('#category_id').val(null).change();
}




function getEditableContent(e)
{
    resetForm();
    
    $("button#form-submit").attr('id','form-submit-edit');

    let row                 = $(this).closest('tr'),
        status              = row.data('status'),
        dataCategoryId      = row.data('categoryid'),
        dataSubcategoryId   = row.data('subcategoryid'),
        selectStatus        = $("input[name=is_active]"),
        arrayOftd           = [];

    $("button#form-submit-edit").attr('data-subcategoryid',dataSubcategoryId);
    $('.active-row').removeClass('active-row');
        row.addClass('active-row');

        arrayOftd = [...$(row).find('td')];
        arrayOftd.pop();

    $.each(arrayOftd,function(i,td){
        let v = td.textContent || td.innerText;

        switch(i)
        {
            case 0: 
                $("#category_id").val(dataCategoryId).trigger('change');
                if($('#category_id').val() == null)
                {
                    leaveErrorMessage(`This Category may be Inactive!`);
                    return false;
                }
            break;
            case 1: $("input[name=subcategory_title]").val(v);
            break;
            case 2: $("textarea[name=subcategory_description]").text(v);
            break;
            case 3: 
                String(status).toLowerCase() == 'active' ? selectStatus.prop('checked',true) : selectStatus.prop('checked',false);
            break;
        }
    });
}


// edit func will start from here 

function updateSubcategory()
{
    let data = getFormData();
        data.subcategory_id = $(this).attr('data-subcategoryid');

    $.ajax({
        url         : UPDATE_SUBCATEGORY,
        method      : 'post',
        data        : data,
        dataType    : 'json',
        beforeSend  : function(){ submitBtn('loading') },
        success     : renderOnExistingRow,
        error       : function(err) { leaveErrorMessage(err.responseJSON.msg) },
        complete    : function(){ submitBtn('reset') }
    });

}


function renderOnExistingRow(res)
{
    let subcategoryId     = $('#form-submit-edit').attr('data-subcategoryid'),
        presentRow  = $(document).find(`tr[data-subcategoryid="${subcategoryId}"]`).replaceWith(renderSingleRow(res.data));
        leaveSuccessMessage(res.msg);
        resetForm();
        $("button#form-submit-edit").attr('id','form-submit');
}