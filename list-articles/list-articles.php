<?php include_once 'articles-functions.php'; ?>

<div class="container" id="list-categories">
  <?php if ($showButtons) : ?>
    <div class="row">
      <div>
        <button type="button" data-toggle="modal" data-target="#crearPublicacionModal">
          Crear nueva publicación
        </button>

        <!-- Modal -->
        <div class="modal fade" id="crearPublicacionModal" tabindex="-1" role="dialog" aria-labelledby="crearPublicacionModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
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
                    <textarea class="form-control" id="message" name="message"></textarea>
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
          $categoryName = $category['name'];
          break;
        }
      }
      $title = isset($blog['title']) ? $blog['title'] : '';
      $description = isset($blog['description']) ? $blog['description'] : '';
      $name = isset($blog['name']) ? $blog['name'] : '';
      $created_at = isset($blog['created']) ? $blog['created'] : '';
      $id = isset($blog['id']) ? $blog['id'] : '';

      $link = "article.php?id=$id";
      /* TODO Alterar para isset($blog['descriptionios']) ? $blog['descriptionios'] : ''; 
          que ja tem o link para o artigo que é caregado no card */
    ?>
      <div class="card-blog col-lg-4 col-sm-6 col-12">
        <div id="article" class="article">
          <?php if ($showButtons) : ?>
            <div class="edit-buttons">
              <button>
                <i class="fa-solid fa-pen-to-square"></i>
              </button>
              <button class="delete-button" data-id="<?php echo $id; ?>">
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
                <button><?php echo $categoryName; ?></button>

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

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var listCategories = document.getElementById('list-categories');

    listCategories.addEventListener('click', function(event) {
      if (event.target && event.target.id === 'savePostBtn') {

        var title = document.getElementById('title').value;
        var subtitle = document.getElementById('subtitle').value;
        var message = document.getElementById('message').value;
        var imageTeste = document.getElementById('imageTeste').value;
        var category = document.getElementById('category').value;

        var formData = new FormData();
        formData.append('method', 'POST');
        formData.append('title', title);
        formData.append('subtitle', subtitle);
        formData.append('message', message);
        formData.append('imageTeste', imageTeste);
        formData.append('category', category);


        // Inicializar uma nova requisição XMLHttpRequest
        var xhr = new XMLHttpRequest();

        // Configurar a requisição
        xhr.open('POST', 'list-articles/articles-functions.php', true);

        xhr.onload = function() {
          if (xhr.status >= 200 && xhr.status < 300) {
            var closeButton = document.getElementById('close-modal-save-post');
            closeButton.click();
            /*             var navbarCategoriesContainer = document.getElementById('section-categories'); */
            var xhrReload = new XMLHttpRequest();
            xhrReload.open('GET', 'list-articles/list-articles.php', true);
            xhrReload.onload = function() {
              if (xhrReload.status >= 200 && xhrReload.status < 300) {
                listCategories.innerHTML = xhrReload.responseText;
              } else {
                console.error('Erro na requisição para recarregar o componente:', xhrReload.statusText);
              }
            };


            xhrReload.send();

          } else {
            // Houve um erro na requisição
            console.error('Erro na requisição:', xhr.statusText);
          }
        };

        // Definir a função de retorno de chamada para lidar com erros de rede
        xhr.onerror = function() {
          console.error('Erro de rede ao enviar requisição.');
        };

        // Enviar a requisição com os dados do formulário
        xhr.send(formData);
      }

      if (event.target && event.target.classList.contains('delete-button')) {
        var button = event.target;
        var id = button.getAttribute('data-id');

        var formData = new FormData();
        formData.append('method', 'PUT');
        formData.append('id', id);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'list-articles/articles-functions.php', true);

        xhr.onload = function() {
          if (xhr.status >= 200 && xhr.status < 300) {
            var xhrReload = new XMLHttpRequest();
            xhrReload.open('GET', 'list-articles/list-articles.php', true);
            xhrReload.onload = function() {
              if (xhrReload.status >= 200 && xhrReload.status < 300) {
                listCategories.innerHTML = xhrReload.responseText;
              } else {
                console.error('Erro na requisição para recarregar o componente:', xhrReload.statusText);
              }
            };
            xhrReload.send();
          } else {
            console.error('Erro na requisição:', xhr.statusText);
          }
        };

        xhr.onerror = function() {
          console.error('Erro de rede ao enviar requisição.');
        };

        xhr.send(formData);
      }
    });


  });
</script>