<?php
include "Database\db_config.php";
?>
<div class="card-header">
    <h2>Register User</h2>
</div>
<div class="card-body">
    <form action="register.php" method="post" enctype="multipart/form-data">
        <label>User Name</label><br>
        <input type="text" id="username" name="username"><br>
        <label>Email</label><br>
        <input type="text" id="email" name="email"><br>
        <label>Password</label><br>
        <input type="text" id="password" name="password"><br>
        <label>Date Of Birth</label><br>
        <input type="date" id="dateofbirth" name="dateofbirth"><br>
        <label>Please Select an Image:</label><br>
        <input type="file" id="myfile" name="myfile"><br>
        <button type="submit">Register</button>
    </form>
</div>

<?php

$name = $email =  $password=  $dob = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["myfile"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    if (isset($_FILES["myfile"]) && $_FILES["myfile"]["error"] == 0) {
        if ($_FILES["myfile"]["size"] > 2097152) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
    
        // Allow certain file formats
        $allowedTypes = ["jpg", "jpeg", "png"];
        if (!in_array($fileType, $allowedTypes)) {
            echo "Sorry, only JPG, JPEG, PNG files are allowed.";
            $uploadOk = 0;
        }
    
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // Attempt to move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES["myfile"]["name"])) . " has been uploaded.";
                $uploadOk = 2;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "No file was uploaded or there was an upload error.";
    }



    $name = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $dob = $_POST["dateofbirth"];
    $errors = [];

    if (IsNullOrEmptyString($name)) {
        $errors[] = "Username cannot be empty.";
    }
    if (IsNullOrEmptyString($email)) {
        $errors[] = "Email cannot be empty.";
    }
    if (IsNullOrEmptyString($password)) {
        $errors[] = "Password cannot be empty.";
    }
    if (IsNullOrEmptyString($dob)) {
        $errors[] = "Date of birth cannot be empty.";
    }

    if (empty($errors)) {
        $email_result = IsEmailValid($email);
        if ($email_result !== true) {
            $errors[] = $email_result;
        }

        $password_result = passwordChk($password);
        if ($password_result !== true) {
            $errors[] = $password_result;
        }
    }


    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    } else {
        if ($uploadOk == 2) {

            echo "All inputs are valid";
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO users (username, email, password, date_of_birth, profile_image)
    VALUES ('$email', '$email', '$hashed_password', '$date_of_birth', '$target_file')";

            if ($conn->query($sql) === TRUE) {
                
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

function IsEmailValid($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Email address is not valid.";
    } else {
        return true;
    }
}
$date_rslt = validateDate($dob);
if ($date_rslt === true) {
    echo "date of birth is valid<br>";
} else {
    echo $date_rslt . "<br>";
}
function IsNullOrEmptyString($str)
{
    return $str === null || trim($str) === '';
}

function passwordChk($pass_strng)
{
    $pass_strng = trim($pass_strng);
    if ($pass_strng === '') {
        return "Password cannot be empty.";
    } elseif (strlen($pass_strng) < 8) {
        return "Password must be at least 8 characters.";
    } elseif (!preg_match('/^(?=.*[a-zA-Z])(?=.*[0-9]).+$/', $pass_strng)) {
        return "Password must contain both letters and numbers.";
    } else {
        return true;
    }
}
function validateDate($date)
{
    // Check for invalid dates
    $d = DateTime::createFromFormat('Y-m-d', $date);
    if (!$d || $d->format('Y-m-d') !== $date) {
        return "Invalid date format";
    }

    // Check for future dates
    $now = new DateTime();
    if ($d > $now) {
        return "Date cannot be in the future";
    }

    // Check for minimum age of 15 years
    $minAge = new DateTime('-15 years');
    if ($d > $minAge) {
        return "User must be at least 15 years old";
    }

    return true;
}
?>

<?php /*
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $dob = $_POST["dateofbirth"];
  if (IsNullOrEmptyString($name) || IsNullOrEmptyString($email) || IsNullOrEmptyString($password) || IsNullOrEmptyString($dob)) {
    echo "All fields must be filled";
  } else {
    $email_rslt = IsEmailValid($email);
    if ($email_rslt == true) {
      echo "email is valid";
    } else {
      echo $email_rslt;
    }
    $password_rslt = passwordChk($password);
    if ($password_rslt == true) {
    echo "password is valid";
    }
    else{
  echo $password_rslt;
    }
  }
}

function IsEmailValid($email)
{
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return "email address is not valid";
  } else {
    return true;
  }
}
function IsNullOrEmptyString(string|null $str)
{
  return $str === null || trim($str) === '';
}

function passwordChk($pass_strng)
{
  $pass_strng = trim($pass_strng);
  if ($pass_strng = '') {
    return "Passowrd can not be empty";
  } elseif (strlen($pass_strng) < 8) {
    return "Password must be atleast 8 characters";
  } elseif (!preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/', $pass_strng)) {
    return "Password must contain number and characters";
  } else {
    return true;
  }
}*/
?>