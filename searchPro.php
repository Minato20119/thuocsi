<?php  
    require 'dbcon.php';
    
    if(isset($_POST["query"])){  
        $output = '';  
        $query = "SELECT * FROM sanpham WHERE ten_san_pham LIKE '%".$_POST["query"]."%'";  
        $result = mysqli_query($con, $query);  
        $output = '<ul class="list-unstyled">';  
        
        if(mysqli_num_rows($result) > 0){  
            while($row = mysqli_fetch_array($result)){  
                $output .= '<li>'.$row["ten_san_pham"].'</li>';  
            }  
        }else{  
            $output .= '<li>Khong tim thay ten san pham.</li>';  
        }  
    
    $output .= '</ul>';  
    echo $output;  
    } 
?>
