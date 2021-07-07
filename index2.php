<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
    function shorthand(str){
        var strArr = str.split(" ")
        str = " "
        for(i in strArr){
            if(strArr[i] === "and") continue;
            str += strArr[i][0]
        }
        return str.toUpperCase();
    }
</script>
</head>
<body>
<h2><script>  document.write(shorthand(<?php echo '\'Computer Science and Engineering\''; ?>)) </script></h2>
    
<h2>
    <?php
        $str = explode(' ', "STP-6");
        $s = "";
        if(count($str) == 1) echo $str[0];
        else{
            foreach($str as $i){
                if($i === "and") continue;
                $s .= $i[0];
            }
            var_dump(strtoupper($s));
        }

    ?>
</h2>
</body>
</html> 
 



    


