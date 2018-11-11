<?php 
include "init.php";
include "header.php";
?>

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

<?php
include "footer.php";
?>