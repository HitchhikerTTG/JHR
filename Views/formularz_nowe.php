<form action="http://nirski.com/oknojohari/index.php/form" method="post" accept-charset="utf-8">

<!-- Pola podstawowe -->
<div class="mb-3">
    <input type="text" class="form-control" id="imie" name="imie" placeholder="Twoje imię">
    <div class="form-text">Żeby łatwiej się do Ciebie zwracać ;-)</div>
</div>

<div class="mb-3">
    <input type="email" class="form-control" id="email" name="email" placeholder="Twój email">
    <div class="form-text">Którego nie zamierzam nikomu udostępniać, a nam może ułatwić komunikację</div>
</div>

<div class="mb-3">
    <input type="text" class="form-control" id="nazwa_okna" name="nazwa_okna" placeholder="Nazwij swoje okno">
    <div class="form-text">Przyda się ;-).</div>
</div>

<!-- Komunikat o wyborze cech -->
<div id="komunikat" class="sticky-top alert alert-info mb-3">
    <span class="komunikat">Wybierz 6 cech z poniższego zestawu</span>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-4">Wybierz cechy charakteryzujące Cię</h4>
        </div>
    </div>

    <!-- Cechy 1-10 -->
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="1" name="feature_list[]" value="1">
                <label class="form-check-label" for="1">Agresywny</label>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="2" name="feature_list[]" value="2">
                <label class="form-check-label" for="2">Arogancki</label>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="3" name="feature_list[]" value="3">
                <label class="form-check-label" for="3">Asertywny</label>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="4" name="feature_list[]" value="4">
                <label class="form-check-label" for="4">Atrakcyjny</label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="5" name="feature_list[]" value="5">
                <label class="form-check-label" for="5">Bezczelny</label>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="6" name="feature_list[]" value="6">
                <label class="form-check-label" for="6">Bezinteresowny</label>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="7" name="feature_list[]" value="7">
                <label class="form-check-label" for="7">Bezmyślny</label>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="8" name="feature_list[]" value="8">
                <label class="form-check-label" for="8">Bezpośredni</label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="9" name="feature_list[]" value="9">
                <label class="form-check-label" for="9">Beztroski</label>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="10" name="feature_list[]" value="10">
                <label class="form-check-label" for="10">Bezwolny</label>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="11" name="feature_list[]" value="11">
                <label class="form-check-label" for="11">Bezwstydny</label>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="12" name="feature_list[]" value="12">
                <label class="form-check-label" for="12">Bezwzględny</label>
            </div>
        </div>
    </div>

    <!-- Cechy 13-181 w tym samym formacie Bootstrap 5 -->
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="13" name="feature_list[]" value="13">
                <label class="form-check-label" for="13">Błyskotliwy</label>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="14" name="feature_list[]" value="14">
                <label class="form-check-label" for="14">Bojaźliwy</label>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="15" name="feature_list[]" value="15">
                <label class="form-check-label" for="15">Brawurowy</label>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="16" name="feature_list[]" value="16">
                <label class="form-check-label" for="16">Chamski</label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="17" name="feature_list[]" value="17">
                <label class="form-check-label" for="17">Chciwy</label>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="18" name="feature_list[]" value="18">
                <label class="form-check-label" for="18">Chytry</label>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="19" name="feature_list[]" value="19">
                <label class="form-check-label" for="19">Ciekawy</label>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="20" name="feature_list[]" value="20">
                <label class="form-check-label" for="20">Cierpliwy</label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="21" name="feature_list[]" value="21"><label class="form-check-label" for="21">Cyniczny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="22" name="feature_list[]" value="22"><label class="form-check-label" for="22">Czuły</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="23" name="feature_list[]" value="23"><label class="form-check-label" for="23">Delikatny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="24" name="feature_list[]" value="24"><label class="form-check-label" for="24">Despotyczny</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="25" name="feature_list[]" value="25"><label class="form-check-label" for="25">Dobroduszny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="26" name="feature_list[]" value="26"><label class="form-check-label" for="26">Dociekliwy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="27" name="feature_list[]" value="27"><label class="form-check-label" for="27">Dojrzały</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="28" name="feature_list[]" value="28"><label class="form-check-label" for="28">Dokładny</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="29" name="feature_list[]" value="29"><label class="form-check-label" for="29">Dumny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="30" name="feature_list[]" value="30"><label class="form-check-label" for="30">Dyskretny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="31" name="feature_list[]" value="31"><label class="form-check-label" for="31">Egocentryczny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="32" name="feature_list[]" value="32"><label class="form-check-label" for="32">Egoista</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="33" name="feature_list[]" value="33"><label class="form-check-label" for="33">Elokwentny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="34" name="feature_list[]" value="34"><label class="form-check-label" for="34">Empatyczny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="35" name="feature_list[]" value="35"><label class="form-check-label" for="35">Fałszywy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="36" name="feature_list[]" value="36"><label class="form-check-label" for="36">Fanatyczny</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="37" name="feature_list[]" value="37"><label class="form-check-label" for="37">Gadatliwy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="38" name="feature_list[]" value="38"><label class="form-check-label" for="38">Głupi</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="39" name="feature_list[]" value="39"><label class="form-check-label" for="39">Gnuśny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="40" name="feature_list[]" value="40"><label class="form-check-label" for="40">Gościnny</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="41" name="feature_list[]" value="41"><label class="form-check-label" for="41">Grubiański</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="42" name="feature_list[]" value="42"><label class="form-check-label" for="42">Grzeczny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="43" name="feature_list[]" value="43"><label class="form-check-label" for="43">Gwałtowny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="44" name="feature_list[]" value="44"><label class="form-check-label" for="44">Hałaśliwy</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="45" name="feature_list[]" value="45"><label class="form-check-label" for="45">Hardy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="46" name="feature_list[]" value="46"><label class="form-check-label" for="46">Hipokryta</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="47" name="feature_list[]" value="47"><label class="form-check-label" for="47">Hojny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="48" name="feature_list[]" value="48"><label class="form-check-label" for="48">Honorowy</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="49" name="feature_list[]" value="49"><label class="form-check-label" for="49">Impulsywny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="50" name="feature_list[]" value="50"><label class="form-check-label" for="50">Inteligentny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="51" name="feature_list[]" value="51"><label class="form-check-label" for="51">Jowialny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="52" name="feature_list[]" value="52"><label class="form-check-label" for="52">Kapryśny</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="53" name="feature_list[]" value="53"><label class="form-check-label" for="53">Kłótliwy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="54" name="feature_list[]" value="54"><label class="form-check-label" for="54">Komunikatywny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="55" name="feature_list[]" value="55"><label class="form-check-label" for="55">Konformistyczny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="56" name="feature_list[]" value="56"><label class="form-check-label" for="56">Konsekwentny</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="57" name="feature_list[]" value="57"><label class="form-check-label" for="57">Kreatywny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="58" name="feature_list[]" value="58"><label class="form-check-label" for="58">Lekkomyślny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="59" name="feature_list[]" value="59"><label class="form-check-label" for="59">Leniwy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="60" name="feature_list[]" value="60"><label class="form-check-label" for="60">Lojalny</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="61" name="feature_list[]" value="61"><label class="form-check-label" for="61">Lubieżny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="62" name="feature_list[]" value="62"><label class="form-check-label" for="62">Łagodny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="63" name="feature_list[]" value="63"><label class="form-check-label" for="63">Łakomy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="64" name="feature_list[]" value="64"><label class="form-check-label" for="64">Łatwowierny</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="65" name="feature_list[]" value="65"><label class="form-check-label" for="65">Małostkowy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="66" name="feature_list[]" value="66"><label class="form-check-label" for="66">Mądry</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="67" name="feature_list[]" value="67"><label class="form-check-label" for="67">Męski</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="68" name="feature_list[]" value="68"><label class="form-check-label" for="68">Mściwy</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="69" name="feature_list[]" value="69"><label class="form-check-label" for="69">Naiwny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="70" name="feature_list[]" value="70"><label class="form-check-label" for="70">Niecierpliwy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="71" name="feature_list[]" value="71"><label class="form-check-label" for="71">Nieczuły</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="72" name="feature_list[]" value="72"><label class="form-check-label" for="72">Niefrasobliwy</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="73" name="feature_list[]" value="73"><label class="form-check-label" for="73">Nielojalny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="74" name="feature_list[]" value="74"><label class="form-check-label" for="74">Niesłowny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="75" name="feature_list[]" value="75"><label class="form-check-label" for="75">Nieszczery</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="76" name="feature_list[]" value="76"><label class="form-check-label" for="76">Nietaktowny</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="77" name="feature_list[]" value="77"><label class="form-check-label" for="77">Nietolerancyjny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="78" name="feature_list[]" value="78"><label class="form-check-label" for="78">Nieuczciwy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="79" name="feature_list[]" value="79"><label class="form-check-label" for="79">Niewierny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="80" name="feature_list[]" value="80"><label class="form-check-label" for="80">Niezależny</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="81" name="feature_list[]" value="81"><label class="form-check-label" for="81">Nikczemny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="82" name="feature_list[]" value="82"><label class="form-check-label" for="82">Obłudny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="83" name="feature_list[]" value="83"><label class="form-check-label" for="83">Obojętny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="84" name="feature_list[]" value="84"><label class="form-check-label" for="84">Obowiązkowy</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="85" name="feature_list[]" value="85"><label class="form-check-label" for="85">Odpowiedzialny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="86" name="feature_list[]" value="86"><label class="form-check-label" for="86">Odważny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="87" name="feature_list[]" value="87"><label class="form-check-label" for="87">Okrutny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="88" name="feature_list[]" value="88"><label class="form-check-label" for="88">Opanowany</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="89" name="feature_list[]" value="89"><label class="form-check-label" for="89">Opiekuńczy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="90" name="feature_list[]" value="90"><label class="form-check-label" for="90">Opryskliwy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="91" name="feature_list[]" value="91"><label class="form-check-label" for="91">Optymistyczny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="92" name="feature_list[]" value="92"><label class="form-check-label" for="92">Oschły</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="93" name="feature_list[]" value="93"><label class="form-check-label" for="93">Oszczędny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="94" name="feature_list[]" value="94"><label class="form-check-label" for="94">Otwarty</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="95" name="feature_list[]" value="95"><label class="form-check-label" for="95">Oziębły</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="96" name="feature_list[]" value="96"><label class="form-check-label" for="96">Perfidny</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="97" name="feature_list[]" value="97"><label class="form-check-label" for="97">Pesymista</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="98" name="feature_list[]" value="98"><label class="form-check-label" for="98">Pewny siebie</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="99" name="feature_list[]" value="99"><label class="form-check-label" for="99">Pilny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="100" name="feature_list[]" value="100"><label class="form-check-label" for="100">Podejrzliwy</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="101" name="feature_list[]" value="101"><label class="form-check-label" for="101">Podły</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="102" name="feature_list[]" value="102"><label class="form-check-label" for="102">Pogardliwy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="103" name="feature_list[]" value="103"><label class="form-check-label" for="103">Pogodny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="104" name="feature_list[]" value="104"><label class="form-check-label" for="104">Pomysłowy</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="105" name="feature_list[]" value="105"><label class="form-check-label" for="105">Porywczy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="106" name="feature_list[]" value="106"><label class="form-check-label" for="106">Pracowity</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="107" name="feature_list[]" value="107"><label class="form-check-label" for="107">Pragmatyczny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="108" name="feature_list[]" value="108"><label class="form-check-label" for="108">Prawdomówny</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="109" name="feature_list[]" value="109"><label class="form-check-label" for="109">Praworządny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="110" name="feature_list[]" value="110"><label class="form-check-label" for="110">Próżny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="111" name="feature_list[]" value="111"><label class="form-check-label" for="111">Pruderyjny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="112" name="feature_list[]" value="112"><label class="form-check-label" for="112">Przebiegły</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="113" name="feature_list[]" value="113"><label class="form-check-label" for="113">Przedsiębiorczy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="114" name="feature_list[]" value="114"><label class="form-check-label" for="114">Przezorny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="115" name="feature_list[]" value="115"><label class="form-check-label" for="115">Przystojny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="116" name="feature_list[]" value="116"><label class="form-check-label" for="116">Punktualny</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="117" name="feature_list[]" value="117"><label class="form-check-label" for="117">Pyszny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="118" name="feature_list[]" value="118"><label class="form-check-label" for="118">Rozrzutny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="119" name="feature_list[]" value="119"><label class="form-check-label" for="119">Rozsądny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="120" name="feature_list[]" value="120"><label class="form-check-label" for="120">Roztargniony</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="121" name="feature_list[]" value="121"><label class="form-check-label" for="121">Roztropny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="122" name="feature_list[]" value="122"><label class="form-check-label" for="122">Rozważny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="123" name="feature_list[]" value="123"><label class="form-check-label" for="123">Rozwiązły</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="124" name="feature_list[]" value="124"><label class="form-check-label" for="124">Rzetelny</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="125" name="feature_list[]" value="125"><label class="form-check-label" for="125">Samochwała</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="126" name="feature_list[]" value="126"><label class="form-check-label" for="126">Samodzielny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="127" name="feature_list[]" value="127"><label class="form-check-label" for="127">Sarkastyczny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="128" name="feature_list[]" value="128"><label class="form-check-label" for="128">Schludny</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="129" name="feature_list[]" value="129"><label class="form-check-label" for="129">Serdeczny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="130" name="feature_list[]" value="130"><label class="form-check-label" for="130">Skąpy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="131" name="feature_list[]" value="131"><label class="form-check-label" for="131">Skromny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="132" name="feature_list[]" value="132"><label class="form-check-label" for="132">Skrupulatny</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="133" name="feature_list[]" value="133"><label class="form-check-label" for="133">Skuteczny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="134" name="feature_list[]" value="134"><label class="form-check-label" for="134">Snobistyczny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="135" name="feature_list[]" value="135"><label class="form-check-label" for="135">Spokojny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="136" name="feature_list[]" value="136"><label class="form-check-label" for="136">Spontaniczny</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="137" name="feature_list[]" value="137"><label class="form-check-label" for="137">Spostrzegawczy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="138" name="feature_list[]" value="138"><label class="form-check-label" for="138">Sprytny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="139" name="feature_list[]" value="139"><label class="form-check-label" for="139">Stanowczy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="140" name="feature_list[]" value="140"><label class="form-check-label" for="140">Staranny</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="141" name="feature_list[]" value="141"><label class="form-check-label" for="141">Sumienny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="142" name="feature_list[]" value="142"><label class="form-check-label" for="142">Systematyczny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="143" name="feature_list[]" value="143"><label class="form-check-label" for="143">Szczery</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="144" name="feature_list[]" value="144"><label class="form-check-label" for="144">Szlachetny</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="145" name="feature_list[]" value="145"><label class="form-check-label" for="145">Śmiały</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="146" name="feature_list[]" value="146"><label class="form-check-label" for="146">Taktowny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="147" name="feature_list[]" value="147"><label class="form-check-label" for="147">Tchórzliwy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="148" name="feature_list[]" value="148"><label class="form-check-label" for="148">Tolerancyjny</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="149" name="feature_list[]" value="149"><label class="form-check-label" for="149">Troskliwy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="150" name="feature_list[]" value="150"><label class="form-check-label" for="150">Tupet</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="151" name="feature_list[]" value="151"><label class="form-check-label" for="151">Tyran</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="152" name="feature_list[]" value="152"><label class="form-check-label" for="152">Uczciwy</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="153" name="feature_list[]" value="153"><label class="form-check-label" for="153">Uczynny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="154" name="feature_list[]" value="154"><label class="form-check-label" for="154">Ugodowy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="155" name="feature_list[]" value="155"><label class="form-check-label" for="155">Uległy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="156" name="feature_list[]" value="156"><label class="form-check-label" for="156">Uparty</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="157" name="feature_list[]" value="157"><label class="form-check-label" for="157">Uprzejmy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="158" name="feature_list[]" value="158"><label class="form-check-label" for="158">Uważny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="159" name="feature_list[]" value="159"><label class="form-check-label" for="159">Wesoły</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="160" name="feature_list[]" value="160"><label class="form-check-label" for="160">Wiarygodny</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="161" name="feature_list[]" value="161"><label class="form-check-label" for="161">Wielkoduszny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="162" name="feature_list[]" value="162"><label class="form-check-label" for="162">Wierny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="163" name="feature_list[]" value="163"><label class="form-check-label" for="163">Wrażliwy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="164" name="feature_list[]" value="164"><label class="form-check-label" for="164">Wspaniałomyślny</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="165" name="feature_list[]" value="165"><label class="form-check-label" for="165">Wścibski</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="166" name="feature_list[]" value="166"><label class="form-check-label" for="166">Wulgarny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="167" name="feature_list[]" value="167"><label class="form-check-label" for="167">Wyrachowany</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="168" name="feature_list[]" value="168"><label class="form-check-label" for="168">Wyrozumiały</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="169" name="feature_list[]" value="169"><label class="form-check-label" for="169">Wytrwały</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="170" name="feature_list[]" value="170"><label class="form-check-label" for="170">Zachłanny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="171" name="feature_list[]" value="171"><label class="form-check-label" for="171">Zarozumiały</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="172" name="feature_list[]" value="172"><label class="form-check-label" for="172">Zawistny</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="173" name="feature_list[]" value="173"><label class="form-check-label" for="173">Zawzięty</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="174" name="feature_list[]" value="174"><label class="form-check-label" for="174">Zazdrosny</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="175" name="feature_list[]" value="175"><label class="form-check-label" for="175">Zdecydowany</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="176" name="feature_list[]" value="176"><label class="form-check-label" for="176">Zdyscyplinowany</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="177" name="feature_list[]" value="177"><label class="form-check-label" for="177">Złośliwy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="178" name="feature_list[]" value="178"><label class="form-check-label" for="178">Zrównoważony</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="179" name="feature_list[]" value="179"><label class="form-check-label" for="179">Zrzędliwy</label></div></div>
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="180" name="feature_list[]" value="180"><label class="form-check-label" for="180">Zuchwały</label></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" id="181" name="feature_list[]" value="181"><label class="form-check-label" for="181">Życzliwy</label></div></div>
    </div>

    <!-- Przycisk submit -->
    <div class="row mt-4">
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary enableOnInput" disabled>Prześlij</button>
        </div>
    </div>
</div>

</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.body.addEventListener('click', function() {
        var n = document.querySelectorAll('input[type="checkbox"]:checked').length;
        var roznica = 6 - n;
        var komunikat = document.querySelector('.komunikat');
        var submitBtn = document.querySelector('.enableOnInput');

        if (roznica === 0) {
            komunikat.textContent = "Świetnie. Jeśli jesteś zadowolony z wybranych cech, stwórz swoje okno";
            submitBtn.disabled = false;
        } else {
            if (roznica > 0) {
                komunikat.textContent = "Zaznaczyłeś / zaznaczyłaś już " + n + " cech. Zostało Ci do zaznaczenia jeszcze " + roznica;
            } else {
                komunikat.textContent = "Zaznaczyłeś / zaznaczyłaś za dużo cech. Musisz odznaczyć " + (-roznica);
            }
            submitBtn.disabled = true;
        }
    });
});
</script>