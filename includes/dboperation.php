<?php

class DbOperation
{
    //Database connection link
    private $con;

    //Class constructor
    function __construct()
    {
        //Getting the DbConnect.php file
        require_once dirname(__FILE__) . '/dbconnect.php';

        //Creating a DbConnect object to connect to the database
        $db = new DbConnect();

        //Initializing our connection link of this class
        //by calling the method connect of DbConnect class
        $this->con = $db->connect();
    }

    /*
    * The create operation
    * When this method is called a new record is created in the database
    */
    /*=============================================Register===========================================================*/
    function Insert($U_Name, $U_email, $U_password, $U_mob)
    {


        $stmt = "INSERT INTO `user_registration`(`u_name`, `u_email`, `u_password`, `u_mob`) VALUES('$U_Name','$U_email','$U_password','$U_mob')";
        $result = mysqli_query($this->con, $stmt);

        if ($result) {
            return true;
        } else {
            return false;
        }

    }

    /*=============================================Login===========================================================*/
    function Login($email, $password)
    {

        $q = "SELECT U_Name,U_password FROM user_registration where U_email='$email' and U_password='$password'";
        $result = mysqli_query($this->con, $q);
        $num = mysqli_num_rows($result);
        if ($num > 0) {

            return true;
        } else {
            return false;
        }

    }

    /*=============================================Add Category===========================================================*/
    function AddCategory($category_name, $user_id)
    {
        $stmt = "INSERT INTO `category`(`categories_name`,`U_id`) VALUES ('$category_name','$user_id')";
        $result = mysqli_query($this->con, $stmt);
        if ($result) {
            return true;
        } else {
            return false;
        }

    }

