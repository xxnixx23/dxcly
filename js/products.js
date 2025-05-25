$(document).ready(function () {
  //get url params
  const urlParams = new URLSearchParams(window.location.search);
  const type = urlParams.get("type");

  const container = $(".products-collection");
  let products;

  let descriptions = {
    techwear:
      "Hoodies are mid-layer garments that can add another dimension to your techwear outfit. Known as a must-have for the warmth they provide in cold weather. They are also a key part of the techwear outfit providing a stylish layer over your clothes. Find the hoodie that fits your style from our collection of affordable techwear hoodies.",
    jackets:
      "Our techwear jackets collection provides high-performance clothing that can protect you from various elements and elevate your outfit with a unique style.",
    hoodies:
      "Hoodies are mid-layer garments that can add another dimension to your techwear outfit. Known as a must-have for the warmth they provide in cold weather. They are also a key part of the techwear outfit providing a stylish layer over your clothes. Find the hoodie that fits your style from our collection of affordable techwear hoodies.",
    vests:
      "Techwear expands the potential of vest use with jacket alternatives that support mobility, core protection and carry-on capabilities.",
    pants:
      "Introducing the latest and greatest in techwear pants for 2024. In order to keep you cozy and safe in any circumstance, our collection includes the most cutting-edge materials and patterns available. With features like reinforced knees and pockets, waterproof and breathable fabrics, and a futuristic design, these trousers are made to survive the worst weather conditions. Prepare to enter the world of cutting-edge, high-performance fashion.",
    shirts:
      "Techwear shirts are a type of clothing that combines the functionality of athletic wear with the style of streetwear. They often feature technical fabrics such as nylon or spandex, which are strong, breathable, and quick-drying. Techwear shirts may also have pockets, zippers, and other functional elements that can be used to store items such as phones, wallets, and keys. They often have a tapered fit and ergonomic design to enhance mobility and comfort.",
    cloaks:
      "A techwear cloak is a modern, functional outerwear garment influenced by futuristic and cyberpunk aesthetics, often integrating advanced materials and technological features for enhanced adaptability, comfort, and urban utility.",
    shorts:
      "Techwear shorts are a type of clothing that combines the functionality of athletic wear with the style of streetwear. They often feature technical fabrics, such as nylon or spandex, and may have pockets, zippers, and other features that are designed to be functional and durable. Techwear shorts are popular among people who are active and want clothing that can keep up with their lifestyle, as well as those who are interested in fashion and want to make a statement with their clothing.",
    footwear:
      "Techwear shoes are a type of technical footwear that are designed to provide protection, functionality, and style. Techwear shoes offer the performance and technical benefits of military footwear with a cutting edge aesthetic. As an essential part of your techwear outfit, techwear shoes are more than ever a useful and fashion accessory, engineered to withstand the toughest conditions while providing you with optimal comfort and original style. In this sense, techwear shoes are no exception to the rule and are made with advanced materials and technical fabrics for enhanced performance.",
    hats: "Our Techwear Hats collection is a must-have for fashion-forward individuals who love to mix style with functionality. This collection features a range of hats that are designed to keep you protected in all weather conditions while still looking stylish and modern.",
    masks:
      "Need extra face protection? The best Techwear masks will take your Techwear clothing style to a new level! Masks occupy a special place in technical clothing, because this fashion concept is directly related to cyberpunk. Techwear masks can also provide protection and comfort in harsh environments.",
    belts:
      "Techwear belts are a trendy and stylish accessory that adds the perfect touch to any outfit. From everyday, casual wear to more high-end looks, these belts provide both function and fashion.",
    gloves:
      "Techwear gloves are a type of technical clothing item that are designed to protect the wearer's hands while also providing functionality and style. They typically feature advanced fabrics and design elements such as:",
    backpacks:
      "The technical backpack spectrum is vast, but the techwear backpack is undeniably its crown jewel. The urban appeal of these techwear gear bags is irresistible to city dwellers. With sleek, cyberpunk backpack designs, they flawlessly mirror the high-octane, tech-driven urban lifestyle. But it’s not just about looks; techwear backpacks are replete with unique features, from water-resistant nooks to embedded USB chargers and other high-tech backpacks features.",
  };

  let xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      //display products

      products = JSON.parse(this.responseText);

      displayProducts();
    }
  };

  if (!type) {
    //fetch all products
    xhr.open("GET", "api/products/fetch.php", true);
    xhr.send();

    $("#title").text("Techwear");
    $("#description").text(descriptions.techwear);
  } else {
    //fetch products by type
    let data = JSON.stringify({ type: type });

    xhr.open("POST", "api/products/fetch_type.php", true);
    xhr.send(data);

    $("#title").text(type);

    let description = $("#description");

    switch (type) {
      case "Jackets":
        description.text(descriptions.jackets);
        break;
      case "Hoodies":
        description.text(descriptions.hoodies);
        break;
      case "Vests":
        description.text(descriptions.vests);
        break;
      case "Pants":
        description.text(descriptions.pants);
        break;
      case "Shirts":
        description.text(descriptions.shirts);
        break;
      case "Cloaks":
        description.text(descriptions.cloaks);
        break;
      case "Shorts":
        description.text(descriptions.shorts);
        break;
      case "Footwear":
        description.text(descriptions.footwear);
        break;
      case "Hats":
        description.text(descriptions.hats);
        break;
      case "Masks":
        description.text(descriptions.masks);
        break;
      case "Belts":
        description.text(descriptions.belts);
        break;
      case "Gloves":
        description.text(descriptions.gloves);
        break;
      case "Backpacks":
        description.text(descriptions.backpacks);
        break;
    }
  }

  $(".sort").on("change", function () {
    switch (this.value) {
      case "Ascending":
        products.sort((a, b) => a.price - b.price);
        break;
      case "Descending":
        products.sort((a, b) => b.price - a.price);
    }

    displayProducts();
  });

  $(".search-btn").click(function () {
    displayProducts();
  });

  function displayProducts() {
    //reset container
    container.empty();

    //set number of results
    let results = 0;

    //get search term
    let searchTerm;
    if ($(".search").val()) {
      searchTerm = $(".search").val();
      searchTerm = searchTerm.toString().toLowerCase();
    }

    $.each(products, function (index, product) {
      let productName = product.name.toLowerCase();

      if (productName.includes(searchTerm) || !searchTerm) {
        let productElement = $("<a>")
          .addClass("product")
          .attr("href", "product.php?id=" + product.id);
        let productImageElement = $("<img>").attr("src", product.location);
        let productNameElement = $("<h6>").text(product.name);
        let productPriceElement = $("<span>").text(product.price);

        productElement.append([
          productImageElement,
          productNameElement,
          productPriceElement,
        ]);

        container.append(productElement);
        results++;
      }
    });

    $(".products-collection .product").slice(4).hide();
    $("#pagination").pagination({
      items: results,
      itemsOnPage: 4,
      cssStyle: "dark-theme",
      onPageClick: function (pageNumber) {
        $(".products-collection .product").hide();
        $(".products-collection .product")
          .slice((pageNumber - 1) * 4, pageNumber * 4)
          .show();
      },
    });

    $(".number-of-products").text(results + " Results");
  }
});
