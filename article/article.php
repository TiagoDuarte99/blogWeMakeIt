<?php include_once 'article-functions.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($article['title']); ?></title>
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="../ckeditor/sample/styles.css">


  <!-- icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- BOOTSTRAP -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

  <!-- JSQUERY -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

  <!--   
  <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script> -->


  <!-- 
  Adicionar isto caso exista uma pagina para o utilizador que escreveu o artigo  
  "url": "site se tiver bibliografio do autor ou assim/<?php echo urlencode($article['name']); ?>" -->
  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BlogPosting",
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "<?php echo htmlspecialchars($article['descriptionios']); ?>"
      },
      "headline": "<?php echo htmlspecialchars($article['title']); ?>",
      "image": {
        "@type": "ImageObject",
        "url": "<?php echo htmlspecialchars($article['url']); ?>",
        "width": 885,
        "height": 375
      },
      "datePublished": "<?php echo date(DateTime::ATOM, strtotime($article['created'])); ?>",
      "dateModified": "<?php echo date(DateTime::ATOM, strtotime($article['updated_at'])); ?>",
      "author": {
        "@type": "Person",
        "name": "<?php echo htmlspecialchars($article['name']); ?>",
        "identifier": "<?php echo htmlspecialchars($article['user_id']); ?>"
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
      },
      "description": "<?php echo htmlspecialchars($article['obs']); ?>",
      "genre": "<?php echo htmlspecialchars($article['category_name']); ?>"
    }
  </script>
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

  <!--   <div class="container">
    <div class="row">
      <div class="div-title">
        <h1>Blog Farmacias</h1>
      </div>
    </div>
  </div>
 -->

  <section id="section-article">
    <div class="container">
      <div class="row article-complet">
        <div class="col-md-8">
          <div class="buttons-nav">
            <a href="../list-articles/list-articles.php">
              <button>Voltar</button>
            </a>
            <a href="../list-articles/list-articles.php?categoryId=<?php echo $article['category']; ?>">
              <button>
                <?php echo htmlspecialchars($article['category_name']); ?>
              </button>
            </a>
          </div>
          <div class="title">
            <h1>
              <?php echo htmlspecialchars($article['title']); ?>
            </h1>

          </div>
          <div class="subtitle"><?php echo htmlspecialchars($article['subtitle']); ?></div>
          <div class="meta">
            <p><i class="fa-solid fa-user"></i> <?php echo htmlspecialchars($article['name']); ?></p>
            <p><i class="fa-solid fa-calendar"></i> <?php echo htmlspecialchars($article['created']); ?></p>
            <p>
              <?php

              $wordsCountDescription = $article['description'];
              
              $wordsCount = 0;
              if (preg_match('/<small\s+id="wordCharCount"\s+class="form-text\s+text-muted">(\d+)\s+words<\/small>/', $wordsCountDescription, $matches)) {
                $wordsCount = intval($matches[1]);
              }
              $averageWordsPerMinute = 200; // Média de palavras por minuto
              $readingTimeMinutes = ceil($wordsCount / $averageWordsPerMinute);
              echo $readingTimeMinutes . ' minutes leitura';
              ?>
            </p>
          </div>
          <div class="content">
            <?php if (!empty($article['url'])) : ?>
              <img class="img-blog" src="<?php echo htmlspecialchars($article['url']); ?>" alt="Blog Image">
            <?php endif; ?>
            <?php echo $article['description']; ?>
          </div>



          <div class="social-share">
            <a href="https://api.whatsapp.com/send?text=<?php echo urlencode('Title: ' . $article['title'] . ' ' . 'Description: ' .  $article['descriptionios']); ?>" target="_blank">
              <i class="fab fa-whatsapp"></i> WhatsApp
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($article['descriptionios']); ?>" target="_blank">
              <i class="fab fa-facebook"></i> Facebook
            </a>
            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($article['descriptionios']); ?>&text=<?php echo urlencode($article['title']); ?>" target="_blank">
              <i class="fab fa-twitter"></i> Twitter
            </a>
            <p id="copyLink">
              <i class="fas fa-link"></i> Copiar Link
            </p>
          </div>


        </div>
      </div>

      <div class="recent-posts">
        <p>Posts Recentes</p>
        <a href="../list-articles/list-articles.php">
          <button>Voltar</button>
        </a>
      </div>
      <div class="articles-container">

        <?php

        for ($i = 0; $i < 3 && $i < count($blogs); $i++) {
          $blog = $blogs[$i];
        ?>
          <div class="card-blog col-lg-4 col-sm-6 col-12">
            <div id="article" class="article">

              <div class="img-card">
                <img src="<?php echo $blog['url']; ?>" alt="<?php echo $blog['title']; ?>">
              </div>
              <div class="info">
                <div class="title">
                  <h2><?php echo $blog['title']; ?></h2>
                </div>

                <div class="line"></div>

                <div class="name">
                  <p><i class="fa-solid fa-user"></i><?php echo $blog['name']; ?></p>
                </div>

                <div class="date-time">
                  <div class="date">
                    <p><?php echo $blog['created']; ?></p>
                  </div>
                  <div>
                    <p>-</p>
                  </div>
                  <div class="time-read">
                    <p>9 min Leitura</p>
                  </div>
                </div>
                <div class="read-more">
                  <a href="article.php?id=<?php echo htmlspecialchars($blog['id']); ?>"><button>LEER MÁS</button>
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
  </section>

  <script src="../js/article.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>


</body>

</html>