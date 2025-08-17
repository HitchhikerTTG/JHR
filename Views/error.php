
<div class="container">
    <div class="row">
        <div class="col-md-8 ml-auto mr-auto text-center">
            <div class="alert alert-danger">
                <h4>Wystąpił błąd</h4>
                <p><?= isset($horror) ? esc($horror) : 'Nieznany błąd' ?></p>
            </div>
            <a href="<?= base_url() ?>" class="btn btn-primary">Wróć do strony głównej</a>
        </div>
    </div>
</div>
