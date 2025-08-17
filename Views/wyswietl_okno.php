<div class="page-header header-filter" data-parallax="true" style="background-image: url('<?php echo base_url()?>assets/img/puzzlen.jpg')">
  <div class="container">
    <div class="row">
      <div class="col-md-8 ml-auto mr-auto">
        <div class="brand text-center">
          <?php echo "<h1>".$okno['nazwa']." - Twoje okno Johari</h1>"; ?>
      	</div>
      </div>
  </div>
    <div class="row">
      <?php if ($licznik){
        $wyliczone = $licznik/8-1;
      } else {
        $wyliczone = 17;
      }?>
          <?php echo "<h5>Twoje okno Johari zostało dotychczas wypełnione przez ".$wyliczone." osób </h5>"; ?>
    </div>
</div>
</div>
<div class="main main-raised">
    <div class="container">
      <div class="section text-center">








<div class="row">
<div class="col-md-4">

             <div class="card">
        <div class="card-header card-header-primary"><h4>Arena</h4></div>
        <div class="card-body">
            <h5 class="card-title">Cechy, wskazane przez Ciebie i kogoś z Twoich znajomych</h5>
              <?php
if ($arena) {
echo "<ul class=\"list-group\">";
foreach ($arena as $cecha) {
    $nazwa = $cecha[1];
    $czestotliwosc = $cecha[2] ?? 1;

    echo "<li class=\"list-group-item d-flex justify-content-between align-items-center\">";
    echo $nazwa;
    if ($czestotliwosc > 1) {
        echo " <span class=\"badge badge-pill badge-primary\">".$czestotliwosc."&#128100;</span>";
    }
    echo "</li>";
}
echo "</ul>";
} else {
echo "<p>Nie ma cech, które są znane wszystkim. Twoje wrażenie i wrażenie Twoich znajomych o Tobie rozjeżdża się troszkę...</p>";
}

              ?>
        </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
        <div class="card-header card-header-info"><h4>Obszar prywatny</h4></div>
        <div class="card-body">
            <h5 class="card-title">Cechy, wskazane tylko przez Ciebie</h5>
              <?php 
           		if ($prywatne) {
				echo "<ul class=\"list-group\">";
				foreach ($prywatne as $cecha) {
				    $nazwa = $cecha[1];
				    $czestotliwosc = $cecha[2] ?? 1;

				    echo "<li class=\"list-group-item d-flex justify-content-between align-items-center\">";
				    echo $nazwa;
				    if ($czestotliwosc > 1) {
				        echo " <span class=\"badge badge-pill badge-info\">".$czestotliwosc."&#128100;</span>";
				    }
				    echo "</li>";
				}
				echo "</ul>";
				} else {
				echo "<p>Nie ma cech, które są znane tylko Tobie. Zostałeś rozpracowany</p>";	
				}	

              ?>
        </div>
    </div>
  </div>
    <div class="col-md-4">
    <div class="card">
        <div class="card-header card-header-warning"><h4>Obszar nieznany</h4></div>
        <div class="card-body">
            <h5 class="card-title">Cechy, które wskazali Twoi znajomi, ale nie Ty</h5>  

              <?php 
              if ($wskazane) {
                echo "<ul class=\"list-group\">";

                // Sortujemy cechy według częstotliwości malejąco
                usort($wskazane, function($a, $b) {
                    return ($b[2] ?? 1) - ($a[2] ?? 1);
                });

                foreach ($wskazane as $cecha) {
                    $nazwa = $cecha[1];
                    $czestotliwosc = $cecha[2] ?? 1;

                    echo "<li class=\"list-group-item d-flex justify-content-between align-items-center\">";
                    echo $nazwa;
                    if ($czestotliwosc > 1) {
                        echo " <span class=\"badge badge-pill badge-warning\">".$czestotliwosc."&#128100;</span>";
                    }
                    echo "</li>";
                }
                echo "</ul>";
              } else {
                echo "<p>Nie ma cech, których o sobie nie wiesz. Albo wszystko się zgadza, albo nie poprosiłaś / poprosiłeś jeszcze nikogo o podzielenie się opinią</p>";
              }
              ?>
        </div>
    </div>
  </div>
