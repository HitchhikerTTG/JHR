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

	<? echo form_open(base_url() . '/stworzOkno'); ?>
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
	   ?>  <button type="submit" class="btn btn-primary btn-round enableOnInput btn-block" disabled='disabled'><i class="material-icons">forward</i> Stwórz swoje okno Johari</button> 
<?    echo "</div></div>";

    echo form_close();

?>

<div class="mt-2">
<p>Tworząc swoje okno Johari akceptujesz <a href="<?= site_url()?>/polityka" tareget="_blank">politykę prywatności serwisu</a>, w której jest napisane, że Twoja dana osobowa (mail) będzie wykorzystywana wyłącznie do identyfikowania Twojego okna, oraz to, że na Twój mail zostanie wysłana wiadomość z linkami do okna dla Ciebie i dla Twoich znajomych.  Na tym zakończone zostanie przetwarzanie Twoich danych. </p>
</div>