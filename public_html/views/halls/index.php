<?php
$choice = -1;
if(isset($_SESSION['choice'])) {
    $choice = $_SESSION['choice'];
}

$hall = array();
if(isset($_SESSION['hallsInformation'])) {
    $hall = $_SESSION['hallsInformation'][$choice];
}

$confirmed = isset($_SESSION['confirmed']) ? $_SESSION['confirmed'] : 0;
?>

<div class="container">
    <div class="content">
        <div class="title">Welke klimhal vandaag?</div>
        <img class="confirmed_image" id="confirmed_image" style="display: none;" src= <?php echo $_ENV["SITE_ROOT"] . "images/confirmed.png" ?> alt="confirmed">
        <img src="<?php echo $hall['image']; ?>" alt="<?php echo $hall['hall_name']; ?>">
        
        <!-- Floating buttons initially hidden -->
        <div class="floating-buttons">
            <div class="floating-button" id="overruleButton" style="display: none;">
                <button onclick="location.href='/welkehal/api/overrule/';" style="--clr:#8A2BE2;"><span>Overrulen</span><i></i></button>
            </div>
            
            <div class="floating-button" id="confirmButton" style="display: none;">
                <button onclick="location.href='/welkehal/api/confirm/';" style="--clr:#0FF0FC;"><span>Bevestig</span><i></i></button>
            </div>
        </div>
        
        <div class="option"><?php echo ucfirst($hall['hall_name']); ?></div>
        <div class="address"><?php echo $hall['address']; ?></div>
        
        <div class="map-links">
            <a class="map-link" href="<?php echo $hall['maps_link']; ?>" target="_blank">Bekijk op Google Maps</a>
            <a class="map-link" href="<?php echo $hall['waze_link']; ?>" target="_blank">Bekijk op Waze</a>
        </div>
    </div>
</div>
