import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');


document.addEventListener('click', async (e) => {
    const btn = e.target?.closest('#pin-btn')
    if (!btn) {
        return
    }
    const icon = btn.querySelector('i');
    try {
        const res = await fetch(`/task/${btn.dataset.id}/toggle-pin`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        })
        console.log(res);

        const data = await res.json();

        console.log(data);

        if (!res.ok) {
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



// document.addEventListener('click', async (e) => {
//     const input = e?.target?.closest('#check-task');
//     if (!input) {
//         return;
//     }
//     try {
//         const res = await fetch(`/task/${input.dataset.id}/${input.checked ? "completed" : "pending"}/change-status`, {
//             method: "PUT",
//             headers: {
//                 'X-Requested-With': 'XMLHttpRequest',
//             },
//         })

//         const data = await res.json();

//         console.log(data);

//         if (!res.ok) {
//             return;
//         }
//     } catch (err) {
//         console.log(err);

//     }
// })



// document.addEventListener('change', (e) => {
//     console.log(e);
//     e.preventDefault();
    
//     if (e.target.matches('.auto-submit')) {
//         e.target.closest('form').submit();
//     }
// });