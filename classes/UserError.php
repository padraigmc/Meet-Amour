<?php

    class UserError
    {
        const ACCOUNT_NOT_FOUND = "Account not found, click Register to create one now!";
        const ACCOUNT_BANNED = "Account is banned, please contact <a hfref=\"mailto:admin@meetamour.ie\">admin@meetamour.ie</a>";

        const LOGIN_ERROR = "Incorrect username or password";

        const EMAIL_INVALID_FORMAT = "Invalid email!";
        const EMAIL_EXISTS = "Email already exists!";
        
        const USERNAME_INVALID_FORMAT = "Username contains an illegal character! Only letters, numbers, underscores and dashes (-) allowed!";
        const USERNAME_EXISTS = "Username already exists!";

        const PASSWORD_INVALID_FORMAT = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number and one special character.";
        const PASSWORD_MISMATCH = "Passwords do not match";
        const PASSWORD_INCORRECT = "Incorrect password";

        const NAME_SHORT = "Name is requred";
        const NAME_LONG = "Name is too long.";

        const DESCRIPTION_LONG = "Description too long.";

    }
?>