<?=$headGNRL;?>

<?php
        if($languaje == 'es') {
            $texto1 = "¡Pago existoso!";
            $texto2 = "El pago se ha realizado con exito, serás redirigido a la página de inicio en un momento...";
        } else if($languaje == 'en') {
            $texto1 = "Successful payment!";
            $texto2 = "The payment has been made successfully, you will be redirected to the home page in a moment...";
        }
?>


<div class="container mt-5">
    <div class="row">
        <div class="col py-1 text-center">
            <div class="alert alert-success">
                <strong><?=$texto1;?></strong> <?=$texto2;?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col py-3 text-center">
            <div class="spinner-border text-success"  style="width: 5rem; height: 5rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</div>