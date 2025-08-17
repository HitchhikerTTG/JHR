<?php echo validation_list_errors(); ?>

<form action="<?php echo base_url('oknojohari'); ?>" method="post" accept-charset="utf-8">
<div class="form-group">
    <input type="text" class="form-control" name="imie" id="imie" placeholder="Twoje imię" value="<?= old('imie') ?>">
    <small class="form-text text-muted">Żeby łatwiej się do Ciebie zwracać ;-)</small>
</div>
<div class="form-group">
    <input type="email" class="form-control" name="email" id="email" placeholder="Twój email" value="<?= old('email') ?>">
    <small class="form-text text-muted">Którego nie zamierzam nikomu udostępniać, a nam może ułatwić komunikację</small>
</div>
<div class="form-group">
    <input type="text" class="form-control" name="tytul" id="tytul" placeholder="Nazwij swoje okno" value="<?= old('tytul') ?>">
    <small class="form-text text-muted">Przyda się ;-).</small>
</div>

<div class="form-check">
<div id="komunikat" class="sticky-top"><span class="komunikat">Wybierz 6 cech z poniższego zestawu</span></div>

<div class="container">
<div class="row">
    <div class="col"><p class="h4">Wybierz cechy, które Cię opisują</p></div>
</div>

<?php 
// Ładujemy cechy z bazy danych (zestaw ID 2)
$cechyModel = new \App\Models\CechyModel();
$cechy = $cechyModel->getFeaturesForNewWindows();

$counter = 0;
foreach ($cechy as $cecha): 
    if ($counter % 4 == 0): // Nowy rząd co 4 cechy
?>
<div class="row">
<?php endif; ?>
    <div class="col">
        <input type="checkbox" id="cecha_<?= $cecha['id'] ?>" name="feature_list[]" value="<?= $cecha['id'] ?>">
        <label for="cecha_<?= $cecha['id'] ?>"><?= esc($cecha['cecha_pl']) ?></label>
    </div>
<?php 
    $counter++;
    if ($counter % 4 == 0 || $counter == count($cechy)): // Zamknij rząd
?>
</div>
<?php 
    endif;
endforeach; 
?>

</div>
<div> 
  <button type="submit" class="btn btn-primary enableOnInput" disabled="disabled">Prześlij</button>
</div>

</div>
</form>

<script>
$(document).ready(function() {
    $(document.body).on('click', 'input[type="checkbox"]', function() {
        var n = $('input[type="checkbox"]:checked').length;
        var roznica = 6 - n;

        if (roznica == 0) {
            $("span.komunikat").text("Świetnie. Jeśli jesteś zadowolony z wybranych cech, stwórz swoje okno"); 
            $('.enableOnInput').prop('disabled', false);
        } else {
            if (roznica > 0) {
                $("span.komunikat").text("Zaznaczyłeś / zaznaczyłaś już " + n + " cech. Zostało Ci do zaznaczenia jeszcze " + roznica); 
            } else {
                $("span.komunikat").text("Zaznaczyłeś / zaznaczyłaś za dużo cech. Musisz odznaczyć " + (-roznica));
            }
            $('.enableOnInput').prop('disabled', true);
        } 
    });
});
</script>