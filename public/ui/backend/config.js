
// -------------- baseURL & Route prefix -------------
const baseURL       = window.location.origin;
const prefixRoute   = '/dashboard';


// ------------------------ category --------------------------------

const CATEGORY_URL                      = baseURL + prefixRoute + '/categories';
const CATEGORY_LIST                     = CATEGORY_URL + '/list';
const CREATE_CATEGORY                   = CATEGORY_URL + '/create';
const UPDATE_CATEGORY                   = CATEGORY_URL + '/update';



// ------------------------ Subcategory --------------------------
const SUBCATEGORY_URL                   = baseURL + prefixRoute + '/subcategories';
const SUBCATEGORY_LIST                  = SUBCATEGORY_URL + '/list';
const CREATE_SUBCATEGORY                = SUBCATEGORY_URL + '/create';
const UPDATE_SUBCATEGORY                = SUBCATEGORY_URL + '/update';


// ----------------------  items -----------------------------------

const ITEMS_LIST_URL                    = baseURL + prefixRoute + '/products';
const SINGLE_ITEM                       = ITEMS_LIST_URL + '/single-item';
const CREATE_ITEM                       = ITEMS_LIST_URL + '/create';
const UPDATE_ITEM                       = ITEMS_LIST_URL + '/update';
const ITEMS_BY_CATEGORY_AND_SUBCATEGORY = ITEMS_LIST_URL + '/category/subcategory';
// ----------------------  items -----------------------------------
