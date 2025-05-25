$(document).ready(function () {
  // Select all child elements of the products class
  const services = $(".services").children();

  // Initialize index for carousel effect
  let currentIndex = 0;

  // Function to display three elements in a carousel
  function displayCarousel() {
    // Hide all elements
    services.hide();

    // Show the next three elements in a loop
    for (let i = 0; i < 2; i++) {
      $(services[currentIndex]).show();
      currentIndex = (currentIndex + 1) % services.length;
    }

    // Move elements to the left
    $(".services")
      .children()
      .each(function (index) {
        $(this).animate(
          {
            left: `-${index * 33.33}%`,
          },
          {
            duration: 500,
            easing: "linear",
          }
        );
      });
  }

  // Call the displayCarousel function initially
  if ($(window).width() <= 725) {
    displayCarousel();

    // Set an interval to display the next three elements every 3 seconds
    setInterval(() => {
      displayCarousel();
    }, 5000);
  }
});

$.ajax({
  url: "products.xml",
  dataType: "xml",
  success: function (xmlDoc) {
    $.ajax({
      url: "products.xsl",
      dataType: "xml",
      success: async function (xslDoc) {
        let xsltProcessor = new XSLTProcessor();
        xsltProcessor.importStylesheet(xslDoc);
        let resultDoc = xsltProcessor.transformToFragment(xmlDoc, document);
        await $(".essentials-products").append(resultDoc);

        $(".product img").hover(
          (event) => {
            let src = $(event.target).attr("src");

            src = src.substring(7); //trims the assets/
            src = src.substring(0, src.indexOf(".")); //trims .jpg

            $(event.target).attr("src", "assets/" + src + "-focused.jpg");
          },
          (event) => {
            let src = $(event.target).attr("src");
            src = src.substring(7); //trims the assets/
            src = src.substring(0, src.indexOf("-")); //trims .jpg

            $(event.target).attr("src", "assets/" + src + ".jpg");
          }
        );

        // Select all child elements of the products class
        const products = $(".products").children();

        // Initialize index for carousel effect
        let currentIndex = 0;

        // Function to display three elements in a carousel
        function displayCarousel() {
          // Hide all elements
          products.hide();

          // Show the next three elements in a loop
          for (let i = 0; i < 1; i++) {
            $(products[currentIndex]).show();
            currentIndex = (currentIndex + 1) % products.length;
          }

          // Move elements to the left
          $(".products")
            .children()
            .each(function (index) {
              $(this).animate(
                {
                  left: `-${index * 33.33}%`,
                },
                {
                  duration: 500,
                  easing: "linear",
                }
              );
            });
        }

        // Call the displayCarousel function initially
        if ($(window).width() <= 725) {
          displayCarousel();

          // Set an interval to display the next three elements every 3 seconds
          setInterval(() => {
            displayCarousel();
          }, 5000);
        }
      },
    });
  },
});
