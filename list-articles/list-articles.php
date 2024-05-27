<?php include_once 'articles-functions.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de artigos</title>
  <link rel="stylesheet" href="../style.css">

  <!-- icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- BOOTSTRAP -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

  <!-- JSQUERY -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

  <!-- EDITOR -->
  <!-- <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script> -->
  <?php if ($showButtons) : ?>
    <script src="../ckeditor/build/ckeditor.js"></script>
  <?php endif; ?>

  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Blog",
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "https://wemakeitdemo2.svr1.appsfarma.com/blog",
        "name": "We Make It - Blog"
      },
      "publisher": {
        "@type": "Organization",
        "name": "We Make It",
        "url": "https://wemakeit.es/",
        "logo": {
          "@type": "ImageObject",
          "url": "https://wemakeit.es/images/ecommerce.png",
          "width": 700,
          "height": 700
        }
      }
    }
  </script>

</head>

<body>
  <div class="container">
    <div class="row">
      <div class="div-login">
        <a href="../login.php"><button>login</button></a>
        <a href="../logout.php"><button>logout</button></a>
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

  <?php include_once '../categories/navbar-categories.php'; ?>

  <div class="container" id="list-categories">
    <div id="list-categories-content">
      <?php if ($showButtons) : ?>
        <div class="row">
          <div class="col-12">
            <button class="button-edit" type="button" id="toggleFormBtn">
              Crear nueva publicación
            </button>
          </div>
        </div>

        <div class="row new-article-form" style="display: none;">
          <div class="col-12 form-group-article">
            <div class="form-section">
              <h5 class="form-title">Crear nueva publicación</h5>
              <form id="crearPublicacionForm">
                <div class="form-group">
                  <label for="title">Título</label>
                  <input type="text" class="form-control" id="title" name="title">
                  <span class="error-message" id="title-error" style="display: none; color: red;">Títilo obrigatório</span>
                </div>
                <div class="form-group">
                  <label for="subtitle">Subtítulo</label>
                  <input type="text" class="form-control" id="subtitle" name="subtitle">
                  <span class="error-message" id="subtitle-error" style="display: none; color: red;">Subtítulo obrigatório</span>
                </div>
                <div class="form-group">
                  <label for="shortDescription">Short Description</label>
                  <textarea class="form-control" id="shortDescription" name="shortDescription" rows="3" maxlength="250"></textarea>
                  <small id="charCount" class="form-text text-muted">0 characters (max. 250)</small>
                  <span class="error-message" id="shortDescription-error" style="display: none; color: red;">Short Description obrigatório</span>
                </div>
                <div class="form-group">
                  <label for="message">Artigo</label>
                  <div class="form-control" id="message" name="message"></div>
                  <small id="wordCharCount" class="form-text text-muted">0 words, 0 characters</small>
                  <span class="error-message" id="message-error" style="display: none; color: red;">Artigo obrigatório</span>
                  <input type="hidden" id="hiddenDescription" name="description">
                </div>
                <div class="form-group">
                  <label for="imageTeste">Image teste</label>
                  <input type="text" class="form-control" id="imageTeste" name="imageTeste">
                  <span class="error-message" id="imageTeste-error" style="display: none; color: red;">Imagem obrigatório</span>
                </div>
                <div class="form-group">
                  <label for="category">Categoría</label>
                  <select class="form-control" id="category" name="category">
                    <?php
                    foreach ($blogCategories as $category) {
                      $id = isset($category['id']) ? $category['id'] : '';
                      $name = isset($category['name']) ? $category['name'] : '';
                    ?>
                      <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                    <?php
                    }
                    ?>
                  </select>
                  <span class="error-message" id="category-error" style="display: none; color: red;">Campo obrigatório</span>
                </div>
                <div class="form-group buttons-post">
                  <button type="button" class="btn btn-secondary" id="close-form">Cerrar</button>
                  <button type="button" class="button-primary" id="savePostBtn">Guardar</button>
                  <button type="button" class="button-primary" id="editPostBtn">Editar</button>
                </div>
              </form>
            </div>


          </div>
        </div>
      <?php endif; ?>




      <div class="row cards-list">
        <?php
        foreach ($blogArticles as $blog) {
          $url = isset($blog['url']) ? $blog['url'] : '';
          $categoryId = isset($blog['category']) ? $blog['category'] : '';
          $categoryName = '';
          foreach ($blogCategories as $category) {
            if ($category['id'] == $categoryId) {
              $categoryId = $category['id'];
              $categoryName = $category['name'];
              break;
            }
          }
          $title = isset($blog['title']) ? $blog['title'] : '';
          $description = isset($blog['obs']) ? $blog['obs'] : '';
          $name = isset($blog['name']) ? $blog['name'] : '';
          $created_at = isset($blog['created']) ? $blog['created'] : '';
          $id = isset($blog['id']) ? $blog['id'] : '';
          $wordsCountDescription = isset($blog['description']) ? $blog['description'] : '';

          $wordsCount = 0;
          if (preg_match('/<small\s+id="wordCharCount"\s+class="form-text\s+text-muted">(\d+)\s+words<\/small>/', $wordsCountDescription, $matches)) {
            error_log(print_r($matches[1], true));
            $wordsCount = intval($matches[1]);
          }
          $averageWordsPerMinute = 200; // Média de palavras por minuto
          $readingTimeMinutes = ceil($wordsCount / $averageWordsPerMinute);


          $link = "../article/article.php?id=$id";
          /*  $link = isset($blog['id']) ? $blog['descriptionios'] : ''; */

        ?>
          <div class="card-blog col-lg-4 col-sm-6 col-12" itemscope itemtype="https://schema.org/BlogPosting">
            <div id="article" class="article">
              <?php if ($showButtons) : ?>
                <div class="edit-buttons">
                  <button class="button-edit editPostBtn" data-blog='<?php echo htmlspecialchars(json_encode($blog), ENT_QUOTES, 'UTF-8'); ?>'>
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>
                  <button class="delete-button button-edit" data-id="<?php echo $id; ?>">
                    <i class="fa-solid fa-trash"></i>
                  </button>

                  <!-- Modal de Confirmação -->
                  <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          Tem certeza de que deseja excluir este item?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                          <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Excluir</button>
                        </div>
                      </div>
                    </div>
                  </div>


                </div>
              <?php endif; ?>
              <div class="img-card">
                <img src="<?php echo $url; ?>" alt="<?php echo $title; ?>" itemprop="image">
              </div>
              <div style="padding: 24px;">
                <div class="categorie-share">
                  <div class="left">
                    <button class="category-button" data-id="<?php echo $categoryId; ?>" itemprop="articleSection"><?php echo $categoryName; ?></button>
                  </div>
                  <div class="right">
                    <button class="share-btn">
                      <i class="fa-solid fa-share"></i>
                    </button>
                    <div class="share-buttons" style="display: none;">
                      <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($description); ?>&text=<?php echo urlencode($title); ?>" target="_blank">
                        <i class="fab fa-twitter"></i> Twitter
                      </a>
                      <a href="https://api.whatsapp.com/send?text=<?php echo urlencode('Title: ' . $title . ' ' . $link); ?>" target="_blank">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                      </a>
                      <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($description); ?>" target="_blank">
                        <i class="fab fa-facebook"></i> Facebook
                      </a>
                      <p class="copyLink" data-link="<?php echo $blog['descriptionios']; ?>">
                        <i class="fas fa-link"></i> Copiar Link
                      </p>
                    </div>
                  </div>
                </div>

                <div class="title">
                  <h2 itemprop="headline"><?php echo $title; ?></h2>
                </div>

                <div class="paragraph" itemprop="description">
                  <?php echo $description; ?>
                </div>

                <div class="line"></div>

                <div class="name" itemprop="author" itemscope itemtype="https://schema.org/Person">
                  <p><i class="fa-solid fa-user"></i><span itemprop="name"><?php echo $name; ?></span></p>
                </div>

                <div class="date-time">
                  <div class="date">
                    <p itemprop="datePublished" content="<?php echo date(DateTime::ATOM, strtotime($created_at)); ?>"><?php echo $created_at; ?></p>
                  </div>
                  <div>
                    <p>-</p>
                  </div>
                  <div class="time-read">
                    <p itemprop="timeRequired"><?php echo $readingTimeMinutes; ?> min Leitura</p>
                  </div>
                </div>
                <div class="read-more">
                  <a href="<?php echo $link; ?>" itemprop="mainEntityOfPage"><button class="button-primary">LEER MÁS</button></a>
                </div>
              </div>
            </div>
          </div>
        <?php
        }
        ?>
      </div>
    </div>
  </div>

  <script src="../js/list-articles.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>

</html>