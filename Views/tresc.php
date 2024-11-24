<body <?php if ($szablon) {echo $szablon;}?>> <nav class="navbar navbar-color-on-scroll navbar-transparent fixed-top navbar-expand-lg"  color-on-scroll="100">
  <div class="container">
      <div class="navbar-translate">
        <a class="navbar-brand" href="<?php echo base_url(); ?>">
          Twoje Okno Johari </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Nawigacja</span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
        </button>
      </div>

      <div class="collapse navbar-collapse">
          <ul class="navbar-nav ml-auto">

            <li class="nav-item">
              <a href="<?php echo base_url();?>/beta" class="nav-link">
                  <i class="material-icons">build</i> Dalszy rozwój Okna Johari
              </a>
            </li>
          </ul>
      </div>
  </div>
</nav>



