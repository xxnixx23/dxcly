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

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" />
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #121212;
      margin: 0;
      padding: 20px;
      color: #FFFFFF;
    }

    h2 {
      text-align: center;
      font-weight: 600;
      font-size: 1.8rem;
      margin-bottom: 20px;
    }

    .add-category-form {
      display: flex;
      gap: 12px;
      margin-bottom: 20px;
      max-width: 700px;
      margin-left: auto;
      margin-right: auto;
    }

    .add-category-form input[type="text"] {
      flex: 1;
      padding: 10px 14px;
      font-size: 1rem;
      border: 1px solid #555;
      border-radius: 4px;
      background-color: #222;
      color: #FFFFFF;
    }

    #add-category-btn {
      padding: 10px 18px;
      background-color: #D3D3D3;
      border: none;
      border-radius: 4px;
      color: #121212;
      font-size: 1rem;
      cursor: pointer;
    }

    table {
      width: 700px;
      margin: 0 auto;
      border-collapse: collapse;
      font-size: 1rem;
      color: #FFFFFF;
    }

    thead th {
      background-color: #222;
      padding: 12px 15px;
      text-align: left;
      border-bottom: 2px solid #333;
    }

    tbody td {
      padding: 12px 15px;
      border-bottom: 1px solid #2A2A2A;
    }

    tbody tr:hover {
      background-color: #1A1A1A;
    }

    button.edit-btn,
    button.delete-btn {
      background: #2C2C2C;
      border: 1px solid #555;
      border-radius: 4px;
      padding: 6px 12px;
      cursor: pointer;
      margin-right: 6px;
      font-size: 0.9rem;
      color: #FFFFFF;
    }

    .pagination {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 5px;
      margin: 20px auto;
      max-width: 700px;
    }

    .pagination button {
      background: #2C2C2C;
      border: 1px solid #555;
      border-radius: 4px;
      padding: 6px 12px;
      cursor: pointer;
      color: #FFFFFF;
      font-size: 0.9rem;
      min-width: 40px;
      text-align: center;
    }

    .pagination button.active {
      background-color: #444;
      font-weight: bold;
      border-color: #999;
    }

    .pagination button.disabled {
      opacity: 0.4;
      pointer-events: none;
    }

    .pagination .ellipsis {
      padding: 6px 12px;
      color: #888;
    }
  </style>
</head>

<body>

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
        <td><?php echo htmlspecialchars($cat['name']); ?></td>
        <td>
          <button class="edit-btn" data-name="<?php echo $cat['name']; ?>">Edit</button>
          <button class="delete-btn" data-name="<?php echo $cat['name']; ?>">Delete</button>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div class="pagination" id="pagination"></div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

  <script>
    $(document).ready(function () {
      // Add category
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
    toastr.success(res.message, "Success", {
      timeOut: 2000,
      preventDuplicates: true,
      positionClass: "toast-bottom-left",
      onHidden: () => {
        location.reload();
      }
    });
  } else {
    toastr.warning(res.message);
  }
}

        });
      });

      // Delete category
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
    toastr.success(res.message, "Success", {
      timeOut: 2000,
      preventDuplicates: true,
      positionClass: "toast-bottom-left",
      onHidden: () => {
        location.reload();
      }
    });
  } else {
    toastr.warning(res.message);
  }
}

        });
      });

      // Edit category
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
        toastr.success(res.message, "Success", {
          timeOut: 2000,
          preventDuplicates: true,
          positionClass: "toast-bottom-left",
          onHidden: () => {
            location.reload();
          }
        });
      } else {
        toastr.warning(res.message);
      }
    }
  });
});

      // Pagination
      const rowsPerPage = 4;
      const rows = $('#category-table-body tr');
      const totalRows = rows.length;
      const totalPages = Math.ceil(totalRows / rowsPerPage);
      let currentPage = 1;

      function showPage(page) {
        rows.hide();
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        rows.slice(start, end).show();
        renderPagination(page);
      }

      function renderPagination(page) {
        const pagination = $('#pagination');
        pagination.empty();

        const maxVisiblePages = 5;

        pagination.append(`<button class="${page === 1 ? 'disabled' : ''}" id="prev-btn">Prev</button>`);

        let startPage = Math.max(1, page - Math.floor(maxVisiblePages / 2));
        let endPage = startPage + maxVisiblePages - 1;

        if (endPage > totalPages) {
          endPage = totalPages;
          startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }

        if (startPage > 1) {
          pagination.append(`<button class="page-btn" data-page="1">1</button>`);
          if (startPage > 2) {
            pagination.append(`<span class="ellipsis">...</span>`);
          }
        }

        for (let i = startPage; i <= endPage; i++) {
          pagination.append(`<button class="page-btn ${i === page ? 'active' : ''}" data-page="${i}">${i}</button>`);
        }

        if (endPage < totalPages) {
          if (endPage < totalPages - 1) {
            pagination.append(`<span class="ellipsis">...</span>`);
          }
          pagination.append(`<button class="page-btn" data-page="${totalPages}">${totalPages}</button>`);
        }

        pagination.append(`<button class="${page === totalPages ? 'disabled' : ''}" id="next-btn">Next</button>`);
      }

      $(document).on('click', '.page-btn', function () {
        const page = Number($(this).data('page'));
        if (!isNaN(page)) {
          currentPage = page;
          showPage(currentPage);
        }
      });

      $(document).on('click', '#prev-btn', function () {
        if (currentPage > 1) {
          currentPage--;
          showPage(currentPage);
        }
      });

      $(document).on('click', '#next-btn', function () {
        if (currentPage < totalPages) {
          currentPage++;
          showPage(currentPage);
        }
      });

      showPage(currentPage);
    });
  </script>

</body>

</html>