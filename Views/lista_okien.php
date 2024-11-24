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
              <div class="card">
                  <div class="card-body">
                      <h5>Statystyki:</h5>
                      <p>Łączna liczba okien: <?php echo $statystyki['total']; ?></p>
                      <p>Okna z jednym wypełnieniem: <?php echo $statystyki['jedno_wypelnienie']; ?></p>
                      <p>Okna z wieloma wypełnieniami: <?php echo $statystyki['wiecej_wypelnien']; ?></p>
                      <p>Rekordzista: <?php echo $statystyki['najwiecej']->nazwa; ?> 
                         (<?php echo $statystyki['najwiecej']->licznik; ?> wypełnień)</p>
                      <p>Średnia liczba wypełnień (bez pojedynczych): <?php echo $statystyki['srednia']; ?></p>
                  </div>
              </div>
          </div>
      </div>

     

<?php foreach ($okna as $i=>$okno){
  $wypelnien = $okno['licznik'] ? $okno['licznik'] : 0;

echo "<p><a class=\"btn btn-outline-primary\" href=".base_url()."/wyswietlOkno/".$okno['hash']."/".$okno['wlasciciel']." target=_blank>".$okno['nazwa']." | <span class='badge badge-secondary'>".$wypelnien." odpowiedzi</span></a></p>";

}

?>