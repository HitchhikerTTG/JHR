<? helper('form'); ?>

<? $errors = $validation->getErrors(); 	?>


<?
	if ($errors) {
		?><div id="komunikaty">
		</div>

<?
	}
?>

<?$licznik=0; ?>



<div class="section">
	<? $validation = \Config\Services::validation();?>

	<? echo form_open(base_url() . 'stworzOkno', ['method' => 'POST', 'onsubmit' => 'console.log("Formularz wysyłany!", this); console.log("Action URL:", this.action); console.log("Method:", this.method); return true;', 'id' => 'form-johari']); ?>
	<?=csrf_field()?>

		  <div class="row">
        <div class="col"><h3 class="text-center">Stwórz swoje okno</h3></div>
      </div>
    	<div class="form-row">

		<div class="form-group col-md-6">
			<label class="bmd-label-floating">Twoje imię</label>
			<input type="text" class="form-control" name="imie" id="ImieAutora" value="<?= set_value('imie');?>">
			<? if ($validation->hasError('imie')) {
    					echo "<span class=\"text-danger text-sm\">".$validation->getError('imie')."</span>";
						} ?>


    		<small id="nameHelp" class="form-text text-muted">Żeby łatwiej się do Ciebie zwracać ;-)</small>
		</div>
		<div class="form-group col-md-6">
			<label class="bmd-label-floating">Twój email</label>
  			<input type="email" class="form-control" name="email" id="Email" aria-describedby="emailHelp"value="<?= set_value('email');?>" >
			<? if ($validation->hasError('email')) {
    					echo "<span class=\"text-danger text-sm\">".$validation->getError('email')."</span>";
						} ?>

  			<small id="emailHelp" class="form-text text-muted">Którego nie zamierzam nikomu udostępniać, a nam może ułatwić komunikację</small>
  		</div>
  	</div>
  	<div class="form-row">
  		<div class="form-group col-md-8">
  				<label class="bmd-label-floating">Nazwa Twojego okna</label>
  			<input type="text" class="form-control" name="tytul" id="TytulOkna" value="<?= set_value('tytul');?>">
									<?if ($validation->hasError('tytul')) {
    					echo "<span class=\"text-danger text-sm\">".$validation->getError('tytul')."</span>";
						} ?>

  			<small id="titleHelp" class="form-text text-muted">Przyda się, na wypadek gdybyś chciał / chciała mieć więcej niż jedno okno, będziemy je rozróżniać po nazwie właśnie.</small>
  		</div>
</div>
		<div class="form-check">
			<div id="komunikat" class="sticky-top"><span id="info">Wybierz 8 cech z poniższego zestawu</span></div>
				<div class="containter">


					<div class="row">

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

	?>    </div><div class="row"><div class="col">
    <?
    $atrybutyPrzycisku =[
    		'class' => 'btn btn-primary btn-round enableOnInput btn-block',
    	];

//    echo form_submit('mysubmit', '<i class="material-icons">forward</i> Stwórz swoje okno Johari', $atrybutyPrzycisku);
	   ?>  
    <button type="submit" class="btn btn-primary btn-round enableOnInput btn-block" disabled="disabled" id="submitBtn"><i class="material-icons">forward</i> Stwórz swoje okno Johari</button>
<?    echo "</div></div>";

    echo form_close();

?>

<div class="mt-2">
<p>Tworząc swoje okno Johari akceptujesz <a href="<?= site_url()?>/polityka" tareget="_blank">politykę prywatności serwisu</a>, w której jest napisane, że Twoja dana osobowa (mail) będzie wykorzystywana wyłącznie do identyfikowania Twojego okna, oraz to, że na Twój mail zostanie wysłana wiadomość z linkami do okna dla Ciebie i dla Twoich znajomych.  Na tym zakończone zostanie przetwarzanie Twoich danych. </p>
</div>

<script>
    // Function to update button state and info message
    function updateButtonState() {
        const checkboxes = document.querySelectorAll('input[name="feature_list[]"]:checked');
        const submitButton = document.getElementById('submitBtn');
        const infoSpan = document.getElementById('info');
        const count = checkboxes.length;
        const roznica = 8 - count;
        
        if (roznica === 0) {
            infoSpan.textContent = 'Świetnie. Jeśli jesteś zadowolony z wybranych cech, stwórz swoje okno';
            submitButton.disabled = false;
            submitButton.removeAttribute('disabled');
            console.log('8 features selected, submit button enabled.');
        } else {
            if (roznica > 0) {
                infoSpan.textContent = 'Zaznaczyłeś / zaznaczyłaś już ' + count + ' cech. Zostało Ci do zaznaczenia jeszcze ' + roznica;
            } else {
                infoSpan.textContent = 'Zaznaczyłeś / zaznaczyłaś za dużo cech. Musisz odznaczyć ' + (-roznica);
            }
            submitButton.disabled = true;
            submitButton.setAttribute('disabled', 'disabled');
            console.log(count + ' features selected, submit button disabled.');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        console.log('Page loaded - formularzyk.php');

        // Add event listener to all checkboxes
        const featureCheckboxes = document.querySelectorAll('input[name="feature_list[]"]');
        
        featureCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateButtonState();
            });
        });

        // Initial check of button state
        updateButtonState();
    });

    // Add logging to form submission
    document.getElementById('form-johari').addEventListener('submit', function(e) {
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
</script>