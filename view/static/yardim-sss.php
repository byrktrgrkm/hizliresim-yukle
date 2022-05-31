

<style>
    /* Style the buttons that are used to open and close the accordion panel */
.accordion {
    background-color: #021526;
    color: white;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  text-align: left;
  border: none;
  outline: none;
  transition: 0.4s;
}

/* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
.active, .accordion:hover {
  background-color: #032940;
}

/* Style the accordion panel. Note: hidden by default */
.panel {
  padding: 0 18px;
  background-color: white;
  display: none;
  overflow: hidden;
}

</style>
<div class="container mt-5">


    <button class="accordion">Hızlı Resim servisi nedir?</button>
    <div class="panel">
    <p>Hızlı Resim ücretsiz resim yükleme servisidir. Yüklediğiniz resimleri internette arkadaşlarınızla, blogunuzda, web sitelerinde, forumlarda veya sosyal ağlarda paylaşabilirsiniz. Üstelik tamamen ücretsiz!</p>
    </div>
    <button class="accordion">Eş zamanlı en fazla kaç resim yükleyebilirim?</button>
    <div class="panel">
    <p>En fazla 10 resime kadar aynı anda yükleme yapabilirsiniz.</p>
    </div>

    <button class="accordion">Resimler için maksimum dosya boyutu nedir?</button>
    <div class="panel">
    <p>Yükleme yapılabilecek maksimum dosya boyutu 10MB, depolama boyutu ise 5MB'dır. Yükleme sonrası depolama boyutundan büyük olan resimler, depolama boyutuna göre sıkıştırılırlar.</p>
    </div>

    <button class="accordion">Yüklenen resimler ne kadar süre depolanır?</button>
    <div class="panel">
    <p>Yüklenen resimler en az 3 ay süreyle depolanır. Siz istemediğiniz sürece sitemizden silinmez.</p>
    </div>

    
    <button class="accordion">Resim silmek için ne yapmalıyım?</button>
    <div class="panel">
    <p>Kötüye Kullanım bölümünden silinmesini istediğiniz resimleri için de başvuru yapabilirsiniz.</p>
    </div>

</div>
<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    /* Toggle between adding and removing the "active" class,
    to highlight the button that controls the panel */
    this.classList.toggle("active");
    
    [...acc].forEach(function(item){
        if(item != acc[i]){
            var panel = item.nextElementSibling;
            panel.style.display = "none";
        }
    });
    /* Toggle between hiding and showing the active panel */
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}

</script>