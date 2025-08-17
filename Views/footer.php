<footer class="footer footer-default" >
  <div class="container">
    <nav class="float-left">


      <ul>
        <li>
          <a>autor:</a><a href="https://www.linkedin.com/in/witnirski/" target="_blank">Wit Nirski</a>
        </li>
        <li> <a href="https://niecodzienny.net/2019/05/zrobmy-sobie-okno-johari/" target="_blank">Dlaczego zrobiłem Okno Johari</a></li>
        <li> <a href="https://subskrypcje.pl" target="_blank">Subskrypcje.pl - najciekawsze subskrypcje w Polsce</a></li>
        <li><a href="https://niecodzienny.net/planowanie-tygodnia-i-roku-z-notion/" target="_blank"  class="nav-link">Mój sposób na planowanie roku</a>
            </li>
      </ul>
    </nav>
    <div class="copyright float-right" style="font-size:12px; text-transform:uppercase;" >
        &copy;
        <script>
            document.write(new Date().getFullYear())
        </script>, zbudowane na Codeigniter, w oparciu o <a href="https://www.creative-tim.com/product/material-kit" target="_blank">Material Kit</a> stworzone przez <a href="https://www.creative-tim.com/" target="blank">Creative Tim</a>
    </div>
  </div>
</footer>
<!-- Bootstrap 5 JS Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="<?php echo base_url()?>/assets/js/plugins/moment.min.js"></script>
<!--  Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker -->
<script src="<?php echo base_url()?>/assets/js/plugins/bootstrap-datetimepicker.js" type="text/javascript"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="<?php echo base_url()?>/assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
<!--  Google Maps Plugin  -->
<?php if (getenv('GOOGLE_MAPS_API_KEY')): ?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?= getenv('GOOGLE_MAPS_API_KEY') ?>"></script>
<?php endif; ?>
<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Material Kit: parallax effects, scripts for the example pages etc -->
<script src="<?php echo base_url()?>/assets/js/material-kit.js?v=2.0.5" type="text/javascript"></script></body>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-46469483-6"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-46469483-6');
</script>
<script type="text/javascript">
   window.onload = function() {
       var komunikaty = document.getElementById('komunikaty');

       //auto scroll only if section#errors exist
       if(komunikaty) { //this also do I assumed, errors.length > 0
           komunikaty.scrollIntoView(true);
       }
   }
</script>
</html>