<?php 



echo "<p>Jeśli chcesz jak najwięcej zrozumieć z tego ćwiczenia, poproś znajomych o wypełnienie Twojego okna podając im ten link:</p>";
echo "<pre><a href=".base_url()."/okno/".$okno['hash'].">".base_url()."/okno/".$okno['hash']."</a></pre>";



?>

</div>
<div class="row"><div class="col">
  <p class="lead">Są wyniki, są cechy i co teraz... Nie mam złotej zasady, ale mam kilka podpowiedzi, które mogą nieco pomóc.</p>
  <p class="lead">Zachęcam do tego, aby przegadać swoje okno z kimś, kogo wiedzę i spostrzeżenia cenisz. Dzięki temu możesz lepiej zrozumieć cechy wskazane w Twoim oknie.</p>
  <p class="lead">Popatrz na relację cech z Areny i z obszaru prywatnego. Jeśli obszar prywatny jest pusty, albo prawie pusty, a wszystkie wskazane przez Ciebie cechy znajdują się na Arenie, to znaczy, że ludzie "czytają" Cię mniej więcej tak, jak Ty siebie widzisz. Tu weź poprawkę też na liczbę osób, która wskazała cechy na arenie, bo to też podpowiedź, jak wyraźnie te Twoje cechy są czytane.</p>
<p class="lead">Jeśli natomiast to Arena jest pusta, a wymienione przez Ciebie cechy zostały w obszarze prywatnym, to możesz się zastanowić, dlaczego tak jest. Czy celowo pewnych rzeczy nie "przekazujesz" światu, czy też nie robisz tego w sposób wystarczająco wyrazisty? </p>
  <p class="lead">Przyglądnij się także cechom z obszaru nieznanego, to cechy wskazane przez innych a Ty je pominęłaś / pominęłaś. Przy czym tu zalecam podejście z dystansem, bo część cech jest synonimiczna, więc trzeba brać na to poprawkę, ale mogą się tam znajdować cechy wskazane wielokrotnie, które zaskoczą</p>
</div></div>
<div class="row"><div class="col">
  <p> Przykładowe pytania, które możesz rozważyć:</p>
  <ul>
  <li>Które z cech znajdujących się w obszarze nieznanym zaskoczyły Cię najbardziej (to, że zostały wymienione)? </li>
  <li>Które z cech dostrzeganych przez innych mogą mieć dla Ciebie największą wartość i dostrzeżenie ich, oswojenie ich jako własnych, może Ci dać najwięcej?</li>
  <li>Które z cech, które są w obszarze prywatnym, chciałbyś upublicznoć, tak aby były widoczne dla innych? </li>
  <li>Czy są jakieś cechy, które chciałbyś/ chciałabyś by były Twoje, ale są raczej z obszaru niezagospodarowanego? </li>
  </ul>
</div></div>
<div class="row"><div class="col">

<div class="card">
        <div class="card-header card-header-secondary"><h4>Cechy niezagospodarowane</h4></div>
        <div class="card-body">
            <h5 class="card-title">Ani Ty ani Twoi znajomi ich nie wskazaliście</h5>  


<?php 
if ($pozostale){
echo "<div class=\"row description\">";
foreach ($pozostale as $cecha) {
echo "<div class=\"col small\">".$cecha[1]."</div>";
}
echo "</div>";
} else {
echo "<p>O kochaniutki... wszystkie cechy zaliczone. Jesteś zdecydowanie bardzo złożoną postacią</p>";
}
echo "</div>";

?>

</div>
<?php //print_r($posortowanenieznane);
/*print_r(sort($nieznane));?>	
<?php print_r(array_count_values($nieznane)); */?>
    </div>
</div>

