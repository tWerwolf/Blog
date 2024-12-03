<?php
    require_once "config.php";

	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	} 

	if(!isset($_SESSION["loggedin"]) || (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false)){
        header("location: login.php");
        exit;
    }

    $articleTitle = $articleDesc = $articleContent = "";
    $articleId = "";


    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $articleId = $_POST["id"];

       
        $sql = $conn->prepare("SELECT ArticleTitle, ArticleDescr, ArticleContent FROM articles WHERE ArticleId = ".$articleId);
        $sql->execute();
        $sql->store_result();
        $sql->bind_result($articleTitle, $articleDesc, $articleContent);
        $sql->fetch();

    }



?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <link rel="stylesheet" href="css.css">
		<style>
			.ck-editor__editable_inline {
				min-height: 400px;
			}
		</style>

    </head>
    <body>
		<div class="container-flex">
            <div class="container"> 
                <?php
                    require 'navbar.php';
                ?>
			<main>
				<div class="h1">Edycja wpisu:</div>
					<form action="updateArticle.php" method="post">
						<div class="form-group">
							<label for="title">Tytuł:</label></br>
							<input type="title" name="title" class="form-control border border-dark" id="title" value="<?php echo $articleTitle; ?>"></br>
							<span class="text-danger">
							</span></br>
						</div>
						<div class="form-group">
							<label for="desc">Krótki opis:</label></br>
							<input type="desc" name="desc" class="form-control border border-dark" id="desc" value="<?php echo $articleDesc;?>"></br>
							<span class="text-danger">
							</span></br>
						</div>
						<div class="form-group">
							<label for="content">Treść:</label></br>
							<textarea name="content" class="form-control border border-dark" id="content" ><?php echo $articleContent;?></textarea></br>
							<span class="text-danger">
						</div>			
                        <input type="hidden" name="articleId" id="articleId" value=<?php echo $articleId; ?>>		
						<input type="submit" value="Uaktualnij">
					</form>
				</div>

			</main>
        </div>
        <footer class="text-center text-lg-start">
			<div class="text-center p-3">2023 Tomasz Wilk</div>
		</footer>

		<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script> 
		<script type="text/javascript">
			ClassicEditor.defaultConfig = {
				toolbar: {
					items: [
					'undo',
					'redo',
					'|',
					'heading',
					'|',
					'bold',
					'italic',
					'|',
					'bulletedList',
					'numberedList',
					'|',
					'insertTable',
					'link',
					'|',					
					]
				},
				table: {
					contentToolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells' ]
				},
				language: 'pl'
				};

			ClassicEditor
					.create(document.getElementById("content"),{
						ckfinder:{
							uploadUrl: 'preview.php'
						}
					})
					.catch( error => {
						console.error(error);
					});
		</script>

    </body>
</html>