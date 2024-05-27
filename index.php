 <!DOCTYPE html>
 <html lang="es">

 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Lista de artigos</title>
   <link rel="stylesheet" href="style.css">

   <!-- icons -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   <!-- BOOTSTRAP -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

   <!-- JSQUERY -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

   <!-- EDITOR -->
      <!-- <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script> -->
   <script src="ckeditor/build/ckeditor.js"></script>
 </head>

 <body>
   <div class="container">
     <div class="row">
       <div class="div-login">

         <a href="login.php"><button>login</button></a>

         <a href="logout.php"><button>logout</button></a>

       </div>
     </div>
   </div>

   <div class="container">
     <div class="row">
       <div class="div-title">
         <h1>Blog Farmacias</h1>
       </div>
     </div>
   </div>

   <?php include_once 'categories/navbar-categories.php'; ?>

   <?php include_once 'list-articles/list-articles.php'; ?>

   <script src="./js/list-articles.js"></script>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>


 </body>

 </html>