    /*--------------------------------Get Category---------------------------------------*/
    function getCategory($user_id)
    {
        $stmt = "SELECT category_id,categories_name FROM `category` where U_id = '$user_id'";
        $result = mysqli_query($this->con, $stmt);

        $outer = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $inner = array();
            $inner['categories_name'] = $row['categories_name'];
            $inner['category_id'] = $row['category_id'];
            array_push($outer, $inner);
        }
        return $outer;
    }

    /*--------------------------------Get ALready set Amount---------------------------------------*/

    function GetAlreadySetAmount($user_id, $date)
    {

        $stmt = "SELECT * FROM `category_set_amount` where user_id = '$user_id' and created_at BETWEEN '$date' AND LAST_DAY('$date')";

        $result = mysqli_query($this->con, $stmt);

        $outer = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $inner = array();
            $inner['set_amount_id'] = $row['set_amount_id'];
            $inner['category_id'] = $row['category_id'];
            $inner['category_name'] = $row['category_name'];
            $inner['amount_set'] = $row['amount_set'];

            array_push($outer, $inner);


        }

        return $outer;
    }

    /*-------------------------------------------------Monthly Overview---------------------------------------------------------*/

    function MonthlyOverview($user_id, $date)
    {
        $stmt = "SELECT category_name,amount_set,sum(amount_set) as sum FROM `category_set_amount`
                 where user_id = '$user_id' and created_at BETWEEN '$date' AND LAST_DAY('$date') GROUP BY(set_amount_id)";

        $result = mysqli_query($this->con, $stmt);
        $num = mysqli_num_rows($result);
        $outer = array();
        if ($num > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $inner = array();
                $inner['category_name'] = $row['category_name'];
                $inner['amount_set'] = $row['amount_set'];
                $inner['sum'] = $row['sum'];
                $inner['is_error'] = false;
                array_push($outer, $inner);
            }
            return $outer;
        } else {
            $inner = array();
            $inner['is_error'] = true;
            array_push($outer, $inner);
            return $outer;
        }

    }

    /*--------------------------------Get Login Data---------------------------------------*/

    function getLoginData($email, $password)
    {


        $stmt = "SELECT * FROM `user_registration` where U_email = '$email' and U_password = '$password'";

        $result = mysqli_query($this->con, $stmt);

        $outer = array();

        while ($row = mysqli_fetch_assoc($result)) {
//            $inner = array();
            $outer['u_id'] = $row['u_id'];
            $outer['u_name'] = $row['u_name'];
            $outer['u_email'] = $row['u_email'];
            $outer['u_password'] = $row['u_password'];
            $outer['u_mob'] = $row['u_mob'];

//            array_push($outer, $inner);
        }

        return $outer;

    }

    /*--------------------------------------Category set amount --------------------------------------*/


    function CategorySetAmount($category_id, $amount_set, $user_id)
    {
        $sql = "SELECT * FROM `category_set_amount` where category_id = '$category_id'";
        $rs = $this->con->query($sql);
        $num = mysqli_num_rows($rs);

        if ($num > 0) {
            return 2;
        }

        $stmt = "INSERT INTO `category_set_amount`(`category_id`, `amount_set`, `user_id`) VALUES('$category_id','$amount_set','$user_id')";
        $result = mysqli_query($this->con, $stmt);

        if ($result) {
            return 0;
        } else {
            return 1;
        }

    }

    /*--------------------------------------Category Get Amount --------------------------------------*/
    function getBudgetData($user_id)
    {
        $stmt = "SELECT category_set_amount.set_amount_id, category.categories_name, category_set_amount.amount_set FROM `category_set_amount` 
                 JOIN category ON category.category_id = category_set_amount.category_id WHERE user_id='$user_id'";
        $result = mysqli_query($this->con, $stmt);

        $outer = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $inner = array();
            $inner['set_amount_id'] = $row['set_amount_id'];
            $inner['categories_name'] = $row['categories_name'];
            $inner['amount_set'] = $row['amount_set'];
            array_push($outer, $inner);
        }

        return $outer;


    }

    /*--------------------------------------Expense set amount --------------------------------------*/
    function CategoryExpensetAmount($category_id, $set_amount_id, $amount, $user_id)
    {
        $stmt = "INSERT INTO `set_amount`(`amount`, `category_id`, `set_amount_id`, `u_id`) VALUES('$amount','$category_id','$set_amount_id','$user_id')";
        $result = mysqli_query($this->con, $stmt);

        if ($result) {
            return true;
        } else {
            return false;
        }

    }

    /*-----------------------------------------------Get Category Data-------------------------------------------------*/
    function getCategoryData($category_id, $user_id)
    {
        $stmt = "SELECT * FROM `category_set_amount` WHERE 	category_id='$category_id' AND 	user_id='$user_id'";
        $result = mysqli_query($this->con, $stmt);

        $outer = array();

        while ($row = mysqli_fetch_assoc($result)) {
//            $inner = array();
            $outer['set_amount_id'] = $row['set_amount_id'];
            $outer['category_id'] = $row['category_id'];
            $outer['amount_set'] = $row['amount_set'];
            $outer['user_id'] = $row['user_id'];
            $outer['created_at'] = $row['created_at'];
//            array_push($outer, $inner);
        }

        return $outer;


    }/*-----------------------------------------------Get Category Data-------------------------------------------------*/
    function getExpenseData($user_id)
    {
        $stmt = "SELECT sum(set_amt.amount) as amount, set_amt.amount_id,cat.category_id,cat.categories_name ,cat_set.amount_set FROM set_amount set_amt,category cat , category_set_amount cat_set 
                 WHERE set_amt.category_id = cat.category_id and cat.category_id = cat_set.category_id and set_amt.u_id='$user_id'
                 group by set_amt.category_id";
        $result = mysqli_query($this->con, $stmt);

        $outer = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $inner = array();
            $inner['amount_id'] = $row['amount_id'];
            $inner['category_id'] = $row['category_id'];
            $inner['amount'] = $row['amount'];
            $inner['amount_set'] = $row['amount_set'];
            $inner['categories_name'] = $row['categories_name'];
            array_push($outer, $inner);
        }
        return $outer;
    }

    /*---------------------------------------------Expense Detail------------------------------------------------------------*/
    function getExpenseDetail($user_id, $cat_id)
    {
        $stmt = "SELECT * FROM `set_amount` WHERE category_id = '$cat_id' and u_id = '$user_id'";
        $result = mysqli_query($this->con, $stmt);
        $outer = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $inner = array();
            $inner['amount_id'] = $row['amount_id'];
            $inner['amount'] = $row['amount'];
            $inner['amt_date'] = $row['amt_date'];
            array_push($outer, $inner);
        }
        return $outer;
    }

    /*---------------------------------------------Expense Update------------------------------------------------------------*/
    function UpdateExpense($a_id, $a_val)
    {
        $stmt = "UPDATE set_amount SET amount='$a_val' WHERE amount_id='$a_id'";
        $result = mysqli_query($this->con, $stmt);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /*-------------------------------------Update Category------------------------------------------------------------*/
    function UpdateCategory($category_id, $categories_name)
    {
        $stmt = "UPDATE category SET categories_name='$categories_name' WHERE category_id='$category_id'";

        $result = mysqli_query($this->con, $stmt);

        if ($result) {
            return true;
        } else {
            return false;
        }

    }

    /*-------------------------------------Update Budget------------------------------------------------------------*/
    function UpdateBudget($budget_id, $budget_Val)
    {
        $stmt = "UPDATE category_set_amount SET amount_set='$budget_Val' WHERE set_amount_id='$budget_id'";

        $result = mysqli_query($this->con, $stmt);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /*-------------------------------------------------ResetBudget Using ML----------------------------------------------------*/
    function ResetBudget($user_id)
    {
        $stmt = "UPDATE category_set_amount SET status='1' WHERE user_id='$user_id'";

        $result = mysqli_query($this->con, $stmt);
        if ($result) {
//
            $sql1 = 'SELECT sum(set_amt.amount) as amount, cat.category_id,cat.categories_name FROM
            set_amount set_amt,category cat , category_set_amount cat_set
            WHERE set_amt.category_id = cat.category_id and cat.category_id = cat_set.category_id and set_amt.u_id=' . $user_id . ' group by set_amt.category_id';

            $r1 = mysqli_query($this->con, $sql1);

            if ($r1->num_rows > 0) {
                while ($ro = mysqli_fetch_array($r1)) {

                    $amount_set = $ro['amount'];
                    //     echo "====";
                    $category_id = $ro['category_id'];

                    $sql2 = "UPDATE category_set_amount SET amount_set = '$amount_set' WHERE user_id = '$user_id' AND category_id = '$category_id'";

                    $r2 = mysqli_query($this->con, $sql2);

                    $sql3 = "UPDATE set_amount SET amount = '0' WHERE u_id = '$user_id' and category_id = '$category_id'";
                    $r3 = mysqli_query($this->con, $sql3);


                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /*-------------------------------------Forgot Password------------------------------------------------------------*/
    function ForgotPassword($email, $password, $v_otp)
    {
        /*OTP MODULE*/
//        $otp = rand(000000, 999999);
        $otp = 123456;
        if ($otp == $v_otp) {

            $stmt = "UPDATE user_registration SET u_password='$password' WHERE u_email='$email'";

            $result = mysqli_query($this->con, $stmt);
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}


?>