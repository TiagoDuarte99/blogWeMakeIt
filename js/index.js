document.addEventListener('DOMContentLoaded', function () {
  var sectionCategories = document.getElementById('section-categories');
  var listCategories = document.getElementById('list-categories');
 
  
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




  //Filtrar
/*   var categoryButtons = document.querySelectorAll('.category-button'); */

  document.body.addEventListener('click', function(event) {
    if (event.target.classList.contains('category-button')) {
        var categoryId = event.target.getAttribute('data-id');
        sendCategoryId(categoryId);
    }
});

  function sendCategoryId(categoryId) {
    var formData = new FormData();
    formData.append('method', 'GET');
    formData.append('categoryId', categoryId);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'list-articles/articles-functions.php', true);
    xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 300) {
        console.log(categoryId);
        var listCategories = document.getElementById('list-categories');
        listCategories.innerHTML = xhr.responseText;

        console.log(xhr.responseText);
      } else {
        console.error('Erro ao enviar categoria:', xhrReload.responseText);
      }
    };
    xhr.onerror = function () {
      console.error('Erro de rede ao enviar categoria.');
    };
    xhr.send(formData);
  }
  //Filtrar


  sectionCategories.addEventListener('click', function (event) {
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

      xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
          document.getElementById('categoryName').value = '';
          document.getElementById('categoryObs').value = '';
          var closeButton = document.getElementById('close-modal-save');
          closeButton.click();
          var navbarCategoriesContainer = document.getElementById('section-categories');
          var xhrReload = new XMLHttpRequest();
          xhrReload.open('GET', 'categories/navbar-categories.php', true);
          xhrReload.onload = function () {
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
      xhr.onerror = function () {
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
      xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
          // Processar a resposta conforme necessário
          var closeButton = document.getElementById('close-modal-delete');
          closeButton.click();
          var navbarCategoriesContainer = document.getElementById('section-categories');
          var xhrReload = new XMLHttpRequest();
          xhrReload.open('GET', 'categories/navbar-categories.php', true);
          xhrReload.onload = function () {
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
      xhr.onerror = function () {
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
      xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
          // Processar a resposta conforme necessário
          var closeButton = document.getElementById('close-modal-edit');
          closeButton.click();
          var navbarCategoriesContainer = document.getElementById('section-categories');
          var xhrReload = new XMLHttpRequest();
          xhrReload.open('GET', 'categories/navbar-categories.php', true);
          xhrReload.onload = function () {
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
      xhr.onerror = function () {
        console.error('Erro de rede ao enviar requisição.');
      };
      xhr.send(formData);
    }

  });

  listCategories.addEventListener('click', function (event) {
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

      xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
          var closeButton = document.getElementById('close-modal-save-post');
          closeButton.click();
          /*             var navbarCategoriesContainer = document.getElementById('section-categories'); */
          var xhrReload = new XMLHttpRequest();
          xhrReload.open('GET', 'list-articles/list-articles.php', true);
          xhrReload.onload = function () {
            if (xhrReload.status >= 200 && xhrReload.status < 300) {
   /*            console.log(xhrReload.responseText)
              listCategories.innerHTML = xhrReload.responseText; */
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
      xhr.onerror = function () {
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

      xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
          var xhrReload = new XMLHttpRequest();
          xhrReload.open('GET', 'list-articles/list-articles.php', true);
          xhrReload.onload = function () {
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

      xhr.onerror = function () {
        console.error('Erro de rede ao enviar requisição.');
      };

      xhr.send(formData);
    }
  });

});
