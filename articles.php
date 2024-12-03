<?php

    require 'config.php';
    $i = 0;
    $sql = $conn->prepare("SELECT ArticleId, ArticleTitle, ArticleDescr, ImageName, ImageType, ImageData FROM articles");
    $sql->execute();
    $sql->store_result();
    $sql->bind_result($id, $title, $descr, $imgName, $imgType, $imgData);
    if($sql->num_rows > 0){

        while($sql->fetch()){
            if($i % 2 == 0){
                echo "<div class='row'><div class='col-md order-first'><img src='data:".$imgType.";base64,".base64_encode($imgData)."' class='img-fluid img-custom'></div><div class='col'><div class='h1'>".$title."</div><br><p class='post-p-custom'>".$descr."</p><br><a href='showArticle.php?id=".$id."'><button class='btn btn-lg btn-dark'>Czytaj dalej</button></a></div></div><hr>";
            }else{
                echo "<div class='row'><div class='col'><div class='h1'>".$title."</div><br><p class='post-p-custom'>".$descr."</p><br><a href='showArticle.php?id=".$id."'><button class='btn btn-lg btn-dark'>Czytaj dalej</button></a></div><div class='col-md order-first order-md-last'><img src='data:".$imgType.";base64,".base64_encode($imgData)."' class='img-fluid img-custom'></div></div><hr>";
            }
            $i++;
        }

    }

?>