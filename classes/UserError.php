<?php

    class UserError
    {
        const ACCOUNT_NOT_FOUND = "Account not found, click Register to create one now!";
        const ACCOUNT_BANNED = "Account is banned, please contact <a hfref=\"mailto:admin@meetamour.ie\">admin@meetamour.ie</a>";

        const LOGIN_ERROR = "Incorrect username or password";

        const EMAIL_INVALID_FORMAT = "Invalid email!";
        const EMAIL_EXISTS = "Email already exists!";
        
        const USERNAME_INVALID_FORMAT = "Username must be at least 4 characters long and can only letters, numbers, underscores and dashes";
        const USERNAME_EXISTS = "Username already exists!";

        const PASSWORD_INVALID_FORMAT = "Password must be at least 8 characters long and contain at least one uppercase letter and one number.";
        const PASSWORD_MISMATCH = "Passwords do not match";
        const PASSWORD_INCORRECT = "Incorrect password";

        const NAME_SHORT = "Name is requred";
        const NAME_LONG = "Name is too long.";

        const DESCRIPTION_LONG = "Description too long.";
        
        const INVALID_DATE_OF_BIRTH = "There's a problem with your date of birth.";

        const IMAGE_LARGE = "Sorry, your file is too large.";
        const IMAGE_UNSUPPORTED = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";

        const GENERAL_ERROR = "There was an error processing your request, please try again later.";
        const PROFILE_UNAVAILABLE = "This profile is not available :(";

    }
?>