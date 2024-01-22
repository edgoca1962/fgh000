document.addEventListener('click', f_editar_post)
document.addEventListener('touchstart', f_editar_post)

function f_editar_post(e) {
   if (e.target.getAttribute('data-post_type')) {
      if (e.target.dataset.post_type == 'post') {
         async function getPostData() {
            try {
               const response = await fetch(e.target.dataset.url)
               const data = await response.json()
               if (response.status === 200) {
                  document.getElementById('titulo_post_' + e.target.dataset.post_id).value = data.title.rendered
               } else {
                  console.log(data)
               }
            } catch (error) {
               console.log(error)
            }
         }
         getPostData()
      }
   }
}