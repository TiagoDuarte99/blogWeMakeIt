document.addEventListener('DOMContentLoaded', function () {
  let editorInstance;
  let words;
  var articleEditId;
  var categoryIdToDelete
  const storedToken = localStorage.getItem('token');


  const saveBtn = document.getElementById('savePostBtn');
  const editBtn = document.getElementById('editPostBtn');
  const formSection = document.querySelector('.new-article-form');
  const cardsList = document.querySelector('.cards-list');






  $(document).ready(function () {

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



    $(document.body).on('click', '.category-button', function (event) {
      var categoryId = $(this).data('id');
      sendCategoryId(categoryId);
    });

    if (storedToken) {
      initializeEditor();
      initializeEditButtons()
    }

    $('#section-categories').on('click', function (event) {
      if (event.target && event.target.id === 'saveCategoryBtn') {
        var isValid = true;

        var categoryName = $('#categoryName').val();
        var categoryObs = $('#categoryObs').val();

        // Reset error messages
        $('.error-message').hide();

        // Validate fields
        if (!categoryName) {
          $('#categoryName-error').show();
          isValid = false;
        }

        if (!isValid) {
          return;
        }
        var formData = new FormData();
        formData.append('method', 'POST');
        formData.append('categoryName', categoryName);
        formData.append('categoryObs', categoryObs);

        $.ajax({
          type: 'POST',
          url: '../categories/category.php',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            $('#categoryName').val('');
            $('#categoryObs').val('');
            $('#close-modal-save').click();
            location.reload();
            /*             $.ajax({
                          type: 'GET',
                          url: '../categories/navbar-categories.php',
                          success: function (data) {
                            $('#section-categories').html($(data).find('#section-categories-content').html());
                          },
                          error: function (xhr, status, error) {
                            console.error('Erro na requisição para recarregar o componente:', error);
                          }
                        }); */
          },
          error: function (xhr, status, error) {
            console.error('Erro na requisição:', error);
          }
        });
      }
      else if (event.target && event.target.id === 'deleteCategoryBtn') {
        var confirmationMessage = document.getElementById('confirmationMessage');

        // Se a mensagem de confirmação estiver visível, executa a exclusão
        if (confirmationMessage.style.display === 'block') {
          var categoryId = $('#categoryIdDelete').val();

          var formData = new FormData();
          formData.append('method', 'DELETE');
          formData.append('id', categoryId);
          formData.append('delete', 'true');

          $.ajax({
            type: 'POST',
            url: '../categories/category.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
              $('#close-modal-delete').click();
              location.reload();
            },
            error: function (xhr, status, error) {
              console.error('Erro na requisição:', error);
            }
          });
        } else {
          // Exibe a mensagem de confirmação
          confirmationMessage.style.display = 'block';
        }
      }
      else if (event.target && event.target.id === 'editCategoryBtn') {
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
          url: '../categories/category.php',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            $('#close-modal-edit').click();
            var navbarCategoriesContainer = $('#section-categories');
            location.reload();
            /*             $.ajax({
                          type: 'GET',
                          url: '../categories/navbar-categories.php',
                          success: function (data) {
                            $('#section-categories').html($(data).find('#section-categories-content').html());
                          },
                          error: function (xhr, status, error) {
                            console.error('Erro na requisição para recarregar o componente:', error);
                          }
                        }); */
          },
          error: function (xhr, status, error) {
            console.error('Erro na requisição:', error);
          }
        });
      }
    });

    $('#list-categories').on('click', function (event) {
      if (event.target && event.target.id === 'savePostBtn') {
        const content = editorInstance.getData();

        updateDescription(content, words);
        messageUpdate = document.getElementById('hiddenDescription').value;

        var isValid = true;
        var title = $('#title').val();
        var subtitle = $('#subtitle').val();
        var message = messageUpdate;
        var imageTeste = $('#imageTeste').val();
        var category = $('#category').val();
        var shortDescription = $('#shortDescription').val();

        // Reset error messages
        $('.error-message').hide();

        // Validate fields
        if (!title) {
          $('#title-error').show();
          isValid = false;
        }
        if (!subtitle) {
          $('#subtitle-error').show();
          isValid = false;
        }
        if (!shortDescription) {
          $('#shortDescription-error').show();
          isValid = false;
        }
        if (!message) {
          $('#message-error').show();
          isValid = false;
        }
        if (!imageTeste) {
          $('#imageTeste-error').show();
          isValid = false;
        }
        if (!category) {
          $('#category-error').show();
          isValid = false;
        }

        if (!isValid) {
          return;
        }

        var formData = new FormData();
        formData.append('method', 'POST');
        formData.append('title', title);
        formData.append('subtitle', subtitle);
        formData.append('message', message);
        formData.append('imageTeste', imageTeste);
        formData.append('category', category);
        formData.append('obs', shortDescription);


        $.ajax({
          type: 'POST',
          url: 'articles-functions.php',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            $('#close-modal-save-post').click();
            location.reload();
          },
          error: function (xhr, status, error) {
            console.error('Erro na requisição:', error);
          }
        });
      }
      if (event.target && event.target.id === 'confirmDeleteBtn') {
        var formData = new FormData();
        formData.append('method', 'DELETE');
        formData.append('id', categoryIdToDelete);

        $.ajax({
          type: 'POST',
          url: 'articles-functions.php',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            location.reload();
          },
          error: function (xhr, status, error) {
            console.error('Erro na requisição:', error);
          }
        });
      }
      if (event.target && event.target.id === 'editPostBtn') {

        const content = editorInstance.getData();

        updateDescription(content, words);
        messageUpdate = document.getElementById('hiddenDescription').value;

        var isValid = true;
        var title = $('#title').val();
        var subtitle = $('#subtitle').val();
        var message = messageUpdate;
        var imageTeste = $('#imageTeste').val();
        var category = $('#category').val();
        var shortDescription = $('#shortDescription').val();

        // Reset error messages
        $('.error-message').hide();

        // Validate fields
        if (!title) {
          $('#title-error').show();
          isValid = false;
        }
        if (!subtitle) {
          $('#subtitle-error').show();
          isValid = false;
        }
        if (!shortDescription) {
          $('#shortDescription-error').show();
          isValid = false;
        }
        if (!message) {
          $('#message-error').show();
          isValid = false;
        }
        if (!imageTeste) {
          $('#imageTeste-error').show();
          isValid = false;
        }
        if (!category) {
          $('#category-error').show();
          isValid = false;
        }

        if (!isValid) {
          return;
        }

        var formData = new FormData();
        formData.append('method', 'PUT');
        formData.append('id', articleEditId);
        formData.append('title', title);
        formData.append('subtitle', subtitle);
        formData.append('message', message);
        formData.append('imageTeste', imageTeste);
        formData.append('category', category);
        formData.append('obs', shortDescription);


        $.ajax({
          type: 'POST',
          url: 'articles-functions.php',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            $('#close-modal-save-post').click();
            location.reload();
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
      url: '../list-articles/articles-functions.php',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        $('#list-categories').html($(response).find('#list-categories-content').html());
        initializeShareButtons();
        initializeCopyLinkButtons();
        destroyEditor(initializeEditor);
        if (storedToken) {
          initializeEditButtons()
        }
      },
      error: function (xhr, status, error) {
        console.error('Erro ao enviar categoria:', error);
      }
    });
  }

  function initializeEditor() {
    ClassicEditor
      .create(document.querySelector('#message'), {
        heading: {
          options: [
            { model: 'paragraph', view: 'p', title: 'Parágrafo', class: 'ck-heading_paragraph' },
            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
            { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
            { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
            { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' }
          ]
        },
        wordCount: {
          onUpdate: stats => {
            const wordCountElement = document.getElementById('wordCharCount');
            let readingTime = Math.ceil(stats.words / 200); // Arredonda para cima para garantir que o tempo de leitura seja um número inteiro
            let readingTimeString = readingTime === 1 ? '1 min' : `${readingTime} mins`; // Formata o tempo de leitura para uma string amigável

            wordCountElement.innerText = `${stats.words} words, ${stats.characters} characters, ${readingTimeString} reading`;

            words = stats.words
          }
        }
      })
      .then(editor => {
        editorInstance = editor;
      })
      .catch(error => {
        console.error('Error initializing editor:', error);
      });
  }

  function destroyEditor(callback) {
  
    if (editorInstance) {
      editorInstance.destroy()
        .then(() => {
          editorInstance = null;
          callback();
        })
        .catch(error => {
          console.error('Error destroying editor instance:', error);
        });
    } else {
      callback();
    }
  }

  function updateDescription(content, words) {
    const description = `${content}`;
    const updatedDescription = `${description} <small id="wordCharCount" class="form-text text-muted">${words} words</small>`;

    // Atualizar o campo oculto com a nova descrição
    document.getElementById('hiddenDescription').value = updatedDescription;
  }

  function resetFormNewArticle() {
    $('#title').val('');
    $('#subtitle').val('');
    editorInstance.setData('');
    $('#imageTeste').val('');
    $('#category').val('');
    $('#shortDescription').val('');
    $('.error-message').hide();
  }

  function resetCategoryForm() {
    $('#categoryName').val('');
    $('#categoryObs').val('');
    $('.error-message').hide();
  }

  /* TODO Partilhar no card */
  function toggleShareButtons(event) {
    const shareBtn = event.currentTarget;
    const shareButtons = shareBtn.nextElementSibling;

    document.querySelectorAll('.share-buttons').forEach(buttonGroup => {
      if (buttonGroup !== shareButtons) {
        buttonGroup.style.display = 'none';
      }
    });

    if (shareButtons.style.display === 'none' || shareButtons.style.display === '') {
      shareButtons.style.display = 'flex';
    } else {
      shareButtons.style.display = 'none';
    }

    event.stopPropagation();
  }

  function initializeShareButtons() {
    const shareButtons = document.querySelectorAll('.share-btn');
    shareButtons.forEach(button => {
      button.removeEventListener('click', toggleShareButtons);
      button.addEventListener('click', toggleShareButtons);
    });

    document.addEventListener('click', function (event) {
      document.querySelectorAll('.share-buttons').forEach(buttonGroup => {
        buttonGroup.style.display = 'none';
      });
    });

    document.querySelectorAll('.share-buttons').forEach(buttonGroup => {
      buttonGroup.addEventListener('click', function (event) {
        event.stopPropagation();
      });
    });
  }

  function initializeEditButtons() {

    const editButtons = document.querySelectorAll('.editPostBtn');
    const formSectionEdit = document.querySelector('.new-article-form');
    const cardsListEdit = document.querySelector('.cards-list');
    const saveBtn = document.getElementById('savePostBtn');
    const editBtn = document.getElementById('editPostBtn');

    editButtons.forEach(button => {
      button.addEventListener('click', function () {

        saveBtn.style.display = 'none';
        editBtn.style.display = 'block';
        var blogData = $(this).data('blog');

        var descriptionWithoutSmall = blogData.description.replace(/<small[^>]*>.*?<\/small>/gi, '');

        $('#title').val(blogData.title);
        $('#subtitle').val(blogData.subtitle);
        editorInstance.setData(descriptionWithoutSmall);
        $('#imageTeste').val(blogData.url);
        $('#category').val(blogData.category);
        $('#shortDescription').val(blogData.obs);
        articleEditId = blogData.id;
 
        formSectionEdit.style.display = 'flex';
        cardsListEdit.style.display = 'none';
      });
    });

    document.getElementById('toggleFormBtn').addEventListener('click', function () {
      if (formSection.style.display === 'none' || formSection.style.display === '') {
        formSectionEdit.style.display = 'flex';
        cardsListEdit.style.display = 'none';
        saveBtn.style.display = 'block';
        editBtn.style.display = 'none';
      } else {
        formSectionEdit.style.display = 'none';
        cardsListEdit.style.display = 'flex';
      }
    });

    // Função para fechar o formulário
    document.getElementById('close-form').addEventListener('click', function () {
      formSectionEdit.style.display = 'none';
      cardsListEdit.style.display = 'flex';
      resetFormNewArticle();
    });

    const shortDescriptionInput = document.getElementById('shortDescription');
    const charCountElement = document.getElementById('charCount');

    shortDescriptionInput.addEventListener('input', function () {
      const charCount = this.value.length;
      charCountElement.textContent = charCount + ' characters (max. 160)';
    });

    document.getElementById('close-modal-save').addEventListener('click', function () {
      resetCategoryForm();
    });

  
    document.querySelectorAll('.delete-button').forEach(button => {
      button.addEventListener('click', function () {
        categoryIdToDelete = this.getAttribute('data-id');
        $('#confirmDeleteModal').modal('show');
      });
    });


    $('#deleteCategory').on('hidden.bs.modal', function () {
      document.getElementById('confirmationMessage').style.display = 'none';
    });

  }

  initializeShareButtons();

  function initializeCopyLinkButtons() {

    document.querySelectorAll('.copyLink').forEach(element => {
      element.addEventListener('click', function () {
        const link = this.getAttribute('data-link');
        copyToClipboard(link);
      });
    });

    function copyToClipboard(text) {
      navigator.clipboard.writeText(text).then(function () {
        alert("Link copiado!");
      }, function (err) {
        console.error('Erro ao copiar o texto: ', err);
      });
    }

  }
  initializeCopyLinkButtons()

});
