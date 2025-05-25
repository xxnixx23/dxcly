<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/index.css" />
  <link rel="icon" href="assets/skull.png" sizes="32x32" type="image/png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <title>DXCLY: Techwear</title>
</head>

<body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <?php
  session_start();

  //blocks admin from accessing the home page
  if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == "admin") {
    header("Location: dashboard.php");
  }
  ?>

  <?php include  "templates/header.php"; ?>

  <div class="content">
    <!-- Hero -->
    <div class="hero">
      <div class="hero-overlay">
      </div>
      <div class="hero-overlay2">
      </div>
      <img src="assets/hero.jpg" alt="" />
      <div class="hero-container">
        <span>Techwear</span>
        <p>
          Techwear refers to clothing made from technical fabrics like,
          GORE-TEX, Primaloft nylon, Polartec fleece, designed to allow for
          water-resistance, breathability, windproof and comfort. Techwear can
          also describe a specific aesthetic inspired by cyberpunk culture and
          urban fashion.
        </p>
      </div>
    </div>

    <!-- Types -->
    <div class="types">
      <a href="products.php?type=Hoodies">
        <div class="type">
          <img src="assets/hoodies-type.jpg" alt="" />
          <span>Hoodie</span>
        </div>
      </a>
      <a href="products.php?type=Jackets">
        <div class="type">
          <img src="assets/jackets-type.jpg" alt="" />
          <span>Jackets</span>
        </div>
      </a>
      <a href="products.php?type=Pants">
        <div class="type">
          <img src="assets/Pants-type.jpg" alt="" />
          <span>Pants</span>
        </div>
      </a>
      <a href="products.php?type=Footwear">
        <div class="type">
          <img src="assets/shoes-type.jpg" alt="" />
          <span>Footwear</span>
        </div>
      </a>
    </div>

    <!-- Parallax Image -->
    <div class="parallax"></div>

    <!-- Essentials-->
    <div class="essentials">
      <span>Techware Essentials</span>
      <div class="essentials-products"></div>
    </div>

    <!-- Testimonial -->
    <div class="testimonial">
      <img src="assets/testimonial.jpg" alt="" />
      <div class="testimony">
        <h4>Innovative and Futuristic</h4>
        <h3>Techwear Fashion</h3>
        <div class="testimony-content">
          <p>
            Made of special fabrics, techwear or urban techwear is a garment that
            is halfway between urban fashion and futuristic design. These highly
            functional garments combine technology and fashion for design and pure
            clothing practiced in all circumstances.
          </p>
          <p>
            Both resistant and comfortable, this range of clothing inspired by the
            military look but also cyberpunk appeals to both men and women.
            Waterproof trench coats, waterproof sneakers or seamless tee-shirts,
            useful clothes and designs.
          </p>
          <p>
            Made of special fabrics, techwear or urban techwear is a garment that
            is halfway between urban fashion and futuristic design. These highly
            functional garments combine technology and fashion for design and pure
            clothing practiced in all circumstances. Both resistant and
            comfortable, this range of clothing inspired by the military look but
            also cyberpunk appeals to both men and women. Waterproof trench coats,
            waterproof sneakers or seamless tee-shirts, useful clothes and
            designs. Shop the latest techwear trends and create the techwear look
            that suits you. Military, cyberpunk or ninja techwear inspired by
            Japanese culture, find the style that suits you among the many
            references available on our site.

        </div>
        </p>
      </div>
    </div>

    <?php include  "templates/footer.php"; ?>

    <script src="js/index.js"></script>
</body>

</html>