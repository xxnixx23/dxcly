<?php
require_once 'api/db.php';

$stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Manage Categories</title>
  
  <!-- Toastr CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" />
  <!-- Your custom CSS -->
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f9f9f9;
      margin: 0;
      padding: 0;
    }
    .manage-categories-container {
      max-width: 700px;
      margin: 40px auto;
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
    }

    h2 {
      margin-bottom: 25px;
      font-weight: 600;
      font-size: 1.8rem;
      color: #333;
    }

    .add-category-form {
      display: flex;
      gap: 12px;
      margin-bottom: 25px;
    }

    .add-category-form input[type="text"] {
      flex: 1;
      padding: 10px 14px;
      font-size: 1rem;
      border: 1px solid #ccc;
      border-radius: 4px;
      transition: border-color 0.3s ease;
    }

    .add-category-form input[type="text"]:focus {
      outline: none;
      border-color: #007bff;
    }

    #add-category-btn {
      padding: 10px 18px;
      background-color: #007bff;
      border: none;
      border-radius: 4px;
      color: white;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    #add-category-btn:hover {
      background-color: #0056b3;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 1rem;
      color: #444;
    }

    thead th {
      background-color: #f0f0f0;
      padding: 12px 15px;
      text-align: left;
      border-bottom: 2px solid #ddd;
    }

    tbody td {
      padding: 12px 15px;
      border-bottom: 1px solid #eee;
    }

    tbody tr:hover {
      background-color: #fafafa;
    }

    .cat-name {
      font-weight: 500;
    }

    button.edit-btn,
    button.delete-btn {
      background: #eee;
      border: 1px solid #ccc;
      border-radius: 4px;
      padding: 6px 12px;
      cursor: pointer;
      margin-right: 6px;
      transition: background-color 0.3s ease;
      font-size: 0.9rem;
    }

    button.edit-btn:hover {
      background-color: #cce5ff;
      border-color: #99caff;
    }

    button.delete-btn:hover {
      background-color: #f8d7da;
      border-color: #f5c2c7;
    }
  </style>

</head>

<body>

  <div class="manage-categories-container">
    <h2>Manage Categories</h2>

    <div class="add-category-form">
      <input type="text" id="new-category" placeholder="Enter new category" />
      <button id="add-category-btn">Add Category</button>
    </div>

    <table>
      <thead>
        <tr>
          <th>Category</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="category-table-body">
        <?php foreach ($categories as $cat): ?>
        <tr>
          <td class="cat-name"><?php echo htmlspecialchars($cat['name']); ?></td>
          <td>
            <button class="edit-btn" data-name="<?php echo $cat['name']; ?>">Edit</button>
            <button class="delete-btn" data-name="<?php echo $cat['name']; ?>">Delete</button>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- jQuery and Toastr JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

  <script>
    $(document).ready(function () {
      $('#add-category-btn').click(function () {
        const newCat = $('#new-category').val().trim();
        if (!newCat) return toastr.warning('Please enter a category');

        $.ajax({
          url: 'api/products/add-category.php',
          method: 'POST',
          contentType: 'application/json',
          data: JSON.stringify({ name: newCat }),
          success: function (res) {
            if (res.success) {
              toastr.success(res.message);
              location.reload();
            } else {
              toastr.warning(res.message);
            }
          }
        });
      });

      $('.delete-btn').click(function () {
        const cat = $(this).data('name');
        if (!confirm(`Delete category "${cat}"?`)) return;

        $.ajax({
          url: 'api/products/delete-category.php',
          method: 'POST',
          contentType: 'application/json',
          data: JSON.stringify({ category: cat }),
          success: function (res) {
            if (res.success) {
              toastr.success(res.message);
              location.reload();
            } else {
              toastr.warning(res.message);
            }
          }
        });
      });

      $('.edit-btn').click(function () {
        const oldName = $(this).data('name');
        const newName = prompt('Edit category name:', oldName);
        if (!newName || newName.trim() === oldName) return;

        $.ajax({
          url: 'api/products/update-category.php',
          method: 'POST',
          contentType: 'application/json',
          data: JSON.stringify({ old: oldName, new: newName.trim() }),
          success: function (res) {
            if (res.success) {
              toastr.success(res.message);
              location.reload();
            } else {
              toastr.warning(res.message);
            }
          }
        });
      });
    });
  </script>

</body>

</html>