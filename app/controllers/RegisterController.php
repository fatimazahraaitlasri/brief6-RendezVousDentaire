<?php

class RegisterController
{


    public function __construct()
    {
        $this->patientModel = new Patient();
    }
    public function index()
    {

        if (isPostRequest())
        {
            $reference = generateRandomString();
            $data = ["reference" => $reference, ...$_POST];
            
            $patient = $this->patientModel->create($data);
            if ($patient) {
                return view("register", ["ref" => $reference]);
            }
        } 
        else
        {
            return view("register");
        }
    }

}

        // ??????????????????????????????????????????????????????????????????????????

       