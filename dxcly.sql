-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2025 at 09:32 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dxcly`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `cart_quantity` int(11) NOT NULL DEFAULT 1,
  `status` set('In Cart','To Pay','To Receive','Completed') NOT NULL DEFAULT 'In Cart',
  `ordered_date` datetime DEFAULT NULL,
  `received_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`cart_id`, `user_id`, `product_id`, `cart_quantity`, `status`, `ordered_date`, `received_date`) VALUES
(20, 18, 50, 1, 'Completed', '2025-05-18 09:55:28', '2025-05-19 23:56:06'),
(21, 18, 63, 1, 'Completed', '2025-05-18 09:57:42', '2025-05-22 23:59:48'),
(22, 18, 61, 1, 'To Pay', '2025-05-18 10:00:04', NULL),
(23, 19, 47, 2, 'Completed', '2025-05-18 15:53:17', '2025-05-23 05:53:57'),
(24, 19, 60, 1, 'Completed', '2025-05-18 15:55:11', '2025-05-28 05:55:33'),
(25, 19, 42, 2, 'Completed', '2025-05-23 18:44:03', '2025-06-04 08:44:18');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` set('Login','Log Out','Update Profile','Change Password') NOT NULL,
  `user_name` varchar(256) NOT NULL,
  `log_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `action`, `user_name`, `log_date`) VALUES
