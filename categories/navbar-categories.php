<?php include_once 'category.php'; ?>

<section id="section-categories">
  <div id="section-categories-content">
    <?php if ($showButtons) : ?>
      <div class="butons-login">
        <div class="container">
          <div class="row">
            <div class="navbar-edit col-12">

              <button class="button-edit" type="button" data-toggle="modal" data-target="#addCategory">
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

              <button class="button-edit" type="button" data-toggle="modal" data-target="#deleteCategory">
                <i class="fa-solid fa-trash"></i> apaga category
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

              <button class="button-edit" type="button" data-toggle="modal" data-target="#editCategory">
                <i class="fa-solid fa-pen-to-square"></i> editar category
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

            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>


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
                <button class="button-primary category-button" data-id="<?php echo $id; ?>">
                  <?php echo $name; ?>
                </button>
              <?php
              }
              ?>
              <button class="button-primary category-button" data-id="0">
                Listar Todas
              </button>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
</section>