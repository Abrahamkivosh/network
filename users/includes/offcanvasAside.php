<?php 
/**
 * This file contains the offcanvas aside navigation
 * 
 */
// Include the links file
 include_once "./includes/links.php";

?>
<div
      class="offcanvas offcanvas-start sidebar-nav bg-dark"
      tabindex="-1"
      id="sidebar"
    >
      <div class="offcanvas-body p-0">
        <nav class="navbar-dark">
          <ul class="navbar-nav">
            <li>
              <div class="text-muted small fw-bold text-uppercase px-3">
                CORE
              </div>
            </li>
            <!-- loop theiugh the links -->
            <?php
              foreach ($links as $link => $value) {
                ?>
                <li>
                  <a
                    href="<?php echo $value['link']; ?>"
                    class="nav-link px-3 <?php echo $value['class']; ?>"
                  >
                    <span class="me-2"><i class="<?php echo $value['icon']; ?>"></i></span>
                    <span><?php echo $value['title']; ?></span>
                  </a>
                </li>
                <?php
              }
            ?>

            <li>
              <hr class="dropdown-divider text-muted my-0" />
            </li>

          </ul>
        </nav>
      </div>
    </div>