<?php
class Validation
{

    public static function validateUserInput($email, $contactNumber, $password, $confirmPassword)
    {
        $errors = [];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }

        if (!preg_match('/^0\d{9}$/', $contactNumber)) {
            $errors[] = "Phone must be a 10-digit and start with zero";
        }

        if (!preg_match("/^(?=.*\d)(?=.*[A-Z])(?=.*\W)(?!.*\s).{6,}$/", $password)) {
            $errors[] = "Password must\n
            1.Contains at least one digit\n  
            2.Contains at least one uppercase letter.\n 
            3.Contains at least one special character.\n
            4.Does not contain white spaces.\n
            5.Contains at least 6 characters.";
        }
        if ($password !== $confirmPassword) {
            $errors[] = "Passwords do not match.";
        }

        return $errors;
    }

    public static function validateServiceProviderInput($email, $contactNumber, $password, $confirmPassword, $businessName, $nicNumber, $whatsappNumber, $serviceAddress, $serviceType)
    {
        $errors = [];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }

        if (!preg_match('/^0\d{9}$/', $contactNumber)) {
            $errors[] = "Phone must be a 10-digit and start with zero";
        }

        if (!preg_match("/^(?=.*\d)(?=.*[A-Z])(?=.*\W)(?!.*\s).{6,}$/", $password)) {
            $errors[] = "Password must\n
            1.Contains at least one digit\n  
            2.Contains at least one uppercase letter.\n 
            3.Contains at least one special character.\n
            4.Does not contain white spaces.\n
            5.Contains at least 6 characters.";
        }
        if ($password !== $confirmPassword) {
            $errors[] = "Passwords do not match.";
        }

        if (empty($businessName)) {
            $errors[] = "Bussiness Name is required";
        }

        if (empty($nicNumber)) {
            $errors[] = "NIC is required";
        } elseif (!preg_match('/^\d{9}$|^\d{12}$/', $nicNumber)) {
            $errors[] = "NIC must be 9 or 12 digits";
        }

        if (empty($whatsappNumber)) {
            $errors[] = "Phone is required";
        } elseif (!preg_match('/^0\d{9}$/', $whatsappNumber)) {
            $errors[] = "Whatsapp Number must be a 10-digit and start with zero";
        }

        if (empty($serviceAddress)) {
            $errors[] = "Service address is required";
        }

        if (empty($serviceType)) {
            $errors[] = "Select Service Type";
        }

        return $errors;
    }
}
