<?php include_once 'articles-functions.php'; ?>

<div class="container" id="list-categories">
  <div id="list-categories-content">
    <?php if ($showButtons) : ?>
      <div class="row">
        <div>
          <button class="button-edit" type="button" data-toggle="modal" data-target="#crearPublicacionModal">
            Crear nueva publicación
          </button>

          <!-- Modal -->
          <div class="modal fade" id="crearPublicacionModal" tabindex="-1" role="dialog" aria-labelledby="crearPublicacionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="crearPublicacionModalLabel">Crear nueva publicación</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form id="crearPublicacionForm">
                    <div class="form-group">
                      <label for="title">Título</label>
                      <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="form-group">
                      <label for="subtitle">Subtítulo</label>
                      <input type="text" class="form-control" id="subtitle" name="subtitle">
                    </div>
                    <div class="form-group">
                      <label for="message">Mensaje</label>
                      <div class="form-control" id="message" name="message"></div>
                    </div>
                    <div class="form-group">
                      <label for="image">Imagen</label>
                      <input type="file" class="form-control-file" id="image" name="image">
                    </div>
                    <div class="form-group">
                      <label for="imageTeste">Image teste</label>
                      <input type="text" class="form-control" id="imageTeste" name="imageTeste">
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
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" id="close-modal-save-post" data-dismiss="modal">Cerrar</button>
                  <button type="button" class="btn btn-primary savebtn" id="savePostBtn">Guardar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <div class="row">
      <?php
      foreach ($blogArticles as $blog) {
        // Extrai os dados do blog
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
        $description = isset($blog['description']) ? $blog['description'] : '';
        $name = isset($blog['name']) ? $blog['name'] : '';
        $created_at = isset($blog['created']) ? $blog['created'] : '';
        $id = isset($blog['id']) ? $blog['id'] : '';

        $link = "article/article.php?id=$id";
        /* TODO Alterar para isset($blog['descriptionios']) ? $blog['descriptionios'] : ''; 
          que ja tem o link para o artigo que é caregado no card */
      ?>
        <div class="card-blog col-lg-4 col-sm-6 col-12">
          <div id="article" class="article">
            <?php if ($showButtons) : ?>
              <div class="edit-buttons">
                <button class="button-edit">
                  <i class="fa-solid fa-pen-to-square"></i>
                </button>
                <button class="delete-button button-edit" data-id="<?php echo $id; ?>">
                  <i class="fa-solid fa-trash"></i>
                </button>
              </div>
            <?php endif; ?>
            <div class="img-card">
              <img src="<?php echo $url; ?>" alt="<?php echo $title; ?>">
            </div>
            <div style="padding: 24px;">
              <div class="categorie-share">
                <div class="left">
                  <button class="category-button" data-id="<?php echo $categoryId; ?>"><?php echo $categoryName; ?></button>
                </div>
                <div class="right">
                  <button>
                    <i class="fa-solid fa-share"></i>
                  </button>
                </div>
              </div>

              <div class="title">
                <h2><?php echo $title; ?></h2>
              </div>

              <div class="paragraph">
                <?php echo $description; ?>
              </div>

              <div class="line"></div>

              <div class="name">
                <p><i class="fa-solid fa-user"></i><?php echo $name; ?></p>
              </div>

              <div class="date-time">
                <div class="date">
                  <p><?php echo $created_at; ?></p>
                </div>
                <div>
                  <p>-</p>
                </div>
                <div class="time-read">
                  <p>9 min Leitura</p>
                </div>
              </div>
              <div class="read-more">
                <a href="<?php echo $link; ?>"><button>LEER MÁS</button>
                </a>
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