<?php

//getting the dboperation class
require_once '../includes/dboperation.php';

//function validating all the paramters are available
//we will pass the required parameters to this function
function isTheseParametersAvailable($params)
{
    //assuming all parameters are available
    $available = true;
    $missingparams = "";

    foreach ($params as $param) {
        if (!isset($_POST[$param]) || strlen($_POST[$param]) <= 0) {
            $available = false;
            $missingparams = $missingparams . ", " . $param;
        }
    }

    //if parameters are missing
    if (!$available) {
        $response = array();
        $response['error'] = true;
        $response['message'] = 'Parameters ' . substr($missingparams, 1, strlen($missingparams)) . ' missing';

        //displaying error
        echo json_encode($response);

        //stopping further execution
        die();
    }
}

//an array to display response
$response = array();

//if it is an api call
//that means a get parameter named api call is set in the URL
//and with this parameter we are concluding that it is an api call
if (isset($_GET['apicall'])) {

    switch ($_GET['apicall']) {

        //the CREATE operation
        //if the api call value is 'createhero'
        //we will create a record in the database


        /*----------------------------------------------Registreation-----------------------------------------------------------*/
        case 'register':
            //first check the parameters required for this request are available or not
            isTheseParametersAvailable(array('u_name', 'u_email', 'u_password', 'u_mob'));

            //creating a new dboperation object
            $db = new DbOperation();

            //creating a new record in the database
            $result = $db->Insert($_POST['u_name'], $_POST['u_email'], $_POST['u_password'], $_POST['u_mob']);

            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Inserted successfully';

            } else {
                //if record is not added that means there is an error
                $response['error'] = true;
                //and we have the error message
                $response['message'] = 'Some error occurred please try again';
            }

            break;

        /*----------------------------------------------Login-----------------------------------------------------------*/
        case 'login':

            isTheseParametersAvailable(array('u_email', 'u_password'));
            //creating a new dboperation object
            $db = new DbOperation();

            //creating a new record in the database
            $result = $db->Login(
                $_POST['u_email'],
                $_POST['u_password']
            );

            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Login successfully';

            } else {

                $response['error'] = true;
                $response['message'] = 'Invalid username or Password';
            }

            break;
        /*----------------------------------------------Add Category--------------------------------------------------------*/
        case 'add_category':

            isTheseParametersAvailable(array('category_name', 'user_id'));

            //creating a new dboperation object
            $db = new DbOperation();

            //creating a new record in the database
            $result = $db->AddCategory($_POST['category_name'], $_POST['user_id']);

            if ($result) {

                $response['error'] = false;
                $response['message'] = 'Category added successfully';

            } else {

                $response['error'] = true;
                $response['message'] = 'Something went wrong!!';
            }

            break;
        /*-------------------------------get Category---------------------------------*/
        case 'get_category':

            isTheseParametersAvailable(array('user_id'));

            //creating a new dboperation object
            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = 'Success';
            $response['categories'] = $db->getCategory($_POST['user_id']);

            break;
        /*-------------------------------get Already Set Amount---------------------------------*/

        case 'getAlreadySetAmount':

            isTheseParametersAvailable(array('user_id', 'date'));

            //creating a new dboperation object
            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = 'Success';
            $response['records'] = $db->GetAlreadySetAmount($_POST['user_id'], $_POST['date']);

            break;

        /*-------------------------------Monthly Overview---------------------------------*/

        case 'monthly_overview':

            isTheseParametersAvailable(array('user_id', 'date'));

            //creating a new dboperation object
            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = 'Success';
            $response['records'] = $db->MonthlyOverview($_POST['user_id'], $_POST['date']);

            break;

        /*-------------------------------get Login Data---------------------------------*/

        case 'login_data':


            isTheseParametersAvailable(array('u_email', 'u_password'));

            //creating a new dboperation object
            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = 'Success';
            $response['users'] = $db->getLoginData($_POST['u_email'], $_POST['u_password']);

            break;


        /*-------------------------------Set  Amount---------------------------------*/

        case 'setamount':


            isTheseParametersAvailable(array('category_id', 'user_id', 'amount_set'));

            //creating a new dboperation object
            $db = new DbOperation();

            //creating a new record in the database
            $result = $db->CategorySetAmount($_POST['category_id'], $_POST['amount_set'], $_POST['user_id']);

            if ($result == 0) {

                $response['error'] = false;
                $response['message'] = 'Amount set successfully';

            } else if ($result == 2) {

                $response['error'] = true;
                $response['message'] = 'Amount already set for this category';

            } else {

                $response['error'] = true;
                $response['message'] = 'Something went wrong';

            }

            break;
        /*--------------------------------------------Expense Amount--------------------------------------------------*/

        case 'expenseamount':


            isTheseParametersAvailable(array('category_id', 'set_amount_id', 'amount', 'u_id'));

            //creating a new dboperation object
            $db = new DbOperation();

            //creating a new record in the database
            $result = $db->CategoryExpensetAmount($_POST['category_id'], $_POST['set_amount_id'], $_POST['amount'], $_POST['u_id']);

            if ($result) {

                $response['error'] = false;
                $response['message'] = 'Amount Set successfully';

            } else {

                $response['error'] = true;
                $response['message'] = 'Something went wrong!!';
            }


            break;

        /*-------------------------------------------Delete category--------------------------------------------------*/

        case 'delete_category':


            isTheseParametersAvailable(array('category_id'));

            //creating a new dboperation object
            $db = new DbOperation();

            //creating a new record in the database
            $result = $db->DeleteCategory($_POST['category_id']);

            if ($result) {

                $response['error'] = false;
                $response['message'] = 'Category delete successfully';

            } else {

                $response['error'] = true;
                $response['message'] = 'Something went wrong!!';
            }

            break;


        /*-----------------------------------------------------CATEGORY VALUE----------------------------------------------------------*/
        case 'get_categoryval':

            isTheseParametersAvailable(array('category_id', 'user_id'));
            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = 'Success';
            $response['expenses'] = $db->getCategoryData($_POST['category_id'], $_POST['user_id']);

            break;
        /*-----------------------------------------------------Expense History VALUE----------------------------------------------------------*/
        case 'getExpenseHistory':

            isTheseParametersAvailable(array('user_id'));
            $db = new DbOperation();

            $response['error'] = false;
            $response['message'] = 'Success';
            $response['exphistory'] = $db->getExpenseData($_POST['user_id']);

            break;

    }

    echo json_encode($response);

}


?>