
$(document).ready(function(){

        $('#category_id').select2({data:[], placeholder:'SELECT A CATEGORY'}).val(null).trigger('change');
        $('#subcategory_id').select2({data:[], placeholder:'SELECT A SUB CATEGORY'}).val(null).trigger('change');

        // eventListener
        getItemCategory();
        $(document).on('change','#category_id', getItemSubcategory);
        $(document).on('click','#add-product',addData);
        $(document).on('click','.fa-edit',editData);
        $(document).on('click','#form-submit',addItems);
        $(document).on('change', '#image', readFile);
        $(document).on('click', '#form-reset', refreshForm);
        $(document).on('click','#form-submit-edit',updateItems);

        // init dataTable 
		load_dataTable({
            tableId         : '#itemsListTable',
            lengthMenu      : [12, 25, 50, 75, 100, 250, 500, 1000],
            data            : [],
            columns		    : [],
            dom             : "Bflrtip",
            paging			: false,
            scrollY         : 500,
            scrollCollapse  : true,
            drawCallback    : true,
            fnRowCallback   : true,
            responsive      : true,
            columnDefs      : [],
            order           : [],
            attr            : ['data-items']
        });


});
    
//--------------------------------------------------------



function readFile() 
{
    if (this.files && this.files[0]) 
    {
		var FR = new FileReader();
		FR.addEventListener("load", function(e) {
			$(document).find('#product-img-b64').val(e.target.result);
			$(document).find('#product-img-preview').attr('src', e.target.result);
        }); 
        
		FR.readAsDataURL( this.files[0] );
	}
}



function formData()
{
    let 
        obj                 = {};
        obj.category_id     = $('#category_id').val(),
        obj.subcategory_id  = $('#subcategory_id').val(),
        obj.title           = $('#title').val(),
        obj.description     = $('#description').val(),
        obj.unit_price      = Number($('#unit_price').val()),
        obj.image           = $('#product-img-b64').val();
        return obj;
}


function addItems(e)
{
        if (e) e.preventDefault();
        if (e.stopPropagation) e.stopPropagation();

         console.log(formData());
        $.ajax({
            url         : CREATE_ITEM,
            method      : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : formData(),
            beforeSend  : function()
            {
                console.log('sending...');
            },
            success     : function(res)
            {
                leaveSuccessMessage(res.msg);
                $('#product-modal').modal('hide');
                $(document).find('#itemsListTable>tbody').prepend(renderSingleRow(res.data));
                refreshForm();
            },
            error       : function(err)
            {
                console.log(err)
                leaveErrorMessage(err.responseJSON.msg??null);
            }

             
        })
    

}


// ------------- updateItems -----------------------

function updateItems()
{
    let 
        obj             = formData();
        obj.product_id  = $(this).attr('data-id');

        console.log(obj)

    $.ajax({
        url         : UPDATE_ITEM,
        method      : 'POST',
        cache       : false,
        crossDomain : true,
        dataType    : 'json',
        data        : obj,
        success     : function(res){

            $('#product-modal').modal('hide');
            $(document).find(`tr[data-itemid="${res.data.id}"]`).replaceWith(renderSingleRow(res.data));
            leaveSuccessMessage(res.msg);
            refreshForm();
        },
        error       : function(err)
        {
            console.error(err);
            leaveErrorMessage(err.responseJSON.msg);
        }
    });

}


// ------------- updateItems -----------------------


//-------------- renderSingleRow ------------------

function renderSingleRow(v=null)
{

    let single_row = `<tr data-row="${v.id}" data-json=${JSON.stringify(v)} data-itemId="${v.id}" data-categoryId="${v.category_id}" data-subcategoryId="${v.subcategory_id }">
                        <td>${v.id}</td>
                        <td>${ v.category.category_title ?? ''}</td>
                        <td>${ v.subcategory.subcategory_title ?? ''}</td>
                        <td>${ v.title ?? ''}</td>
                        <td class="text-center">
                            <img style="width: 80px; height: 80px;" src="/products/${ v.image ?? '' }" alt="product image">
                        </td>
                        <td>${ v.unit_price ?? '' }</td>
                        <td>${ (v.created_by) != null ? v.created_by.name :'' }</td>
                        <td data-itemId="${v.id}" data-categoryId="${v.category_id}" data-subcategoryId="${v.subcategory_id }" class="text-center"><i class="fa fa-edit" style="color: #ac4c05;"></i></td>
                    </tr>`;

    return single_row;
}
//-------------- renderSingleRow ------------------



//-------------- refreshItemsForm ------------------

function refreshForm()
{
    $('#product-form')[0].reset();
    $("#category_id").val(null).trigger('change');
    $("#subcategory_id").val(null).trigger('change');
}
//-------------- refreshItemsForm ------------------





function getItemCategory(selector="category_id",state=null)
{

    $.get(CATEGORY_LIST, function(res){
        $(`#${selector} option`).remove();
        $(`#${selector}`).select2({
            data:res.data, 
            placeholder:'SELECT A CATEGORY'
        }).val(state).trigger('change');
    });
    
}



function getItemSubcategory(e,subcategory='subcategory_id',state=null)
{
    let 
    category_id = $('#category_id').val(),
    params      = { "category_id" : category_id };

    $.get(SUBCATEGORY_LIST, params, function(res){
        if(res.success && res.msg != '*')
        {
            $(`#${subcategory} option`).remove();
            $(`#${subcategory}`).select2({
                data:res.data, 
                placeholder:'SELECT A SUBCATEGORY'
            }).val(state).trigger('change');
        }
    });


}



// ---------- load store -------------------------------

// ---------- Show Entry form ------------------------

function showEntryForm()
{
    $('#product-modal').modal('show');
}
// ---------- Show Entry form ------------------------


function addData()
{
    $('#product-img-preview').attr('src','/images/blank-user.jpg');
    $("button#form-submit-edit").attr('id','form-submit');
    $(document).find('#product-img-b64').val("");
    refreshForm();
    showEntryForm();
}



function editData()
{

    refreshForm();

    let data = JSON.parse($(this).closest('tr').attr('data-json'));
    let src  = /products/+data.image;

    $("button#form-submit").attr('id','form-submit-edit');
    $("button#form-submit-edit").attr('data-id',data.id);

    $('#title').val(data.title);
    $('#description').val(data.description);
    $('#unit_price').val(data.unit_price);
    $('#product-img-preview').attr('src',src);

    getItemCategory(selector="category_id",data.category_id);
    setTimeout(function(){
        getItemSubcategory(null, subcategory='subcategory_id',data.subcategory_id);
    },1000)

    showEntryForm();
}

