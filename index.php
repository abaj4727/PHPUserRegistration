<?php include 'header.php'; ?>

<main>
  <h2>Welcome to My Website</h2>
  <p>This is my first form in php and i am about to validate this</p>

  <div class="index_body">
    <div class="card" style="margin-top: 10px;margin-bottom: 10px;">
      <?php
      if (isset($_GET['page'])) {
        $page = $_GET['page'];
        if ($page == 'login') {
          include 'login.php';
        } elseif ($page == 'register') {
          include 'register.php';
        } else {
          echo "Invalid page.";
        }
      }
      else
      {
        echo "Welcome to the homepage!";
      }
      ?>

    </div>
  </div>
</main>

<?php include 'footer.php'; ?>