<?php if (isset($ma_tlumaczenie) && $ma_tlumaczenie): ?>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <h4><i class="fa fa-language"></i> Tłumaczenie na nowy zestaw cech</h4>
                    <p>To okno zostało utworzone z wykorzystaniem starszego zestawu cech. Możesz przetłumaczyć je na nowy zestaw cech:</p>
                    <button id="tlumacz-okno" class="btn btn-primary" onclick="tlumaczOkno()">
                        <i class="fa fa-language"></i> Tłumacz okno na nowe cechy
                    </button>
                </div>
            </div>
        </div>

        <div id="tlumaczenie-container" style="display: none;">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success">
                        <h5>Przetłumaczona wersja z nowym zestawem cech:</h5>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Arena (publiczne cechy)</h5>
                            <div id="tlumaczenie-arena"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Cechy prywatne</h5>
                            <div id="tlumaczenie-prywatne"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Obszar nieznany</h5>
                            <div id="tlumaczenie-wskazane"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pozostałe cechy</h5>
                            <div id="tlumaczenie-pozostale"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function tlumaczOkno() {
    const button = document.getElementById('tlumacz-okno');
    button.disabled = true;
    button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Tłumaczę...';
    
    fetch('<?= base_url() ?>/tlumaczOkno/<?= $hash_okna ?>/<?= $hash_wlasciciela ?>', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert('Błąd: ' + data.error);
            return;
        }
        
        const tlumaczenie = data.tlumaczenie;
        
        // Wypełnij arena
        document.getElementById('tlumaczenie-arena').innerHTML = renderCechyZCzestotliwoscia(tlumaczenie.arena, 'primary');
        
        // Wypełnij prywatne
        document.getElementById('tlumaczenie-prywatne').innerHTML = renderCechyZCzestotliwoscia(tlumaczenie.prywatne, 'info');
        
        // Wypełnij wskazane (sortowane według częstotliwości)
        tlumaczenie.wskazane.sort((a, b) => (b[2] || 1) - (a[2] || 1));
        document.getElementById('tlumaczenie-wskazane').innerHTML = renderCechyZCzestotliwoscia(tlumaczenie.wskazane, 'warning');
        
        // Wypełnij pozostałe
        document.getElementById('tlumaczenie-pozostale').innerHTML = renderCechyBezCzestotliwosci(tlumaczenie.pozostale);
        
        // Pokaż kontener z tłumaczeniem
        document.getElementById('tlumaczenie-container').style.display = 'block';
        
        // Ukryj przycisk
        button.style.display = 'none';
    })
    .catch(error => {
        console.error('Błąd:', error);
        alert('Wystąpił błąd podczas tłumaczenia okna');
        button.disabled = false;
        button.innerHTML = '<i class="fa fa-language"></i> Tłumacz okno na nowe cechy';
    });
}

function renderCechyZCzestotliwoscia(cechy, badgeType) {
    if (!cechy || cechy.length === 0) {
        return '<p>Brak cech w tej kategorii</p>';
    }
    
    let html = '<ul class="list-group">';
    cechy.forEach(cecha => {
        const nazwa = cecha[1];
        const czestotliwosc = cecha[2] || 1;
        
        html += '<li class="list-group-item d-flex justify-content-between align-items-center">';
        html += nazwa;
        if (czestotliwosc > 1) {
            html += ` <span class="badge badge-pill badge-${badgeType}">${czestotliwosc}&#128100;</span>`;
        }
        html += '</li>';
    });
    html += '</ul>';
    return html;
}

function renderCechyBezCzestotliwosci(cechy) {
    if (!cechy || cechy.length === 0) {
        return '<p>Wszystkie cechy zostały wykorzystane</p>';
    }
    
    const chunksSize = Math.ceil(cechy.length / 2);
    const chunks = [];
    for (let i = 0; i < cechy.length; i += chunksSize) {
        chunks.push(cechy.slice(i, i + chunksSize));
    }
    
    let html = '<div class="row">';
    chunks.forEach(chunk => {
        html += '<div class="col-md-6"><ul class="list-group list-group-flush">';
        chunk.forEach(cecha => {
            html += `<li class="list-group-item border-0 py-1 small">${cecha[1]}</li>`;
        });
        html += '</ul></div>';
    });
    html += '</div>';
    return html;
}
</script>
<?php endif; ?>

</div>