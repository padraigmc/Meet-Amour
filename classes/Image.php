<?php   

require_once("User.php");

class Image
{

    public static function upload_user_image($dbConnection, $userID, $http_file_upload_array) 
    {
        $epoch_milli = round(microtime(true) * 1000);
        $target_dir = dirname(__DIR__) . "/" . User::USER_IMAGES;
        $supported_formats = array("jpg", "png", "jpeg", "gif");

        // if the user already has an image, delete it
        self::delete_user_image($dbConnection, $userID);

        // get file prefix and extension
        $filename_as_uploaded = $http_file_upload_array["name"];
        $file_prefix = pathinfo($http_file_upload_array["name"], PATHINFO_FILENAME);
        $file_extension = pathinfo($filename_as_uploaded, PATHINFO_EXTENSION);
        
        // build filename and path
        $filename = substr($file_prefix, 0, 30) . "_" . $epoch_milli . "." . $file_extension;
        $target_file = $target_dir . $filename;
        
        // Check if image file is areal image
        if(getimagesize($http_file_upload_array["tmp_name"]) === false) {
            $_SESSION[User::ERROR][] = UserError::IMAGE_UNSUPPORTED;
            return 0;
        }            
        
        // Check file size 2MB
        if ($http_file_upload_array["size"] > 2097152) {
            $_SESSION[User::ERROR][] = UserError::IMAGE_LARGE;
            return 0;
        }

        // Allow certain file formats
        if(!in_array($file_extension, $supported_formats)) {
            $_SESSION[User::ERROR][] = UserError::IMAGE_UNSUPPORTED . "test";
            return 0;
        }

        // try to move file to target folder
        if (move_uploaded_file($http_file_upload_array["tmp_name"], $target_file)) {
            $success = self::add_image_to_database($dbConnection, $userID, $filename);

        } else {
            $_SESSION[User::ERROR][] = UserError::GENERAL_ERROR;
            return 0;
        }
        return $success;
    }


    public static function get_user_image_filepath($dbConnection, $userID) 
    {
        if ($fileName = self::get_user_image_filename($dbConnection, $userID)) {
            return User::USER_IMAGE_DIR . $fileName;
        } else {
            return User::DEFAULT_USER_IMAGE;
        }
    }

    public static function delete_user_image($dbConnection, $userID) 
    {
        $fileName = self::get_user_image_filename($dbConnection, $userID);
        if ($fileName && self::delete_user_image_from_database($dbConnection, $fileName)) {
            $filePath = User::USER_IMAGE_DIR . $fileName;
            $success = self::delete_file($filePath);
        } else {
            $success = 0;
        }
        return $success;            
    }


    private static function get_user_image_filename($dbConnection, $userID) 
    {
        $fileName = null;
        $sql = "SELECT `fileName` FROM `Photo` 
                WHERE `userID` = ?;";
        
        if ($stmt = $dbConnection->prepare($sql)) {
            $stmt->bind_param("s", $userID);
            $stmt->execute(); 
            $stmt->bind_result($fileName);
            $stmt->fetch();
            $stmt->close();
        }

        if ($fileName && is_file(User::USER_IMAGE_DIR . $fileName)) {
            return $fileName;
        } else {
            return 0;
        }
    }

    private static function add_image_to_database($databaseConnection, $userID, $filename) {
        $dateUploaded = date("Y-m-d H:i:s");
        $sql = "INSERT INTO `Photo` (`userID`, `fileName`, `dateUploaded`) 
                VALUES (?, ?, ?);";

        if ($stmt = $databaseConnection->prepare($sql)) {
            $stmt->bind_param("sss", $userID, $filename, $dateUploaded);
            $stmt->execute();
            $sucess = $stmt->affected_rows;
            $stmt->close();
        } else {
            $sucess = 0;
        }
        return $sucess;            
    }

    private static function delete_user_image_from_database($dbConnection, $fileName) 
    {
        $sql = "DELETE FROM `Photo` 
                WHERE `fileName` = ?;";

        if ($stmt = $dbConnection->prepare($sql)) {
            $stmt->bind_param("s", $fileName);
            $stmt->execute();
            $success = $stmt->affected_rows;
            $stmt->close();
        } else {
            $success = 0;
        }
        return $success;
    }

    private static function delete_file($filePath) 
    {
        if (is_file($filePath)) {
            $success = unlink($filePath);
        } else {
            $success = 0;
        }
        return $success;
    }

}

?>