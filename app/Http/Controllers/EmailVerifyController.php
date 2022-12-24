<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use Egulias\EmailValidator\Validation\NoRFCWarningsValidation ;

class EmailVerifyController extends Controller
{
    //

    public function index(Request $req)
    {
        $validator = new EmailValidator();
        $multipleValidations = new MultipleValidationWithAnd([
            new RFCValidation(),
            new DNSCheckValidation(),
            new NoRFCWarningsValidation(),
        ]);

        $red = $validator->isValid("b@gmail.com", $multipleValidations);

        return $red;
    }
}
