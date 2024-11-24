<div class="page-header header-filter" data-parallax="true" style="background-image: url('<?php echo base_url()?>assets/img/puzzle.jpg')">
  <div class="container">
    <div class="row">
      <div class="col-md-8 ml-auto mr-auto">
        <div class="brand text-center">
          <h1>Okno Johari</h1>
      	</div>
      </div>
  </div>
</div>
</div>
<div class="main main-raised">
    <div class="container">
      <div class="section text-center">
      	<div class="row">
          <div class="col-md-8 ml-auto mr-auto">  
          	<h3>Lista okien [<?php echo count($okna);?>]</h3>
<?php

foreach ($okna as $i=>$okno){

echo "<a class=\"btn btn-outline-primary\" href=".base_url()."/wyswietlOkno/".$okno['hash']."/".$okno['wlasciciel']." target=_blank>".$okno['nazwa']."</a>";

}

?>