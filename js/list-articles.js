document.addEventListener('DOMContentLoaded', function () {
  let editorInstance;

  const storedToken = localStorage.getItem('token');
  if (storedToken) {
    //editar 
    var categoryIdSelect = document.getElementById('categoryIdEdit');
    categoryIdSelect.addEventListener('change', function () {
      var selectedCategoryId = categoryIdSelect.value;
      var labels = document.querySelectorAll('[data-category-id]');
      labels.forEach(function (label) {
        if (label.getAttribute('data-category-id') === selectedCategoryId) {
          label.style.display = 'block';
        } else {
          label.style.display = 'none';
        }
      });
    }); //editar

  }

  $(document).ready(function () {
    $(document.body).on('click', '.category-button', function (event) {
      var categoryId = $(this).data('id');
      sendCategoryId(categoryId);
    });
    initializeEditor();

    $('#section-categories').on('click', function (event) {
      if (event.target && event.target.id === 'saveCategoryBtn') {
        var categoryName = $('#categoryName').val();
        var categoryObs = $('#categoryObs').val();
        // TODO: Se o nome estiver vazio, não guardar e mostrar uma mensagem de obrigação

        var formData = new FormData();
        formData.append('method', 'POST');
        formData.append('categoryName', categoryName);
        formData.append('categoryObs', categoryObs);

        $.ajax({
          type: 'POST',
          url: 'categories/category.php',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            $('#categoryName').val('');
            $('#categoryObs').val('');
            $('#close-modal-save').click();
            $.ajax({
              type: 'GET',
              url: 'categories/navbar-categories.php',
              success: function (data) {
                $('#section-categories').html($(data).find('#section-categories-content').html());
              },
              error: function (xhr, status, error) {
                console.error('Erro na requisição para recarregar o componente:', error);
              }
            });
          },
          error: function (xhr, status, error) {
            console.error('Erro na requisição:', error);
          }
        });
      } else if (event.target && event.target.id === 'deleteCategoryBtn') {
        var categoryId = $('#categoryIdDelete').val();

        var formData = new FormData();
        formData.append('method', 'DELETE');
        formData.append('id', categoryId);
        formData.append('delete', 'true');

        $.ajax({
          type: 'POST',
          url: 'categories/category.php',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            $('#close-modal-delete').click();
            var navbarCategoriesContainer = $('#section-categories');
            $.ajax({
              type: 'GET',
              url: 'categories/navbar-categories.php',
              success: function (data) {
                $('#section-categories').html($(data).find('#section-categories-content').html());
              },
              error: function (xhr, status, error) {
                console.error('Erro na requisição para recarregar o componente:', error);
              }
            });
          },
          error: function (xhr, status, error) {
            console.error('Erro na requisição:', error);
          }
        });
      } else if (event.target && event.target.id === 'editCategoryBtn') {
        var categoryIdEdit = $('#categoryIdEdit').val();
        var catagoryNameEdit = $('#categoryEditName').val();
        var categoryObsEdit = $('#categoryEditObs').val();

        var formData = new FormData();
        formData.append('method', 'PUT');
        formData.append('categoryIdEdit', categoryIdEdit);
        formData.append('catagoryNameEdit', catagoryNameEdit);
        formData.append('categoryObsEdit', categoryObsEdit);

        $.ajax({
          type: 'POST',
          url: 'categories/category.php',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            $('#close-modal-edit').click();
            var navbarCategoriesContainer = $('#section-categories');
            $.ajax({
              type: 'GET',
              url: 'categories/navbar-categories.php',
              success: function (data) {
                $('#section-categories').html($(data).find('#section-categories-content').html());
              },
              error: function (xhr, status, error) {
                console.error('Erro na requisição para recarregar o componente:', error);
              }
            });
          },
          error: function (xhr, status, error) {
            console.error('Erro na requisição:', error);
          }
        });
      }
    });

    $('#list-categories').on('click', function (event) {
      if (event.target && event.target.id === 'savePostBtn') {

        var title = $('#title').val();
        var subtitle = $('#subtitle').val();
        var message = editorInstance.getData();
        var imageTeste = $('#imageTeste').val();
        var category = $('#category').val();

        var formData = new FormData();
        formData.append('method', 'POST');
        formData.append('title', title);
        formData.append('subtitle', subtitle);
        formData.append('message', message);
        formData.append('imageTeste', imageTeste);
        formData.append('category', category);

        $.ajax({
          type: 'POST',
          url: 'list-articles/articles-functions.php',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            $('#close-modal-save-post').click();
            destroyEditor();
            initializeEditor();
            $.ajax({
              type: 'GET',
              url: 'list-articles/list-articles.php',
              success: function (data) {
                $('#list-categories').html($(data).find('#list-categories-content').html());
              },
              error: function (xhr, status, error) {
                console.error('Erro na requisição para recarregar o componente:', error);
              }
            });
          },
          error: function (xhr, status, error) {
            console.error('Erro na requisição:', error);
          }
        });
      }

      if (event.target && $(event.target).hasClass('delete-button')) {
        var id = $(event.target).data('id');

        var formData = new FormData();
        formData.append('method', 'PUT');
        formData.append('id', id);

        $.ajax({
          type: 'POST',
          url: 'list-articles/articles-functions.php',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            $.ajax({
              type: 'GET',
              url: 'list-articles/list-articles.php',
              success: function (data) {
                $('#list-categories').html($(data).find('#list-categories-content').html());
              },
              error: function (xhr, status, error) {
                console.error('Erro na requisição para recarregar o componente:', error);
              }
            });
          },
          error: function (xhr, status, error) {
            console.error('Erro na requisição:', error);
          }
        });
      }
    });
  });

  function sendCategoryId(categoryId) {
    var formData = new FormData();
    formData.append('method', 'GET');
    formData.append('categoryId', categoryId);

    $.ajax({
      type: 'POST',
      url: 'list-articles/articles-functions.php',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        $('#list-categories').html($(response).find('#list-categories-content').html());
      },
      error: function (xhr, status, error) {
        console.error('Erro ao enviar categoria:', error);
      }
    });
  }

  function initializeEditor() {

    ClassicEditor
      .create(document.querySelector('#message'), {
        ckfinder: {
          uploadUrl: 'url'
        }
      })
      .then(editor => {
        window.editor = editor;
      })
      .catch(error => {
        console.error(error);
      });
  }
  
  function destroyEditor() {
    if (editorInstance) {
      editorInstance.destroy()
        .then(() => {
          editorInstance = null;
        })
        .catch(error => {
          console.error('Error destroying editor instance:', error);
        });
    }
  }
});
