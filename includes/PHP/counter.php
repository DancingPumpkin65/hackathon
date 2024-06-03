<div class="counter">
    <h2>Nombres des inscrits</h2>
    <div class="odometer" id="odometer"></div>
</div>
<?php 
  $sql='SELECT COUNT(*) AS NumberOfUsers FROM Laureat';
  try {
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $numberOfUsers = $result['NumberOfUsers'];
      
      echo "<p id='nbf' style='display:none;'>" . $numberOfUsers . "</p>";
  } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/odometer.js/0.4.7/odometer.min.js" ></script>

<script>
    let value = parseInt(document.getElementById('nbf').textContent);
    setInterval( () => {
        odometer.innerHTML = value;
    }, 500);
</script>

<style>
.counter {
    margin: auto;
    padding: 1rem;
    display: flex;
    justify-content: center;
    align-items: center;
    background: rgb(29,122,208);
    background: linear-gradient(330deg, rgba(29,122,208,1) 0%, rgba(17,71,122,1) 100%);
    width: 30rem;
    color: white;
    border-radius: 5px;
    top: 50%;
    transform: translateY(-50%);
}

.counter h2 {
    margin-right: 2rem;
    font-weight: 400;
    margin-left: 0;
}

.counter .odometer {
    padding: 0 2rem;
    font-size: 1.5rem;
    font-weight: 400;
}

.odometer.odometer-auto-theme,
.odometer.odometer-auto-theme .odometer-digit,
.odometer.odometer-theme-car,
.odometer.odometer-theme-car .odometer-digit {
  -moz-box-orient: vertical;
  display: inline-block;
  vertical-align: middle;
  position: relative;
}

.odometer.odometer-auto-theme .odometer-digit .odometer-digit-spacer,
.odometer.odometer-theme-car .odometer-digit .odometer-digit-spacer {
  -moz-box-orient: vertical;
  display: inline-block;
  vertical-align: middle;
  visibility: hidden;
}

.odometer.odometer-auto-theme .odometer-digit .odometer-digit-inner,
.odometer.odometer-theme-car .odometer-digit .odometer-digit-inner {
  text-align: left;
  display: block;
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  overflow: hidden;
  left: .15em;
}

.odometer.odometer-auto-theme .odometer-digit .odometer-ribbon,
.odometer.odometer-theme-car .odometer-digit .odometer-ribbon {
  display: block;
}

.odometer.odometer-auto-theme .odometer-digit .odometer-ribbon-inner,
.odometer.odometer-theme-car .odometer-digit .odometer-ribbon-inner {
  display: block;
  -webkit-backface-visibility: hidden;
}

.odometer.odometer-auto-theme .odometer-digit .odometer-value,
.odometer.odometer-theme-car .odometer-digit .odometer-value {
  display: block;
  -webkit-transform: translateZ(0);
}

.odometer.odometer-auto-theme .odometer-digit .odometer-value.odometer-last-value,
.odometer.odometer-theme-car .odometer-digit .odometer-value.odometer-last-value {
  position: absolute;
}

.odometer.odometer-auto-theme.odometer-animating-up .odometer-ribbon-inner,
.odometer.odometer-theme-car.odometer-animating-up .odometer-ribbon-inner {
  -webkit-transition: -webkit-transform 2s;
  -moz-transition: -moz-transform 2s;
  -ms-transition: -ms-transform 2s;
  -o-transition: -o-transform 2s;
  transition: transform 2s;
}

.odometer.odometer-auto-theme.odometer-animating-down .odometer-ribbon-inner,
.odometer.odometer-auto-theme.odometer-animating-up.odometer-animating .odometer-ribbon-inner,
.odometer.odometer-theme-car.odometer-animating-down .odometer-ribbon-inner,
.odometer.odometer-theme-car.odometer-animating-up.odometer-animating .odometer-ribbon-inner {
  -webkit-transform: translateY(-100%);
  -moz-transform: translateY(-100%);
  -ms-transform: translateY(-100%);
  -o-transform: translateY(-100%);
  transform: translateY(-100%);
}

.odometer.odometer-auto-theme.odometer-animating-down.odometer-animating .odometer-ribbon-inner,
.odometer.odometer-theme-car.odometer-animating-down.odometer-animating .odometer-ribbon-inner {
  -webkit-transition: -webkit-transform 2s;
  -moz-transition: -moz-transform 2s;
  -ms-transition: -ms-transform 2s;
  -o-transition: -o-transform 2s;
  transition: transform 2s;
  -webkit-transform: translateY(0);
  -moz-transform: translateY(0);
  -ms-transform: translateY(0);
  -o-transform: translateY(0);
  transform: translateY(0);
}

.odometer.odometer-auto-theme,
.odometer.odometer-theme-car {
  -moz-border-radius: .34em;
  -webkit-border-radius: .34em;
  -o-border-radius: .34em;
  -ms-border-radius: .34em;
  -khtml-border-radius: .34em;
  border-radius: .34em;
  padding: .15em;
  color: white;
}

.odometer.odometer-auto-theme .odometer-digit,
.odometer.odometer-theme-car .odometer-digit {
  -moz-box-shadow: inset 0 0 .3em rgba(0, 0, 0, .8);
  -webkit-box-shadow: inset 0 0 .3em rgba(0, 0, 0, .8);
  -o-box-shadow: inset 0 0 .3em rgba(0, 0, 0, .8);
  padding: 0 .15em;
}

.odometer.odometer-auto-theme .odometer-digit:first-child,
.odometer.odometer-theme-car .odometer-digit:first-child {
  -moz-border-radius: .2em 0 0 .2em;
  -webkit-border-radius: .2em 0 0 .2em;
  -o-border-radius: .2em 0 0 .2em;
  -ms-border-radius: .2em 0 0 .2em;
  -khtml-border-radius: .2em 0 0 .2em;
}

.odometer.odometer-auto-theme .odometer-digit:last-child,
.odometer.odometer-theme-car .odometer-digit:last-child {
  -moz-border-radius: 0 .2em .2em 0;
  -webkit-border-radius: 0 .2em .2em 0;
  -o-border-radius: 0 .2em .2em 0;
  -ms-border-radius: 0 .2em .2em 0;
  -khtml-border-radius: 0 .2em .2em 0;
  border-radius: 0 .2em .2em 0;
  color: white;
}

.odometer.odometer-auto-theme.odometer-animating-down.odometer-animating .odometer-ribbon-inner,
.odometer.odometer-auto-theme.odometer-animating-up .odometer-ribbon-inner,
.odometer.odometer-theme-car.odometer-animating-down.odometer-animating .odometer-ribbon-inner,
.odometer.odometer-theme-car.odometer-animating-up .odometer-ribbon-inner {
  -webkit-transition-timing-function: linear;
  -moz-transition-timing-function: linear;
  -ms-transition-timing-function: linear;
  -o-transition-timing-function: linear;
  transition-timing-function: linear;
}

@media (max-width: 800px) {
  .counter {
    margin: auto;
    padding: 1rem;
    display: flex;
    justify-content: center;
    background: rgb(29,122,208);
    background: linear-gradient(330deg, rgba(29,122,208,1) 0%, rgba(17,71,122,1) 100%);
    width: 20rem;
    color: white;
    border-radius: 5px;
    top: 50%;
    transform: translateY(-50%);
  }
  .counter h2 {
    margin-right: 2rem;
    font-weight: 400;
    margin-left: 0;
    font-size: 0.8rem;
}

.counter .odometer {
    font-size: 1rem;
    font-weight: 400;
}
}
</style>
