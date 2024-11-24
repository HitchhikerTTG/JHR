<?php 

echo validation_errors();

echo form_open('okno/view');
$licznik=0; 
?>
<div class="section">

    	<form action="http://nirski.com/oknojohari/index.php/form" method="post" accept-charset="utf-8">
		  <div class="row">
        <div class="col"><h3 class="text-center">Stwórz swoje okno</h3></div>
      </div>
    	<div class="form-row">

		<div class="form-group col-md-6">
			<label class="bmd-label-floating">Twoje imię</label>
			<input type="text" class="form-control" name="imie" id="ImieAutora">
    		<small id="nameHelp" class="form-text text-muted">Żeby łatwiej się do Ciebie zwracać ;-)</small>
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
</div>
