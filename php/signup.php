<?php
    session_start();
    include_once "config.php";
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //check if email is in database
            $sql = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}'");
            if(mysqli_num_rows($sql) > 0){ //If email already exist
                echo "$email - This email already exist";
            }else{
                //let's check if user uploaded a file or not
                if(isset($_FILES['image'])){ //if fill is uploaded
                    $img_name = $_FILES['image']["name"]; //getting user uploaded image name
                    // $img_name = $_FILES['image']["type"]; //getting user uploaded image type
                    $tmp_name = $_FILES['image']["tmp_name"]; //this temporary name is used to save/move file in our folder

                    //let's explode image and get the last extension like ".jpg", ".png"
                    $img_explode = explode('.', $img_name);
                    $img_ext = end($img_explode); //here we get the extension of a user uploaded image file

                    $extensions = ['png', 'jpeg', 'jpg']; //this are some valid image extensions and we have saved them in an array
                    if(in_array($img_ext, $extensions) === true){ //if user uploaded image extension is matched with any array extension
                        $time = time();  // we need this time rename and save user uploaded image file to our folder so each image have a unique name
                        //let's move the user uploaded image to our own folder
                        $new_img_name = $time.$img_name;
                        
                        if(move_uploaded_file($tmp_name, "images/".$new_img_name)){ //if user uploaded image was moved successfully to our folder
                            $random_id = rand(time(), 10000000); //creating random id for users
                            $status = "Active now"; //once user signed up there status become active

                            //let's insert all user data inside table in database
                            $sql2 = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, status, img)
                                                 VALUES ({$random_id}, '{$fname}', '{$lname}', '{$email}', '{$password}', '{$status}', '{$new_img_name}')");
                            if($sql2){ //if these data is inserted
                                $sql3 = mysqli_query($conn, "SELECT * FROM user WHERE email = '{$email}'");
                                if(mysqli_num_rows($sql3) > 0){
                                    $row = mysqli_fetch_assoc($sql3);
                                    $_SESSION['unique_id'] = $row['unique_id']; //using this session we use user unique_id in other php file
                                    echo "success";
                                }else{
                                    echo "This email address does not Exist!";
                                }
                            }else{
                                echo "Something went wrong! ";
                            }
                        }
                    }else{
                        echo "Please select an Image file extenstion with - \".jpeg\", \".png\" or \".jpg\" ";
                    }
                }else{
                    echo "Please select an Image file";
                }
            }
        }else {
            echo "$email - This is not a valid email";
        }
        
    }else {
        echo "All input field are required";
    }
    
?>