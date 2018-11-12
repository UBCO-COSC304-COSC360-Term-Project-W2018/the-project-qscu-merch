<?php 
include "init.php";
include "header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/adminList.css">
    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="icon" type="image/x-icon" href="images/QSCU_favicon.png" />
</head>

<body>

    <main>
        <div id="container">
            <table>
                <caption>Product List</caption>
                <thead>
                    <tr>
                        <th>
                            <span>Product Name</span>
                        </th>
                        <td>
                            <button>Add Product</button>
                        </td>
                    </tr>
                </thead>
                <tr>
                    <td class="listName">
                        <span>Product Name</span>
                    </td>
                    <td class="editButton">
                        <button>edit</button>
                    </td>
                </tr>
            </table>
            <table>
                <caption>User List</caption>
                <thead>
                    <tr>
                        <th>
                            <span>User Email</span>
                        </th>
                        <td>
                        </td>
                    </tr>
                </thead>
                <tr>
                    <td class="listName">
                        <span>user1@eamil.com</span>
                    </td>
                    <td class="reviewButton">
                        <button>Review</button>
                    </td>
                </tr>
            </table>
        </div>
    </main>
</body>
</html>

<?php
include "footer.php";
?>