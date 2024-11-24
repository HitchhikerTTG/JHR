<?php 
//$validation = \Config\Services::validation();
//$validation->listErrors();
?> 
<?= session()->getFlashdata('error') ?>
<?= service('validation')->listErrors() ?>


<? echo form_open('form/index'); ?>
   <?= csrf_field() ?>
   <input type="hidden" name="okno" value="f38f26832a1e6910e12c4624cc20e97eac812d0b">
<div class="section">


		  <div class="row">
        <div class="col"><h3 class="text-center">Stwórz swoje okno</h3></div>
      </div>
    	<div class="form-row">

		<div class="form-group col-md-6">
			<label class="bmd-label-floating">Twoje imię</label>
			<input type="text" class="form-control" name="imie" id="ImieAutora">
    		<small id="nameHelp" class="form-text text-muted">żeby było mi łatwiej się do Ciebie zwracać ;-)</small>
		</div>
		<div class="form-group col-md-6">
			<label class="bmd-label-floating">Twój email</label>
  			<input type="email" class="form-control" name="email" id="Email" aria-describedby="emailHelp" >
  			<small id="emailHelp" class="form-text text-muted">Którego nie zamierzam nikomu udostępniać, a nam może ułatwić komunikację</small>
  		</div>
  	</div>
  	<div class="form-row">
  		<div class="form-group col-md-8">
  				<label class="bmd-label-floating">Nazwa Twojego okna</label>
  			<input type="text" class="form-control" name="tytul" id="TytulOkna">
  			<small id="titleHelp" class="form-text text-muted">Przyda się, na wypadek gdybyś chciał / chciała mieć więcej niż jedno okno, będziemy je rozróżniać po nazwie właśnie.</small>
  		</div>
  		<div class="form-row">

		<div class="form-group col-md-6">
  		<? 
  		echo form_checkbox('feature_list[]', 'id_cechy1', false, set_checkbox('feature_list[]', 'id_cechy1'));
  		echo form_label('Ćecha 1', 'feature_list[]');
  		?>

		</div>
		
				<div class="form-group col-md-6">
  		<? 
  		echo form_checkbox('feature_list[]', 'id_cechy2', false, set_checkbox('feature_list[]', 'id_cechy2'));
  		echo form_label('Ćecha 2', 'feature_list[]');
  		?>

		</div>
				<div class="form-group col-md-6">
  		<? 
  		echo form_checkbox('feature_list[]', 'id_cechy3', false, set_checkbox('feature_list[]', 'id_cechy3'));
  		echo form_label('Ćecha 3', 'feature_list[]');
  		?>

		</div>
				<div class="form-group col-md-6">
  		<? 
  		echo form_checkbox('feature_list[]', 'id_cechy4', false, set_checkbox('feature_list[]', 'id_cechy4'));
  		echo form_label('Ćecha 4', 'feature_list[]');
  		?>

		</div>
				<div class="form-group col-md-6">
  		<? 
  		echo form_checkbox('feature_list[]', 'id_cechy5', false, set_checkbox('feature_list[]', 'id_cechy5'));
  		echo form_label('Ćecha 5', 'feature_list[]');
  		?>

		</div>
  	</div>

  		        <div><input type="submit" value="Submit"></div>
</div>

<?	 

	for ($test=1; $test<5; $test++) {



/*	$zestaw = [
        'name' => 'feature_list[]',
       // 'id' => $test,
        'value' => $test,
        set_checkbox('feature_list[]', $test, false),
            ];*/
    $atrybuty =[
        'type'=>'checkbox',
    ];
    echo "<div class=\"col-6 col-md-2\">";
    echo form_checkbox('feature_list[]',$test,set_checkbox('feature_list[]',$test,false));
    echo form_label($test,$test,$atrybuty);
    echo "</div>"; 

			}
?>
<? form_close();?>	