<!-- https://source.unsplash.com/random/300X300?universe -->
<style>
   @media (min-width: 768px) {
      .carousel-inner {
         display: flex;
      }

      .carousel-item {
         margin-right: 0;
         flex: 0 0 33.333333%;
         display: block;
      }
   }

   .carousel-control-prev,
   .carousel-control-next {
      background-color: #e1e1e1;
      width: 6vh;
      height: 6vh;
      border-radius: 50%;
      top: 50%;
      transform: translateY(-50%);
   }
</style>
<div class="container py-5">
   <div id="carouselExample" class="carousel">
      <div class="carousel-inner">
         <div class="carousel-item active">
            <div class="card h-100 m-2">
               <img src="https://source.unsplash.com/random/300X300?universe" class="card-img-top" style="max-height: 200px;" alt="Imagen">
               <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
               </div>
            </div>
         </div>
         <div class="carousel-item">
            <div class="card h-100 m-2">
               <img src="https://source.unsplash.com/random/300X300?forest" class="card-img-top" style="max-height: 200px;" alt="Imagen">
               <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
               </div>
            </div>
         </div>
         <div class="carousel-item">
            <div class="card h-100 m-2">
               <img src="https://source.unsplash.com/random/300X300?mountains" class="card-img-top" style="max-height: 200px;" alt="Imagen">
               <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
               </div>
            </div>
         </div>
         <div class="carousel-item">
            <div class="card h-100 m-2">
               <img src="https://source.unsplash.com/random/300X300?ocean" class="card-img-top" style="max-height: 200px;" alt="Imagen">
               <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
               </div>
            </div>
         </div>
         <div class="carousel-item">
            <div class="card h-100 m-2">
               <img src="https://source.unsplash.com/random/300X300?people" class="card-img-top" style="max-height: 200px;" alt="Imagen">
               <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
               </div>
            </div>
         </div>
         <div class="carousel-item">
            <div class="card h-100 m-2">
               <img src="https://source.unsplash.com/random/300X300?buildings" class="card-img-top" style="max-height: 200px;" alt="Imagen">
               <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
               </div>
            </div>
         </div>
         <div class="carousel-item">
            <div class="card h-100 m-2">
               <img src="https://source.unsplash.com/random/300X300?ocean" class="card-img-top" style="max-height: 200px;" alt="Imagen">
               <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
               </div>
            </div>
         </div>
         <div class="carousel-item">
            <div class="card h-100 m-2">
               <img src="https://source.unsplash.com/random/300X300?people" class="card-img-top" style="max-height: 200px;" alt="Imagen">
               <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
               </div>
            </div>
         </div>
         <div class="carousel-item">
            <div class="card h-100 m-2">
               <img src="https://source.unsplash.com/random/300X300?buildings" class="card-img-top" style="max-height: 200px;" alt="Imagen">
               <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
               </div>
            </div>
         </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
         <span class="carousel-control-prev-icon" aria-hidden="true"></span>
         <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
         <span class="carousel-control-next-icon" aria-hidden="true"></span>
         <span class="visually-hidden">Next</span>
      </button>
   </div>
</div>
<script>
   let carouselWidth = document.getElementById('carouselExample').scrollWidth
   let cardWidth = document.querySelector('.carousel-item').offsetWidth
   let totalCardsWidth = document.querySelectorAll('.carousel-item').length * cardWidth
   let scrollPosition = 0
   document.querySelector('.carousel-control-next').addEventListener('click', () => {
      if (scrollPosition <= totalCardsWidth - cardWidth * 4) {
         scrollPosition += cardWidth
         document.querySelector('.carousel-inner').scrollTo({
            left: scrollPosition,
            behavior: 'smooth'
         })
      }
   })
   document.querySelector('.carousel-control-prev').addEventListener('click', () => {
      if (scrollPosition > 0) {
         scrollPosition -= cardWidth
         document.querySelector('.carousel-inner').scrollTo({
            left: scrollPosition,
            behavior: 'smooth'
         })
      }
   })
</script>