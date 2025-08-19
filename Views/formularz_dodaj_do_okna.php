<? helper('form'); ?>
<? $errors = $validation->getErrors(); 	?>


<?php $parametr = "okno/".$hashOkna; ?>

<?php echo form_open($parametr); ?>
    <?=csrf_field()?>
    <? echo form_hidden('okno', $hashOkna); ?>
<?php $licznik=0; ?>
<div class="form-check">
<?php 
$liczbaCech = count($features ?? []);
$komunikatCech = "Wybierz 8 cech";
?>
<div id="komunikat" class="sticky-top"><span class="komunikat"><?= $komunikatCech ?>, które opisują <?= $ImieWlasciciela ?> (dostępne: <?= $liczbaCech ?> cech)</span></div>

<div class="containter">

					<div class="row">

<?php //miejsce na rzeczy związane z listowaniem cech ?>

	          <?php /*foreach ($cechy as $cecha): 

		        echo "<div class=\"col-6 col-md-2\"><input type=\"checkbox\" id=".$licznik." name=\"feature_list[]\" value=\"".$licznik."\"><label type=\"checkbox\" for=".$licznik++.">".$cecha['cecha_pl']."</label></div>";
		        if (!($licznik%6)) {
		        	echo "</div><div class=\"row\">";
		        }

	          		endforeach;*/	?>


<? foreach ($features as $cecha): 
    $zestaw = [
        'name' => 'feature_list[]',
        'id' => $cecha['id'],
        'value' => $cecha['id'],
        'checked'=>false,
    ];
    $atrybuty =[
        'type'=>'checkbox',
    ];
    echo "<div class=\"col-6 col-md-2\">";
    //echo form_checkbox($zestaw);
    ?>
    <input type="checkbox" name="feature_list[]" id="<?php echo $cecha['id'];?>" value="<?php echo $cecha['id'];?>" <?php echo set_checkbox('feature_list[]',$cecha['id']);?> >
    <?

    echo form_label($cecha['cecha_pl'],$cecha['id'],$atrybuty);
    echo "</div>";
    if (!(++$licznik%6)) {
              echo "</div><div class=\"row\">";
          }
    endforeach

    ?>     
	          </div>
</div>
</div>
<div class="row">
    <div class="col-lg-6">
		<div class="row">
			<div class="col">
        <label for="Email">Email</label>
        <input type="input" name="email" />
		</div>
		</div>
		<div class="row">
<div class="col">
<? if ($validation->hasError('email')) { ?>
                        <div id="komunikaty">
                        <span class="text-danger text-sm"><?=$validation->getError('email')?></span>
</div>
					<?	} ?>


</div>
</div>

    </div>
    <div class="col-lg-6">
<p>Twój mail posłuży wyłącznie do zweryfikowania, czy nie wskazywałaś / wskazywałeś już cech dla tego konkretnego okna. Dlaczego to sprawdzam? Aby nie zaburzać wyników okna (przez wielokrotne udzielanie odpowiedzi przez tę samą osobę). A niestety imię może się łatwo powtórzyć, a mail.. mail jest unikalny;-) Równocześnie - Twój mail nie zostaje zapisany do bazy, a do Ciebie nie będzie wysłany żaden mail. o</p>
    </div>
</div>

<div class="row"><div class="col">

       <button type="submit" class="btn btn-primary btn-round enableOnInput btn-block" disabled='disabled'><i class="material-icons">forward</i> Dodaj cechy do okna znajomego</button></div></div>
</form>

<script>
$(document).ready(function() {
    // Limit cech zawsze wynosi 8
    var limitCech = 8;
    var komunikatBazowy = '<?= $komunikatCech ?>, które opisują <?= $ImieWlasciciela ?>';

    function updateButtonState() {
        var n = $('input[name="feature_list[]"]:checked').length;
        var roznica = limitCech - n;
        
        logToFile('Dodaj do okna - liczba wybranych cech: ' + n + ', limit: ' + limitCech);
        
        if (roznica == 0) {
            $('#komunikat .komunikat').text('Wybrano ' + limitCech + ' cech - możesz już wysłać formularz');
            $('.enableOnInput').prop('disabled', false);
            $('.enableOnInput').removeAttr('disabled');
            logToFile('Przycisk odblokowany - formularz dodaj do okna');
        } else {
            if (roznica > 0) {
                $('#komunikat .komunikat').text('Zaznaczyłeś/zaznaczyłaś już ' + n + ' cech. Zostało Ci do zaznaczenia jeszcze ' + roznica);
            } else {
                $('#komunikat .komunikat').text('Zaznaczyłeś/zaznaczyłaś za dużo cech. Musisz odznaczyć ' + (-roznica));
            }
            $('.enableOnInput').prop('disabled', true);
            $('.enableOnInput').attr('disabled', 'disabled');
            logToFile('Przycisk zablokowany - formularz dodaj do okna');
        }
    }

    // Nasłuchuj zmian na checkboxach
    $(document.body).on('change', 'input[name="feature_list[]"]', function() {
        updateButtonState();
    });

    // Sprawdź stan na początku (dla przypadku gdy są już zaznaczone checkboxy)
    updateButtonState();

    // Zabezpieczenie przed wysłaniem formularza z nieprawidłową liczbą cech
    $('form').on('submit', function(e) {
        var checkedCount = $('input[name="feature_list[]"]:checked').length;
        if (checkedCount !== limitCech) {
            e.preventDefault();
            alert('Musisz wybrać dokładnie ' + limitCech + ' cech!');
            logToFile('Formularz zablokowany - nieprawidłowa liczba cech: ' + checkedCount + '/' + limitCech, 'warning');
            return false;
        }
        logToFile('Formularz wysyłany - poprawna liczba cech: ' + checkedCount);
    });
});
</script>