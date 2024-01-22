//Anima y cambia css del navbar una vez que deja la sección de hero.
if (
   document.getElementById('main_navbar') &&
   document.getElementById('hero-page')
) {
   const navbar = document.getElementById('main_navbar');
   const section = document.getElementById('hero-page');
   const logo = document.getElementById('logo');
   const sectionOptions = {
      rootMargin: '-70px 0px 0px 0px',
   };

   const sectionObserver = new IntersectionObserver(function (
      entries,
      sectionObserver
   ) {
      entries.forEach((entry) => {
         if (!entry.isIntersecting) {
            navbar.classList.add('navbar-scroll');
            logo.classList.remove('logo');
            logo.classList.add('cambio');
            logo.classList.add('bg-black')
         } else {
            navbar.classList.remove('navbar-scroll');
            logo.classList.add('logo');
            logo.classList.remove('cambio');
            logo.classList.remove('bg-black')
         }
      });
   },
      sectionOptions);
   sectionObserver.observe(section);
}
if (document.getElementById('btnmenu')) {
   const btnmenu = document.getElementById('btnmenu')
   const navbarSupportedContent = document.getElementById('navbarSupportedContent')
   btnmenu.addEventListener('touchstart', f_btnmenu)
   function f_btnmenu() {
      navbarSupportedContent.classList.toggle('bgmenumini')
   }
}
