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
<script src="<?php echo base_url()?>/assets/js/core/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>/assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>/assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
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
<script>
// Funkcja do logowania do pliku na serwerze
function logToFile(message, level = 'debug') {
    var data = {
        message: message,
        level: level,
        timestamp: new Date().toISOString(),
        url: window.location.href,
        userAgent: navigator.userAgent
    };
    
    // Wysyłaj asynchronicznie, nie blokuj działania strony
    fetch('<?= base_url() ?>/log-js', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(data)
    }).catch(function(error) {
        // W razie błędu zapisz lokalnie
        console.log('Błąd logowania:', error, 'Oryginalny log:', message);
    });
}

$(document).ready(function() {
    logToFile('JavaScript załadowany');
    
    $('input[name="feature_list[]"]').on('change', function() {
        var n = $('input[name="feature_list[]"]:checked').length;
        logToFile('Liczba wybranych cech: ' + n);
        var roznica = 8 - n;
        var submitBtn = $('#submitBtn');

        if (roznica == 0) {
            $("span#info").text("Świetnie. Jeśli jesteś zadowolony z wybranych cech, stwórz swoje okno");
            submitBtn.prop('disabled', false);
            submitBtn.removeAttr('disabled');
            logToFile('Przycisk odblokowany');
        } else {
            if (roznica > 0) {
                $("span#info").text("Zaznaczyłeś / zaznaczyłaś już " + n + " cech. Zostało Ci do zaznaczenia jeszcze " + roznica);
            } else {
                $("span#info").text("Zaznaczyłeś / zaznaczyłaś za dużo cech. Musisz odznaczyć " + (-roznica));
            }
            submitBtn.prop('disabled', true);
            submitBtn.attr('disabled', 'disabled');
            logToFile('Przycisk zablokowany');
        }
    });

    // DEBUG: Sprawdź kliknięcie przycisku
    $('#submitBtn').on('click', function(e) {
        logToFile('Przycisk kliknięty!');
        logToFile('Przycisk disabled: ' + $(this).prop('disabled'));
        logToFile('Przycisk attr disabled: ' + $(this).attr('disabled'));
        logToFile('Liczba wybranych cech: ' + $('input[name="feature_list[]"]:checked').length);
        
        if ($(this).prop('disabled')) {
            logToFile('Przycisk jest disabled - blokujemy wysyłanie', 'warning');
            e.preventDefault();
            return false;
        }
        logToFile('Przycisk nie jest disabled - formularz powinien się wysłać');
    });
    
    // DEBUG: Sprawdź wysyłanie formularza
    $('form').on('submit', function(e) {
        logToFile('Formularz submit event!');
        logToFile('Action: ' + $(this).attr('action'));
        logToFile('Method: ' + $(this).attr('method'));
        logToFile('Liczba wybranych cech: ' + $('input[name="feature_list[]"]:checked').length);
        
        var checkedCount = $('input[name="feature_list[]"]:checked').length;
        if (checkedCount !== 8) {
            logToFile('Nieprawidłowa liczba cech - blokujemy wysyłanie', 'error');
            e.preventDefault();
            alert('Musisz wybrać dokładnie 8 cech!');
            return false;
        }
        logToFile('Formularz zostanie wysłany!');
    });
});
</script>
</html>