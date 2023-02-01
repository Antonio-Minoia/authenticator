<div class="header">

    <!-- BEGIN Header Holder -->
    <div class="header-holder header-holder-desktop">
        <div class="header-container container-fluid">
            <h4 class="header-title"><?= $_SESSION['current_page'] ?></h4>
            <i class="header-divider"></i>
            <div class="header-wrap header-wrap-block justify-content-start">
            </div>
            <div class="header-wrap">
                <p class="text-sm align-center">Ciao, <?= $_SESSION['user']['nome'] ?></p>
                <button class="btn btn-label-info btn-icon ml-2" title="Logout" data-placement="left" onClick="FunzioneLogout()" >
                    <i class="fa fa-sign-out-alt"></i>

                </button>
                
            </div>
        </div>
    </div>
    <!-- END Header Holder -->
    <!-- BEGIN Header Holder -->
    <div class="header-holder header-holder-mobile sticky-header" id="sticky-header-mobile">
        <div class="header-container container-fluid">
            <div class="header-wrap header-wrap-block justify-content-start">
                <h4 class="header-brand"><?= $_SESSION['impostazioni']['nome_azienda'] ?><small> gestione</small></h4>
            </div>
            <div class="header-wrap">
                <div class="header-wrap">
                    <button class="btn btn-label-info btn-icon ml-2"  title="Logout" data-placement="left" onClick="FunzioneLogout()" >
                        <i class="fa fa-sign-out-alt"></i>
                    </button>
                </div>
                <button class="btn btn-flat-primary btn-icon ml-2" data-toggle="aside">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- END Header Holder -->
</div>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>

<script>
    function FunzioneLogout() {
        Cookies.remove('PHPSESSID');
        location.reload();
    }
</script>