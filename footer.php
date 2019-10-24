  <?php wp_footer(); ?>

  <!-- Modal -->
  <div id="alt-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <form id="searchform" class="search-form" method="get" action="<?php echo home_url('/'); ?>">
              <div class="row">
                  <div class="col">
                      <input type="text" id="search-field" autofocus class="search-field" name="s" placeholder="<?php _e("What are you looking for?", "altminimo"); ?>" value="<?php the_search_query(); ?>">
                  </div>
                  <div class="col-sm-auto text-center">
                      <input class="btn btn-warning btn-extralg btn-search-field" style="width:100%;" type="submit" value="<?php _e("Search", "altminimo"); ?>">
                  </div>
              </div>

          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- end modal  -->
</body>
</html>
