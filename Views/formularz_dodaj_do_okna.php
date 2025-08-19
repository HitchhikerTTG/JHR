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
    // Function to update button state and info message - identyczna jak w formularzyk.php
    function updateButtonState() {
        const checkboxes = document.querySelectorAll('input[name="feature_list[]"]:checked');
        const submitButton = document.querySelector('.enableOnInput');
        const komunikatSpan = document.querySelector('#komunikat .komunikat');
        const count = checkboxes.length;
        const roznica = 8 - count;
        
        console.log('Dodaj do okna - liczba wybranych cech: ' + count + ', limit: 8');
        
        if (roznica === 0) {
            komunikatSpan.textContent = 'Wybrano 8 cech - możesz już wysłać formularz';
            submitButton.disabled = false;
            submitButton.removeAttribute('disabled');
            console.log('Przycisk odblokowany - formularz dodaj do okna');
        } else {
            if (roznica > 0) {
                komunikatSpan.textContent = 'Zaznaczyłeś/zaznaczyłaś już ' + count + ' cech. Zostało Ci do zaznaczenia jeszcze ' + roznica;
            } else {
                komunikatSpan.textContent = 'Zaznaczyłeś/zaznaczyłaś za dużo cech. Musisz odznaczyć ' + (-roznica);
            }
            submitButton.disabled = true;
            submitButton.setAttribute('disabled', 'disabled');
            console.log('Przycisk zablokowany - formularz dodaj do okna');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        console.log('Page loaded - formularz_dodaj_do_okna.php');

        // Add event listener to all checkboxes - identyczne jak w formularzyk.php
        const featureCheckboxes = document.querySelectorAll('input[name="feature_list[]"]');
        
        featureCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateButtonState();
            });
        });

        // Initial check of button state
        updateButtonState();
    });

    // Add logging to form submission - identyczne jak w formularzyk.php
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                console.log('Form submission started');

                const selectedFeatures = document.querySelectorAll('input[name="feature_list[]"]:checked');
                const featuresArray = Array.from(selectedFeatures).map(checkbox => checkbox.value);

                console.log('Selected features count: ' + featuresArray.length + ', features: ' + featuresArray.join(','));

                if (featuresArray.length !== 8) {
                    e.preventDefault();
                    console.log('Form submission blocked - wrong feature count: ' + featuresArray.length);
                    alert('Musisz wybrać dokładnie 8 cech!');
                    return false;
                }

                console.log('Form validation passed, submitting form');
                return true;
            });
        }
    });
</script>