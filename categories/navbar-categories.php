<?php include_once 'category.php'; ?>

<section id="section-categories">
  <div class="navbar-categories">
    <div class="container">
      <div class="row">

        <div class="navbar col-12">
          <div class="categories">
            <?php
            foreach ($blogCategories as $category) {
              $id = isset($category['id']) ? $category['id'] : '';
              $name = isset($category['name']) ? $category['name'] : '';
            ?>
              <a href="javascript:void(0);" onclick="sendCategoryId(<?php echo $id; ?>)">
                <button class="button-primary">
                  <?php echo $name; ?>
                </button>
              </a>
            <?php
            }
            ?>
          </div>
        </div>
        <div class="butons-login">
          <?php if ($showButtons) : ?>
            <button class="button-primary" type="button" data-toggle="modal" data-target="#addCategory">
              Crear nueva category
            </button>

            <div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryLabel">Inserir Categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="categoryForm">
                      <div class="form-group">
                        <label for="categoryName">Nome da Categoria:</label>
                        <input type="text" class="form-control" id="categoryName" name="categoryName">
                      </div>
                      <div class="form-group">
                        <label for="categoryObs">Observação:</label>
                        <input type="text" class="form-control" id="categoryObs" name="categoryObs">
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="close-modal-save" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary savebtn" id="saveCategoryBtn">Guardar</button>
                  </div>
                </div>
              </div>
            </div>






            <button class="button-primary" type="button" data-toggle="modal" data-target="#deleteCategory">
              apaga category
            </button>

            <div class="modal fade" id="deleteCategory" tabindex="-1" aria-labelledby="deleteCategoryLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="deleteCategoryLabel">Eliminar Categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="deleteCategoryForm">
                      <div class="form-group">
                        <label for="categoryIdDelete">Escolha uma categoria:</label>
                        <select class="form-control" id="categoryIdDelete" name="categoryIdDelete">
                          <?php foreach ($blogCategories as $category) : ?>
                            <?php $id = isset($category['id']) ? $category['id'] : ''; ?>
                            <?php $name = isset($category['name']) ? $category['name'] : ''; ?>
                            <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="close-modal-delete" data-dismiss="modal">Fechar</button>
                    <!-- Atualizado: incluído atributo de dados para o ID da categoria -->
                    <button type="button" class="btn btn-danger" id="deleteCategoryBtn">Eliminar</button>
                  </div>
                </div>
              </div>
            </div>







            <button class="button-primary" type="button" data-toggle="modal" data-target="#editCategory">
              editar category
            </button>

            <div class="modal fade" id="editCategory" tabindex="-1" aria-labelledby="editCategoryLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryLabel">Editar Categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="editCategoryForm">
                      <div class="form-group">
                        <label for="categoryIdEdit"><strong>Escolha a categoria a editar:</strong></label>
                        <select class="form-control" id="categoryIdEdit" name="categoryIdEdit">
                          <option value="">Selecione uma categoria</option>
                          <?php foreach ($blogCategories as $category) : ?>
                            <?php $id = isset($category['id']) ? $category['id'] : ''; ?>
                            <?php $name = isset($category['name']) ? $category['name'] : ''; ?>
                            <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                          <?php endforeach; ?>
                        </select>
                        <?php foreach ($blogCategories as $category) : ?>
                          <?php
                          $id = isset($category['id']) ? $category['id'] : '';
                          $obs = isset($category['obs']) ? $category['obs'] : '';
                          ?>
                          <label style="display: none; padding: 8px 0" data-category-id="<?php echo $id; ?>">
                            <strong>Observações:</strong>
                            <br>
                            <?php echo $obs; ?>
                          </label>
                        <?php endforeach; ?>
                        <div class="form-group">
                          <label for="categoryEditName"><strong>Nome da Categoria:</strong></label>
                          <input type="text" class="form-control" id="categoryEditName" name="categoryEditName">
                        </div>
                        <div class="form-group">
                          <label for="categoryEditObs"><strong>Observação:</strong></label>
                          <input type="text" class="form-control" id="categoryEditObs" name="categoryEditObs">
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="close-modal-edit" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-danger" id="editCategoryBtn">Editar</button>
                  </div>
                </div>
              </div>
            </div>


          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var sectionCategories = document.getElementById('section-categories');

    //editar 
    var categoryIdSelect = document.getElementById('categoryIdEdit');
    categoryIdSelect.addEventListener('change', function() {
      var selectedCategoryId = categoryIdSelect.value;
      var labels = document.querySelectorAll('[data-category-id]');
      labels.forEach(function(label) {
        if (label.getAttribute('data-category-id') === selectedCategoryId) {
          label.style.display = 'block';
        } else {
          label.style.display = 'none';
        }
      });
    }); //editar



    sectionCategories.addEventListener('click', function(event) {
      if (event.target && event.target.id === 'saveCategoryBtn') {
        var categoryName = document.getElementById('categoryName').value;
        var categoryObs = document.getElementById('categoryObs').value;
        //TODO se for o name vazio nao guardar mostar mensagem de obrigaçao
        var formData = new FormData();
        formData.append('method', 'POST');
        formData.append('categoryName', categoryName);
        formData.append('categoryObs', categoryObs);

        // Inicializar uma nova requisição XMLHttpRequest
        var xhr = new XMLHttpRequest();

        // Configurar a requisição
        xhr.open('POST', 'categories/category.php', true);

        xhr.onload = function() {
          if (xhr.status >= 200 && xhr.status < 300) {
            document.getElementById('categoryName').value = '';
            document.getElementById('categoryObs').value = '';
            var closeButton = document.getElementById('close-modal-save');
            closeButton.click();
            var navbarCategoriesContainer = document.getElementById('section-categories');
            var xhrReload = new XMLHttpRequest();
            xhrReload.open('GET', 'categories/navbar-categories.php', true);
            xhrReload.onload = function() {
              if (xhrReload.status >= 200 && xhrReload.status < 300) {
                navbarCategoriesContainer.innerHTML = xhrReload.responseText;
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
      } else if (event.target && event.target.id === 'deleteCategoryBtn') {
        // Obter o valor do categoryId
        var categoryId = document.getElementById('categoryIdDelete').value;

        // Criar um objeto FormData manualmente e adicionar os dados
        var formData = new FormData();
        formData.append('method', 'DELETE');
        formData.append('id', categoryId);
        formData.append('delete', 'true');

        // Enviar os dados via XMLHttpRequest
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'categories/category.php', true);
        xhr.onload = function() {
          if (xhr.status >= 200 && xhr.status < 300) {
            // Processar a resposta conforme necessário
            var closeButton = document.getElementById('close-modal-delete');
            closeButton.click();
            var navbarCategoriesContainer = document.getElementById('section-categories');
            var xhrReload = new XMLHttpRequest();
            xhrReload.open('GET', 'categories/navbar-categories.php', true);
            xhrReload.onload = function() {
              if (xhrReload.status >= 200 && xhrReload.status < 300) {
                navbarCategoriesContainer.innerHTML = xhrReload.responseText;
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
      } else if (event.target && event.target.id === 'editCategoryBtn') {
        // Obter o valor do categoryId
        var categoryIdEdit = document.getElementById('categoryIdEdit').value;
        var catagoryNameEdit = document.getElementById('categoryEditName').value;
        var categoryObsEdit = document.getElementById('categoryEditObs').value;
        // Criar um objeto FormData manualmente e adicionar os dados
        var formData = new FormData();
        formData.append('method', 'PUT');
        formData.append('categoryIdEdit', categoryIdEdit);
        formData.append('catagoryNameEdit', catagoryNameEdit);
        formData.append('categoryObsEdit', categoryObsEdit);

       // Enviar os dados via XMLHttpRequest
       var xhr = new XMLHttpRequest();
      xhr.open('POST', 'categories/category.php', true);
      xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
          // Processar a resposta conforme necessário
          var closeButton = document.getElementById('close-modal-edit');
          closeButton.click();
          var navbarCategoriesContainer = document.getElementById('section-categories');
          var xhrReload = new XMLHttpRequest();
          xhrReload.open('GET', 'categories/navbar-categories.php', true);
          xhrReload.onload = function() {
            if (xhrReload.status >= 200 && xhrReload.status < 300) {
              navbarCategoriesContainer.innerHTML = xhrReload.responseText;
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