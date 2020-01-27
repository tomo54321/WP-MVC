### Wordpress MVC Theme Framework
This project probably shouldn't be used in production just yet.

If you would like to add / maintain the framework please feel free to fork this repository and submit a pull request :) 

## How to setup
Currently, cloning this repo won't work please follow the below steps to get setup.

 - Create an `inc` folder in your theme (If you don't have one already)
 - Clone this repo to a `wpmvc` folder inside the `inc` folder you just created.
 - Move the `Helper` file into the `inc` folder
 - Inside of the `inc` folder create the following folders: `config`, `Controllers`, `Emails`, `Models` and `Views`
 - Inside of the `config` folder create a `mail.php` file and paste the [email config](#Email-Config-File) into it and fill in your email server credentials or run the `php Helper config:mail` to generate the file.
 - You're ready to begin using!
 
 ## Using Helper CLI
 The Helper CLI can be used in the `inc` folder by running the following command `php Helper`. The helper is able to generate Models, Controllers, Email Templates, Wordpress Pages/Categories/Archives and more... 
 
 Run `php Helper` to view a list of commands you can use along with how you can use them.
 
 ## Routing
 To begin creating your first route open the page of choice ex. `page.php` in your theme directory.
 
 Then be sure to first of include the framework into the page, you can do this by putting the following in at the top of the page under your `<?php` tag `include_once("inc/wpmvc/run.php");`.
 
 Next you'll need to tell `php` to use the WPMVC Route class by putting underneath the include statement, `use WPMVC\Core\Route;`
 
 Then there are two functions to load in required Models and Emails (if you use them), this can by done with the following:`load_models(["ModelFileNameWithoutPHP"]);` and `load_emails(["EmailFileNameWithoutPHP"]);`
 
 Then finally implement your route: `Route::get("SomeController", "show")` the usage is `Route::get("ControllerClassName", "Function in Controller")`.
 
 ***Route only currently supports `get` and `post` functions.***
 
 Your page should now look something like this:
 ```php
 <?php
 include_once("inc/wpmvc/run.php");
 use WPMVC\Core\Route;

 load_models(["User"]);//Load models used
 load_emails(["UserSignUpEmail"]);//Load emails used

 Route::get("SomeController", "show");
 Route::post("SomeController", "update");
 ```
 
 ## Controllers
 Controllers are very easy to use, all functions called from `Route` will pass a `Request` object with request headers and parameters.
 To generate a controller simply run `php Helper make:controller [ControllerName]`
 Controllers **MUST** extend `WPMVC\Core\Controller`.
 
 To display a view simply return `$this->view("view path")`, replace slashes(***/***) with dots(***.***).

 
 ## Models
 Generate a model using `php Helper make:model [name]`
 
 The table name defaults to the Models class name however this can be overriden with the `get_table` function like:
 ```php
 /**
 * Override table name
 */
public static function get_table(){
 return "TableName";//Tables name
}
 ```
 
 If you don't have a primary key in your table you will need to use the `primary_key` function and return null. We will automatically find the primary key or you can return the columns name as a `string` an example:
 
 ```php
/**
* Override the find function's row
* Required if no primary key is present in table
*/
protected static function primary_key(){
 return "id";//Column Name
}
 ```
 
 If you would like to have a `created_at` and `updated_at` column in your table you may find that the `Timestamps` trait will help.
 Begin by adding this to your model, `use WPMVC\Database\Traits\Timestamps;` then within the model's class simply add:
 ```php
 use Timestamps;//Auto fill the 'created_at' and 'updated_at' column
 ```
 
 An example model using timestamps looks like this:
 
 ```php
 <?php
namespace App;

use WPMVC\Database\Model;
use WPMVC\Database\Traits\Timestamps;
class Testing extends Model{

    use Timestamps;//Auto fill the 'created_at' and 'updated_at' column
    

    /**
     * Override table name
     */
    public static function get_table(){
        return "TableName";
    }

    /**
     * Override the find function's row
     * Required if no primary key is present in table
     */
    protected static function primary_key(){
        return "id";
    }

}
 ```
 
 ## Email Config File
 ```php
 <?php
/**
 * Email configuration
 * Use this file to specify connection details and other
 * settings to connect to your mail server
 * 
 * @package WPMVC
 */

/**
 * There is a variable set before the file 
 * is included to prevent direct loads of 
 * the file and leaking of mail server info. (That could be bad D:)
*/
if(!isset($WPMVC_ENV) || $WPMVC_ENV!==true){
    http_response_code(401);
    echo "Access Denied.";
    exit;
}

$config = array(

    /**
     * WPMVC Emails are powered by PHPMailer
     * for variables you can use, take a look here:
     * https://github.com/PHPMailer/PHPMailer
    */
    "SERVER"=>array(
        "Host"=>"smtp.mailtrap.io",         //The Mail Server Host
        "SMTPAuth"=>true,                   //Enable SMTP authentication
        "Username"=>"",                     //SMTP Username
        "Password"=>"",                     //SMTP Password
        "Port"=>587,                        //TCP port to connect to
    ),

    /**
     * These aren't part of PHPMailer
     * Do not refer to their documentation for this section onwards.
    */
    "FROM_EMAIL_ADDRESS"=>"user@example.com",
    "FROM_MAIL_NAME"=>"My Name",

);

 ```
