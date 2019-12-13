<?php
if (isset($_GET["code"]) && isset($_GET["name"]) && isset($_GET["website"])) {
    $_DB = array(
        "server" => "127.0.0.1",
        "database" => "isa",
        "user" => "isa",
        "passwd" => "isa_admin",
    );
    
    $data = array(
        "code" => Format($_GET["code"]),
        "name" => Format($_GET["name"]),
        "website" => Format($_GET["website"]),
    );
    
    if ($data["code"] != "" && $data["name"] != "") {
        $sql = "insert into `isa_js_push` (`name`, `code`, `website`, `create`) values ('" .$data["name"]. "', '" .$data["code"]. "', '" .$data["website"]. "', now())";
        $con = new mysqli($_DB["server"], $_DB["user"], $_DB["passwd"], $_DB["database"]);
        if ($con->connect_errno) {
            $error = "Failed to connect to database: (" . $con->connect_errno . ") " . $con->connect_error;
            echo json_encode(array("status" => "error", "msg" => $error));           
        }
        else {
            if (false == $con->query($sql)) {
                $error = "Failed to push data: " . $con->error;               
                echo json_encode(array("status" => "error", "msg" => $error . ":" . $sql));                
            }
            else {
                echo json_encode(array("status" => "ok", "msg" => ""));
            }
            $con->close();
        }
    }
    else {
        echo json_encode(array("status" => "error", "msg" => "error param."));
    }
}
else {
    echo json_encode($_GET);
}

function Format($value)
{
    $value = htmlspecialchars($value, ENT_QUOTES);
    $value = addslashes($value);
    return $value;
}