(48, 18, 'Login', 'niks', '2025-05-18 09:55:19'),
(49, 19, 'Login', 'Nikki', '2025-05-18 10:03:44'),
(50, 18, 'Log Out', 'niks', '2025-05-18 10:05:24'),
(51, 19, 'Log Out', 'Nikki', '2025-05-18 14:49:39'),
(52, 19, 'Login', 'Nikki', '2025-05-18 15:52:08'),
(53, 19, 'Login', 'Nikki', '2025-05-23 18:24:55'),
(54, 19, 'Log Out', 'Nikki', '2025-05-23 18:29:19'),
(55, 19, 'Login', 'Nikki', '2025-05-23 18:43:45');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `location` varchar(256) NOT NULL,
  `price` double NOT NULL DEFAULT 0,
  `type` set('Jackets','Hoodies','Vest','Pants','Shirts','Cloaks','Shorts','Footwear','Hats','Masks','Belts','Gloves','Backpacks') NOT NULL,
  `description` varchar(2048) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 15
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `location`, `price`, `type`, `description`, `quantity`) VALUES
(1, 'BLACK TECHWEAR JACKET\r\n', 'assets\\jackets\\black-techwear-jacket-techwear-351_360x.jpg', 3999, 'Jackets', 'This black techwear jacket is the perfect garment to enhance your techwear look. Fashioned from a blend of lightweight yet sturdy materials, this jacket is versatile enough for the brisk winds of fall and the biting cold of winter. It\'s tailored for the mo', 0),
(2, 'XGXF JACKET\r\n', 'assets\\jackets\\xgxf-jacket-techwear-667_360x.jpg', 3999, 'Jackets', 'This XGXF jacket (X.G.X.F.) is a fashionable windbreaker, thanks to the many details that decorate it for a stunning rendering. In addition, this functional clothing has numerous storage pockets to allow you to take all your personal belongings with you wh', 10),
(3, 'PUNK BLACK DENIM JACKET', 'assets\\jackets\\punk-black-denim-jacket-techwear-605_360x.jpg', 3999, 'Jackets', 'Assert your rebellious soul! This Punk black denim jacket is printed on the back with a red demon head. The ideal outfit for all dissidents against the system.\r\n\r\nThe jacket features a striking print of a red demon head on the back, symbolizing a fierce de', 0),
(4, 'TECHWEAR RAIN JACKET', 'assets\\jackets\\techwear-rain-jacket-techwear-769_360x.jpg', 3499, 'Jackets', 'This water-resistant rain jacket is inspired by Korean Techwear. Made of light and hydrophobic technical material, this water-repellent jacket allows you to stay dry while the rain comes down.', 6),
(5, 'TECHWEAR BOMBER JACKET', 'assets\\jackets\\techwear-bomber-jacket-techwear-676_360x.jpg', 5699, 'Jackets', 'Wear a fashion emblem in a techwear style. The bomber was originally a vest worn by U.S. Army pilots. The bomber or \"flight jacket\", is a timeless and must-have in this street and urban techwear declination. Ideal to wear with cargo pants for an assured te', 12),
(6, 'TECHWEAR COAT', 'assets\\jackets\\techwear-coat-techwear-558_360x.jpg', 8499, 'Jackets', 'Upgrade your dark style with this must-have techwear coat. Equipped with two zip pockets and a double hood, this techwear coat adds a technical dimension to your outfit. Inspired by the trench coat revisited with an urban look, this coat guarantees you an ', 12),
(7, 'BLACK SLEEVELESS JACKET', 'assets\\jackets\\black-sleeveless-jacket-techwear-593_360x.jpg', 4499, 'Jackets', 'Adopt an urban look with this black sleeveless jacket and its hood, ideal for mid-season. Tailored for the mid-season but versatile enough for layering in various climates, this jacket is the perfect amalgamation of form and function. The hooded wonder of ', 12),
(8, 'CYBERPUNK FUTURISTIC JACKET', 'assets\\jackets\\cyberpunk-futuristic-jacket-techwear-637_360x.jpg', 8499, 'Jackets', 'Looking for a Cyber Goth style? This jacket printed with a transhuman logo is what you are looking for! This cyberpunk outerwear is greatly inspired by the futuristic cyberpunk universe with an original and avant-garde design. Made from thin and resistant ', 11),
(9, 'FUTURISTIC HOODIE', 'assets\\hoodies\\futuristic-hoodie-techwear-574_540x.jpg', 6499, 'Hoodies', 'Discover a garment that pushes the boundaries of contemporary fashion. Our Futuristic Hoodie offers more than just warmth and comfort, it offers a taste of what\'s to come in the realms of techwear and futuristic design. This futuristic hoodie is available ', 11),
(10, 'FUNCTIONAL HOODIE', 'assets\\hoodies\\functional-hoodie-techwear-171_540x.jpg', 6499, 'Hoodies', 'This black functional hoodie is designed to meet the needs of techwear enthusiasts. With its sleek black design and unique features, this hoodie is perfect for anyone looking to blend style with practicality.\r\n\r\nThe functional hoodie is made from high-qual', 12),
(11, 'CENTIPEDE HOODIE', 'assets\\hoodies\\centipede-hoodie-techwear-832_540x.jpg', 5499, 'Hoodies', 'Meticulously designed, the Centipede Hoodie features a captivating centipede graphic that winds its way from the small of the back, along the spine, and up to the hood. This design isn\'t just unique—it\'s a daring style statement. With its blend of bold vis', 12),
(12, 'TURTLENECK HOODIE', 'assets\\hoodies\\turtleneck-hoodie-techwear-306_360x.jpg', 6699, 'Hoodies', 'Experience both sophistication and coziness with our Turtleneck Hoodie—an evolution in laid-back apparel. This hoodie takes a beloved classic and gives it a modern update, featuring an elegant turtleneck that distinguishes it from conventional choices.', 15),
(13, 'BLACK HOODIE STREETWEAR', 'assets\\hoodies\\black-hoodie-streetwear-techwear-345_720x.jpg', 8499, 'Hoodies', 'Made with premium, soft-touch materials, our hoodie promises to be a lasting companion on your urban adventures. The luxurious fabric ensures breathability and comfort, making it perfect for the bustling city life.\r\n\r\nThis hoodie is more than its captivati', 15),
(14, 'CYBERPUNK HOODIE', 'assets\\hoodies\\cyberpunk-hoodie-techwear-581_360x.jpg', 6699, 'Hoodies', 'Amidst the surge of tech-driven fashion trends, the Cyberpunk Hoodie stands out as a captivating favorite among contemporary aficionados. Marrying advanced technology with cutting-edge design, this hoodie represents the next chapter in forward-thinking str', 15),
(15, 'CYBERPUNK NINJA HOODIE', 'assets\\hoodies\\cyberpunk-ninja-hoodie-techwear-869_360x.jpg', 6699, 'Hoodies', 'The deep ebony material acts as a backdrop, highlighting a fusion of detailed patterns influenced by ancient ninja warriors and the glowing avenues of cyberpunk urban jungles. Whether wandering through the dynamic lanes of a city or venturing into the real', 15),
(16, 'BLACK TACTICAL HOODIE', 'assets\\hoodies\\black-tactical-hoodie-techwear-390_360x.jpg', 6499, 'Hoodies', 'This hoodie embraces the ethos of techwear, integrating advanced fabric technologies with a sleek and modern aesthetic. When you think of the perfect intersection between style, comfort, and function, this hoodie should come to mind. With its distinct dark', 15),
(17, 'SCARLXRD MILITARY VEST', 'assets\\vests\\scarlxrd-military-vest-techwear-365_360x.jpg', 4699, 'Vest', 'Complete your style with this Scarlxrd tactical vest. This tactical vest is inspired by military equipment. It is one of the accessories that make up the many techwear outfits of the singer Scarlxrd as in his video clip \"BANDS\". This techwear vest is made ', 15),
(18, 'TACTICAL VEST TECHWEAR', 'assets\\vests\\tactical-vest-techwear-techwear-634_360x.jpg', 4699, 'Vest', 'This tactical vest techwear has an adjustable strap to perfectly fit your size. Inspired by military equipment, this vest is the perfect accessory for an urban techwear outfit. The perfect fashion bulletproof vest to add military touch to your techwear sty', 15),
(19, 'TECHWEAR UTILITY VEST', 'assets\\vests\\techwear-utility-vest-techwear-209_360x.jpg', 4499, 'Vest', 'This sleeveless vest is equipped with six pockets of different sizes on the front. Its small integrated side bag allows you to store your larger belongings. Its zipper closure and back drawstrings allow for an ideal fit. The Velcro strip on the chest is re', 15),
(20, 'BULLETPROOF VEST TECHWEAR', 'assets\\vests\\bulletproof-vest-techwear-techwear-781_360x.jpg', 4499, 'Vest', 'Made of high density polyester with breathable mesh combined, this black bulletproof vest is equipped with two adjustable belts to easily adjust the vest to your size. A removable equipment pouch and a shotgun shell holder are located on both sides of the ', 15),
(21, 'BLACK TACTICAL VEST STREETWEAR', 'assets\\vests\\black-tactical-vest-streetwear-techwear-555_360x.jpg', 4699, 'Vest', 'Whether you\'re looking for a practical or stylish accessory to dress up your style, this techwear vest perfectly combines the best of both thanks to a jacket made of technical materials that feature numerous storage pockets and an avant-garde style inspire', 15),
(22, 'RUNNING CHEST PACK', 'assets\\vests\\running-chest-pack-techwear-273_360x.jpg', 3999, 'Vest', 'A must-have to perfect your techwear style. Get forward-thinking clothes that provide both utility and comfort with our Techwear Vest collection.', 15),
(23, 'STREETWEAR VEST', 'assets\\vests\\streetwear-vest-techwear-998_360x.jpg', 4999, 'Vest', 'This streetwear vest brings you comfortable clothing for everyday use in urban environments. The vest is equipped with two front pockets for storing all equipment and daily necessities. This vest is perfect for any early morning activities. This piece also', 15),
(24, 'STREETWEAR TACTICAL VEST', 'assets\\vests\\streetwear-tactical-vest-techwear-119_360x.jpg', 6499, 'Vest', 'Wear it over a t-shirt, long sleeve top or hoodie for functional street style. Throw on this functional vest top with two chest pockets, and you\'ll be ready to hit the streets in urban style. The jacket has a zip closure, so you can easily put on and take ', 15),
(25, 'TECHWEAR JOGGERS', 'assets\\pants\\techwear-joggers-techwear-624_360x.jpg', 4999, 'Pants', 'Step into the future of urban fashion while ensuring you remain agile, comfortable, and ready for any adventure. With our Tactical Joggers, we offer the perfect fusion of modern design aesthetics, utility, and unparalleled comfort.\r\nMore comfortable than p', 15),
(26, 'TACTICAL JOGGERS', 'assets\\pants\\tactical-joggers-techwear-844_360x.jpg', 5499, 'Pants', 'These pants are the perfect mix of comfort, style and utility. Equipped with many pockets, these black jogging pants are resistant and stretchy for everyday comfort. Its futuristic design is ideal for a techwear, street goth style.\r\n\r\nThe tactical joggers ', 14),
(27, 'TECHWEAR CARGO PANTS', 'assets\\pants\\techwear-cargo-pants-techwear-476_360x.jpg', 6499, 'Pants', 'When it comes to fashion that effortlessly merges utility with avant-garde style, techwear holds its ground. The Techwear Cargo Pants are a prime example, blending the robustness of military apparel with edgy streetwear aesthetics.', 15),
(28, 'TECHWEAR BLACK PANTS', 'assets\\pants\\techwear-black-pants-techwear-337_360x.jpg', 6499, 'Pants', 'Very comfortable to wear and made of soft and resistant technological materials, these black pants can easily be worn with any style. All in black or contrasting with a colorful t-shirt, these famous military-inspired pants will enhance your look with grea', 15),
(29, 'X T-SHIRT', 'assets\\shirts\\x-t-shirt-techwear-167_360x.jpg', 4499, 'Shirts', 'This trendy shirt made of cotton as a big cross on the front. The X tee-shirt, made of resistant materials, can be worn all year round with a maximum comfort. Complete your outfit with a cap and a short or cargo pants for a techwear style.', 15),
(30, 'SCI-FI SHIRT', 'assets\\shirts\\sci-fi-shirt-techwear-892_360x.jpg', 4699, 'Shirts', 'This shirt will bring you a futuristic style with ease. Available in two colors, it will perfectly match your techwear outfit. Wear this shirt inspired by science-fiction culture with a black cargo pants and a face mask to get a Cyberpunk look.', 15),
(31, 'URBAN T-SHIRT DESIGN', 'assets\\shirts\\urban-t-shirt-design-techwear-552_360x.jpg', 4499, 'Shirts', 'The Urban T-Shirt Design is not just a piece of clothing; it\'s an embodiment of boldness and individuality, built for the trendsetters and rule-breakers. This faded black tee creates a unique aesthetic that speaks to the heart of urban fashion.\r\n\r\nThe Urba', 15),
(32, 'PAIN SHIRT', 'assets\\shirts\\pain-shirt-techwear-189_360x.jpg', 4699, 'Shirts', 'Complete your urban techwear wardrobe with the Light Reflective Shirt for an underground and futuristic look. Create a more finished appearance with other Techwear shirts essentials.', 15),
(33, 'LIGHT REFLECTIVE SHIRT', 'assets\\shirts\\light-reflective-shirt-techwear-930_360x.jpg', 4699, 'Shirts', 'Unisex t-shirt with round neckline and reflective pattern. Expose the t-shirt to the light to reveal its full potential! This reflective t-shirt can be worn for sports to be visible at night or simply to have a trendy and original style. Its unique design ', 15),
(34, 'BLACK WASHED OVERSIZED T SHIRT', 'assets\\shirts\\black-washed-oversized-t-shirt-techwear-644_360x.jpg', 4299, 'Shirts', 'Whether you\'re aiming for a laid-back urban vibe or a polished casual appearance, this shirt acts as the ideal foundation. Made from an exceptional blend of pre-washed cotton and polyester, the material is designed for ultimate softness against your skin.\r', 15),
(35, 'CYBERPUNK CLOAK', 'assets\\cloaks\\175_360x.png', 6499, 'Cloaks', 'assets\\cloaks\\175_360x.png', 15),
(36, 'TACTICAL CLOAK', 'assets\\cloaks\\tactical-cloak-techwear-491_360x.jpg', 8499, 'Cloaks', 'This functional rain coat is made of resistant technical materials. It can be quickly and easily put on to protect you from the weather. It is equipped with a central pocket and a high collar to protect you from the wind. The perfect outdoor rainproof cloa', 15),
(37, 'ECHWEAR CARGO SHORTS', 'assets\\shorts\\techwear-cargo-shorts-329_360x.jpg', 4999, 'Shorts', 'Spend the summer in style with these cargo pants. Made of breathable and lightweight materials, these black shorts are a must-have to complete your techwear look even during the hot season. Constructed from premium, lightweight fabrics, these shorts provid', 15),
(38, 'BARBED WIRE SHORTS', 'assets\\shorts\\barbed-wire-shorts-techwear-252_360x.jpg', 4899, 'Shorts', 'These shorts are printed with a barbed wire pattern that brings an original and alternative touch to your outfit. These shorts for men and women have two discreet pockets and an elastic waist for comfort in all circumstances. Made of breathable materials, ', 15),
(39, 'ANIME STREETWEAR SHORTS', 'assets\\shorts\\anime-streetwear-shorts-techwear-903_360x.jpg', 4699, 'Shorts', 'In the world of streetwear, anime-inspired designs have always held a unique place, combining the passion of fandom with the bold statements of urban fashion.', 15),
(40, 'ALTERNATIVE SHORTS', 'assets\\shorts\\alternative-shorts-techwear-739_360x.jpg', 4999, 'Shorts', 'Stay cool all summer long by completing your wardrobe with the comfortable and lightweight Combat shorts to spend a summer in style. For a more underground and futuristic look, discover our Techwear shorts.', 15),
(41, 'AFFORDABLE TECHWEAR SHOES', 'assets\\footwear\\affordable-techwear-shoes-techwear-995_360x.jpg', 5499, 'Footwear', 'This pair of shoes is the perfect accessory to finalize your techwear style. They are made of breathable materials and are equipped with anti-shock soles for your comfort. Opt for a dark and military style with the shoes in black color, or a pure and futur', 15),
(42, 'TECHWEAR NINJA SHOES', 'assets\\footwear\\techwear-ninja-shoes-techwear-136_360x.jpg', 4999, 'Footwear', 'Drawing inspiration from the agile footwear of historical ninjas, these Techwear Ninja Shoes integrate time-honored aesthetics with the latest in techwear design. The result? Footwear that resonates with a deep sense of history, while being unapologeticall', 13),
(43, 'CYBERPUNK BASEBALL CAP', 'assets\\hats\\cyberpunk-baseball-cap-techwear-680_360x.jpg', 3999, 'Hats', 'The Cyberpunk Baseball Cap is the ultimate accessory for those who love both style and technology. This black cap features an adjustable strap, ensuring a perfect fit for any head size. The standout feature of this cap is its bold and futuristic cyberpunk ', 15),
(44, 'BLACK MASK TECHWEAR', 'assets\\masks\\black-mask-techwear-techwear-272_360x.jpg', 4999, 'Masks', 'Adopt a techwear look to make amazing photos or cosplay with the black mask techwear. A solid mask made of PVC with interchangeable straps.', 15),
(45, 'BEST TECHWEAR SHOES', 'assets\\footwear\\best-techwear-shoes-techwear-404_360x.jpg', 6999, 'Footwear', 'These functional shoes are an essential element to achieve your style. Complementing your cargo pants and techwear t-shirt, this pair of shoes will add a futuristic and design touch to your outfit.', 12),
(46, 'CHUNKY TECHWEAR SHOES', 'assets\\footwear\\chunky-techwear-shoes-techwear-148_360x.jpg', 6499, 'Footwear', 'Empower every step you take in the urban jungle with the new Chunky Techwear Shoes. Marrying bold aesthetics with functional design, these shoes redefine the standards of modern-day footwear, echoing the rebellious spirit of techwear enthusiasts. Crafted w', 15),
(47, 'TECHWEAR BASEBALL CAP', 'assets\\hats\\techwear-baseball-cap-techwear-132_360x.jpg', 3499, 'Hats', 'The Techwear Baseball Cap is the perfect accessory for those who love to stay on top of the latest tech wear trends. Made with resistant and breathable materials, this cap is designed to keep you comfortable and cool, even during the hottest days. The adju', 13),
(48, 'REFLECTIVE SNEAKERS', 'assets\\footwear\\reflective-sneakers-techwear-281_360x.jpg', 8499, 'Footwear', 'Make your footsteps shine even in the darkest hours with our uniquely designed Reflective Sneakers. These reflective sneakers are equipped with reflective strips. The reflective technology allows you to reflect light sources, so you can be visible in all c', 15),
(49, 'EZ SHOES', 'assets\\footwear\\ez-shoes-techwear-720_360x.jpg', 5499, 'Footwear', 'From the instant you step into our EZ sneakers, you\'ll discover unparalleled comfort thanks to a specialized blend of materials. These sneakers adapt effortlessly to the unique shape of your feet, setting a new standard for exceptional comfort.', 15),
(50, 'JAPANESE BASEBALL CAP', 'assets\\hats\\japanese-baseball-cap-techwear-170_360x.jpg', 3499, 'Hats', 'This Japanese baseball cap is made of cotton and polyester. It is equipped with eyelets to let the air circulate while protecting you effectively from the rain and the sun with its visor. This snapback cap adapts easily to all heads with its adjustable str', 14),
(51, 'WARCORE MASK', 'assets\\masks\\warcore-mask-techwear-308_360x.jpg', 5499, 'Masks', 'The Warcore Mask is a protective gear inspired by military personnel and extreme sport enthusiasts alike. Designed with the latest in advanced technology, the Warcore Mask offers superior protection against any potential threats. The mask provide maximum c', 15),
(52, 'STREETWEAR SNEAKERS', 'assets\\footwear\\streetwear-sneakers-techwear-955_360x.jpg', 4499, 'Footwear', 'Delve into a realm where contemporary style embraces unmatched comfort. Our Streetwear Sneakers are meticulously designed to cater to the modern urbanite, embodying a fusion of streetwear and techwear aesthetics. Their sleek design manifests a minimalistic', 15),
(53, 'TECH SNEAKERS', 'assets\\footwear\\tech-sneakers-techwear-454_360x.jpg', 6999, 'Footwear', 'Get an amazing pair of useful sneakers made of breathable materials to improve your comfort. Their unique design will delight with ease all those in search of fashion techwear. These soft and light shoes will give you a feeling of freedom! Available in bla', 15),
(54, 'WARCORE HELMET', 'assets\\masks\\warcore-helmet-techwear-361_360x.jpg', 6499, 'Masks', 'This warcore helmet is a type of armor that was specifically designed for use in warfare. It is made out of a tough, durable material that can withstand a lot of damage, and it also has a visor that protects the wearer\'s eyes from flying debris or enemy at', 15),
(55, 'FUTURISTIC FACE MASK', 'assets\\masks\\futuristic-face-mask-techwear-749_360x.jpg', 8999, 'Masks', 'Introducing the ultimate accessory for any cyberpunk enthusiast or cosplayer, the Futuristic LED face mask! This cutting-edge mask is inspired by the iconic style and attitude of the cyberpunk genre, and is guaranteed to turn heads wherever you go.\r\n\r\nFeat', 15),
(56, 'TACTICAL CAP', 'assets\\hats\\tactical-cap-techwear-133_360x.jpg', 3999, 'Hats', 'This tactical hat will accompany you for daily use because it allows you to be protected against rain but also against sunlight. Equipped with an elastic band it adapts perfectly to your head size. The different velcro panels will allow you to personalize ', 13),
(57, 'TECHWEAR FACE MASK', 'assets\\masks\\techwear-face-mask-techwear-616_360x.jpg', 4499, 'Masks', 'In the realm of techwear, where functionality seamlessly merges with high-end fashion, our Techwear Face Mask stands unparalleled. This isn\'t just an accessory, it\'s an essential piece that accentuates your techwear ensemble while offering the comfort and ', 15),
(58, 'TECHWEAR FACE SHIELD', 'assets\\masks\\techwear-face-shield-techwear-775_360x.jpg', 4999, 'Masks', 'The Techwear Face Shield is a revolutionary protective face mask developed to provide maximum protection against airborne particles. It has been designed with innovative design that conform to the natural shape of your face, providing superior coverage and', 15),
(59, 'TACTICAL NYLON BELT', 'assets\\belts\\tactical-nylon-belt-techwear-751_360x.jpg', 3499, 'Belts', 'Made out of resistant material with a unique design, you can also discover the Black utility belt from our Techwear belt collection. An essential to adjust the waist of your pants with style. This webbing strap with snap-fit buckle perfectly matches with a', 15),
(60, 'BLACK UTILITY BELT', 'assets\\belts\\black-utility-belt21_360x.png', 3699, 'Belts', 'Our Black Utility Belt, a must-have accessory in the techwear universe. This belt transcends mere functionality; it\'s a statement of intent, a nod to the utilitarian while embracing the aesthetic of modern streetwear.\r\n\r\nConstructed with a robust nylon str', 14),
(61, 'MILITARY FULL FINGER TACTICAL GLOVES', 'assets\\gloves\\military-full-finger-tactical-gloves-techwear-768_360x.jpg', 3699, 'Gloves', 'Made with stretch materials which gives them flexibility, comfort and resistance. These tactical gloves will provide maximum protection for your hands thanks to the rigid reinforcements present on the top of the hand and the reinforcements present in the p', 15),
(62, 'GREEN ARMY TACTICAL GLOVES', 'assets\\gloves\\green-army-tactical-gloves-techwear-428_360x.jpg', 3499, 'Gloves', 'Experience the epitome of versatility, protection, and tactical efficiency with our premium Green Army Tactical Gloves. Designed to meet the specific needs of military personnel, outdoor adventurers, or to enhance your warcore style, these gloves set a new', 14),
(63, 'CAMO TACTICAL GLOVES', 'assets\\gloves\\camo-tactical-gloves-techwear-554_360x.jpg', 3499, 'Gloves', 'Specially designed for individuals who won\'t settle for anything less than the best, these gloves combine advanced functionality with an unbeatable camo design. The high-quality fabric used in their construction provides a robust yet flexible structure, en', 14),
(64, 'TECHWEAR WINTER GLOVES', 'assets\\gloves\\techwear-winter-gloves-techwear-361_360x.jpg', 3699, 'Gloves', 'Used by most military interventions, they are made of high stretch breathable fabric that keep your hands at the right temperature during the cold season. Designed to withstand the dangers of the terrain, the gloves use high performance materials. These gl', 15),
(65, 'LARGE TACTICAL BACKPACK', 'assets\\backpacks\\large-tactical-backpack-techwear-194_360x.jpg', 8499, 'Backpacks', 'In the world of techwear, where futuristic design converges with modern-day practicality, our techwear large tactical backpack stands out as a game changer. This giant backpack made of resistant and breathable materials is highly functional. With a capacit', 15),
(66, 'CLASS=\"SCROLL-TO-SECTION\"', 'assets/cyberpunk-backpack-techwear-220_360x.jpg', 6999, 'Jackets', '\nIn the ever-evolving landscape of modern fashion, the cyberpunk backpack emerges as a testament to the blend of technology and avant-garde aesthetics. With a design that screams \"future,\" this backpack effortlessly captures the essence of a world of fast and efficient.\n', 15);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(128) NOT NULL,
  `address` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `contact_number` varchar(11) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `account_type` set('admin','buyer','') NOT NULL,
  `payment_method` set('GCash','Maya','Card') DEFAULT 'GCash',
  `profile_picture` varchar(256) NOT NULL DEFAULT 'assets/default-pfp.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `address`, `email`, `contact_number`, `username`, `password`, `account_type`, `payment_method`, `profile_picture`) VALUES
(17, 'admin', 'admin', 'admin@example.com', '09914225221', 'admins', '$2y$10$rGy.ib0Io16AnmlTBzwC3ul8AQ/nK2CGoFf/1PMwc/ukyH87X.vhG', 'admin', 'GCash', 'assets/default-pfp.png'),
(19, 'Nikkiella Manuel', 'San Simon, Pampanga', 'nikkiellamanuel.2022@gmail.com', '09914225221', 'Nikki', '$2y$10$unCqkab33j/hPtZAlWaazuuS7QpdcNR3RBMSBhv3sjuOz5qIgzrSu', 'buyer', 'GCash', 'assets/default-pfp.png'),
(22, 'ben', 'ben', 'ben@gmail.com', '09912345678', 'benn', '$2y$10$pgocruFlTJQn/O4XkSB7PuPaFkWMrrSywVdsiRYABig9rk3WroUJe', 'admin', 'GCash', 'assets/default-pfp.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
