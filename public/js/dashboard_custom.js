"٠١٢٣٤٥٦٧٨٩".replace(/\d/g, function (v) {
    return String.fromCharCode(v.charCodeAt(0) + 0x0630);
}); // "0123456789"

//    (()=>{
//         addEventListener('DOMContentLoaded', ()=>{
//             let el = document.querySelector('[wire\\:sortable]')
//             let options = { draggable: '[wire\\:sortable\\.item]' }

//             if (el.querySelector('[wire\\:sortable\\.handle]')) {
//                 options.handle ='[wire\\:sortable\\.handle]'
//             }

//             const sortable = new Sortable(el, options);

//             sortable.on('sortable:stop', () => {
//                 setTimeout(() => {
//                     let items = []

//                     document.querySelectorAll('[wire\\:sortable\\.item]').forEach((el, index) => {
//                         items.push({ order: index + 1, value: el.getAttribute('wire:sortable.item')})
//                     })

//                    Livewire.dispatch('updateOrder', {items: items})

//                 }, 1)
//             });
//         });
//     })();
