<?php
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	} 

	if(!isset($_SESSION["loggedin"]) || (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false)){
        header("location: login.php");
        exit;
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
				<div class="h1">Dodawanie wpisu:</div>
					<form action="preview.php" method="post" class="AddPostForm" enctype="multipart/form-data">
						<div class="form-group">
							<label for="title">Tytuł:</label></br>
							<input type="title" name="title" class="form-control border border-dark" id="title" value="<?php if(isset($_SESSION["title"])) echo $_SESSION["title"];?>"></br>
							<span class="text-danger">
								<?php
									if(isset($_SESSION["titleErr"])){
										echo $_SESSION["titleErr"];
									}
								?>
							</span></br>
						</div>
						<div class="form-group">
							<label for="desc">Krótki opis:</label></br>
							<input type="desc" name="desc" class="form-control border border-dark" id="desc" value="<?php if(isset($_SESSION["desc"])) echo $_SESSION["desc"];?>"></br>
							<span class="text-danger">
							<?php
									if(isset($_SESSION["descErr"])){
										echo $_SESSION["descErr"];
									}
								?>
							</span></br>
						</div>
						<div class="form-group">
							<label for="content">Treść:</label></br>
							<textarea name="content" class="form-control border border-dark" id="content" ><?php if(isset($_SESSION["content"])) echo $_SESSION["content"];?></textarea></br>
							<span class="text-danger">
							<?php
									if(isset($_SESSION["contentErr"])){
										echo $_SESSION["contentErr"];
									}
								?>
							</span></br>
						</div>	
						<div class="form-group">
							<label for="image">Prześlij zdjęcie na miniaturkę:</label></br>
							<input class="form-control form-control-lg border-dark" type="file" name="image" id="image">
							<span class="text-danger">
							<?php
									if(isset($_SESSION["imageErr"])){
										echo $_SESSION["imageErr"];
									}
								?>
							</span></br>
						</div>
						<input type="submit" value="Dalej">
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