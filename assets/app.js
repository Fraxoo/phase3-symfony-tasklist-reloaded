import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');


document.querySelectorAll('#pin-btn').forEach(btn => {
    const icon = btn.querySelector('i');
    btn.addEventListener('click', async () => {
        try {
            const res = await  fetch(`/task/${btn.dataset.id}/toggle-pin`, {
                method: 'POST'
            })
            console.log(res);

            const data = await res.json();

            console.log(data);

            if(!res.ok) {
                console.log("Erreur");
                
            }

            if (data.isPinned) {
                icon.classList.remove('fa-thumbtack');
                icon.classList.add('fa-thumbtack-slash');
            } else {
                icon.classList.remove('fa-thumbtack-slash');
                icon.classList.add('fa-thumbtack');
            }
        } catch (err) {
            console.log(err);
            
        }
    })
})